<?php

require_once "pdo.php";
session_start();

$addName = $addPhone = $addEmail = $addPos = $addID = $addPassword = '';
$updateName = $updatePhone = $updateEmail = $updatePos = $updateID = '';

//Delete an employee
if( isset($_POST['emID']) && isset($_POST['delete']) ){
  $sql = "DELETE FROM employee WHERE emID = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':zip' => $_POST['emID']
  ));

  header("Location: administrator_view_employee.php");
  return;
}

//Add a new employee
if(isset($_POST['addName']) && isset($_POST['addPhone']) && isset($_POST['addEmail']) && isset($_POST['addPos']) && isset($_POST['addID']) && isset($_POST['addPassword']) && isset($_POST['add'])) {

  $addName = $_POST['addName'];
  $addPhone = $_POST['addPhone'];
  $addEmail = $_POST['addEmail'];
  $addPos = $_POST['addPos'];
  $addID = $_POST['addID'];
  $addPassword = $_POST['addPassword'];

  $_SESSION['addName'] = $addName;
  $_SESSION['addPhone'] = $addPhone;
  $_SESSION['addEmail'] = $addEmail;
  $_SESSION['addPos'] = $addPos;
  $_SESSION['addID'] = $addID;
  $_SESSION['addPassword'] = $addPassword;

  //Validation of form input
  if( empty($addName) || empty($addPhone) || empty($addEmail) || empty($addPos) || empty($addID) || empty($addPassword) ) {
    $_SESSION['addMessage'] = "Please fill in all required fields.";
  }
  else if ( $addName == " " || $addPhone == " " || $addEmail == " " || $addPos == " " || $addID == " " || $addPassword == " " ) {
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

    $sql = "INSERT INTO employee (emName, emPhone, emEmail, emPos, emID, emPassword) VALUES (:emName, :emPhone, :emEmail, :emPos, :emID, :emPassword)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
  	':emName' => $_POST['addName'],
  	':emPhone' => $_POST['addPhone'],
  	':emEmail' => $_POST['addEmail'],
  	':emPos' => $_POST['addPos'],
  	':emID' => $_POST['addID'],
    ':emPassword' => $_POST['addPassword']));

    unset($_SESSION['addName']);
    unset($_SESSION['addPhone']);
    unset($_SESSION['addEmail']);
    unset($_SESSION['addPos']);
    unset($_SESSION['addID']);
    unset($_SESSION['addPassword']);

  }

    header("Location: administrator_view_employee.php");
    return;

}

//Update an employee information
if(isset($_POST['updateID']) && isset($_POST['updateName']) && isset($_POST['updatePhone']) && isset($_POST['updateEmail']) && isset($_POST['updatePos']) && isset($_POST['update'])) {

  $updateID = $_POST['updateID'];
  $updateName = $_POST['updateName'];
  $updatePhone = $_POST['updatePhone'];
  $updateEmail = $_POST['updateEmail'];
  $updatePos = $_POST['updatePos'];

  $_SESSION['updateID'] = $updateID;
  $_SESSION['updateName'] = $updateName;
  $_SESSION['updatePhone'] = $updatePhone;
  $_SESSION['updateEmail'] = $updateEmail;
  $_SESSION['updatePos'] = $updatePos;

  //Validation of form input
  if ( empty($updateID) || empty($updateName) || empty($updatePhone) || empty($updateEmail) || empty($updatePos) ) {
    $_SESSION['updateMessage'] = "Please fill in all required fields.";
  }
  else if ( $updateID == " " || $updateName == " " || $updatePhone == " " || $updateEmail == " " || $updatePos == " " ) {
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
  else {

    $sql = "UPDATE employee SET emName=:emName, emPhone=:emPhone, emEmail=:emEmail, emPos=:emPos WHERE emID=:emID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':emName' => $_POST['updateName'],
      ':emPhone' => $_POST['updatePhone'],
      ':emEmail' => $_POST['updateEmail'],
      ':emPos' => $_POST['updatePos'],
      ':emID' => $_POST['updateID']));

      unset($_SESSION['updateName']);
      unset($_SESSION['updatePhone']);
      unset($_SESSION['updateEmail']);
      unset($_SESSION['updatePos']);
      unset($_SESSION['updateID']);

  }
    header("Location: administrator_view_employee.php");
    return;

}


?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="admin.css"/>
</head>
<body>

<div class="sidenav">
  <img class = "logo" src = "logo_transparent.png" alt = "Hospial Logo" />
  <button type="button" class="btnLogout" onclick="location.href='logout.php'">Log Out</button>
  <br/><br/><br/><br/>

  <a href="administrator_dashboard.php">Dashboard</a>
  <a href="administrator_view_employee.php" style="color: #FFFFFF;" >View Employee List</a>
</div>

<div class="main">

<h2>Employee List</h2>

<table>
	<tr>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center;">Employee ID</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Full Name</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Phone Number</th>
	<th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Email Address</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Position</th>
  <th style = "background-color: #005A9E; color: #FFFFFF; text-align: center; font-weight: bold">Delete</th>
	</tr>

<?php

//To display all the employee data in table form
$stmt = $pdo->query("SELECT emID, emName, emPhone, emEmail, emPos FROM employee");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row){
echo ("<tr><td>");
echo ($row['emID']);
echo ("</td><td>");
echo ($row['emName']);
echo ("</td><td>");
echo ($row['emPhone']);
echo ("</td><td>");
echo ($row['emEmail']);
echo ("</td><td>");
echo ($row['emPos']);
echo ("</td><td>");
echo ('<form method = "post"><input type = "hidden" name = "emID" value = "'.$row['emID'].'" />' . "\n" );
echo ('<input type = "submit" value = "Delete" name = "delete" class = "btnDelete" />');
echo ("\n</form>\n");
echo ("</td></tr>\n");
}

?>

</table>
<br/><br/>

<h2>Add a New Employee</h2>
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
$addPos = isset($_SESSION['addPos']) ? $_SESSION['addPos'] : '';
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
      <input type="text" id="add_name" name="addName" placeholder="Your name.."
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
      <input type="text" id="add_phone" name="addPhone" placeholder="Your phone number.."
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
      <input type="text" id="add_email" name="addEmail" placeholder="Your email.."
      <?php
      echo 'value = "' . htmlentities($addEmail) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_position">Position</label>
    </div>
    <div class="col-75">
      <select id="add_position" name="addPos">
        <option value="Administrator">Administrator</option>
        <option value="Doctor">Doctor</option>
        <option value="Nurse">Nurse</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="add_userID">New Employee ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="add_userID" name="addID" placeholder="Generate an ID for the new employee.."
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
      <input type="password" id="add_pw" name="addPassword" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; resize: vertical;" placeholder="Generate a password for the new employee.."
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
<h2>Update an Employee Information</h2>
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
$updatePos = isset($_SESSION['updatePos']) ? $_SESSION['updatePos'] : '';

?>

<div class="container">
  <form method = "post">
  <div class="row">
    <div class="col-25">
      <label for="userID">Employee ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="userID" name="updateID" placeholder="Your ID.."
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
      <input type="text" id="name" name="updateName" placeholder="Your name.."
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
      <input type="text" id="phone" name="updatePhone" placeholder="Your phone number.."
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
      <input type="text" id="email" name="updateEmail" placeholder="Your email.."
      <?php
      echo 'value = "' . htmlentities($updateEmail) . '"';
      ?>
      />
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="position">Position</label>
    </div>
    <div class="col-75">
      <select id="position" name="updatePos">
        <option value="Administrator">Administrator</option>
        <option value="Doctor">Doctor</option>
        <option value="Nurse">Nurse</option>
      </select>
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
