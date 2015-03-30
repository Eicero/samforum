<html>
	<head> 
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
</html>

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

	if(isset($_SESSION["logged_in"])){
		echo "Hello {$_SESSION} you can change your password here";
	}else{
		echo "<form action=\"{$_SERVER["PHP_SELF"]}\"  method=\"POST\">
		<p class='form_title'> Your email: </p>
		<input name=\"email\" type=\"text\"> </br>
		<input name=\"recover\" type=\"submit\" value=\"Recover\">
		</form>";
		
		include_once("../connection_to_db.php");
		include_once("recover_password_class.php");
		$rec_pass = new recover_password;
		$rec_pass->data($conn);
	}
?>
