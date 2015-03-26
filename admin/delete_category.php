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
	include_once("../connection_to_db.php");
	include_once("admin_class.php");
	
	//This returns true if user is admin.
	$Admin = new Admin($conn);
	
	if( isset($_SESSION["logged_in"]) and ($Admin->is_admin()) ){
	
		$Del_cat = new Delete_category($conn);
		
		//displays all the categories with checkbox 
		$Del_cat->show_categories_to_delete();

	}else{
		header("location: ../index.php");
	}
?>
