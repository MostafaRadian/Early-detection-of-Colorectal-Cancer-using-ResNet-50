<?php
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
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
    $pName = $_SESSION['p_name'];
    $imgName = $_SESSION['imgName'];
    $loc = $_SESSION['loc'];
    $test = $imgName . '?' . $loc;
    $pId = $_SESSION['p_id'];
    $command = escapeshellcmd("/Library/Frameworks/Python.framework/Versions/3.10/bin/python3 cnn.py $test");
    $output = shell_exec($command . " 2>&1");
    $out = substr($output, -13);

    function CancerCheck($out)
    {
        if (str_contains($out, 'normal')) {

            return 0;
        } else {

            return 1;
        }
    }
    $cCheck = CancerCheck($out);
    $result = "";
    if ($cCheck === 0) {
        $result = "Negative";
    } else {
        $result = "Positive";
    }
    $sql = "UPDATE `Patient` SET `CRC` = '$cCheck' WHERE id = '$pId';";
    $conn->query($sql);
    $sql = "SELECT medical_history,location_in_colon,patient_image FROM `Patient` WHERE id='$pId';";
    $pData =  $conn->query($sql);
    $row = $pData->fetch_assoc();
    $pMedic = $row['medical_history'];
    $loc = $row['location_in_colon'];
    $pImg = $row['patient_image'];
    $conn->close();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Results</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="codecss.css">
    <link href="doctor.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- jQuery library -->

</head>

<body style="background-image: url('background.jpg')">
    <nav class="topnav">
        <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
        <a href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
        <a href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
        <a class="active" href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
        <a href='aboutUs.php'> <i class="  fa fa-users"></i> About us</a>
        <a id='logout' href="login.php"> <i class="fa fa-sign-out"></i> Log Out</a>
    </nav>

    <center>
        <form method="post" id="result" enctype="multipart/form-data" style="background-color:rgba(0,0,0,0.5) ;">
            <center>
                <legend class="form__title">Patient Results</legend>
            </center>


            <img src="Images/<?php echo $pImg ?>" width="60%" height="20%" style="display: inline_block; border-radius: 50%;" />
            <br><br>
            <label for="name" class="col">Patient Name</label><br />
            <input type="text" class='input_text' value="<?php echo $pName ?>">
            <br><br>
            <label for="history" class="col">Medical History</label><br />
            <textarea class="input_text" rows="5" cols="5"><?php echo $pMedic ?></textarea>
            <br /><br />
            <label for="pimage" class='col'>Colon Image</label><br>
            <img src="Images/<?php echo $imgName ?>" width="80%" height="20%" />
            <br /><br />
            <center><label for="loc" class='col'> Image Location </label></center>
            <input type="text" class='input_text' value="<?php echo $loc ?>">
            <br /><br />
            <label for="res" class='col'> CRC </label><br>
            <input type="text" class='input_text' value="<?php echo $result ?>">


        </form>
    </center>











    <script src="script.js">


    </script>
</body>

</html>