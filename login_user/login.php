
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

	include("../general/general_class.php");
	include("login_class.php");
	
	include("../connection_to_db.php");
	$Login = new Login;
	$Login->functions_processor($_POST, $conn);
?>

<form method="POST" action="<?PHP $_SERVER["PHP_SELF"];?>">
	Username: <input name="username" type="text" > </br>
	Password: <input name="password" type="text" > </br>
	Enter captcha:  <input name="captcha" type="text" > </br>
			 <?PHP Login::display_captcha(); ?>
	<input name="login" type="submit" value="Login"> </br>
</form>

