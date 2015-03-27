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

	class create{
		function __construct($conn){
			$this->conn = $conn;
			if(isset($_POST["submit_thread"])){
				$this->category_id		= $_GET["cat_id"];
				
				$this->thread_title		= $_POST["thread_title"];
				$this->thread_body		= $_POST["thread_body"];
				
				$this->user_id			= $_SESSION["user_id"];
				$this->thread_by		= $_SESSION["logged_in"];
				
				//call function to validate input.
				$this->validate_input();
			}
		}
		
		function validate_input(){
			if( !empty($this->thread_title) and !empty($this->thread_body) ){
				if(strlen($this->thread_title) > 5){
					if(strlen($this->thread_body) > 10){
						//call function to create thread;
						$this->create_thread();
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
		
		function create_thread(){
		
			//Create thread table.
			$create_thread_table = $this->conn->prepare("
			create table if not exists thread(
				thread_id int(11) not null auto_increment,
				category_id int(11) not null,
				thread_by text(25) not null,
				thread_title varchar(50) not null,
				thread_body varchar(500) not null,
				thread_created_time text(20) not null,
				primary key(thread_id)
			)");
						
			$create_thread_table->execute();
						
			$create_thread_query_string = $this->conn->prepare("insert into thread(category_id, thread_by, thread_title, thread_body, thread_created_time) values(:category_id, :thread_by, :thread_title, :thread_body, :thread_created_time)");
			
			$create_thread_array_for_execution = array('category_id'=>$this->category_id, 'thread_by'=>$_SESSION["logged_in"], 'thread_title'=>$this->thread_title, 'thread_body'=>$this->thread_body, 'thread_created_time'=>date("d-m-y"));
						
			if($create_thread_query_string->execute($create_thread_array_for_execution)){
				header("Location: error_message.php?message=Your thread has been created!");
			}else{
			
				$this->show_message("");
				header("Location: error_message.php?message=Unexpected error occured!. in file create_thread_class.php");
			}
		}
		
	}
?>
