
<?PHP
	//*************************************//
	        //////Samichatbox//////
	//*************************************//
	
	define('ALLOWED', true);
	
	//connection file. 
	include("connection_to_db.php");
	
	//including clatbox_class.php, it's out Samichatbox class.
	include("chatbox_class.php");
	
	//Creating chatbox object.
	$Chatbox = new Samichatbox;
	
	//Setting $conn variable in class, so it can be used anywhere in it.
	$Chatbox->set_connection($conn);
	
	//Checking if user is logged, in.
	if($Chatbox->is_user_logged_in("logged_in")){
		echo "<b> samforum chatbox </b>";

	
		//Show chatbox if is_user_logged_in() returned true(logged in);
		$Chatbox->show_chatbox();
		
		//setting data and checking if field is empty.
		if($Chatbox->set_posted_data($_POST)){
		
			//Creating a table.
			if($Chatbox->create_chat_table()){
			
				//this reutrns true if there is less than 20 rows. Will say rows deleted when there's more.s
				if($Chatbox->delete_old_messages()){
				
					//insert data into database, this will insert data regardeless. even when rows are 20+. however delete_old_messages() deletes the rows first and returns true.
					$Chatbox->insert_message();
				}
			}
		}
	}else{
		echo "Session not set(user not logged in). Send it to index.php";
	}
?>

<div id="message"></div>

<script src="jquery.js"></script>
<script>
	$(document).ready(function(){
	   //ajaxTime.php is called every second to get time from server
	   var refreshId = setInterval(function()
	   {
		 $('#message').load('messages.php');
	   }, 1000);
	});
</script>