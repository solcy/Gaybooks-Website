<?php
	require("dbconn.php");
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']===true){ //checks if logged in
		echo '<div align="right">You are logged in! <a href="signout.php">(Sign Out)</a></div>';
	}else{
		echo '<div align="right"><a href="login.php">Login   </a></div>';
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Gaybooks</title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="stylesheet" type="text/css" href="style2.css" media="screen" /><!-- from free-css.com -->
	<link rel="stylesheet" href="styles.css" type="text/css" /> <!-- from http://www.free-css.com/free-css-menus/page3 menu #33-->
	<!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->
	
	<style>
	a {font-weight: bold; color: #4CAF50; text-decoration: none;}
	a:hover {color: #00ccff;}
	</style>
</head>
<body>
<div id="dolphincontainer"> <!-- Start of the navigation/menu-->
  <div id="dolphinnav">
    <ul>
      <li><a href="index.php" class="current"><span>Home</span></a></li>
      <li><a href="http://www.free-css.com/"><span>Profile</span></a></li>
      <li><a href="http://www.free-css.com/"><span>Forum</span></a></li>
      <li><a href="http://www.free-css.com/"><span>About Us</span></a></li>
      <li><a href="application.php"><span>Reviewer Application</span></a></li>
    </ul>
  </div>
</div> <!-- End of navigation -->

<!-- <div id="header"> -->
  <!-- <h1>Gaybooks</h1> -->
<!-- </div> -->
<!--//end #header//-->

<div id="leftColumn">
  <h2></h2>
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Gallery</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</div>
<!--//end #leftColumn//-->

<div id="centerColumn">
  <h2></h2>
  <blockquote>
    <p><strong>blockquote</strong><br />
      Augur et fulgente decorus arcu Phoebus acceptusque novem Camenis, qui salutari levat arte fessos corporis artus.</p>
  </blockquote>
</div>
<!--//end #centerColumn//-->

<div id="rightColumn">
  <h2></h2>
  <p></p>
</div>
<!--//end #rightColumn//-->
</body>
</html>