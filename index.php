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
   
	$doc_root = $_SERVER["DOCUMENT_ROOT"] = "files";

   //work on search feature
	include_once("connection_to_db.php");

	session_start();
	
	//link to search bar
	echo "<a href=\"search.php\"> Search on this site </a> </br>";
	
	if(!isset($_SESSION["logged_in"])){
		//if user is not logged in then show login, register, and recover_password options
		echo "<a href='login_user/login.php'> Login </a> </br>";
		echo "<a href='register_account/register.php'> Register new account </a> </br>";
		echo "<a href='recover_password/recover_password.php'> Recover password </a> </br>";
	}else{
		echo "Hello, " .$_SESSION["logged_in"] . "</br>";
		echo "<a href=\"login_user/logout.php\"> Logout </a> </br>";
		echo "<a href=\"user_profile.php\"> My profile </a> </br>";
		echo "<a href=\"chat_box.php\"> Join chat </a> </br>";

		//If user is logged in(session exists), we're going to check if user is admin.
		
		include_once("general/general_class.php");
		include_once("login_user/login_class.php");
		include_once("connection_to_db.php");
		
		//..checks if user is admin
		echo Login::show_admincp($conn);
		
	}
	
	//Shows categories and other things.
	include_once("show_data_class.php");
	$Data_display = new Data_display($conn);
	$Data_display->set_title("</br> <b> Boards </b>");
	$Data_display->show_categories();


?>
