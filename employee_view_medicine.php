<?php

require_once "pdo.php";
session_start();

$addName = $addCon = $addPrice = $addID = '';
$updateName = $updateCon = $updatePrice = $updateID = '';

//Delete a medicine
if( isset($_POST['medID']) && isset($_POST['delete']) ){
  $sql = "DELETE FROM medicine WHERE medID = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':zip' => $_POST['medID']
  ));

  header("Location: employee_view_medicine.php");
  return;
}

//Add a new medicine
if(isset($_POST['addName']) && isset($_POST['addCon']) && isset($_POST['addPrice']) && isset($_POST['addID']) && isset($_POST['add'])) {

  $addName = $_POST['addName'];
  $addCon = $_POST['addCon'];
  $addPrice = $_POST['addPrice'];
  $addID = $_POST['addID'];

  $_SESSION['addName'] = $addName;
  $_SESSION['addCon'] = $addCon;
  $_SESSION['addPrice'] = $addPrice;
  $_SESSION['addID'] = $addID;

  //Validation of form input
  if( empty($addName) || empty($addCon) || empty($addPrice) || empty($addID) ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( $addName == " " || $addCon == " " || $addPrice == " " || $addID == " " ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $addName)) {
    $_SESSION['addMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else if ( ! is_numeric($addPrice)) {
    $_SESSION['addMessage'] = "Price must contain numbers only.";
  }
  else {

    $sql = "INSERT INTO medicine (medName, medCon, medPrice, medID) VALUES (:medName, :medCon, :medPrice, :medID)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	':medName' => $_POST['addName'],
  	':medCon' => $_POST['addCon'],
  	':medPrice' => $_POST['addPrice'],
  	':medID' => $_POST['addID']
    ));

    unset($_SESSION['addName']);
    unset($_SESSION['addCon']);
    unset($_SESSION['addPrice']);
    unset($_SESSION['addID']);

  }

  header("Location: employee_view_medicine.php");
  return;

}

//Update a medicine information
if(isset($_POST['updateID']) && isset($_POST['updateName']) && isset($_POST['updateCon']) && isset($_POST['updatePrice']) && isset($_POST['update'])) {

  $updateID = $_POST['updateID'];
  $updateName = $_POST['updateName'];
  $updateCon = $_POST['updateCon'];
  $updatePrice = $_POST['updatePrice'];

  $_SESSION['updateID'] = $updateID;
  $_SESSION['updateName'] = $updateName;
  $_SESSION['updateCon'] = $updateCon;
  $_SESSION['updatePrice'] = $updatePrice;

  //Validation of form input
  if ( empty($updateID) || empty($updateName) || empty($updateCon) || empty($updatePrice) ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( $updateID == " " || $updateName == " " || $updateCon == " " || $updatePrice == " " ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( ! preg_match("/^[a-zA-Z-' ]*$/", $updateName)) {
    $_SESSION['updateMessage'] = "Only letters and white space are allowed in the name field.";
  }
  else if ( ! is_numeric($updatePrice)) {
    $_SESSION['updateMessage'] = "Price must contain numbers only.";
  }
  else {

    $sql = "UPDATE medicine SET medName=:medName, medCon=:medCon, medPrice=:medPrice WHERE medID=:medID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':medName' => $_POST['updateName'],
      ':medCon' => $_POST['updateCon'],
      ':medPrice' => $_POST['updatePrice'],
      ':medID' => $_POST['updateID']));

      unset($_SESSION['updateName']);
      unset($_SESSION['updateCon']);
      unset($_SESSION['updatePrice']);
      unset($_SESSION['updateID']);

  }

    header("Location: employee_view_medicine.php");
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
  <a href="employee_view_diagnosis.php">View Diagnosis List</a>
  <a href="employee_view_medicine.php" style="color: #FFFFFF;" >View Medicine List</a>
</div>

<div class="main">

<h2>Medicine List</h2>

<table>
	<tr>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center;">Medicine ID</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Medicine Name</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Content</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Price (RM)</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Delete</th>
	</tr>

<?php

//To display all the medicine data in table form
$stmt = $pdo->query("SELECT medID, medName, medCon, medPrice FROM medicine");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row){
echo ("<tr><td>");
echo ($row['medID']);
echo ("</td><td>");
echo ($row['medName']);
echo ("</td><td>");
echo ($row['medCon']);
echo ("</td><td>");
echo ($row['medPrice']);
echo ("</td><td>");
echo ('<form method = "post"><input type = "hidden" name = "medID" value = "'.$row['medID'].'" />' . "\n" );
echo ('<input type = "submit" value = "Delete" name = "delete" class = "btnDelete" />');
echo ("\n</form>\n");
echo ("</td></tr>\n");
}

?>

</table>
<br/><br/>

<h2>Add a New Medicine</h2>
<p>Enter the details in the below form:</p>

<?php

//Prints our error message if have one
if (isset($_SESSION['addMessage'])){
  echo ('<p style = "color: red">'.$_SESSION['addMessage']."</p>\n");
  unset($_SESSION['addMessage']);
}

//Set session to each input to prevent double post
$addName = isset($_SESSION['addName']) ? $_SESSION['addName'] : '';
$addCon = isset($_SESSION['addCon']) ? $_SESSION['addCon'] : '';
$addPrice = isset($_SESSION['addPrice']) ? $_SESSION['addPrice'] : '';
$addID = isset($_SESSION['addID']) ? $_SESSION['addID'] : '';

?>

<div class="container">
  <form method="post">
  <div class="row">
    <div class="col-25">
      <label for="add_name">Medicine Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_name" name="addName" placeholder="Enter medicine's name.."
      <?php
      echo 'value = "' . htmlentities($addName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_con">Content</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_con" name="addCon" placeholder="Enter medicine's content.."
      <?php
      echo 'value = "' . htmlentities($addCon) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_price">Price (RM)</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_price" name="addPrice" placeholder="Enter medicine's price.."
      <?php
      echo 'value = "' . htmlentities($addPrice) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_ID">New Medicine ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_ID" name="addID" placeholder="Generate an ID for the new medicine.."
      <?php
      echo 'value = "' . htmlentities($addID) . '"';
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
<h2>Update a Medicine Information</h2>
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
$updateCon = isset($_SESSION['updateCon']) ? $_SESSION['updateCon'] : '';
$updatePrice = isset($_SESSION['updatePrice']) ? $_SESSION['updatePrice'] : '';

?>

<div class="container">
  <form method = "post">
  <div class="row">
    <div class="col-25">
      <label for="update_ID">Medicine ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_ID" name="updateID" placeholder="Enter medicine ID.."
      <?php
      echo 'value = "' . htmlentities($updateID) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_name">Medicine Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_name" name="updateName" placeholder="Enter medicine's name.."
      <?php
      echo 'value = "' . htmlentities($updateName) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_con">Content</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_con" name="updateCon" placeholder="Enter medicine's content.."
      <?php
      echo 'value = "' . htmlentities($updateCon) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="update_price">Price (RM)</label>
    </div>
    <div class="col-75">
      <input type="text" id="update_price" name="updatePrice" placeholder="Enter medicine's price.."
      <?php
      echo 'value = "' . htmlentities($updatePrice) . '"';
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
