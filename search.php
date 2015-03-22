
	
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