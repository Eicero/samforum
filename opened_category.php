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

	//start session
	session_start();
	
	//if get variable contains cat_id value..
	if(isset($_GET["cat_id"])){
		//show the threads that belong to that form
		include_once("connection_to_db.php");
		include_once("show_data_class.php");
		$show_thread = new Data_display($conn);
		$show_thread->show_threads();
		
		//if user is logged in then..
		if( isset($_SESSION["logged_in"]) ){
			echo "<b>Create a new thread</b> <form method=\"POST\" action=\"{$_SERVER['PHP_SELF']}?cat_id={$_GET['cat_id']}\">
			Thread title: <input name=\"thread_title\" type=\"text\"> </br>
			Thread body:  <textarea name=\"thread_body\" type=\"text\"></textarea> </br>
						  <input name=\"submit_thread\" type=\"submit\" value=\"Submit thread\">
			</form>";
			
			//class to create thread.
			include_once("connection_to_db.php");
			include_once("create_thread/create_thread_class.php");
			$Create = new create($conn);
		}else{
			echo "You need to login to create a new thread";
		}
	}else{
		echo "No category id found in get variable";
	}

	
?>
