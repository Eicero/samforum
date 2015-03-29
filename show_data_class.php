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

	class Data_display{
		private $conn;
		private $title;
		
		function __construct($conn){
			$this->conn = $conn;
			$this->file = "opened_category.php";
		}
		
		function set_title($title){
			$this->title = $title;
		}
		
		function show_categories(){
			$select_data_query = $this->conn->prepare("select category_id, category_name, category_description from categories");
			
			if($select_data_query->execute()){
				echo $this->title;
				while($data = $select_data_query->fetch(PDO::FETCH_ASSOC)){
					echo "</br>";
					echo "<a href=\"$this->file?cat_id={$data["category_id"]}\"> {$data["category_name"]} </a> </br>";
					echo $data["category_description"] . "</br>";
				}
			}
		}
		
		function show_threads(){
			
			$select_data_query = $this->conn->prepare("select thread_id, thread_by, thread_title, thread_created_time from thread where category_id = :category_id");
			
			$select_category_name = $this->conn->prepare("select category_name from categories where category_id = :category_id");
			
			$select_category_name->execute(array('category_id'=>$_GET["cat_id"]));
			
			$cat_name = $select_category_name->fetch(PDO::FETCH_ASSOC);
			echo "<h3> {$cat_name["category_name"]} </h3>";
			
			if($select_data_query->execute(array('category_id'=>$_GET["cat_id"]))){
				while($data = $select_data_query->fetch(PDO::FETCH_ASSOC)){
					echo "<a href=\"threads.php?thread_id={$data["thread_id"]}&cat_id={$_GET["cat_id"]}\"> {$data["thread_title"]} </a> </br>";
					echo "Thread by: " . $data["thread_by"] . "</br>";
					echo "Created on: " . $data["thread_created_time"] . "</br> </br>";
				}
			}
		}
		
		
		function show_thread_body(){
			
			$select_data_query = $this->conn->prepare("select thread_id, thread_by, thread_title, thread_body, thread_created_time from thread where thread_id = :thread_id");
			
			$select_category_name = $this->conn->prepare("select category_name from categories where category_id = :category_id");
			
			$select_category_name->execute(array('category_id'=>$_GET["cat_id"]));
			
			$cat_name = $select_category_name->fetch(PDO::FETCH_ASSOC);
			echo "<h3> {$cat_name["category_name"]} </h3>";
			
			if($select_data_query->execute(array('thread_id'=>$_GET["thread_id"]))){
				while($data = $select_data_query->fetch(PDO::FETCH_ASSOC)){
					//echo "<a href=\"threads.php?thread_id={$data["thread_id"]}\"> {$data["thread_title"]} </a> </br>";
					echo "Thread by: " . $data["thread_by"] . "</br>";
					echo "Created on: " . $data["thread_created_time"] . "</br>";
					echo "Thread_title: " . htmlentities($data["thread_title"]) . "</br>";
					echo "Thread_body: " . "<b>" . htmlentities($data["thread_body"]) . "</b>" . "</br> </br>";
				}
			}
		}
		
		
		function show_replies(){
			$select_replies_query = $this->conn->prepare("select reply_body, reply_by, reply_time from replies where thread_id = :thread_id");
			if($select_replies_query->execute(array('thread_id'=>$_GET["thread_id"]))){
			//http://localhost/files/threads.php?thread_id=1&cat_id=2
				while( $replies_to_show = $select_replies_query->fetch(PDO::FETCH_ASSOC) ){
					echo "Reply by: " . $replies_to_show["reply_by"] . "</br>";
					echo "Replied on " . $replies_to_show["reply_time"] . "</br>";
					echo "Reply: " . "<b>" . htmlentities($replies_to_show["reply_body"]) . "</b>" . "</br> </br>";

				}
			}			
		}
		
		
	}
?>
