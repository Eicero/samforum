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

	//define('ALLOWED', true);
	include_once("admin_class.php");
	include_once("../connection_to_db.php");
	$Admin_category = new Admin($conn);
	if( isset($_SESSION["logged_in"]) and ($Admin_category->is_admin()) ){
			echo "<form method=\"POST\" action=\"{$_SERVER['PHP_SELF']}\">
				Category Name: </br> <input type=\"text\" name=\"category_name\"> </br>
				Category Description: </br> <textarea name=\"category_body\"></textarea> </br>
				<input type=\"submit\" name=\"make_category\" value=\"Make category\">
		 </form>";
		$Admin_category->check_set();
	}else{
		header("location: ../index.php");
	}
?>
