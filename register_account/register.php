<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

session_start();

?>

<b> Register new account </b>
<form method="POST" action="submit_registration.php">
	Username: <input name="username" type="text"> </br>
	Email: <input name="email" type="text"> </br>
	Password <input name="password_one" type="text"> </br>
	Repeat Password <input name="password_two" type="text"> </br>
	Enter captcha <input name="captcha" type="text"> </br>
	
	<?PHP include("form_registration_class.php"); register::display_captcha(); ?>
	<input name="register_user" type="submit" value="Register">
</form>