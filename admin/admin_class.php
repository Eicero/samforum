<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	class Admin{
		protected $conn;
		function __construct($conn){
			$this->conn = $conn;
		}
		
		//check if power is 1(admin).
		function is_admin(){
			$select_power = $this->conn->prepare("select power from registered_users where username = :username");
			$select_power->execute(array('username'=>$_SESSION["logged_in"]));
			$select_power = $select_power->fetch(PDO::FETCH_ASSOC);
			if($select_power["power"] == 1){
				return true;
			}else{
				header("index.php");
			}
		}
		
		private function create_table(){
			$create_table = $this->conn->prepare("create table if not exists categories(
				category_id int not null auto_increment,
				category_name varchar(30) not null,
				category_description varchar(100) not null,
				primary key(category_id)
			)");
			if($create_table->execute()){
				return true;
			}else{
				echo 'Create_table method in admin_class failed to create categories table.';
				return false;
			}
		}
		
		private function create_category(){
			$query_create_category = $this->conn->prepare("insert into categories(category_name, category_description) values(:category_name, :category_description)");
			
			if( $query_create_category->execute(array('category_name'=>$this->cat_name, 'category_description'=>$this->cat_body)) ){
				echo "category $this->cat_name created";
			}
		}
		
		
		private function validate_data(){
			if( !empty($_POST["category_name"]) and !empty($_POST["category_body"]) ){
					$this->cat_name = strip_tags(stripslashes(trim($_POST["category_name"], '"')));
					$this->cat_body = strip_tags(stripslashes(trim($_POST["category_body"], '"')));
					$this->create_category();
			}else{
				echo "Leave no field empty";
			}
		}

		public function check_set(){
			if(isset($_POST["make_category"])){
				if($this->create_table()){
					$this->validate_data();
				}
			}
		}
	}
	
	class Delete_category extends Admin{
	
		function __construct($conn){
			$this->conn = $conn;
		}
		
		public function show_categories_to_delete(){
			
			$select_categories_query = $this->conn->prepare("select category_name, category_id from categories");
			if($select_categories_query->execute()){
				echo "<b> Choose categories to delete </b>";
				echo "<form method=\"POST\" action=\"{$_SERVER["PHP_SELF"]}\">";
					while($get_data_back = $select_categories_query->fetch(PDO::FETCH_ASSOC)){
						echo $get_data_back["category_name"] . "<input name='cat_id[]' value=\"{$get_data_back["category_id"]}\" type=\"checkbox\"> </br>";
					}
					echo "<input name=\"del_cat\" type=\"submit\" value=\"Delete category\"> ";
				echo "</form>";
				
				if($this->is_data_received()){
					$this->delete_categories();
				}
				
			}else{
				return false;
			}
		}
		
		function is_data_received(){
			if(isset($_POST["del_cat"])){
				if(!empty($_POST["cat_id"])){
					return true;				
				}else{
					echo "Please choose alteast one category to delete";
					return false;
				}
			}			
		}
		
		function delete_categories(){
			//$this->conn->prepare("delete ");
			foreach($_POST["cat_id"]  as $checked_items ){
				$delete_query = $this->conn->prepare("delete from categories where category_id = :category_id");
				if( $delete_query->execute(array('category_id'=>$checked_items)) ){
					echo "categories sucessfully deleted";
				}else{
					echo "couldn't delete categories";
				}
			}
		}
		
	}
?>