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
	}else{
		echo "Hello {$_SESSION["logged_in"]}, this is your profile" . "</br>";
		echo "<a href=\"change_password/change_password.php\"> Change password </a> </br>";
		echo "<a href=\"index.php\"> Home </a>";
	}
?>
