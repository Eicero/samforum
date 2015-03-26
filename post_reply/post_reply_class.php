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

	class reply{
		
		//initialize $conn variable.
		protected $conn;
		function __construct($conn){
			$this->conn = $conn;
			$this->show_form();
		}
		
		function show_form(){
			$where_to_send_data = "?thread_id={$_GET["thread_id"]}&cat_id={$_GET["cat_id"]}";
			if( isset($_GET["thread_id"]) and isset($_GET["cat_id"]) ){	
				if(isset($_SESSION["logged_in"])){
					echo "Reply with: </br> <form method=\"POST\" action=\"$where_to_send_data\">
					<textarea name=\"reply\"></textarea> </br>
					<input name=\"post_reply\" type=\"submit\" value=\"Post reply\">
					</form>";
				}
			}
		}
	
		//initialize $reply variable
		function set_reply(){
		
		//check if cat_id and thread_id exists.
			if( isset($_GET["thread_id"]) and isset($_GET["cat_id"]) ){
			
				//if session exists.
				if(isset($_SESSION["logged_in"])){
				
					//if post variable is set.
					if(isset($_POST["reply"])){
					
						//make sure reply field is not empty
						if(!empty($_POST["post_reply"])){
						
							//make sure reply's atlease 15 chars long
							if(strlen($_POST["reply"]) > 15){
							
								//reply variable.
								$this->reply = $_POST["reply"];
								return true;
							}else{
								header("Location: ../error_message.php?message=Your reply is too short");
							}
						}else{
							header("Location: ../error_message.php?message=Reply field cannot be left empty");
						}
					}
				}else{
					header("location: ../index.php");
				}
			}else{
				header("location: ../index.php");
			}
		}
		
		//post the reply.
		function post_reply(){
		
			//creates table.
			$create_table_query = $this->conn->prepare("create table if not exists replies(
				reply_id int(11) not null auto_increment,
				category_id int(11) not null,
				thread_id int(11) not null,
				reply_by text(25) not null,
				reply_body varchar(250) not null,
				reply_time text(20) not null,
				primary key(reply_id)
			)");
			
			//if there was no error in query then do this..
			if($create_table_query->execute()){
				$insert_reply_query = $this->conn->prepare("insert into replies(category_id, thread_id, reply_by, reply_body, reply_time) values(:category_id, :thread_id, :reply_by, :reply_body, :reply_time)");
				if($insert_reply_query->execute(array( 'category_id'=>$_GET["cat_id"], 'thread_id'=>$_GET["thread_id"], 'reply_by'=>$_SESSION["logged_in"], 'reply_body'=>$this->reply, 'reply_time'=>date("d-m-y") ))){
					header("Location: ../error_message.php?message=Reply sucessfully made");	
				}else{
					header("Location: ../error_message.php?message=Couldn't post reply. query failed");
				}
			}else{
				header("Location: ../error_message.php?message=Table failed to create");
			}
			
		}
		
		private function show_message($message){
			session_start();
			$_SESSION["message"] = $message;
			header("location: ../show_message.php");
		}
		
	}
	
	class Quote extends reply{
		//function 
	}
?>


