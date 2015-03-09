<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	session_start();
	
	if(isset($_GET["code"])){
		include_once("classes/recover_password_class.php");
		include_once("connection_to_db.php");
		$rec_class = new recover_password();
		$rec_class->check_recovery_code($conn);
	}
	
	if(isset($_SESSION["recovery_code"])){
		echo "<form method=\"POST\" action=\"{$_SERVER["PHP_SELF"]}\"> 
		New password: <input name=\"password_one\" type=\"text\"> </br>
		Repeat password: <input name=\"password_two\" type=\"text\"> </br>
		<input type=\"submit\" name=\"recover_pass\"  value=\"Recover pass\">
	    </form>";
		include_once("classes/recover_password_class.php");
		include_once("connection_to_db.php");
		$rec_class = new recover_password();
		$rec_class->change_pass($conn);
	}else{
		header("location:index.php");
	}
	

	
	//http://localhost/files/finish_recovery.php?code=085e1b3d84aa14ad19f21a1fe855156b1423610487
?>