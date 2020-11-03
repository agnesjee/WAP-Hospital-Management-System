<?php

require_once "pdo.php";

$stmt = $pdo->query("SELECT * FROM employee");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<table border = "1">' . "\n";
foreach ($rows as $row) {
  echo ("<tr><td>");
  echo ($row['emID']);
  echo ("</td><td>");
  echo ($row['emPassword']);
  echo ("</td><td>");
  echo ($row['emName']);
  echo ("</td><td>");
  echo ($row['emPhone']);
  echo ("</td><td>");
  echo ($row['emEmail']);
  echo ("</td><td>");
  echo ($row['emPos']);
  echo ("</td><td>");
  echo ("</td></tr>\n");
}
echo "</table>\n";


 ?>

<html>

<head></head>
<body>

<img src = "logo_transparent.png" alt = "HOPEE General Hospital Logo" />
<h1>Welcome to HOPEE General Hospital website!</h1>
<h3>Please log in to continue.</h3>
<br/><br/>

<form method = "post">
  <p>Log in as:<br/>
  <input type = "radio" name = "position" value = "administrator" checked />Administrator
  <input type = "radio" name = "position" value = "employee" />employee
  <input type = "radio" name = "position" value = "patient" />Patient
  </p>
  <p><label for = "user_id">User ID:</label><br/>
    <input type = "text" name = "user_id" id = "user_id" size = "40">
  </p>
  <p><label for = "user_password">Password:</label><br/>
    <input type = "password" name = "user_password" id = "user_password" size = "40">
  </p>
  <p><input type = "submit" name = "submit" value = "Log In"/>

</form>


</body>

</html>
