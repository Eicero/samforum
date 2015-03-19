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
	
	include_once("admin_class.php");
	include_once("../connection_to_db.php");
	$Admin_cp = new Admin($conn);
	
	if( isset($_SESSION["logged_in"]) and ($Admin_cp->is_admin()) ){
		include_once("../connection_to_db.php");
		include_once("admin_class.php");
		echo "<a href=\"create_category.php\"> Create category </a> </br>";
		echo "<a href=\"edit_category.php\"> Edit category </a> </br>";
		echo "<a href=\"delete_category.php\"> Delete category </a>";
	}else{
		header("location: index.php");
	}
?>
