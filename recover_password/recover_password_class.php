<?PHP
//******************************************//
//* This copyright notice must not be removed
//* under any circumstances.
//* It must stay intact in all the files.

//* Samforum
//* Version 1.0
//* Script created by Samiuddin Samiuddin
//* Email: phpdevsami@gmail.com
//* Skype: n0h4cks

//* - This is not an open source project, functions/classes
//*   or any other code form this script cannot be
//*   used for other scripts or applications.

//*   You are not allowed to resell this script.

//* - You are free to make modification/changes,
//*   however it must be for your own use.
//*********************************************************************//

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
					header("Location: ../error_message.php?message=Fill email field please");
				}
			}
		}
		
		function change_pass($conn){
			if(isset($_POST["recover_pass"])){
				$this->user_password = md5($_POST["password_one"]);
				if( (!empty($_POST["password_one"])) and (!empty($_POST["password_two"])) ){
					if($_POST["password_one"] == $_POST["password_two"]){
						if(strlen($_POST["password_one"]) > 10){						
							$query_insert_pass = $conn->prepare("update registered_users SET user_password = :user_password WHERE recovery_code = :recovery_code");
							if( $query_insert_pass->execute(array(':user_password'=>$this->user_password, ':recovery_code'=>$_SESSION["recovery_code"])) ){
								$query_del_rec_code = $conn->prepare("update registered_users set recovery_code = :recovery_code");
								$query_del_rec_code->execute(array('recovery_code'=>''));
								header("Location: ../error_message.php?message=Password has been changed");
							}
						}else{
							header("Location: ../error_message.php?message=Password too small");
						}
					}else{
						header("Location: ../error_message.php?message=passwords do not match");
					}
				}else{
					header("Location: ../error_message.php?message=dont leave password field empty");
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
				header("location: ../index.php");
			}
		}
		
		protected function send_mail(){
			$this->site_name = "http://atheustbn.site11.com";
			$this->from = "sami forums";
			$this->message = "Recovery link:  " . "$this->site_name/finish_recovery.php?code=$this->recovery_code .  If you did not make these change please then do not click the link.";
			mail($this->email, "Recovery link", $this->message, "From: $this->from");
			header("Location: ../error_message.php?message=If your mail was correct you will receive the email soon");
		}
		
		protected function recover(){
			$query_select_email = $this->conn->prepare("select email from registered_users where email = :email");
			$query_select_email->execute(array(':email'=>$this->email));
			$query_select_email = $query_select_email->fetch(PDO::FETCH_ASSOC);
			
			if(!empty($query_select_email)){
				$this->recovery_code = md5($this->email) . time();
				$insert_recovery_code = $this->conn->prepare("UPDATE registered_users SET recovery_code = :recovery_code WHERE email = :email");

				if($insert_recovery_code->execute(array(':recovery_code'=>$this->recovery_code, ':email'=>$this->email))){
					$this->send_mail();
				}
			}else{
				header("Location: ../error_message.php?message=if your mail was correct you will receive the email soon");
			}
		}
	}
	
?>
