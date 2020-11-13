<?php
if ( ! isset($_COOKIE['wap'])){
  setcookie('wap', '42', time()+3600);
}

 ?>

<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
  font-family: Helvetica, sans-serif;
  margin: 0px;
}

.header{
    background-color: #005A9E;
    color: #FFFFFF;
    overflow: hidden;
    padding: 10px;

}

.container{
    display: block;
    margin-left: 470px;
}

.login_title{
    font-size: 25px;
    font-weight: bold;
    margin-left: 530px;
}

.column a{
    text-align: center;
    color: black;
    font-weight: bold;
    text-decoration: none;
    padding: 8px;
}

.column {
  float: left;
  width: 30%;
  padding: 5px;
  margin-left: 40px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}
</style>
</head>
<body>

<div class="header">

    <h2>Welcome to HOPEE General Hospital Official Website</h2>
</div>
<br/><br/>
<div class = "container">
    <img src="logo_transparent.png" alt = "Hopital logo" width="30%"/>
</div>
<p class="login_title">Log In As:</p>
<br/>

<div class="row">
  <div class="column">
    <a href = "administrator_login.php" style="margin-left: 60px;">
        <img src="administrator.png" alt="Administrator" style="width: 30%;">
        <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Administrator
    </a>
  </div>
  <div class="column">
    <a href = "employee_login.php" style="margin-left: 60px;">
        <img src="employee.png" alt="Employee" style="width:30%;">
        <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Employee
    </a>
  </div>
  <div class="column">
    <a href = "patient_login.php" style="margin-left: 60px;">
        <img src="patient.png" alt="Patient" style="width:30%">
        <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Patient
    </a>
  </div>
</div>

</body>
</html>
