<?PHP
	/* Copyright (c)  2015  S.Samiuddin.
	Permission is granted to copy, distribute and/or modify this document
	under the terms of the GNU Free Documentation License, Version 1.2
	or any later version published by the Free Software Foundation;
	with no Invariant Sections, no Front-Cover Texts, and no Back-Cover
	Texts.  A copy of the license is included in the section entitled "GNU
	Free Documentation License". */

	if( isset($_GET["thread_id"]) and isset($_GET["cat_id"]) ){
		include_once("connection_to_db.php");
		include_once("show_data_class.php");
		$Show_thread_body = new Data_display($conn);
		$Show_thread_body->show_thread_body();
		
		$Show_thread_body->show_replies();
		
		echo "<a href=\"post_reply/post_reply.php?thread_id={$_GET["thread_id"]}&cat_id={$_GET["cat_id"]} \"> Post a reply </a>";
	}else{
		header("location:index.php");
	}

?>
