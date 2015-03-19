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
		//if user is not logged in then sent to index.php
		//header("location: index.php");
		echo "send to index. usr not logged in";
	}else{		
		//show the form.
		echo "<form method=\"POST\" action=\"{$_SERVER['PHP_SELF']}\">
				Password: <input type=\"text\" name=\"password_one\"> </br>
				Repeat password: <input ype=\"text\" name=\"password_two\"> </br>
				<input name=\"change_password\" value=\"Change\" type=\"submit\">
			</form>";
	}
	
	include_once("classes/change_password_class.php");
	include_once("connection_to_db.php");
	$Recover_password = new Recover_password;
	$Recover_password->initialize_connection($conn);
	$Recover_password->is_posted();
	
	
	





?>
