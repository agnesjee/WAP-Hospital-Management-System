<?php

require_once "pdo.php";
session_start();

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

  <a href="patient_dashboard.php">Dashboard</a>
  <a href="patient_view_diagnosis.php" style="color: #FFFFFF;" >View Diagnosis History</a>
</div>

<div class="main">

<h2>Your Diagnosis History</h2>

<table>
	<tr>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center;">Diagnosis ID</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Diagnosis Name</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Symptoms</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Medicine to be taken</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Your patient ID</th>
	</tr>

<?php

  $sql = "SELECT diaID, diaName, diaSym, diaMed, patID FROM diagnosis WHERE patID=:patID";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':patID' => $_SESSION['account']
  ));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($rows as $row){
  echo ("<tr><td>");
  echo ($row['diaID']);
  echo ("</td><td>");
  echo ($row['diaName']);
  echo ("</td><td>");
  echo ($row['diaSym']);
  echo ("</td><td>");
  echo ($row['diaMed']);
  echo ("</td><td>");
  echo ($row['patID']);
  echo ("</td></tr>\n");
  }

?>

</table>
</div>
<br/><br/>

</body>
</html>
