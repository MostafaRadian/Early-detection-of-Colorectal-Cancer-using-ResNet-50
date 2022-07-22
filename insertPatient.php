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
    if (isset($_POST['submit'])) {
        $p_name = $_POST['name'];
        $age = $_POST['age'];
        $m_history = $_POST['history'];
        $d_id = $_SESSION['user_id'];
        if (is_numeric($p_name)) {
            echo "<script>alert('Please enter a valid name with no numbers')</script>";
        }
        if (isset($_FILES['pimage'])) {
            $errors = array();
            $file_name = $_FILES['pimage']['name'];
            $file_size = $_FILES['pimage']['size'];
            $file_tmp = $_FILES['pimage']['tmp_name'];
            $file_type = $_FILES['pimage']['type'];

            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $extensions = array("jpeg", "jpg", "png");
            // echo $file_name . "<br>" . $file_size . "<br>" . $file_tmp . "<br>" . $file_type . "<br>" . $file_ext . "<br>";
            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "/Applications/MAMP/htdocs/GraduationProject/Images/" . $file_name);
                $sql = "INSERT INTO `Patient`(`name`, `age`, `medical_history`, `patient_image`, `doctor_id`) VALUES ('$p_name','$age','$m_history','$file_name','$d_id');";
                if ($conn->query($sql) === TRUE) {
                    header('Location:home.php');
                } else {
                    $error = $conn->error;
                    echo $error;
                }
            }
        } else {
            echo "NO image";
        }
    }
}
$conn->close();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="codecss.css"> -->
    <link href="doctor.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery library -->

</head>

<body style="background-image: url('background.jpg')">
    <nav class="topnav">
        <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="doctorProfile.php"><i class="fa fa-address-book"></i> Profile</a>
        <a href="patientProfile.php"><i class="fa fa-vcard"></i> Patients Information</a>
        <a class="active" href="insertPatient.php"><i class="fa fa-user-plus"></i> Add patient</a>
        <a href="canserCheck.php"><i class="fa fa-search"></i> CRC Detector</a>
        <a href='aboutUs.php'> <i class="  fa fa-users"></i> About us</a>
        <a id='logout' href="login.php"> <i class="fa fa-sign-out"></i> Log Out</a>
    </nav>
    <center>
        <form name="myform" id="insert_form" enctype="multipart/form-data" style="background-color:rgba(0,0,0,0.5) ;" method="post">
            <center>
                <legend class="form__title">Patient Form</legend>
            </center>
            <label for="name" class='col'> Patient Name <span class="required">*</span> </label><br>
            <input id="name" type="text" class='input_text' placeholder="Enter patient Name" name="name" required>
            <br><br>
            <label for="age" class='col'>Age <span class="required">*</span></label><br>
            <input id="age" type="number" class="input_text" placeholder="Enter age" name="age" min=0 max=130 required>
            <br><br>
            <label for="history" class='col'>Medical History<span class="required">*</span></label><br>
            <textarea id="history" class="input_text" placeholder="Enter medical history of patient" name="history" rows="10" cols="10" required></textarea>
            <br><br>
            <label for="pimage" class='col'>Patient Image (If avalible) </label><br>
            <input type="file" name="pimage" style="color:white" class="input_text" />
            <br><br>
            <center>
                <input type="reset" value="Reset" id='reset_sign_up' class='btn btn-larger'>
            </center>
            <br>
            <center>
                <input type="submit" name="submit" value="Add Patient" id='sign' class='btn btn-larger'>
            </center>
        </form>
    </center>

    <script src="script.js">
    </script>
</body>

</html>

</html>