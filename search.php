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
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
  <input name="search_query" type="text">
  <input name="search" type="submit" value="search">
</form>
	
<?PHP
	//search data will be posted here and result will also be shown here.
	
	//Deny 
	define('ALLOWED', true);
	
	include("connection_to_db.php");
	include("search_class.php");
	
	$Search = new Search;
	if($Search->set_data($conn)){
		$Search->search_in_db();
	}
	
	
?>