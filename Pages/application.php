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
	
	<link rel="stylesheet" type="text/css" href="style2.css" media="screen" /> <!-- from free-css.com -->
	<link rel="stylesheet" href="styles.css" type="text/css" /> <!-- from http://www.free-css.com/free-css-menus/page3 menu #33-->
	<!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->
	<style>
		.error {color: #FF0000; font-size: 80%;}
		textarea{resize: none;}
		table {width: 1000px; margin: 10px auto;}
		a {font-weight: bold; color: #4CAF50; text-decoration: none;}
		a:hover {color: #00ccff;}
	</style>
	<script type="text/javascript">
     function checkWordLen(obj, wordLen){
      var len = obj.value.split(/[\s]+/);
       if(len.length > wordLen){
           alert("You cannot put more than "+wordLen+" words in this text area.");
           obj.oldValue = obj.value!=obj.oldValue?obj.value:obj.oldValue;
           obj.value = obj.oldValue?obj.oldValue:"";
           return false;
       }
     return true;
   }
   </script>
</head>
<body>
<?php
		function validate($data) { //generically validates data
			$data = trim($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	
		function textOnly($data){ //tests data to make sure it doesn't contain anything but letters
			if(!preg_match('/^([^[:punct:]\d]+)$/',$data)){
				return false;
			}else{
				return true;
			}
		}
	
		function validNum($num, $desiredLength){ //returns true if $num is of the desired length $desiredLength, and false if its not
			if(strlen($num) == $desiredLength){
				return true;
			}else{
				return false;
			}
		}
	
		function endswith($string, $test) {
			$strlen = strlen($string);
			$testlen = strlen($test);
			if ($testlen > $strlen) return false;
			return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
		}
	
		
		$datemax = date('Y-m-d', strtotime("-18 years",time()));
		$datemin = date('Y-m-d', strtotime("-100 years",time()));
		
?>
<div id="dolphincontainer"> <!-- Start of the navigation/menu-->
  <div id="dolphinnav">
    <ul>
      <li><a href="index.php"><span>Home</span></a></li>
      <li><a href=""><span>Profile</span></a></li>
      <li><a href=""><span>Forum</span></a></li>
      <li><a href=""><span>About Us</span></a></li>
      <li><a href="application.php" class="current"><span>Reviewer Application</span></a></li>
    </ul>
  </div>
</div> <!-- End of navigation -->


<div id="header">
<?php
	if(isset($_SESSION['admin']) && $_SESSION['admin']==='yes'){
		echo '<center><h2> Application Review</h2></center>';
	}
?>
	
<div> <!-- End of header -->

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
<?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']===true){
	if(isset($_SESSION['admin']) && $_SESSION['admin']==='yes'){
		
		$appReviewQuery = "SELECT * FROM GBApplication";
		$appReview = mysqli_query($db, $appReviewQuery);
		
		$totalRecords = mysqli_num_rows($appReview); //gets total number of rows in GBApplication
		$pages = $totalRecords;
		if(!isset($_GET['id'])){
			$appsQuerys = "SELECT appID FROM GBApplication WHERE appID > 0 ORDER BY appID LIMIT 1";
			$appResults = mysqli_query($db, $appsQuerys);
			$initialID = mysqli_fetch_array($appResults);
			
			$id = $initialID[0];
		}else{
			$id = $_GET['id'];
		}
		
		$appsQuery = "SELECT * FROM GBApplication WHERE appID = {$id} ORDER BY appID LIMIT 1";
		$appResult = mysqli_query($db, $appsQuery);
		  // Fetch one and only one row
	
		while($row = mysqli_fetch_row($appResult)){
			//echo '<h1><center>Application Review</center></h1><br/><br/>';
			echo '<table style="margin: 0px auto;" border="0"><tr>
				<td width="50%"><p>';
				echo "<strong>Name:</strong> {$row[2]} {$row[3]} ";
				if(isset($row[4])){
					echo "({$row[4]})";
				}
				echo "</td>";
				echo "<td><strong>Gender:</strong> {$row[6]}</td><tr>";
				echo "<tr><td><strong>E-mail:</strong> {$row[7]}</td>";
				echo "<td><strong>Birthdate:</strong> {$row[5]}</td></tr>";
				echo "<tr><td>";
				
				if($row[8]=='yes' && $row[9]=='yes'){
					echo 'Already has a degree in English/Writing and is working towards another.';
				}elseif($row[8]=='yes'){
					echo 'Has a degree in English/Writing.';
				}elseif($row[9]=='yes'){
					echo 'Working towards a degree in English/Writing.';
				}else{
					echo 'No degree in English/Writing and not working towards it.';
				}
				echo '</td></tr></table>';
				echo '<table><tr><td>';
				
				if($row[10]=='yes'){
					echo "<strong>Published: </strong> {$row[11]}";
				}else{
					echo "Has not published.";
				}
				
				echo "</td></tr><tr><td><strong>Reason for applying: </strong>{$row[12]}</td></tr>";
				echo "<tr><td><strong>Sample writing: </strong>{$row[13]}</td></tr></p></table>";
				
				
				echo '<br/><br/><table><tr>';
				
				
				
				if(isset($_GET['id']) && !is_null($_GET['id'])){
					//$id = $_GET['id'];
					$queryNext = "SELECT appID FROM GBApplication WHERE appID > {$_GET['id']} ORDER BY appID LIMIT 1";
					$next = mysqli_query($db, $queryNext);
					$nextID = mysqli_fetch_array($next);
					
					$queryPrev = "SELECT appID FROM GBApplication WHERE appID < {$_GET['id']} ORDER BY appID DESC LIMIT 1";
					$prev = mysqli_query($db, $queryPrev);
					$prevID = mysqli_fetch_array($prev);
					
					if($prevID){
						echo '<td><a href="application.php?id=' . $prevID[0] . '">Previous</a></td>';
					}
					
					if($nextID){
						echo '<td><div align="right"><a href="application.php?id=' . $nextID[0] . '">Next</a></div></td>';
					}
					
				}else{
					$queryNext = "SELECT appID FROM GBApplication WHERE appID > $row[0] ORDER BY appID LIMIT 1";
					$first = mysqli_query($db, $queryNext);
					$firstID = mysqli_fetch_array($first);
					$id = $row[0];
					
					echo '<td width=50%></td><td><div align="right"><a href="application.php?id=' . $firstID[0] . '">Next</a></div></td>';
				}
				
				echo '</table>';
		}//end of while loop
		
		  
				
				
	
		  
		 mysqli_free_result($appResult); // Free result set
		
		mysqli_free_result($appReview);//frees result
		
		//might have to make an array of "SELECT * appID FROM GBApplication" then get the associative array for the ID
	
	}else{
		
	  if(empty($_POST)){
				$datemax = date('Y-m-d', strtotime("-18 years",time()));
				$datemin = date('Y-m-d', strtotime("-100 years",time()));
				
				echo '<br/><br/><br/><table><tr><td><h1>Reviewer Application</h1></td></tr></table>
				<table style="margin: 0px auto;" border="0"><tr><td width="50%"><p>By filling out this application, you can apply to become an official book reviewer on this site. 
			Although this <br/>application is always available, be aware that the administrators may not always be looking for other <br/>reviewers. 
			Regardless, your application will be saved and overviewed when the current reviewers are looking <br/>for help.</p><br/></td></tr>
			</table>';
				
				echo '<form action="application.php" method="post">
				<table style="margin: 0px auto;" border="0"><tr>
				<td width="50%">Name: <input type="text" name="fname" placeholder="First Name" maxlength="20" ';
					if(isset($_POST['fname'])) echo "value='$fname'";
					echo 'required><span class="error"> ';
					if(isset($fnameErr)) echo $fnameErr; //displays error if error is assigned
					echo '</span> 
				<input type="text" name="lname" placeholder="Last Name" maxlength="20" ';
					if(isset($_POST['lname'])) echo "value='$lname'"; 
					echo 'required> <span class="error">';
					if(isset($lnameErr)) echo $lnameErr; //displays error if error is assigned
					echo '</span></td>';
					//End of first line (fname, lname)
					
					echo '<td>Preferred Name:<input type="text" name="nickname" placeholder="" maxlength="20" ';
					if(isset($_POST['nickname'])) echo "value='$nickname'"; 
					echo '> <span class="error">';
					if(isset($nicknameErr)) echo $nicknameErr; //displays error if error is assigned
					echo '</span></td></tr>';
					
					echo '<tr><td width="50%">Birthdate: <input type="date" name="birthdate" max=';
					echo "'{$datemax}'";
					echo 'min=';
					echo "'{$datemin}'";
					if(isset($_POST['birthdate'])) echo "value='$birthdate'";
					echo '> Gender: <select name="gender" required> 
					<option disabled selected value> -- select -- </option>
					<option value="male" ';
					if(isset($_POST['gender']) && $gender == "male") echo "selected";
					echo '>Male</option>
					<option value="female" ';
					if(isset($_POST['gender']) && $gender == "female") echo "selected";
					echo '>Female</option>
					<option value="other" ';
					if(isset($_POST['gender']) && $gender == "other") echo "selected";
					echo '>Other</option>
					</select></td>';																			
					//End of 2nd line (birthdate,gender)
					
					
					echo '<td width="50%">Email: <input type="email" name="email" placeholder="Email" size ="30" maxlength="50" ';
					if(isset($_POST['email'])) echo "value='$email'";
					echo ' required> 
					<span class="error"> ';
					if(isset($emailErr)) echo $emailErr; //if error is set, displays it
					echo '</span></td></tr></table>';
					
					
					echo '<table style="margin: 0px auto;" border="0"><tr><td>&nbsp;</td></tr>';
					
					
					echo '<tr><td width="50%">Are you working towards a degree in English or English Writing? 
						<input type="radio" name="college" value="yes" ';
					if(isset($_POST['college']) && $_POST['college']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="college" value="no" ';
					if(isset($_POST['college']) && $_POST['college']==='no') echo 'checked ';
					echo '>No											
					</td></tr>';
					//End of 5th line (college)
					
					echo '<tr><td width="50%">Do you already have a degree in English or English Writing? 
						<input type="radio" name="degree" value="yes" ';
					if(isset($_POST['degree']) && $_POST['degree']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="degree" value="no" ';
					if(isset($_POST['degree']) && $_POST['degree']==='no') echo 'checked ';
					echo '>No											
					</td></tr>';
					//End of 6th line (degree)
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Have you published before? 
						<input type="radio" name="published" value="yes" ';
					if(isset($_POST['published']) && $_POST['published']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="published" value="no" ';
					if(isset($_POST['published']) && $_POST['published']==='no') echo 'checked ';
					echo '>No											
					</td></tr><br/>';
					//End of 7th line (published)
					
					echo '<tr><td width="50%">If so, what have you published? <span class="error">';
					if(isset($publisheditemsErr)) echo $publisheditemsErr;
					echo '</span><br/>
					<textarea class="input" name="publisheditems" rows="4" cols="111" onkeyup="wordcount(this.value)" onkeydown="wordcount(this.value)" onchange="checkWordLen(this,100);">';
					if(isset($_POST['publisheditems'])) echo $publisheditems;
					echo '</textarea>
					</td></tr>';
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Why do you want to become a reviewer for this site? <span class="error">';
					if(isset($reasonErr)) echo $reasonErr;
					echo '</span><br/>
					<textarea class="input" name="reason" rows="4" cols="111" onchange="checkWordLen(this,100);">';
					if(isset($_POST['reason'])) echo $reason;
					echo '</textarea></td></tr>';
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Please give a 500 word sample of your writing on any subject to demonstrate your writing abilities: <span class="error">';
					if(isset($sampleErr)) echo $sampleErr;
					echo '</span><br/>
					<textarea class="input" name="sample" rows="10" cols="111" onchange="checkWordLen(this,500);">';
					if(isset($_POST['sample'])) echo $sample;
					echo '</textarea>';
					
					echo '<br/><br/>
					<input type="submit" name="submit" value="Submit" />										
					</td></tr></form>';
			}else{
				$fname = validate($_POST["fname"]);
				$lname = validate($_POST["lname"]);
				$birthdate = $_POST["birthdate"];
				$degree = $_POST["degree"]; //new
				$college = $_POST["college"]; //new
				$email = validate($_POST["email"]);
				$gender = $_POST["gender"];
				$published = $_POST['published'];
				$publisheditems = $_POST["publisheditems"]; //new
				$nickname = $_POST["nickname"]; //new
				$reason = $_POST["reason"]; //new
				$sample = $_POST["sample"]; //new
				
				
				
				if(empty($email)){ 
					$emailErr = "*is required";
				}elseif((!endsWith($email,".com")) || (strpos($email, '@') == false)){ //makes sure .com comes at the end of the email & has @ sign
					$emailErr = "* invalid email";
				}else{
					$email = validate($_POST['email']);
				}
					
				if (empty($fname)) { //gives error "required"
					$fnameErr = "* is required";
				}elseif(!textOnly($fname)){ //checks for non alphabetic - sets error "only include letters"
					$fnameErr = "First name can contain letters only";
					$fname = "";
				}else{ //sets fname in $_POST to $fname
					$fname = validate($_POST['fname']);
				}
					
				if (empty($lname)) { //gives error "required"
					$lnameErr = "* is required";
				}elseif(!textOnly($lname)){ //checks for non alphabetic - sets error "only include letters"
					$lnameErr = "* letters only";
					$lname = "";
				}else{ //sets lname in $_POST to $lname
					$lname = validate($_POST['lname']);
				}
				
				if(isset($_POST['published']) && $_POST['published']==='yes'){
					if(empty($publisheditems)){
						$publisheditemsErr = "* required when your work has been published";
					}elseif(!(str_word_count($publisheditems) <= 100)){
						$publisheditemsErr = "* response must be less than 100 words";
					}else{
						validate($publisheditems);
					}		
				}
					
				if (!empty($nickname)) { //gives error "required"
					if(!textOnly($nickname)){ //checks for non alphabetic - sets error "only include letters"
						$nicknameErr = "Nickname can contain letters only";
						$nickname = "";
					}else{ //sets nickname in $_POST to $nickname
						$nickname = validate($_POST['nickname']);
					}
				}
				
				if(empty($reason)){
					$reasonErr = "* required";
				}elseif(!(str_word_count($reason) <= 100)){
					$reasonErr = "* must be less than 100 words";
				}else{
					validate($reason);
				}
				
				if(empty($sample)){
					$sampleErr = "*required";
				}elseif(!(str_word_count($sample) <= 500)){
					$sampleErr = "* must be less than 500 words";
				}else{
					validate($sample);
				}
				
			
			if(isset($emailErr) || isset($fnameErr) || isset($lnameErr) || isset($publisheditemsErr) || isset($nicknameErr) || isset($reasonErr) || isset($sampleErr)){
				$datemax = date('Y-m-d', strtotime("-18 years",time()));
				$datemin = date('Y-m-d', strtotime("-100 years",time()));
				
				echo '<br/><br/><br/>
		<table style="margin: 0px auto;" border="0"><tr><td width="50%"><h1>Reviewer Application</h1></td></tr>
	  <tr><td width="50%"><p>By filling out this application, you can apply to become an official book reviewer on this site. 
	  Although this <br/>application is always available, be aware that the administrators may not always be looking for other <br/>reviewers. 
	  Regardless, your application will be saved and overviewed when the current reviewers are looking <br/>for help.</p><br/></td></tr>
	  </table>';
				
				echo '<form action="application.php" method="post">
				<table style="margin: 0px auto;" border="0"><tr>
				<td width="50%">Name: <input type="text" name="fname" placeholder="First Name" maxlength="20" ';
					if(isset($_POST['fname'])) echo "value='$fname'";
					echo 'required><span class="error"> ';
					if(isset($fnameErr)) echo $fnameErr; //displays error if error is assigned
					echo '</span> 
				<input type="text" name="lname" placeholder="Last Name" maxlength="20" ';
					if(isset($_POST['lname'])) echo "value='$lname'"; 
					echo 'required> <span class="error">';
					if(isset($lnameErr)) echo $lnameErr; //displays error if error is assigned
					echo '</span></td>';
					//End of first line (fname, lname)
					
					echo '<td>Preferred Name:<input type="text" name="nickname" placeholder="" maxlength="20" ';
					if(isset($_POST['nickname'])) echo "value='$nickname'"; 
					echo '> <span class="error">';
					if(isset($nicknameErr)) echo $nicknameErr; //displays error if error is assigned
					echo '</span></td></tr>';
					
					echo '<tr><td width="50%">Birthdate: <input type="date" name="birthdate" max=';
					echo "'{$datemax}'";
					echo 'min=';
					echo "'{$datemin}'";
					if(isset($_POST['birthdate'])) echo "value='$birthdate'";
					echo '> Gender: <select name="gender" required> 
					<option disabled selected value> -- select -- </option>
					<option value="male" ';
					if(isset($_POST['gender']) && $gender == "male") echo "selected";
					echo '>Male</option>
					<option value="female" ';
					if(isset($_POST['gender']) && $gender == "female") echo "selected";
					echo '>Female</option>
					<option value="other" ';
					if(isset($_POST['gender']) && $gender == "other") echo "selected";
					echo '>Other</option>
					</select></td>';																			
					//End of 2nd line (birthdate,gender)
					
					
					echo '<td width="50%">Email: <input type="email" name="email" placeholder="Email" size ="30" maxlength="50" ';
					if(isset($_POST['email'])) echo "value='$email'";
					echo ' required> 
					<span class="error"> ';
					if(isset($emailErr)) echo $emailErr; //if error is set, displays it
					echo '</span></td></tr></table>';
					
					
					echo '<table style="margin: 0px auto;" border="0"><tr><td>&nbsp;</td></tr>';
					
					
					echo '<tr><td width="50%">Are you working towards a degree in English or English Writing? 
						<input type="radio" name="college" value="yes" ';
					if(isset($_POST['college']) && $_POST['college']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="college" value="no" ';
					if(isset($_POST['college']) && $_POST['college']==='no') echo 'checked ';
					echo 'required>No											
					</td></tr>';
					//End of 5th line (college)
					
					echo '<tr><td width="50%">Do you already have a degree in English or English Writing? 
						<input type="radio" name="degree" value="yes" ';
					if(isset($_POST['degree']) && $_POST['degree']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="degree" value="no" ';
					if(isset($_POST['degree']) && $_POST['degree']==='no') echo 'checked ';
					echo 'required>No											
					</td></tr>';
					//End of 6th line (degree)
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Have you published before? 
						<input type="radio" name="published" value="yes" ';
					if(isset($_POST['published']) && $_POST['published']==='yes') echo 'checked ';
					echo 'required>Yes
						<input type="radio" name="published" value="no" ';
					if(isset($_POST['published']) && $_POST['published']==='no') echo 'checked ';
					echo 'required>No											
					</td></tr><br/>';
					//End of 7th line (published)
					
					echo '<tr><td width="50%">If so, what have you published? <span class="error">';
					if(isset($publisheditemsErr)) echo $publisheditemsErr;
					echo '</span><br/>
					<textarea class="input" name="publisheditems" rows="4" cols="111" onkeyup="wordcount(this.value)" onkeydown="wordcount(this.value)" onchange="checkWordLen(this,100);">';
					if(isset($_POST['publisheditems'])) echo $publisheditems;
					echo '</textarea>
					</td></tr>';
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Why do you want to become a reviewer for this site? <span class="error">';
					if(isset($reasonErr)) echo $reasonErr;
					echo '</span><br/>
					<textarea class="input" name="reason" rows="4" cols="111" onchange="checkWordLen(this,100);">';
					if(isset($_POST['reason'])) echo $reason;
					echo '</textarea></td></tr>';
					
					echo '<tr><td>&nbsp;</td></tr>';
					
					echo '<tr><td width="50%">Please give a 500 word sample of your writing on any subject to demonstrate your writing abilities: <span class="error">';
					if(isset($sampleErr)) echo $sampleErr;
					echo '</span><br/>
					<textarea class="input" name="sample" rows="10" cols="111" onchange="checkWordLen(this,500);">';
					if(isset($_POST['sample'])) echo $sample;
					echo '</textarea>';
					
					echo '<br/><br/>
					<input type="submit" name="submit" value="Submit" />										
					</td></tr></form>';
			}else{
					$fname = mysqli_real_escape_string($db, $fname);
					$lname = mysqli_real_escape_string($db, $lname);
					$publisheditems = mysqli_real_escape_string($db, $publisheditems);
					$nickname = mysqli_real_escape_string($db, $nickname);
					$email = mysqli_real_escape_string($db, $email); //makes sure no sql injection
					$reason = mysqli_real_escape_string($db, $reason);
					$sample = mysqli_real_escape_string($db, $sample);
					$applicantID = $_SESSION['userID']; 
					
				
					$application = "INSERT INTO GBApplication (GBUser_userID, firstName, lastName, nickname, birthdate, gender, email, degree, college, published, publishedItems, reason, sample)";
					$application .= "VALUES ({$applicantID}, '{$fname}', '{$lname}', '{$nickname}', '{$birthdate}', '{$gender}', '{$email}', '{$degree}', '{$college}', '{$published}', '{$publisheditems}', '{$reason}', '{$sample}')";
					$applicationresult = mysqli_query($db, $application);
				
					
					if($applicationresult){
						echo "<center><h3>Your application was submitted!</h3></center><br/>";
					}else{
						die("Database query failed."); // if not result for position or applicant query, query failed
						
					}
					
				}
			}
		}
		
		
		mysqli_close($db); //closes database connection

}else{
	echo '<center><h1>You need to log in to apply to be a reviewer.</h1></center>';
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