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
	
	if(isset($_GET["code"])){
		include_once("recover_password_class.php");
		include_once("../connection_to_db.php");
		$rec_class = new recover_password();
		$rec_class->check_recovery_code($conn);
	}
	
	if(isset($_SESSION["recovery_code"])){
		echo "<form method=\"POST\" action=\"{$_SERVER["PHP_SELF"]}\"> 
		New password: <input name=\"password_one\" type=\"text\"> </br>
		Repeat password: <input name=\"password_two\" type=\"text\"> </br>
		<input type=\"submit\" name=\"recover_pass\"  value=\"Recover pass\">
	    </form>";
		include_once("recover_password_class.php");
		include_once("../connection_to_db.php");
		$rec_class = new recover_password();
		$rec_class->change_pass($conn);
	}else{
		header("location:index.php");
	}
	

	
	//http://localhost/files/finish_recovery.php?code=085e1b3d84aa14ad19f21a1fe855156b1423610487
?>
