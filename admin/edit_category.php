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
	}
	
	define('ALLOWED', true);
	include_once("admin_class.php");
	include_once("../connection_to_db.php");
	$Admin_cp = new Admin($conn);
	
	if( isset($_SESSION["logged_in"]) and ($Admin_cp->is_admin()) ){
		include_once("../connection_to_db.php");
		include_once("../show_data_class.php");
		include_once("edit_info_class.php");
		
		$Data_display_to_edit = new Data_display($conn);
		$Data_display_to_edit->file = "edit_category.php";
		$Data_display_to_edit->set_title("</br> <b> Click on the category title to edit </b>");
		
		$Data_display_to_edit->show_categories();
		
		$Edit_info = new edit_info($conn);
		$Edit_info->edit_category();
	}else{
		header("location: ../index.php");
	}
?>
