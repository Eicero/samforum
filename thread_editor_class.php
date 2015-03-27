<?PHP
	
	session_start();
	include("general/general_class.php");
	
	class Thread_editor extends General{
		
		public function edit_title_and_body($thread_id){
			//$get_thread_by_query = $this->conn->prepare();
		}
		
		public function show_edit_form(){
			$get_thread = $this->conn->prepare("SELECT thread_title, thread_body FROM thread WHERE thread_id = :thread_id");
			$get_thread->execute(array(':thread_id'=>$_GET["thread_id"]));
			$thread = $get_thread->fetch(PDO::FETCH_ASSOC);
			echo "<form method=\"POST\" action=\"?thread_id={$_GET["thread_id"]}\">
				New title: </br>
				<input name=\"thread_title\" type=\"text\" value=\"{$thread["thread_title"]}\"> </br> </br>
				New body: </br>
				<textarea name=\"thread_body\">{$thread["thread_body"]}</textarea> </br>
				<input name=\"edit_thread\" type=\"submit\" value=\"Edit thread\">
			</form>";
		}
		
		public function update_info(){
			$update_info = $this->conn->prepare("UPDATE thread SET thread_title = :thread_title, thread_body = :thread_body WHERE thread_id = :thread_id");
			if($update_info->execute(array(':thread_title'=>$this->thread_title, ':thread_body'=>$this->thread_body, ':thread_id'=>$_GET["thread_id"]))){
				header("Location: error_message.php?message=Your thread has been updated");
			}else{
				header("Location: error_message.php?message=Thread couldn't be updated due to technical error. Please contact admin.");
			}
		}
		
		function validate_submitted_info(){
			if(isset($_POST["edit_thread"])){
				if( !empty($_POST["thread_title"]) and !empty($_POST["thread_body"]) ){
					if(strlen($_POST["thread_title"]) > 5){
						if(strlen($_POST["thread_body"]) > 10){
							$this->thread_title = $_POST["thread_title"];
							$this->thread_body = $_POST["thread_body"];
							return true;
						}else{
							header("Location: error_message.php?message=thread body is too short");
						}
					}else{
						header("Location: error_message.php?message=thread title is too short");
					}
				}else{
					header("Location: error_message.php?message=Fill all the fields");
				}
			}
		}
		
		function check_if_allowed_to_edit(){
			if(isset($_GET["thread_id"]) and !empty($_GET["thread_id"])){
				$select_thread_by = $this->conn->prepare("SELECT thread_by FROM thread WHERE thread_id = :thread_id");
				$select_thread_by->execute(array(':thread_id'=>$_GET["thread_id"]));
				$thread_by = $select_thread_by->fetch(PDO::FETCH_ASSOC);
				
				$get_user_power = $this->conn->prepare("SELECT power FROM registered_users WHERE username = :username");
				$get_user_power->execute(array(':username'=>$_SESSION["logged_in"]));
				$user_power = $get_user_power->fetch(PDO::FETCH_ASSOC);
				
				//if user is admin.
				if($user_power["power"] == 1){
					return true;
				}
				
				//or if user owns this thread.
				elseif($thread_by["thread_by"] == $_SESSION["logged_in"]){
					return true;
				}
				//if user is not admin, nor he owns this thread. return false;
				else{
					return false;
				}
			
			}else{
				echo header("location: index.php");
			}
		}
		

	}



?>