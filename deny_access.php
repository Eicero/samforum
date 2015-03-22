<?PHP
	//when this function is called it checks if ALLOWED constant is defined, it wont be defined if you're accessing this file directly, it has to be defined somewhere in other file, where this file is included.

	//Ex. search.php (includes search_class.php) - ALLOWED constant is defined in search.php
	//search_class(includes deny_access.php).
	
	
	function access($send_to){
        if(!defined('ALLOWED')){
            header("location: $send_to");
        }
    }
?>