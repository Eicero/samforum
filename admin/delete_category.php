<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

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
