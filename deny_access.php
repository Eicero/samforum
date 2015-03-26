<?PHP
//******************************************//
//* This copyright notice must not be removed
//* under any circumstances.
//* It must stay intact in all the files.

//* Samforum
//* Version 1.0
//* Script created by Samiuddin Samiuddin
//* Email: phpdevsami@gmail.com
//* Skype: n0h4cks

//* - This is not an open source project, functions/classes
//*   or any other code form this script cannot be
//*   used for other scripts or applications.

//*   You are not allowed to resell this script.

//* - You are free to make modification/changes,
//*   however it must be for your own use.
//*********************************************************************//

	//when this function is called it checks if ALLOWED constant is defined, it wont be defined if you're accessing this file directly, it has to be defined somewhere in other file, where this file is included.

	//Ex. search.php (includes search_class.php) - ALLOWED constant is defined in search.php
	//search_class(includes deny_access.php).
	
	
	function access($send_to){
        if(!defined('ALLOWED')){
            header("location: $send_to");
        }
    }
?>