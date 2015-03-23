<?PHP

/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
Permission is granted to copy, distribute and/or modify this document
under the terms of the GNU Free Documentation License, Version 1.2
or any later version published by the Free Software Foundation;
with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
Texts.  A copy of the license is included in the section entitled "GNU
Free Documentation License". */


	//deny direct access to this file. One search.php is allowed to use this file.
	include("deny_access.php");
	access("index.php");
	
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
						echo "<a target=\"_blank\" href=\"threads.php?thread_id={$row["thread_id"]}&cat_id={$row["category_id"]}\"> {$row["thread_title"]} </a> </br>";
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