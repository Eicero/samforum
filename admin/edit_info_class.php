<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	include("../deny_access.php");
	class edit_info{
		public $conn;
		function __construct($conn){
			$this->conn = $conn;
		}
		
		function edit_category(){
			if(isset($_GET["cat_id"])){			
				$category_id = $_GET["cat_id"];				
				$select_cat = $this->conn->prepare("select category_name, category_description from categories where category_id = :category_id");					
				$select_cat->execute(array('category_id'=>$category_id));				
				$show_cat = $select_cat->fetch(PDO::FETCH_ASSOC);				
				$edit_cat_form = "<form method=\"POST\"  action=\"?cat_id=$category_id\">
					<input name = \"category_name\" type=\"text\" value=\"{$show_cat['category_name']}\"> </br>
					<textarea name = \"category_description\">{$show_cat['category_description']}</textarea>
					<input type=\"submit\" name=\"edit_category_name\" value=\"Edit!\">
				</form>";				
				echo "<b></b></br></br> {$show_cat['category_name']}  section </b>";
				echo $edit_cat_form;			
			}
			
			if(isset($_POST["edit_category_name"]) and isset($_GET["cat_id"])){
				if(!empty($_POST["category_name"]) and !empty($_POST["category_description"])){
					$category_id = $_GET["cat_id"];					
					$category_description = $_POST["category_description"];					
					$category_name = $_POST["category_name"];					
					$edit_cat_name = $this->conn->prepare("update categories set category_name = :category_name, category_description  = :category_description where category_id = :category_id");					
					if($edit_cat_name->execute(array('category_name'=>$category_name, 'category_description'=>
					$category_description, 'category_id'=>$category_id))){
						$this->show_message("Category edited");
					}
				}
			}
		}
		
		private function show_message($message){
			session_start();
			$_SESSION["message"] = $message;
			header("location: ../show_message.php");
		}
		
	}
?>
