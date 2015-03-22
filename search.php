<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
Permission is granted to copy, distribute and/or modify this document
under the terms of the GNU Free Documentation License, Version 1.2
or any later version published by the Free Software Foundation;
with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
Texts.  A copy of the license is included in the section entitled "GNU
Free Documentation License". */
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
  <input name="search_query" type="text"> 
  <input name="search" type="submit" value="Search">
</form>
	
<?PHP
	//search data will be posted here and result will also be shown here.
	
	//Deny 
	define('ALLOWED', true);
	
	include("connection_to_db.php");
	include("search_class.php");
	
	$Search = new Search;
	if($Search->set_data($conn, $_GET)){
		$Search->search_in_db();
	}
?>