<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	class recover_password{
		private $email;
		private $conn;
		function data($conn){
			if( isset($_POST["recover"]) ){
				if(!empty($_POST["email"])){
					$this->email = strip_tags(stripslashes(trim($_POST["email"], '"')));
					$this->conn = $conn;
					$this->recover();
				}else{
					echo $this->show_message("Fill email field please");
				}
			}
		}
		
		function change_pass($conn){
			if(isset($_POST["recover_pass"])){
				$this->user_password = md5($_POST["password_one"]);
				if( (!empty($_POST["password_one"])) and (!empty($_POST["password_two"])) ){
					if($_POST["password_one"] == $_POST["password_two"]){
						if(strlen($_POST["password_one"]) > 10){
							$query_insert_pass = $conn->prepare("update registered_users set user_password = :user_password");
							if( $query_insert_pass->execute(array('user_password'=>$this->user_password )) ){
								$query_del_rec_code = $conn->prepare("update registered_users set recovery_code = :recovery_code");
								$query_del_rec_code->execute(array('recovery_code'=>''));
								//header("location: password_changed.php");
								$this->show_message("Password has been changed");
							}
						}else{
							$this->show_message('password too small');
						}
					}else{
						$this->show_message('passwords do not match');
					}
				}else{
				$this->show_message('dont leave password field empty');
				}
			}
		}
		
		function check_recovery_code($conn){
			$select_recovery_code = $conn->prepare("select recovery_code from registered_users where recovery_code = :recovery_code");
			$select_recovery_code->execute(array('recovery_code'=>$_GET["code"]));
			$select_recovery_code = $select_recovery_code->fetch(PDO::FETCH_ASSOC);
			if(!empty($select_recovery_code)){
				session_start();
				$_SESSION["recovery_code"] = $_GET["code"];
				header("location:finish_recovery.php");
			}else{
				header("location: index.php");
			}
		}
		
		protected function send_mail(){
			$this->site_name = "http://atheustbn.site11.com";
			$this->from = "sami forums";
			$this->message = "Recovery link:  " . "$this->site_name/finish_recovery.php?code=$this->recovery_code .  If you did not make these change please then do not click the link.";
			mail($this->email, "Recovery link", $this->message, "From: $this->from");
			$this->show_message('If your mail was correct you will receive the email soon');
		}
		
		protected function recover(){
			$query_select_email = $this->conn->prepare("select email from registered_users where email = :email");
			$query_select_email->execute(array('email'=>$this->email));
			$query_select_email = $query_select_email->fetch(PDO::FETCH_ASSOC);
			
			if(!empty($query_select_email)){
				$this->recovery_code = md5($this->email) . time();
				$insert_recovery_code = $this->conn->prepare("update registered_users set recovery_code = :recovery_code");

				if($insert_recovery_code->execute(array('recovery_code'=>$this->recovery_code))){
					$this->send_mail();
				}
			}else{
				$this->show_message('if your mail was correct you will receive the email soon');
			}
		}
		
		private function show_message($message){
			session_start();
			$_SESSION["message"] = $message;
			header("location: ../show_message.php");
		}
	}
	
?>
