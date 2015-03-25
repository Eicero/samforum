<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */
	include("../general/general_class.php");
	class register extends General {
		private $chean_data;
		private $username;
		private $email;
		private $password_one;
		private $password_two;
		private $errors;
		private $arr_length;
		private $set_check;
		private $data;
		private $cleaned_data;
		private $email_pattern;
		
		private $conn;
		public  $show_errors;

		function __construct($data='', $conn=''){
			$this->data = $data;
			$this->conn = $conn;
			$this->arr_length = count($data) - 1;
			
			//Check if register_user key of exists in _POST array
			if(isset($data["register_user"])){
			
				//Loop though $_POST array keys and values, store key and error in errors array.
				foreach($data as $empty_key=>$empty_value){
				
					//Keeping track of how mnay fields have been looped.
					$this->arr_length = $this->arr_length - 1;
					
					//If fields are empty. Do this.
					if(empty($empty_value)){
						$this->errors[$empty_key] =  $empty_key . " cannot be left empty. </br>";
						echo $this->errors[$empty_key];
					}
				}
				
				//When it reaches -1(all fields looped) check if errors array contains any errors. If it's empty. Then..
				if($this->arr_length == -1){
					if(empty($this->errors)){
					
						//..sanitizing all the data. And assign it to new array cleanred_data.
						foreach($data as $field_key=>$field_value){
							$this->cleaned_data[$field_key]  = strip_tags(stripslashes(trim($field_value, '"')));
						}
						
						//data sanitized. Now call functions and see if they return any data in errors array. All errors are stored in an array.
						$this->validate_email();
						$this->validate_passwords();
						$this->validate_username();
						
						//Looping in error aray and checking if there's something in. if not, continue process.. all 3 functions above might have stored errors in errors variables.
						if(!empty($this->errors)){
							foreach($this->errors as $show_errors){
								echo $show_errors . "</br>";
							}
						}elseif($this::is_captcha_right()){
							$this->insert_info();
						}
					}
				}
			}
		}
		
		//validate email function 
		private function validate_email(){
			//Regular explression, returns true if email is valid.
			$this->email_pattern = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
			
			//Checking if regular expression is returning false, along with filter var. And also making sure email's not too short/long. If yes, errors are stored in errors array.
			if( (!preg_match($this->email_pattern, $this->cleaned_data["email"])) or
				(!filter_var($this->cleaned_data["email"], FILTER_VALIDATE_EMAIL)) or
				(strlen($this->cleaned_data["email"]) > 30) or
				(strlen($this->cleaned_data["email"]) < 10)){
					$this->errors[] = $this->cleaned_data["email"] . " is an invalid email address";
			}
		}
		
		private function validate_passwords(){
			if( (strlen($this->cleaned_data["password_one"]) < 10) or (strlen($this->cleaned_data["password_two"]) < 10) ){
				$this->errors[] = "Password is too weak";
				return false;
			}
			if($this->cleaned_data["password_one"] !== $this->cleaned_data["password_two"]){
				$this->errors[] = "Passwords do not match";
			}
		}
		
		private function validate_username(){
			if(!ctype_alnum($this->cleaned_data["username"]) or strlen($this->cleaned_data["username"]) > 25 ){
				$this->errors[] = $this->cleaned_data["username"] . " is an invalid username.";
			}
		}
		
		private function send_mail(){
			$this->site_name = "http://atheustbn.site11.com";
			$this->from = "sami forum";
			$this->message = "Verfication link: $this->site_name/register_account/confirmation_page.php?code=$this->confirmation_code";
			mail($this->cleaned_data["email"], "Account verification",
			$this->message, 'From: ' . $this->from . "\r\n" );
			session_start();
			header("Location: ../error_message.php?message= Account sucessfully created. Please verify");
		}
		
		private function insert_info(){
			$this->user_ip				= $_SERVER["REMOTE_ADDR"];
			$this->is_confirmed			= false;
			$this->confirmation_code	= md5($this->cleaned_data["email"]) + time();
			$this->user_password		= md5($this->cleaned_data["password_one"]);
			
			//creating table it it doesn't exist.
			$query_make_table = $this->conn->prepare("
			create table if not exists registered_users(
			user_id int not null auto_increment,
			username varchar(25) not null,
			power int not null,
			email varchar(30) not null,
			user_password varchar(100) not null,
			user_ip varchar(25) not null,
			is_confirmed boolean not null,
			confirmation_code varchar(100),
			recovery_code varchar(100) not null,
			primary key(user_id)
			)");
			$query_make_table->execute();
			
			//Check if Usernae, email or IP exists in db.
			$query_check_email = $this->conn->prepare("select email from registered_users where email = :email");
			$query_check_email->execute(array('email'=>$this->cleaned_data["email"]));
			
			$query_check_username = $this->conn->prepare("select username from registered_users where username = :username");
			$query_check_username->execute(array('username'=>$this->cleaned_data["username"]));
			
			$query_check_ip = $this->conn->prepare("select user_ip from registered_users where user_ip = :user_ip");
			$query_check_ip->execute(array('user_ip'=>$this->user_ip));
						
			$get_ip				= $query_check_ip->fetch(PDO::FETCH_ASSOC);
			$get_email			= $query_check_email->fetch(PDO::FETCH_ASSOC);
			$get_username		= $query_check_username->fetch(PDO::FETCH_ASSOC);
			
			//If ip email, and username exist in databse, then don register.
			if(!$get_ip){
				if(!$get_email){
					if(!$get_username){
						
						//Insert into into table. 
						$query_insert_info = $this->conn->prepare("
						insert into registered_users(username, email, user_password, user_ip, is_confirmed, confirmation_code) 
						values(:username, :email, :user_password, :user_ip, :is_confirmed, :confirmation_code)
						");
						if($query_insert_info->execute(array(
						':username'=>$this->cleaned_data["username"],
						':email'=>$this->cleaned_data["email"],
						':user_password'=>$this->user_password,
						':user_ip'=>$this->user_ip,
						':is_confirmed'=>$this->is_confirmed,
						':confirmation_code'=>$this->confirmation_code
						))){	
							$this->send_mail();
						}else{
							header("Location: ../error_message.php?message=Error occured please contact site admin");
						}
				
					}else{
						$_SESSION["username"] = $this->cleaned_data["username"];
						header("Location: ../error_message.php?message=That username as already been taken please try different username");
					}
				}else{
					$_SESSION["email"] = $this->cleaned_data["email"];
					header("Location: ../error_message.php?message=someone else has already registered an account with this email");
				}
			}else{
				$_SESSION["ip"] = $this->user_ip;	
				header("Location: ../error_message.php?message=Account form your IP has already been created. We do not allow multiple account");

			}
		}
		
		private function show_message($message){
			session_start();
			$_SESSION["message"] = $message;
			header("location: ../show_message.php");
		}
	}
	
?>
