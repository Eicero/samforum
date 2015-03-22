<?PHP

/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
Permission is granted to copy, distribute and/or modify this document
under the terms of the GNU Free Documentation License, Version 1.2
or any later version published by the Free Software Foundation;
with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
Texts.  A copy of the license is included in the section entitled "GNU
Free Documentation License". */



//your host details.
$host = "";
$db = "";
$user = "";
$pass = "";


try{
	$conn = new pdo('mysql:host='. $host . ';dbname=' . $db, $user, $pass);				
}catch(PDOException $error){
	echo $error->getMessage();
	die();
}

?>
