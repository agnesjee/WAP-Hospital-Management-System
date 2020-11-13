<?php

require_once "pdo.php";
session_start();

$addName = $addPhone = $addEmail = $addID = $addPassword = '';
$updateName = $updatePhone = $updateEmail = $updateID = '';

//Delete a patient
if( isset($_POST['patID']) && isset($_POST['delete']) ){
  $sql = "DELETE FROM patient WHERE patID = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':zip' => $_POST['patID']
  ));

  header("Location: employee_view_patient.php");
  return;
}

//Add a new patient
if(isset($_POST['addName']) && isset($_POST['addPhone']) && isset($_POST['addEmail']) && isset($_POST['addID']) && isset($_POST['addPassword']) && isset($_POST['add'])) {

  $addName = $_POST['addName'];
  $addPhone = $_POST['addPhone'];
  $addEmail = $_POST['addEmail'];
  $addID = $_POST['addID'];
  $addPassword = $_POST['addPassword'];

  $_SESSION['addName'] = $addName;
  $_SESSION['addPhone'] = $addPhone;
  $_SESSION['addEmail'] = $addEmail;
  $_SESSION['addID'] = $addID;
  $_SESSION['addPassword'] = $addPassword;

  //Validation of form input
  if( empty($addName) || empty($addPhone) || empty($addEmail) || empty($addID) || empty($addPassword) ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( $addName == " " || $addPhone == " " || $addEmail == " " || $addID == " " || $addPassword == " " ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $addName)) {
    $_SESSION['addMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else if ( ! is_numeric($addPhone)) {
    $_SESSION['addMessage'] = "Phone number must contain numbers only.";
  }
  else if ( ! filter_var($addEmail, FILTER_VALIDATE_EMAIL )) {
    $_SESSION['addMessage'] = "Invalid email format.";
  }
  else if ( strlen($addPassword) < 4) {
    $_SESSION['addMessage'] = "Password is too short.";
  }
  else {

    $sql = "INSERT INTO patient (patName, patPhone, patEmail, patID, patPassword) VALUES (:patName, :patPhone, :patEmail, :patID, :patPassword)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	':patName' => $_POST['addName'],
  	':patPhone' => $_POST['addPhone'],
  	':patEmail' => $_POST['addEmail'],
  	':patID' => $_POST['addID'],
    ':patPassword' => $_POST['addPassword']));

    unset($_SESSION['addName']);
    unset($_SESSION['addPhone']);
    unset($_SESSION['addEmail']);
    unset($_SESSION['addID']);
    unset($_SESSION['addPassword']);

  }

  header("Location: employee_view_patient.php");
  return;

}

//Update a patient information
if(isset($_POST['updateID']) && isset($_POST['updateName']) && isset($_POST['updatePhone']) && isset($_POST['updateEmail']) && isset($_POST['update'])) {

  $updateID = $_POST['updateID'];
  $updateName = $_POST['updateName'];
  $updatePhone = $_POST['updatePhone'];
  $updateEmail = $_POST['updateEmail'];

  $_SESSION['updateID'] = $updateID;
  $_SESSION['updateName'] = $updateName;
  $_SESSION['updatePhone'] = $updatePhone;
  $_SESSION['updateEmail'] = $updateEmail;

  //Validation of form input
  if ( empty($updateID) || empty($updateName) || empty($updatePhone) || empty($updateEmail) ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( $updateID == " " || $updateName == " " || $updatePhone == " " || $updateEmail == " " ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $updateName)) {
    $_SESSION['updateMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else if ( ! is_numeric($updatePhone)) {
    $_SESSION['updateMessage'] = "Phone number must contain numbers only.";
  }
  else if ( ! filter_var($updateEmail, FILTER_VALIDATE_EMAIL )) {
    $_SESSION['updateMessage'] = "Invalid email format.";
  }
  else{

    $sql = "UPDATE patient SET patName=:patName, patPhone=:patPhone, patEmail=:patEmail WHERE patID=:patID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':patName' => $_POST['updateName'],
      ':patPhone' => $_POST['updatePhone'],
      ':patEmail' => $_POST['updateEmail'],
      ':patID' => $_POST['updateID']));

      unset($_SESSION['updateName']);
      unset($_SESSION['updatePhone']);
      unset($_SESSION['updateEmail']);
      unset($_SESSION['updateID']);

  }

    header("Location: employee_view_patient.php");
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
  <a href="employee_view_patient.php" style="color: #FFFFFF;" >View Patient List</a>
  <a href="employee_view_diagnosis.php">View Diagnosis List</a>
  <a href="employee_view_medicine.php">View Medicine List</a>
</div>

<div class="main">

<h2>Patient List</h2>

<table>
	<tr>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center;">Patient ID</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Full Name</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Phone Number</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Email Address</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Delete</th>
	</tr>

<?php

//To display all the patient data in table form
$stmt = $pdo->query("SELECT patID, patName, patPhone, patEmail FROM patient");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row){
echo ("<tr><td>");
echo ($row['patID']);
echo ("</td><td>");
echo ($row['patName']);
echo ("</td><td>");
echo ($row['patPhone']);
echo ("</td><td>");
echo ($row['patEmail']);
echo ("</td><td>");
echo ('<form method = "post"><input type = "hidden" name = "patID" value = "'.$row['patID'].'" />' . "\n" );
echo ('<input type = "submit" value = "Delete" name = "delete" class = "btnDelete" />');
echo ("\n</form>\n");
echo ("</td></tr>\n");
}

?>

</table>
<br/><br/>

<h2>Add a New Patient</h2>
<p>Enter the details in the below form:</p>

<?php

//Prints our error message if have one
if (isset($_SESSION['addMessage'])){
  echo ('<p style = "color: red">'.$_SESSION['addMessage']."</p>\n");
  unset($_SESSION['addMessage']);
}

//Set session to each input to prevent double post
$addName = isset($_SESSION['addName']) ? $_SESSION['addName'] : '';
$addPhone = isset($_SESSION['addPhone']) ? $_SESSION['addPhone'] : '';
$addEmail = isset($_SESSION['addEmail']) ? $_SESSION['addEmail'] : '';
$addID = isset($_SESSION['addID']) ? $_SESSION['addID'] : '';
$addPassword = isset($_SESSION['addPassword']) ? $_SESSION['addPassword'] : '';

?>

<div class="container">
  <form method="post">
  <div class="row">
    <div class="col-25">
      <label for="add_name">Full Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_name" name="addName" placeholder="Enter patient's name.."
      <?php
      echo 'value = "' . htmlentities($addName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_phone">Phone</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_phone" name="addPhone" placeholder="Enter patient's phone number.."
      <?php
      echo 'value = "' . htmlentities($addPhone) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_email">Email</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_email" name="addEmail" placeholder="Enter patient's email.."
      <?php
      echo 'value = "' . htmlentities($addEmail) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_userID">New Patient ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_userID" name="addID" placeholder="Generate an ID for the new patient.."
      <?php
      echo 'value = "' . htmlentities($addID) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_pw">New Password</label>
    </div>
    <div class="col-75">
      <input type="password" id="add_pw" name="addPassword" placeholder="Generate a password for the new patient.."
      <?php
      echo 'value = "' . htmlentities($addPassword) . '"';
      ?>
      />
      <br/><br/>
      <input type="checkbox" onclick="showPassword()" />Show Password
    </div>
  </div>
  <br/>
  <div class="row">
    <input type="submit" value="Add" class="btnSubmit" name = "add" />
  </div>
  </form>
</div>


<br/><br/>
<h2>Update a Patient Information</h2>
<p>Please fill up all fields:</p>

<?php

//Prints out error message if have one
if (isset($_SESSION['updateMessage'])){
  echo ('<p style = "color: red">'.$_SESSION['updateMessage']."</p>\n");
  unset($_SESSION['updateMessage']);
}

//Set session to each input to prevent double post
$updateID = isset($_SESSION['updateID']) ? $_SESSION['updateID'] : '';
$updateName = isset($_SESSION['updateName']) ? $_SESSION['updateName'] : '';
$updatePhone = isset($_SESSION['updatePhone']) ? $_SESSION['updatePhone'] : '';
$updateEmail = isset($_SESSION['updateEmail']) ? $_SESSION['updateEmail'] : '';

?>

<div class="container">
  <form method = "post">
  <div class="row">
    <div class="col-25">
      <label for="userID">Patient ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="userID" name="updateID" placeholder="Enter patient's ID.."
      <?php
      echo 'value = "' . htmlentities($updateID) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="name">Full Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="name" name="updateName" placeholder="Enter patient's name.."
      <?php
      echo 'value = "' . htmlentities($updateName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="phone">Phone</label>
    </div>
    <div class="col-75">
      <input type="text" id="phone" name="updatePhone" placeholder="Enter patient's phone number.."
      <?php
      echo 'value = "' . htmlentities($updatePhone) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="email">Email</label>
    </div>
    <div class="col-75">
      <input type="text" id="email" name="updateEmail" placeholder="Enter patient's email.."
      <?php
      echo 'value = "' . htmlentities($updateEmail) . '"';
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

<script>
  function showPassword(){
    var x = document.getElementById("add_pw");
    if (x.type === "password"){
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>

</body>
</html>
