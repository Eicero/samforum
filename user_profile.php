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
		echo "Hello {$_SESSION["logged_in"]}, this is your profile" . "</br>";
		echo "<a href=\"change_password/change_password.php\"> Change password </a> </br>";
		echo "<a href=\"index.php\"> Home </a>";
	}
?>
