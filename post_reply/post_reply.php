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

session_start();
include("post_reply_class.php");
include("../connection_to_db.php");

//do these if only is user if logged in. this also shows the form if user if logged in.
$Post_reply = new reply($conn);

//takes care of making sure user is logged in. thread_id and cat_id variables exist, reply length and empty reply...
if($Post_reply->set_reply()){
	$Post_reply->post_reply();
}








?>
