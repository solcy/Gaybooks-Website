<?php
	session_start();
	unset($_SESSION['loggedin']);
	
	if(isset($_SESSION['username'])){
		unset($_SESSION['username']);
	}
	if(isset($_SESSION['userID'])){
		unset($_SESSION['userID']);
	}
	if(isset($_SESSION['admin'])){
		unset($_SESSION['admin']);
	}
	
	if(isset($_SESSION['psrevious'])){
		unset($_SESSION['previous']);
	}
	header("Location: login.php");
?>