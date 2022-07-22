<?php
session_start();
$user_id;
$user_id = $_SESSION['user_id'];
if (empty($user_id)) {
  header('Location:login.php');
}
if (isset($_GET["logout"])) {
  unset($_SESSION['user_id']);
  unset($_SESSION['p_name']);
  unset($_SESSION['loc']);
  unset($_SESSION['p_id']);
  unset($_SESSION['imgName']);
  session_destroy();
  header('Location:login.php');
}
?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="description" content="" />
  <meta name="author" content="" />
  <link href="doctor.css" rel="stylesheet" />
  <link href="style.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <title>Profile</title>
</head>

<body style="background-image: url('background.jpg')">
  <nav class="topnav">
    <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
    <a href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
    <a href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
    <a href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
    <a class="active" href="aboutUs.html"><i class="fa fa-users"></i> About us</a>
    <a id="logout" href="login.php"><i class="fa fa-sign-out"></i> Log Out</a>
  </nav>
  <center>
    <div id="about" style="background-color: rgba(0, 0, 0, 0.5); height: 850px">
      <p style="text-align: left; font-size: larger">
        We are Bioinformatics developers who link our knoledge in Biology with
        our programming expertese to produces medical applications that can be
        used by doctors or professionals ,whether, it's DNA sequencing or any
        type of cancer detection, it all can be made as effiecent as possible.
      </p>
      <br /><br /><br /><br />
      <div class="flip-card" style="display: inline_block; border-radius: 50%; float: left">
        <div class="flip-card-inner" style="display: inline_block; border-radius: 50%">
          <div class="flip-card-front" style="display: inline_block; border-radius: 50%">
            <img src="Ali.jpg" alt="Avatar" style="
                  width: 300px;
                  height: 300px;
                  display: inline_block;
                  border-radius: 50%;
                " />
          </div>
          <div class="flip-card-back" style="display: inline_block; border-radius: 50%">
            <br /><br />
            <h1>Ali Mohamed</h1>
            <p>Architect & Engineer</p>
            <p>Email: ali.2016.16a@gmail.com</p>
          </div>
        </div>
      </div>

      <div class="flip-card" style="display: inline_block; border-radius: 50%; float: right">
        <div class="flip-card-inner" style="display: inline_block; border-radius: 50%">
          <div class="flip-card-front" style="display: inline_block; border-radius: 50%">
            <img src="anas.jpg" alt="Avatar" style="
                  width: 300px;
                  height: 300px;
                  display: inline_block;
                  border-radius: 50%;
                " />
          </div>
          <div class="flip-card-back" style="display: inline_block; border-radius: 50%">
            <br /><br />
            <h1>Anas Emad</h1>
            <p>Architect & Engineer</p>
            <p>Email: anasemad518@gmail.coms</p>
          </div>
        </div>
      </div>

      <div class="flip-card" style="display: inline_block; border-radius: 50%">
        <div class="flip-card-inner" style="display: inline_block; border-radius: 50%">
          <div class="flip-card-front" style="display: inline_block; border-radius: 50%">
            <img src="mostafa.jpg" alt="Avatar" style="
                  width: 300px;
                  height: 300px;
                  display: inline_block;
                  border-radius: 50%;
                " />
          </div>
          <div class="flip-card-back" style="display: inline_block; border-radius: 50%">
            <br /><br />
            <h1>Mostafa Ahmed</h1>
            <p>Architect & Engineer</p>
            <p>Email: mostafa.batesta@gmail.com</p>
          </div>
        </div>
      </div>

      <br /><br /><br />

      <div class="flip-card" style="display: inline_block; border-radius: 50%; float: left">
        <div class="flip-card-inner" style="display: inline_block; border-radius: 50%">
          <div class="flip-card-front" style="display: inline_block; border-radius: 50%">
            <img src="esraa.jpeg" alt="Avatar" style="
                  width: 300px;
                  height: 300px;
                  display: inline_block;
                  border-radius: 50%;
                " />
          </div>
          <div class="flip-card-back" style="display: inline_block; border-radius: 50%">
            <br /><br />
            <h1>Esraa Shierf</h1>
            <p>Architect & Engineer</p>
            <p>Email: esramoawed@gmail.com</p>
          </div>
        </div>
      </div>

      <div class="flip-card" style="display: inline_block; border-radius: 50%">
        <div class="flip-card-inner" style="display: inline_block; border-radius: 50%">
          <div class="flip-card-front" style="display: inline_block; border-radius: 50%">
            <img src="rawan.jpg" alt="Avatar" style="
                  width: 300px;
                  height: 300px;
                  display: inline_block;
                  border-radius: 50%;
                " />
          </div>
          <div class="flip-card-back" style="display: inline_block; border-radius: 50%">
            <br /><br />
            <h1>Rawan Osama</h1>
            <p>Architect & Engineer</p>
            <p>Email: rewanusamaa44@gmail.com</p>
          </div>
        </div>
      </div>
    </div>
  </center>
</body>

</html>