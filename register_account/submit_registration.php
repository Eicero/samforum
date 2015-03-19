<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	if(!isset($_SESSION)){
		session_Start();
	}
	
	if(isset($_POST["register_user"])){
		require_once("form_registration_class.php");
		//require_once("login_class.php");
		require_once("../connection_to_db.php");
		$register_user = new register($_POST, $conn);
	}
?>
