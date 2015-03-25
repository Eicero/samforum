

<?PHP
	session_start();
	include("../general/general_class.php");
	include("login_class.php");
	
	include("../connection_to_db.php");
	$Login = new Login;
	$Login->functions_processor($_POST, $conn);
	
?>

<form method="POST" action="<?PHP $_SERVER["PHP_SELF"];?>">
	Username: <input name="username" type="text" > </br>
	Password: <input name="password" type="text" > </br>
			  <input name="captcha" type="text" > </br>
			  <?PHP Login::display_captcha(); ?>
	<input name="login" type="submit" value="Login"> </br>
</form>

