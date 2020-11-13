<?php
  require_once "pdo.php";
  session_start();

  //Check if we are logged in!
  if ( ! isset($_SESSION['account'])) {
    header("Location: index.php");
  }

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="employee.css"/>
</head>
<body>

<div class="sidenav">

<img class = "logo" src = "logo_transparent.png" alt = "Hospial Logo" />
<button type="button" class="btnLogout" onclick="location.href='logout.php'">Log Out</button>
<br/><br/><br/><br/>

<a href="employee_dashboard.php" style="color: #FFFFFF;" >Dashboard</a>
<a href="employee_view_patient.php">View Patient List</a>
<a href="employee_view_diagnosis.php">View Diagnosis List</a>
<a href="employee_view_medicine.php">View Medicine List</a>
</div>

<div class = "headerImage">
  <br/>
  <span class = "pageTitle">&nbsp;Dashboard</span><br/>
  <span class = "pageSubtitle" style="font-size: 30px; font-weight: bold; margin-left: 15px; color: #242020;">&nbsp;&nbsp;Welcome to Employee Portal !</span>

</div>

<div class="main">

  <h1 class = "title">View Your Profile</h1>

  <?php

    $sql = "SELECT emID, emName, emPhone, emEmail, emPos FROM employee WHERE emID=:emID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	   ':emID' => $_SESSION['account']
  	  ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo ('<div class="container">');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Employee ID: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['emID']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Full Name: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['emName']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Phone Number: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['emPhone']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Email Address: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['emEmail']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Position: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['emPos']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('</div><br/><br/>');

  ?>

</div>
</body>
</html>
