<?PHP
	function access(){
        if(!defined('ALLOWED')){
            header("location: ../index.php");
        }
    }
    access();
?>