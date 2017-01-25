<?php
	require("dbconn.php");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Gaybooks</title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="stylesheet" type="text/css" href="style2.css" media="screen" /> <!-- from free-css.com -->
	<link rel="stylesheet" href="styles.css" type="text/css" /> <!-- from http://www.free-css.com/free-css-menus/page3 menu #33-->
	<link rel="stylesheet" href="loginstyle.css" /> <!-- from http://codepen.io/colorlib/pen/rxddKy -->
	<!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->
	<style>
		.error {color: #FF0000; font-size: 80%;}
		textarea{resize: none;}
		table {width:1000px;margin: 10px auto;}
	</style>
</head>
<body>
<div id="dolphincontainer"> <!-- Start of the navigation/menu-->
  <div id="dolphinnav">
    <ul>
      <li><a href="index.php"><span>Home</span></a></li>
      <li><a href=""><span>Profile</span></a></li>
      <li><a href=""><span>Forum</span></a></li>
      <li><a href=""><span>About Us</span></a></li>
      <li><a href="application.php"><span>Reviewer Application</span></a></li>
    </ul>
  </div>
</div> <!-- End of navigation -->

<!-- <div id="header"> -->
  <!-- <h1>Gaybooks</h1> -->
<!-- </div> -->
<!--//end #header//-->

<div id="leftColumn">
  <h2>leftColumn</h2>
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Gallery</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</div>
<!--//end #leftColumn//-->

<div id="centerColumn">
<?php
	
	if(empty($_POST)){
		echo '<div class="login-page"><!-- Login page CSS from https://dcrazed.com/css-html-login-form-templates/-->
		<div class="form">
			<form class="login-form">
				<input type="text" name="username" placeholder="username" ';
		if(isset($_POST['username'])) echo "value=" . "'" .$_POST['username'] . "' ";
		echo 'required><span class="error">';
		if(isset($usernameErr)) echo $usernameErr; //displays error if error is assigned
		echo '</span>
		<input type="password" name="password" placeholder="password" ';
		echo 'required><span class="error">';
		if(isset($passwordErr)) echo $passwordErr; //displays error if error is assigned
		echo '</span>
			<button type="submit" name="login" formmethod="post">login</button>
			<p class="message">Not registered? <a href="register.php">Create an account</a></p>'; //insert register link here
		echo '</form>
			</div>
		</div>';
		echo "<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>";

		echo '<script src="index.js"></script>';
	}else{
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		
		$passquery = "SELECT password FROM GBUsers WHERE username = '{$username}'";
		$pass = mysqli_query($db, $passquery);
		$passarr = mysqli_fetch_assoc($pass);
		$passstring=$passarr['password'];
		
		
		
		if(empty($username)){
			$usernameErr = "* username required";
		}elseif(!$pass){
			$usernameErr = "* wrong username/password";
		}elseif(!($passstring===$password)){
			$usernameErr = "* wrong username/password";
		}
		
		if(empty($password)){
			$passwordErr = "* password required";
		}

		
		if(isset($usernameErr) || isset($passwordErr)){
			echo '<div class="login-page"><!-- Login page CSS from https://dcrazed.com/css-html-login-form-templates/-->
			<div class="form">
				<form class="login-form">
					<input type="text" name="username" placeholder="username" ';
			if(isset($_POST['username'])) echo "value=" . "'" .$_POST['username'] . "' ";
			echo 'required><span class="error">';
			if(isset($usernameErr)) echo $usernameErr; //displays error if error is assigned
			echo '</span>
			<input type="password" name="password" placeholder="password" ';
			echo 'required><span class="error">';
			if(isset($passwordErr)) echo $passwordErr; //displays error if error is assigned
			echo '</span>
				<button type="submit" name="login" formmethod="post">login</button>
				<p class="message">Not registered? <a href="register.php">Create an account</a></p>'; //insert register link here
			echo '</form>
				</div>
			</div>';
			echo "<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>";

			echo '<script src="index.js"></script>';
		}else{
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $_POST['username'];
			
			$adminquery = "SELECT COUNT(*) FROM GBUsers WHERE username = '{$username}' AND admin = 'yes'";
			$admin = mysqli_query($db, $adminquery);
			$adminBoolean = mysqli_fetch_array($admin);
			
			if($adminBoolean[0]==1){
				$_SESSION['admin'] = 'yes';
			}
			
			echo '<script type="text/javascript">';
			echo "window.location.href = 'index.php';
			</script>";
		}
		mysqli_free_result($pass);
		mysqli_close($db);
	}

?>





</div>
<!--//end #centerColumn//-->

<div id="rightColumn">
  <h2></h2>
  <p></p>
</div>
<!--//end #rightColumn//-->

</body>
</html>