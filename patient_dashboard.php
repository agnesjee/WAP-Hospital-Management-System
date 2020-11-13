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
<link type="text/css" rel="stylesheet" href="patient.css"/>
</head>
<body>

<div class="sidenav">

<img class = "logo" src = "logo_transparent.png" alt = "Hospial Logo" />
<button type="button" class="btnLogout" onclick="location.href='logout.php'">Log Out</button>
<br/><br/><br/><br/>

<a href="patient_dashboard.php" style="color: #FFFFFF;" >Dashboard</a>
<a href="patient_view_diagnosis.php">View Diagnosis History</a>
</div>

<div class = "headerImage">
  <br/>
  <span class = "pageTitle">&nbsp;Dashboard</span><br/>
  <span class = "pageSubtitle" style="font-size: 30px; font-weight: bold; margin-left: 45px; color: #242020;">&nbsp;&nbsp;Welcome to Patient Portal !</span>

</div>

<div class="main">

  <h1 class = "title">View Your Profile</h1>

  <?php

    //To show the profile information of a specific user
    $sql = "SELECT patID, patName, patPhone, patEmail FROM patient WHERE patID=:patID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	   ':patID' => $_SESSION['account']
  	  ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo ('<div class="container">');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Patient ID: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['patID']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Full Name: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['patName']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Phone Number: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['patPhone']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('<div class="row">');
    echo ('<div class="col-25">');
    echo ('<p><b>Email Address: </b></p>');
    echo ('</div>');
    echo ('<div class="col-75">');
    echo ("<p>");
    echo ($row['patEmail']);
    echo ('</p></div>');
    echo ('</div>');

    echo ('</div><br/><br/>');

  ?>

</div>
</body>
</html>
