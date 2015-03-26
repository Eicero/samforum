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
	
	class Login extends General{
		private function are_values_clean($posted_data, $conn){
			if(isset($posted_data["login"])){
				if(!empty($posted_data["username"]) and !empty($posted_data["password"])){
					$this->username			= $posted_data['username'];
					$this->user_password	= md5($posted_data['password']);
					$this->conn				= $conn;
					return true;
				}else{
					header("Location: ../error_message.php?message=Please leave no field empty");
					return false;
				}
			}
		}
		
		private function does_a_user_exists_in_registered_users_table(){
			$select_table_column = $this->conn->prepare("SELECT 1 FROM registered_users");
			if($select_table_column->execute()){
				return true;
			}else{
				header("Location: ../error_message.php?message=Script failed to find the table 'registered_users' in your database, please register atleast one user for table to be created.");
				return false;
			}
		}
		
		private function are_details_right(){
			$query_credentials = $this->conn->prepare("SELECT username, user_password FROM registered_users WHERE username = :username and user_password = :user_password");
			if($query_credentials->execute(array('username'=>$this->username, 'user_password'=>$this->user_password))){
				$get_user_details = $query_credentials->fetch(PDO::FETCH_ASSOC);
				if(count($get_user_details) == 2){
					return true;
				}else{
					header("Location: ../error_message.php?message=Wrong username or password");
					return false;
				}
			}
		}
			
		private function is_account_confirmed(){
			$select_confirmed = $this->conn->prepare("SELECT is_confirmed, user_id FROM registered_users WHERE username = :username");
			$select_confirmed->execute(array('username'=>$this->username));
			$compare = $select_confirmed->fetch(PDO::FETCH_ASSOC);
			if($compare["is_confirmed"] == 1){
				return true;
			}else{
				header("Location: ../error_message.php?message=This account has not yet been confirmed, please confirm the account first");
				return false;
			}
	
		}

		private function login_the_user(){
			if(!isset($_SESSION["logged_in"])){
				session_start();
			}
			$_SESSION["logged_in"] = $this->username;
			header("location: ../index.php");
		}
		
		static function show_admincp($conn){
			$select_power = $conn->prepare("SELECT power from registered_users WHERE username = :username");
			$select_power->execute(array('username'=>$_SESSION["logged_in"]));
			$select_power = $select_power->fetch(PDO::FETCH_ASSOC);
			if($select_power["power"] == 1){
				return "<a href=\"admin/admin_cp.php\"> Admin control panel </a> </br>";
			}
		}
		
		public function functions_processor($POST, $conn){

			// - Set values if fields are not empty.
			if($this->are_values_clean($POST, $conn)){
			
				//If a table named register_users exists in database, with atleast one registered users.
				if($this->does_a_user_exists_in_registered_users_table()){
					
					//If captcha entered is right.
					if(parent::is_captcha_right()){
					
						//If login information is correct
						if($this->are_details_right()){
						
							//If account is a confirmed account
							if($this->is_account_confirmed()){
								$this->login_the_user();
							}
							
						}
					}
				}
					
			}
				
		}
	}











?>