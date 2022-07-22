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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link href="doctor.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Profile</title>
</head>

<body style="background-image: url('background.jpg')">
    <nav class="topnav">
        <a class="active" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
        <a href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
        <a href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
        <a href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
        <a href='aboutUs.php'> <i class="  fa fa-users"></i> About us</a>
        <a id='logout' href="login.php"> <i class="fa fa-sign-out"></i> Log Out</a>
    </nav>
    <center>
        <div id="home" style="background-color:rgba(0,0,0,0.5) ;">
            <h1> Welcome to Detection of colorectal cancer</h1><br><br><br><br><br><br><br><br><br><br>
            <p style="text-align: left;font-size: larger;">This is the first site to provide CRC detection module that can be used by various doctors, a CNN module was used with a dataset of 6000 colonoscopy photos of different parts of a human colon, 50% were positive and 50% were negative. There are various options that are provided by the website such as add patients, checking if they have CRC, checking general information about patients and checking user infromation. </p>
        </div>
    </center>
</body>

</html>