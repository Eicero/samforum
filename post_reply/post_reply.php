<?PHP
	/* Copyright (c)  2015  S.Samiuddin. phpdevsami@gmail.com
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

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
