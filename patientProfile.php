<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CRCD";
$conn = new mysqli($servername, $username, $password, $dbname); // Check connection
$result = "";
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
  if (isset($_POST['submit'])) {
    $pName = $_POST['patient'];
    $sql = "SELECT age,medical_history,location_in_colon,patient_image,image,CRC FROM `Patient` WHERE name='$pName';";
    $pData =  $conn->query($sql);
    $row = $pData->fetch_assoc();
    $pAge = $row['age'];
    $pMedic = $row['medical_history'];
    $loc = $row['location_in_colon'];
    $pImg = $row['patient_image'];
    $colon = $row['image'];
    $crc = $row['CRC'];
    if ($crc === '0') {
      $result = "Negative";
    } else {
      $result = "Positive";
    }
  }
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Information</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link href="doctor.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">

  <!-- jQuery library -->
</head>

<body style="background-image: url('background.jpg');">
  <nav class="topnav">
    <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
    <a class="active" href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
    <a href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
    <a href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
    <a href='aboutUs.php'> <i class="  fa fa-users"></i> About us</a>
    <a id='logout' href="login.php"> <i class="fa fa-sign-out"></i> Log Out</a>
  </nav>
  <center>
    <form method="post" id="pinfo" style="background-color:rgba(0,0,0,0.5) ;">
      <center>
        <legend class="form__title">Patient Information</legend>
      </center>
      <label for="patient" class='col'> Select patient <span class="required">*</span> </label><br>
      <select id="patient" name="patient">
        <?php
        $sql = "SELECT name  FROM `Patient` WHERE doctor_id='$d_id';";
        $p_list =  $conn->query($sql);
        while ($row = $p_list->fetch_assoc()) {
          echo "<option>" . $row['name'] . "</option>";
        }
        ?>
      </select>
      <br><br>
      <center>
        <input type="submit" name="submit" value="Show Data" id='sign' class='btn btn-larger '>
      </center>
      <br>
      <center>
        <img src="Images/<?php echo $pImg ?>" width="60%" height="18%" style="display: inline_block; border-radius: 50%;" />
        <br /><br />
        <label for="name" class="col"> Patient Name </label><br />
        <input type="text" class="input_text" value="<?php echo $pName ?>" />
        <br /><br />
        <label for="age" class="col"> Patient Age </label><br />
        <input type="text" class="input_text" value="<?php echo $pAge ?>" />
        <br /><br />
        <label for="history" class="col">Medical History</label><br />
        <textarea class="input_text" rows="10" cols="10"><?php echo $pMedic ?></textarea>
        <br /><br />
        <label for="pimage" class="col">Colon Image</label><br />
        <img src="Images/<?php echo $colon ?>" width="80%" height="20%" />
        <br /><br />
        <label for="loc" class="col"> Image Location </label><br />
        <input type="text" class="input_text" value="<?php echo $loc ?>" />
        <br /><br />
        <label for="res" class="col" style="color: black"> CRC </label><br />
        <input type="text" class="input_text" value="<?php echo $result ?>" />
        <br /><br />
    </form>
  </center>





  <script src="script.js"></script>
  <?php $conn->close(); ?>
</body>

</html>