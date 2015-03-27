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

	//deny direct access to this file. One search.php is allowed to use this file.
	include("../deny_access.php");
	access("../index.php");
	
	class Search{
		protected $conn;
		function set_data($conn){
			$this->conn = $conn;
			if(isset($_GET["search"])){
				if(strlen($_GET["search_query"]) > 2){
					$this->search_this = $_GET['search_query'];
					return true;
				}else{
					echo "invalid query";
					return false;
				}
			}
		}
		
		function search_in_db(){
		
			$query_string = $this->conn->prepare("select category_id, thread_id, thread_title, thread_body from thread where thread_title LIKE :thread_title OR thread_body LIKE :thread_body");
			
			$select_table = $this->conn->prepare("select 1 from thread");
			
			//checking if threads table exists before searching through threads
			if($select_table->execute()){
				if( $query_string->execute(array(':thread_title'=>"%$this->search_this%", ':thread_body'=>"%$this->search_this%")) ){
					while($row = $query_string->fetch(PDO::FETCH_ASSOC) ){
						echo "<a target=\"_blank\" href=\"../threads.php?thread_id={$row["thread_id"]}&cat_id={$row["category_id"]}\"> {$row["thread_title"]} </a> </br>";
						$returned_result = true;
					}
					if(!isset($returned_result)){
						die("No match found");
					}
				}else{
					
					//echo var_dump($this->conn->errorInfo());
					die("couldn't perform query, perhaps the tables haven't yet been created. Create tables before perofrming a search");
				}
			}else{
				echo "Well you cannot peform search query when there's no thread on the board.";
			}
		}
	}
	
	






?>