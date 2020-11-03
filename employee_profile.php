<?php



 ?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Helvetica, sans-serif;
}

.logo{
  width: 200px;
  height: 200px;
  margin-left: 20px;
}

.headerImage{
  background-image: url("hos_bg5.jpg");
  width:1015px;
  height:300px;
  margin-left: 240px;
  padding-top: 0px;
}

.pageTitle{
  font-size: 70px;
  font-weight: bold;
  color: #242020;
  margin-left: 10px;
}

.sidenav {
  height: 100%;
  width: 250px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #005A9E;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 30px;
  text-decoration: none;
  font-size: 20px;
  color: #BEBEBE;
  display: block;
}

.sidenav a:hover {
  color: #F1F1F1;
}

.main {
  margin-left: 250px; /* Same as the width of the sidenav */
  font-size: 15px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>

<div class="sidenav">

<img class = "logo" src = "logo_transparent.png" alt = "Hospial Logo" />
<br/><br/><br/><br/>

  <a href="#about">Dashboard</a>
  <a href="#services">View Patient List</a>
  <a href="#clients">View Medicine List</a>
  <a href="#contact">View Diagnosis List</a>
</div>

<div class = "headerImage" >
  <br/>
  <span class = "pageTitle">&nbsp;&nbsp;&nbsp;Dashboard</span>

</div>

<div class="main">

  <h1 class = "title">Some Description</h1>
  <p>View Your Profile</p>
  <p>Welcome Back ! Please enter your Employee ID to view your own profile.</p>
  <p>Scroll down the page to see the result.</p>
  <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
  <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
  <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
  <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
</div>

</body>
</html>
