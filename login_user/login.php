<form method="POST" action="<?PHP $_SERVER["PHP_SELF"];?>">
	Username: <input name="username" type="text" > </br>
	Password: <input name="password" type="text" > </br>
	<input name="login" type="submit" value="Login">
</form>

<?PHP
	include("login_class.php");
	include("../connection_to_db.php");
	$Login = new Login;
	$Login->functions_processor($_POST, $conn);
?>