<?PHP
	define('ALLOWED', true);
	include("chatbox_class.php");
	include("connection_to_db.php");
	Samichatbox::show_messages($conn);
?>