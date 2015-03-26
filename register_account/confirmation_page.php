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


class confirmation{
	private $code;
	private $conn;
	
	function __construct($conn){
		$this->conn = $conn;
	}
	
	function set_code(){
		if(isset($_GET["code"])){
			$this->code = $_GET["code"];
			$this->check_code();
		}else{
			header("location: ../index.php");
		}
	}
	
	private function check_code(){
		$select_confirmation_from_db = $this->conn->prepare("select confirmation_code from registered_users where confirmation_code = :code");
		$select_confirmation_from_db->execute(array('code'=>$this->code));
		$result = $select_confirmation_from_db->fetch(PDO::FETCH_ASSOC);
		if($result){
			$confirm_account = $this->conn->prepare("update registered_users set is_confirmed = 1 where confirmation_code = :code");
			$confirm_account->execute(array('code'=>$this->code));
			
			//Deleting confirmation code so if user visits the same page again, or tried to visit with same confirmation code, throw error because code's been deleted once used.
			$delete_confirmation_code = $this->conn->prepare("update registered_users set confirmation_code = '' where confirmation_code = :code");
			$delete_confirmation_code->execute(array('code'=>$this->code));
			
			session_start();
			$_SESSION["acc_con"] = "acc_con";
			header("location: account_confirmed.php");
		}
		if(!$result){
			header("location: ../index.php");
		}
	}
}

include("../connection_to_db.php");
$confirm = new confirmation($conn);
$confirm->set_code($_GET);



?>
