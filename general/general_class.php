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
	
abstract class General{

	//This method generates captcha.
	static function display_captcha(){
		//possible letters that can can come in captcha.
		$possible_letter = array("a", "z", "b", "t", "k", "s", "m");

		//just random number.
		$random_letter = rand(1, 6);

		//Whole random string combined with numbers and letters
		$whole_random_possibility = $possible_letter[$random_letter] . rand(100, 199) . $possible_letter[$random_letter];

		//random string stored in this session
		$_SESSION["random_string"] = $whole_random_possibility;

		//return image identifies represending black image of speficied size
		$image = imagecreatetruecolor(70, 30);

		//create text color for specified image.
		$text_color = imagecolorallocate($image, 255, 255, 255);

		//paste the string on top of the image
		imagestring($image, 5, 5, 5, $whole_random_possibility, $text_color);

		//outputs saves the image to same directory as other files.
		imagepng($image, "image.png");
		echo "<img src='image.png'> </br>";
	}
	
	//This method checks if captcha is right.
	static function is_captcha_right(){
		//Check if captcha matches the text inserted. random string session is made by captcha class
		if($_POST["captcha"] == $_SESSION["random_string"]){
			return true;
		}else{
			echo "Wrong captcha inserted, try again";
		}
	}
 
	//Checks if user is logged in. Accepts session name as a parameter. like "logged_in"
	public function is_user_logged_in($session_name){
			if(isset($_SESSION[$session_name])){
				$this->username = $_SESSION["logged_in"];
				return true;
			}else{
				return false;
			}
		}
	
	//this method checks if connection exists and sets it so it can be used anywhere in child class.
	public function connection_setter($conn){
		$this->conn = $conn;
	}
 
 
 }













?>