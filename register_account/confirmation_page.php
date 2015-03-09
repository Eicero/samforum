<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */


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