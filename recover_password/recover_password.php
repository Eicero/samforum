<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	if(isset($_SESSION["logged_in"])){
		echo "Hello {$_SESSION} you can change your password here";
	}else{
		echo "<form action=\"{$_SERVER["PHP_SELF"]}\"  method=\"POST\">
		<b> Recover password </b> </br>
		Your email:
		<input name=\"email\" type=\"text\"> </br>
		<input name=\"recover\" type=\"submit\" value=\"Recover\">
		</form>";
		
		include_once("../connection_to_db.php");
		include_once("recover_password_class.php");
		$rec_pass = new recover_password;
		$rec_pass->data($conn);
	}
?>