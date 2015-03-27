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

	if( isset($_GET["thread_id"]) and isset($_GET["cat_id"]) ){
		include_once("connection_to_db.php");
		include_once("show_data_class.php");
		include_once("thread_editor_class.php");
		
		$Thread_editor = new Thread_editor;
		$Thread_editor->connection_setter($conn);
		
		//shows whole thread info, like thread body, title, thread by and time.
		$Show_thread_body = new Data_display($conn);
		$Show_thread_body->show_thread_body();
		
		//show thread replies.
		$Show_thread_body->show_replies();
		
		

		//code below only runs if user is logged in.
		if($Thread_editor->is_user_logged_in("logged_in")){
		
			//how post reply link.
			echo "<a href=\"post_reply/post_reply.php?thread_id={$_GET["thread_id"]}&cat_id={$_GET["cat_id"]} \"> Post a reply </a>";
		
			//show link if user owns the thread.
			if($Thread_editor->check_if_allowed_to_edit()){
				echo "<a href=\"thread_body_title_editor.php?thread_id={$_GET["thread_id"]}\"> Edit my thread! </a> </br> </br>";
			}
		}else{
			echo " </br> Please login to post a reply </br>";
		}
	}else{
		header("location:index.php");
	}

?>
