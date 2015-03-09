<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */



?>

<b> Login </b>
<form method="POST" action="<?PHP $_SERVER["PHP_SELF"];?>">
	Username: <input name="username" type="text" > </br>
	Password: <input name="password" type="text" > </br>
	<input name="login" type="submit" value="Login">
</form>

<?PHP
	if(!(isset($_SESSION))){
		session_start();
	}
	
	if(isset($_POST["login"])){
		include("../connection_to_db.php");
		include("login_class.php");
		$login = new login($conn);

	}
?>