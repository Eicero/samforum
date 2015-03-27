<?PHP
include("thread_editor_class.php");
include("connection_to_db.php");

$Thread_editor = new Thread_editor;
$Thread_editor->connection_setter($conn);

if($Thread_editor->is_user_logged_in("logged_in")){
	if($Thread_editor->check_if_allowed_to_edit()){
		echo "hi";
	}else{
		echo "You're not allowed to edit this thread";
	}
}






?>