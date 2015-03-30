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

	
	//Dall form data is sent this this file.
	
	if(!isset($_SESSION)){
		session_Start();
	}
	
	if(isset($_POST["register_user"])){
		require_once("form_registration_class.php");
		require_once("../connection_to_db.php");
		$register_user = new register($_POST, $conn);
	}
?>
