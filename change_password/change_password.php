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

	session_start();
	
	if(!isset($_SESSION["logged_in"])){
		header("location: index.php");
	}else{		
		//show the form.
		echo "<form method=\"POST\" action=\"{$_SERVER['PHP_SELF']}\">
				Password: <input type=\"text\" name=\"password_one\"> </br>
				Repeat password: <input ype=\"text\" name=\"password_two\"> </br>
				<input name=\"change_password\" value=\"Change\" type=\"submit\">
			</form>";
	}
	
	include_once("change_password_class.php");
	include_once("../connection_to_db.php");
	$Recover_password = new Recover_password;
	$Recover_password->initialize_connection($conn);
	$Recover_password->is_posted();
	
	
	





?>
