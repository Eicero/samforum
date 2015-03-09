<?PHP

	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	session_start();
	if(isset($_SESSION["message"])){
		echo $_SESSION["message"] . "</br>";
		echo  "<a href=\"index.php\"> Back to homepage! </a> </br>";
		if($_SESSION["message"] == "Unknown error occured, please contact admin."){
			echo  "<a href=\"change_password.php\"> Try again! </a>";
		}		
		unset($_SESSION["message"]);
	}else{
		header("location: index.php");
	}
?>