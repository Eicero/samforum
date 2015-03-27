<?PHP
include("thread_editor_class.php");
include("connection_to_db.php");

$Thread_editor = new Thread_editor;
$Thread_editor->connection_setter($conn);

if($Thread_editor->is_user_logged_in("logged_in")){
	if($Thread_editor->check_if_allowed_to_edit()){
		$Thread_editor->show_edit_form();
		if($Thread_editor->validate_submitted_info()){
			$Thread_editor->update_info();
		}
	}else{
		header("location: index.php");
	}
}






?>