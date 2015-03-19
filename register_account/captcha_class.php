<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	
/*
	function: imagestring();
    Image reference.
    Font-size of the text (it can be 5 at most).
    x-coordinate (changing proportionally for every alphabet).
    y-coordinate (kept the same, although we could change this randomly too).
    Actual string to be written.
    Font-color of the text.
*/
if(!isset($_SESSION)){
	session_start();
}

class captcha{
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
}
?>


