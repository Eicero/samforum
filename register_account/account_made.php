
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
	if(!$_SESSION["acc_made"]){
		header("location: index.php");
	}else{
		echo "Account sucessfully created, please verify";
		
		echo "<a href=\"index.php\"> Return to the homepage </a>";
		session_destroy();
	}

?>
