<?PHP
	
	session_start();
	include("general/general_class.php");
	
	class Thread_editor extends General{
		
		public function edit_title_and_body($thread_id){
			//$get_thread_by_query = $this->conn->prepare();
		}
		
		public function show_edit_form(){
			echo "<form method=\"GET\">
				<input name=\"thread_title\" type=\"text\">
				<input name=\"thread_body\" type=\"text\">
				<input name=\"edit_thread\" type=\"submit\" value=\"Edit thread\">
			</form>";
		}
		
		function check_if_allowed_to_edit(){
			if(isset($_GET["thread_id"])){

				$select_thread_by = $this->conn->prepare("SELECT thread_by FROM thread WHERE thread_id = :thread_id");
				$select_thread_by->execute(array(':thread_id'=>$_GET["thread_id"]));
				$thread_by = $select_thread_by->fetch(PDO::FETCH_ASSOC);
				
				$get_user_power = $this->conn->prepare("SELECT power FROM registered_users WHERE username = :username");
				$get_user_power->execute(array(':username'=>$_SESSION["logged_in"]));
				$user_power = $get_user_power->fetch(PDO::FETCH_ASSOC);
				
				//if user is admin.
				if($user_power["power"] == 1){
					echo "admin in you can edit any thread";
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
				echo "thread id doesn't exist in url.";
			}
		}
		

	}



?>