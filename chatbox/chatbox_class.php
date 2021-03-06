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
	
	include("../deny_access.php");
	access("../index.php");
	session_start();
	
	class Samchatbox extends General{
	
		protected $conn;
		public function set_connection($conn){
			$this->conn = $conn;
		}
		
		public function set_posted_data($posted_info){
			if(isset($posted_info["submit"])){
				//checking if field is empty.
				if(!empty($posted_info["message"])){
					$this->message = trim($posted_info["message"]);
					return true;
				}else{
					echo "Please fill message field";
				}
			}
		}
		
		public function create_chat_table(){
			$create_table_query = $this->conn->prepare("
				create table if not exists sami_chatbox(
					message_id int(11) not null auto_increment,
					message_by varchar(20) not null,
					message varchar(50) not null, primary key(message_id)
				)");
			if($create_table_query->execute()){
				return true;
			}else{
				echo "failed to create a table";
			}
			
		}
		
		public function show_chatbox(){
			echo "<form method=\"POST\" action=\"{$_SERVER['PHP_SELF']}\">
			<textarea name=\"message\"></textarea> </br>
			<input name=\"submit\" value=\"Shout!\" type=\"submit\">
			</form>";
		}		
		
		public function insert_message(){
			$insert_message_query = $this->conn->prepare("insert into sami_chatbox(message_by, message) values(:message_by, :message)");
			if($insert_message_query->execute(array(':message_by'=>$this->username, ':message'=>$this->message))){
				
			}else{
				header("Location: ../error_message.php?message=couldnt insert. query failed in insert message function in chatbox_class.php");
			}
		}
		
		//if there is 20 messages, delete first 10.
		
		function delete_old_messages(){
			$Select_all_query = $this->conn->prepare("select * from sami_chatbox");
			if($Select_all_query->execute()){
			
				//counting number of rows in the table.
				$total_messages = 0;
				while($select_message_id = $Select_all_query->fetch(PDO::FETCH_ASSOC)){
					$total_messages = $total_messages + 1;
				}
				
				//if number of rows is bigger than or equal to 20 then delete last 10 rows.
				if($total_messages >= 20){
					$delete_old_messages_query = $this->conn->prepare("delete from sami_chatbox order by message_id limit 10");
					if($delete_old_messages_query->execute()){
						echo "Query sucessful, or deleted last 10 messages";
						return true;
					}else{
						echo "Failed to delete first 10 messages";
					}
				}else{
					return true;
				}
			}else{
				echo "query failed";
				return false;
			}
		}
		
		static function show_messages($conn){
			$select_messages_query = $conn->prepare("select * from sami_chatbox");
			if($select_messages_query->execute()){
				while($the_message = $select_messages_query->fetch(PDO::FETCH_ASSOC)){
				$the_message["message_by"] = htmlentities($the_message["message_by"]);
				$the_message["message"] = htmlentities($the_message["message"]);
					echo "<p class='thread_by' style='display:inline'> {$the_message["message_by"]} </p>";
					echo "<p style='display:inline'> {$the_message["message"]} </p> </br>" ;
				}
			}
		}

	}
	
	


?>