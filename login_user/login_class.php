<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	class login{
		protected $username;
		protected $password;
		protected $conn;
		protected $user_id;
		
		function __construct($conn){
				$this->username = $_POST['username'];
				$this->user_password = md5($_POST['password']);
				$this->conn = $conn;
			
			//If no field is empty call function check_credentials.
			if(!empty($this->username) and !empty($this->user_password)){
				$this->check_credentials();
			}else{
				$this->show_message("Please enter username & password");
			}
		}
	
		protected function check_confirmation(){
			$select_confirmed = $this->conn->prepare("select is_confirmed, user_id from registered_users where username = :username");
			$select_confirmed->execute(array('username'=>$this->username));
			$compare = $select_confirmed->fetch(PDO::FETCH_ASSOC);
			if($compare["is_confirmed"] == 1){
				include("../connection_to_db.php");
				$Security = new Security($conn);
				$Security->set_name_id($compare);
				if($Security->create_table()){
					include("../connection_to_db.php");
					$Security = new Security($conn);
					$Security->set_name_id($compare);
					$Security->check_attempts_num_time();
				}
			}else{
				$this->show_message("This account has no yet been confirmed, please verify the account and try again </br>");
			}
		}
	
		function check_credentials(){	
			$query_credentials = $this->conn->prepare("SELECT username, user_password FROM registered_users WHERE username = :username and user_password = :user_password");
			if($query_credentials->execute(array('username'=>$this->username, 'user_password'=>$this->user_password))){
				$get_data = $query_credentials->fetch(PDO::FETCH_ASSOC);
				if(count($get_data) == 2){
					$this->check_confirmation();
					//echo "here";
				}else{
					include("../connection_to_db.php");
					$Security = new security($conn);
					$Security->insert_attempts();
				}
			}
		}
		
		public static function show_admincp($conn){
			$select_power = $conn->prepare("select power from registered_users where username = :username");
			$select_power->execute(array('username'=>$_SESSION["logged_in"]));
			$select_power = $select_power->fetch(PDO::FETCH_ASSOC);
			if($select_power["power"] == 1){
				echo "<a href=\"admin/admin_cp.php\"> Admin control panel </a> </br>";
			}
		}
		
		protected function show_message($message){
			session_start();
			$_SESSION["message"] = $message;
			header("location: ../show_message.php");
		}
	}
	
	
	
	class Security extends login{
		protected $conn;
		protected $IP;
		function __construct($conn){
			$this->conn = $conn;
			$this->current_time = time();
			$this->IP = $_SERVER["REMOTE_ADDR"];
		}
		
		//setting username and user id
		function set_name_id($compare){
			$this->username = $_POST["username"];
			$this->user_id = $compare["user_id"];
		}
		
		//create table
		function create_table(){
			$create_table_login_attempts = $this->conn->prepare("create table if not exists login_attempts(
				user_ip varchar(30) not null,
				last_attempt int(30) not null,
				attempts_num int(11) not null,
				primary key(user_ip)
			)");
			
			if($create_table_login_attempts->execute()){
				return true;
			}else{
				echo "Table login_attempts failed to create";
			}
			
		}
		
		//this function is run when user tries to login. If attempts are less than 5 and time past is more than 10 minutes than login, else, run function insert_attempts
		function check_attempts_num_time(){			
				$query_select_time_attempts_num = $this->conn->prepare("select last_attempt, attempts_num from login_attempts where user_ip = :user_ip");
				$query_select_time_attempts_num->execute(array('user_ip'=>$this->IP));
				$this->returned_array		= $query_select_time_attempts_num->fetch(PDO::FETCH_ASSOC);
			
			//getting back the ip. checking if ip exists in db. 
			if(!empty($this->returned_array)){		
				$this->last_attempt_time	= $this->returned_array["last_attempt"];
				$this->attempts_num			= $this->returned_array["attempts_num"];		
				
				//if attempts is smaller than 5, then there's no need to check for last failed time.
				if( $this->attempts_num <= 5 ){
					$this->reset_attempts();
				}
				
				if( $this->attempts_num > 5 ){
					if( ($this->current_time - $this->last_attempt_time) >= 60 ){
						$this->reset_attempts();
					}else{
						echo "please wait a minute. Too many failed attempts";
					}
				}
				
			}else{
				session_start();
				$_SESSION["logged_in"]	= $this->username;
				$_SESSION["user_id"]	= $this->user_id;
				header("location: ../index.php");
			}
		}
		
		function reset_attempts(){
			$update_attempts_num = $this->conn->prepare("update login_attempts set attempts_num = :attempts_num where user_ip = :user_ip");
			$update_attempts_num->execute(array('attempts_num'=>0, 'user_ip'=>$this->IP));
			
			//session_start();
			$_SESSION["logged_in"]	= $this->username;
			$_SESSION["user_id"]	= $this->user_id;
			echo $_SESSION["logged_in"];
			echo $_SESSION["user_id"];
			header("location: ../index.php");
			
		}
		
		function insert_attempts(){
			$select_ip_query = $this->conn->prepare("select user_ip from login_attempts where user_ip = :user_ip");
			$select_ip_query->execute(array('user_ip'=>$this->IP));
			$get_ip = $select_ip_query->fetch(PDO::FETCH_ASSOC);
			
			//checks if ip exists
			if(!empty($get_ip)){
			
				//update the records, set last attemp and attempt number to new value.
				 $query_update_attempts = $this->conn->prepare("update login_attempts set last_attempt = :last_attempt, attempts_num = attempts_num + 1 where user_ip = :user_ip");
				
				//updating last attempt time and attempt number
				if($query_update_attempts->execute(array('last_attempt'=>$this->current_time, 'user_ip'=>$this->IP))){
					echo "Wrong username or password";
				}else{
					echo "record couldnt be updated as previous query failed to execute.";
				}
			}else{
				//if ip doesn't exist in database then insert ip.
				$insert_ip = $this->conn->prepare("insert into login_attempts(user_ip, last_attempt) values(:user_ip, :last_attempt)");
				$insert_ip->execute(array('user_ip'=>$this->IP, 'last_attempt'=>$this->current_time));
				echo "Wrong username or password";
			}
		}
	}
?>
