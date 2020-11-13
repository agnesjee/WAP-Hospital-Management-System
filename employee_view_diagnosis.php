<?php

require_once "pdo.php";
session_start();

$addName = $addSym = $addMed = $addDiaID = $addPatID = '';
$updateName = $updateSym = $updateMed = $updateDiaID = $updatePatID = '';

//Delete a diagnosis
if( isset($_POST['diaID']) && isset($_POST['delete']) ){
  $sql = "DELETE FROM diagnosis WHERE diaID = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':zip' => $_POST['diaID']
  ));

  header("Location: employee_view_diagnosis.php");
  return;
}

//Add a new diagnosis
if(isset($_POST['addName']) && isset($_POST['addSym']) && isset($_POST['addMed']) && isset($_POST['addDiaID']) && isset($_POST['addPatID']) && isset($_POST['add'])) {

  $addName = $_POST['addName'];
  $addSym = $_POST['addSym'];
  $addMed = $_POST['addMed'];
  $addDiaID = $_POST['addDiaID'];
  $addPatID = $_POST['addPatID'];

  $_SESSION['addName'] = $addName;
  $_SESSION['addSym'] = $addSym;
  $_SESSION['addMed'] = $addMed;
  $_SESSION['addDiaID'] = $addDiaID;
  $_SESSION['addPatID'] = $addPatID;

  //Validation of form input
  if( empty($addName) || empty($addSym) || empty($addMed) || empty($addDiaID) || empty($addPatID) ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( $addName == " " || $addSym == " " || $addMed == " " || $addDiaID == " " || $addPatID == " " ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $addName)) {
    $_SESSION['addMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else {

    $sql = "INSERT INTO diagnosis (diaName, diaSym, diaMed, diaID, patID) VALUES (:diaName, :diaSym, :diaMed, :diaID, :patID)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	':diaName' => $_POST['addName'],
  	':diaSym' => $_POST['addSym'],
  	':diaMed' => $_POST['addMed'],
  	':diaID' => $_POST['addDiaID'],
    ':patID' => $_POST['addPatID']));

    unset($_SESSION['addName']);
    unset($_SESSION['addSym']);
    unset($_SESSION['addMed']);
    unset($_SESSION['addDiaID']);
    unset($_SESSION['addPatID']);

  }

  header("Location: employee_view_diagnosis.php");
  return;

}

//Update a diagnosis information
if(isset($_POST['updateDiaID']) && isset($_POST['updateName']) && isset($_POST['updateSym']) && isset($_POST['updateMed']) && isset($_POST['updatePatID']) && isset($_POST['update'])) {

  $updateDiaID = $_POST['updateDiaID'];
  $updateName = $_POST['updateName'];
  $updateSym = $_POST['updateSym'];
  $updateMed = $_POST['updateMed'];
  $updatePatID = $_POST['updatePatID'];

  $_SESSION['updateDiaID'] = $updateDiaID;
  $_SESSION['updateName'] = $updateName;
  $_SESSION['updateSym'] = $updateSym;
  $_SESSION['updateMed'] = $updateMed;
  $_SESSION['updatePatID'] = $updatePatID;

  //Validation of form input
  if ( empty($updateDiaID) || empty($updateName) || empty($updateSym) || empty($updateMed) || empty($updatePatID) ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( $updateDiaID == " " || $updateName == " " || $updateSym == " " || $updateMed == " " || $updatePatID == " " ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $updateName)) {
    $_SESSION['updateMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else {

    $sql = "UPDATE diagnosis SET diaName=:diaName, diaSym=:diaSym, diaMed=:diaMed, patID=:patID WHERE diaID=:diaID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':diaID' => $_POST['updateDiaID'],
      ':diaName' => $_POST['updateName'],
      ':diaSym' => $_POST['updateSym'],
      ':diaMed' => $_POST['updateMed'],
      ':patID' => $_POST['updatePatID']));

      unset($_SESSION['updateDiaID']);
      unset($_SESSION['updateName']);
      unset($_SESSION['updateSym']);
      unset($_SESSION['updateMed']);
      unset($_SESSION['updatePatID']);

  }

    header("Location: employee_view_diagnosis.php");
    return;

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

  <a href="employee_dashboard.php">Dashboard</a>
  <a href="employee_view_patient.php">View Patient List</a>
  <a href="employee_view_diagnosis.php" style="color: #FFFFFF;" >View Diagnosis List</a>
  <a href="employee_view_medicine.php">View Medicine List</a>
</div>

<div class="main">

<h2>Diagnosis List</h2>

<table>
	<tr>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center;">Diagnosis ID</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Diagnosis Name</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Symptoms</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Medicine to be taken</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Patient ID</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Delete</th>
	</tr>

<?php

//To display all the diagnosis data in table form
$stmt = $pdo->query("SELECT diaID, diaName, diaSym, diaMed, patID FROM diagnosis");
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
echo ("</td><td>");
echo ('<form method = "post"><input type = "hidden" name = "diaID" value = "'.$row['diaID'].'" />' . "\n" );
echo ('<input type = "submit" value = "Delete" name = "delete" class = "btnDelete" />');
echo ("\n</form>\n");
echo ("</td></tr>\n");
}

?>

</table>
<br/><br/>

<h2>Add a New Diagnosis</h2>
<p>Enter the details in the below form:</p>

<?php

//Prints our error message if have one
if (isset($_SESSION['addMessage'])){
  echo ('<p style = "color: red">'.$_SESSION['addMessage']."</p>\n");
  unset($_SESSION['addMessage']);
}

//Set session to each input to prevent double post
$addName = isset($_SESSION['addName']) ? $_SESSION['addName'] : '';
$addSym = isset($_SESSION['addSym']) ? $_SESSION['addSym'] : '';
$addMed = isset($_SESSION['addMed']) ? $_SESSION['addMed'] : '';
$addDiaID = isset($_SESSION['addDiaID']) ? $_SESSION['addDiaID'] : '';
$addPatID = isset($_SESSION['addPatID']) ? $_SESSION['addPatID'] : '';

?>

<div class="container">
  <form method="post">
  <div class="row">
    <div class="col-25">
      <label for="add_name">Diagnosis Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_name" name="addName" placeholder="Diagnosis name.."
      <?php
      echo 'value = "' . htmlentities($addName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_sym">Symptoms</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_sym" name="addSym" placeholder="Any symptoms.."
      <?php
      echo 'value = "' . htmlentities($addSym) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_med">Medicine</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_med" name="addMed" placeholder="Enter medicine to be taken.."
      <?php
      echo 'value = "' . htmlentities($addMed) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_patID">Patient ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_patID" name="addPatID" placeholder="Enter respective patient ID.."
      <?php
      echo 'value = "' . htmlentities($addPatID) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_diaID">New Diagnosis ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_diaID" name="addDiaID" placeholder="Generate a new diagnosis ID.."
      <?php
      echo 'value = "' . htmlentities($addDiaID) . '"';
      ?>
      />
    </div>
  </div>
  <br/>
  <div class="row">
    <input type="submit" value="Add" class="btnSubmit" name = "add" />
  </div>
  </form>
</div>


<br/><br/>
<h2>Update a Diagnosis Information</h2>
<p>Please fill up all fields:</p>

<?php

//Prints out error message if have one
if (isset($_SESSION['updateMessage'])){
  echo ('<p style = "color: red">'.$_SESSION['updateMessage']."</p>\n");
  unset($_SESSION['updateMessage']);
}

//Set session to each input to prevent double post
$updateDiaID = isset($_SESSION['updateDiaID']) ? $_SESSION['updateDiaID'] : '';
$updateName = isset($_SESSION['updateName']) ? $_SESSION['updateName'] : '';
$updateSym = isset($_SESSION['updateSym']) ? $_SESSION['updateSym'] : '';
$updateMed = isset($_SESSION['updateMed']) ? $_SESSION['updateMed'] : '';
$updatePatID = isset($_SESSION['updatePatID']) ? $_SESSION['updatePatID'] : '';

?>

<div class="container">
  <form method = "post">
  <div class="row">
    <div class="col-25">
      <label for="update_diaID">Diagnosis ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_diaID" name="updateDiaID" placeholder="Diagnosis ID.."
      <?php
      echo 'value = "' . htmlentities($updateDiaID) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_name">Diagnosis Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_name" name="updateName" placeholder="Diagnosis name.."
      <?php
      echo 'value = "' . htmlentities($updateName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_sym">Symptoms</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_sym" name="updateSym" placeholder="Any symptoms.."
      <?php
      echo 'value = "' . htmlentities($updateSym) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_med">Medicine</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_med" name="updateMed" placeholder="Any medicine to be taken.."
      <?php
      echo 'value = "' . htmlentities($updateMed) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_patID">Patient ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_patID" name="updatePatID" placeholder="Enter respective patient ID.."
      <?php
      echo 'value = "' . htmlentities($updatePatID) . '"';
      ?>
      />
    </div>
  </div>
  <br/>
  <div class="row">
    <input type="submit" value="Update" class = "btnSubmit" name = "update" />
  </div>
  </form>
</div>
<br/><br/>

</body>
</html>
