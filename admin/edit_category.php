<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

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
		header("location: index.php");
	}
?>
