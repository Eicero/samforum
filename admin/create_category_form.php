<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

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
