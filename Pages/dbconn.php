<?php
	session_start();

	$dbhost = "localhost";
	$dbuser = "abc53";
	$dbpass = "";
	$dbname = "abc53";

	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname); //connect to database

	if(mysqli_connect_errno()){
		die("Database connection failed.");
	}

?>