<?PHP
	/* Copyright (c)  2015  S.Samiuddin.  phpdevsami@gmail.com
   Permission is granted to copy, distribute and/or modify this document
   under the terms of the GNU Free Documentation License, Version 1.2
   or any later version published by the Free Software Foundation;
   with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
   Texts.  A copy of the license is included in the section entitled "GNU
   Free Documentation License". */

   //work on search feature
	include_once("connection_to_db.php");

	session_start();
	
	//link to search bar
	echo "<a href=\"search.php\"> Search on this site </a> </br>";
	
	if(!isset($_SESSION["logged_in"])){
		//if user is not logged in then show login, register, and recover_password options
		echo "<a href='login_user/login.php'> Login </a> </br>";
		echo "<a href='register_account/register.php'> Register new account </a> </br>";
		echo "<a href='recover_password/recover_password.php'> Recover password </a> </br>";
	}else{
		echo "Hello, " .$_SESSION["logged_in"] . "</br>";
		echo "<a href=\"login_user/logout.php\"> Logout </a> </br>";
		echo "<a href=\"user_profile.php\"> My profile </a> </br>";
		echo "<a href=\"chat_box.php\"> Join chat </a> </br>";
		
		//If user is logged in(session exists), we're going to check if user is admin.
		include_once("login_user/login_class.php");
		include_once("connection_to_db.php");
		
		//..checks if user is admin
		login::show_admincp($conn);
	}
	
	//Shows categories and other things.
	include_once("show_data_class.php");
	$Data_display = new Data_display($conn);
	$Data_display->set_title("</br> <b> Boards </b>");
	$Data_display->show_categories();
?>
