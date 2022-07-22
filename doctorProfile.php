<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CRCD";
$conn = new mysqli($servername, $username, $password, $dbname); // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
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
  $d_id = $_SESSION['user_id'];
  $sql = "SELECT fname,lname,email,phone,hospital,image FROM `Doctor` WHERE id='$d_id';";
  $dData =  $conn->query($sql);
  $row = $dData->fetch_assoc();
  $dName = $row['fname'] . " " . $row['lname'];
  $dEmail = $row['email'];
  $dPhone = $row['phone'];
  $hosp = $row['hospital'];
  $dImg = $row['image'];
}
$conn->close();
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctor Profile</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link href="doctor.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <!-- jQuery library -->
</head>

<body style="background-image:url('background.jpg');">
  <nav class="topnav">
    <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <a class="active" href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
    <a href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
    <a href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
    <a href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
    <a href='aboutUs.php'> <i class="  fa fa-users"></i> About us</a>
    <a id='logout' href="login.php"> <i class="fa fa-sign-out"></i> Log Out</a>
  </nav>
  <center>
    <div id="profile" style="background-color:rgba(0,0,0,0.5) ;">

      <center>

        <img style='width: 55%;height: 53%; display: inline_block; border-radius: 50%;' class=" img-responsive" src="images/<?php echo $dImg; ?>" alt="Doctor Image">
      </center>
      <br><br>

      <center>
        <div style="display: block; text-align: center; padding: 10px  ; background-color:aliceblue;background-position-x: right;width: 60%;text-align: left;border-radius: 5%;">
          <i>
            <p style=" color:darkblue; font-size: larger;"><b> Name :</b> <?php echo $dName; ?></p>
            <p style=" color:darkblue; font-size: larger;"><b> Email :</b> <?php echo $dEmail; ?></p>
            <p style=" color:darkblue; font-size: larger;"><b> Phone :</b> <?php echo $dPhone; ?></p>
            <p style=" color:darkblue; font-size: larger;"><b> Hospital :</b> <?php echo $hosp; ?></p>
          </i>
          </p>
        </div>
      </center>
    </div>
  </center>
  <script src="script.js"></script>
</body>

</html>