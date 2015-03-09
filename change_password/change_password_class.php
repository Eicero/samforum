<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	class Recover_password{
		private $conn;
		private $password_one;
		private $password_two;
		
		function initialize_connection($conn){
			if($conn instanceof PDO){
				$this->conn = $conn;
			}else{
				echo "Connection problem accured";
			}
		}
		
		function is_posted(){
			if(isset($_POST["change_password"])){
				$this->is_empty();
			}
		}
		
		private function is_empty(){
			$is_empty = null;
			$count = 0;
			
			foreach($_POST as $post_value){
				if(empty($post_value)){
					echo "Field/s are empty";
					break;
				}
				$count = $count + 1;
				
				if(!empty($post_value)){
					if($count == 2){
						$this->set_values();
					}
				}
			}
			
			/*
			if(isset($is_empty)){
				$this->set_values();
			}
			*/
		}
		
		private function set_values(){
			$this->password_one = strip_tags(stripslashes(trim($_POST["password_two"], '"')));
			$this->password_two = strip_tags(stripslashes(trim($_POST["password_one"], '"')));
			
			if($this->password_one == $this->password_two){
				if( strlen($this->password_one) > 10 ){
					$this->password_one = md5($this->password_one);
					$this->change_password_to_new();
				}else{
					$this->show_message("The password you provided is too weak");
				}
			}else{
				$this->show_message("Please make sure the passwords match");
			}
		}
		
		private function change_password_to_new(){
			$insert_pass_query = $this->conn->prepare("update registered_users set user_password = :user_password where username = :username");
			if( $insert_pass_query->execute(array('user_password'=>$this->password_one, 'username'=>$_SESSION["logged_in"])) ){
				$this->show_message("Password has been sucessfully changed!");	
			}else{
				$this->show_message("Unknown error occured, please contact admin.");
			}
		}

		private function show_message($message){
			$_SESSION["message"] = $message;
			header("location: show_message.php");
		}
	}

?>