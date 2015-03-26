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
