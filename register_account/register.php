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

?>

<b> Register new account </b>
<form method="POST" action="submit_registration.php">
	Username: <input name="username" type="text"> </br>
	Email: <input name="email" type="text"> </br>
	Password <input name="password_one" type="text"> </br>
	Repeat Password <input name="password_two" type="text"> </br>
	Enter captcha <input name="captcha" type="text"> </br>
	
	<?PHP include("form_registration_class.php"); register::display_captcha(); ?>
	<input name="register_user" type="submit" value="Register">
</form>