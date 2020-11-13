<?php

require_once "pdo.php";
session_start();

//Form input for login
if( isset($_POST['patID']) && isset($_POST['patPassword']) && isset($_POST['login'])) {

unset($_SESSION['account']); //Logout current user

  //Check whether input field is empty
  if (empty($_POST['patID']) || $_POST['patID'] ==  " " ) {
    $_SESSION['error'] = "Please enter Patient ID.";
    header("Location: patient_login.php");
    return;
  }
  else if (empty($_POST['patPassword']) $_POST['patPassword'] == " " ) {
    $_SESSION['error'] = "Please enter password.";
    header("Location: patient_login.php");
    return;
  }
  else { //If input field is not empty then proceed to below codes for validation of id and password

    $sql = "SELECT * FROM patient WHERE patID=:patID AND patPassword=:patPassword ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    	':patID' => $_POST['patID'],
    	':patPassword' => $_POST['patPassword']
    	));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($stmt->rowCount() > 0) {
    	if( $_POST['patID'] == $row['patID']) {
    		if( $_POST['patPassword'] == $row['patPassword']) {
    			$_SESSION['account'] = $row['patID'];
    			header("Location: patient_dashboard.php");
    			return;
    		} else {
    			$_SESSION['error'] = "Incorrect password.";
    			header("Location: patient_login.php");
    			return;
    		}
    	} else {
    		$_SESSION['error'] = "Incorrect Patient ID.";
    		header("Location: patient_login.php");
    		return;
    	}
    } else {
    	$_SESSION['error'] = "Incorrect Patient ID or password.";
    	header("Location: patient_login.php");
    	return;
    }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: Helvetica, sans-serif;
    margin: 0;
}

.header{
    background-color: #333;
    color: #FFFFFF;
    overflow: hidden;
}

.header a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: #005A9E;
  color: white;
}

p {
  text-align: center;
}

form {
    border: 3px solid #f1f1f1;
    margin-left: 360px;
    margin-right: 360px;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.btnLogin {
  background-color: #005A9E;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.btnLogin:hover {
  opacity: 0.8;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.logo {
  width: 40%;
}

.container {
  padding: 10px;
  margin-left: 30px;
  margin-right: 30px;
}

</style>
</head>

<body>

<div class="header">
  <a href="administrator_login.php">Administrator</a>
  <a href="employee_login.php">Employee</a>
  <a class="active" href="patient_login.php">Patient</a>
</div><br/>

<form method="post">
  <div class="imgcontainer">
    <img src="logo_transparent.png" alt="Hospital logo" class="logo" />
  </div>

  <?php
  if ( isset($_SESSION['error'])) {
  	echo ('<p style = "color:red">'.$_SESSION['error']."</p>\n");
  	unset($_SESSION['error']);
  }
  ?>

  <div class="container">
    <label for="patID"><b>Patient ID</b></label>
    <input type="text" id="patID"  placeholder="Enter Patient ID" name="patID" required/>

    <label for="patPassword"><b>Password</b></label>
    <input type="password" id="patPassword" placeholder="Enter Password" name="patPassword" required/>
    <br/><br/>

    <input type="submit" value="Login" class="btnLogin" name="login"/>
    <br/><br/>
  </div>

</form>

</body>
</html>
