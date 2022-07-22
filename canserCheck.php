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

    $d_id = $_SESSION['user_id'];
    if (isset($_POST['submit'])) {
        $p_name = $_POST['patient'];
        $loc = $_POST['loc'];
        $sql = "SELECT id  FROM `Patient` WHERE name='$p_name';";
        $id_list =  $conn->query($sql);
        $row = $id_list->fetch_assoc();
        $p_id = $row['id'];

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
                $sql = "UPDATE `Patient` SET `location_in_colon` = '$loc' ,`image` ='$file_name' WHERE name = '$p_name';";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['p_name'] = $p_name;
                    $_SESSION['imgName'] = $file_name;
                    $_SESSION['p_id'] = $p_id;
                    $_SESSION['loc'] = $loc;
                    header('Location:result.php');
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
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRC Detector</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="doctor.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery library -->

</head>

<body style="background-image: url('background.jpg');">
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
        <form method="post" id="checker" enctype="multipart/form-data" style="background-color:rgba(0,0,0,0.5) ;">
            <center>
                <legend class="form__title">Check for canser</legend>
            </center>
            <label for="patient" class='col'> Select patient </label><br>
            <select id="patient" name="patient" style='color:black;'>
                <?php
                $sql = "SELECT name  FROM `Patient` WHERE doctor_id='$d_id';";
                $p_list =  $conn->query($sql);
                while ($row = $p_list->fetch_assoc()) {
                    echo "<option>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="loc" class='col'>Select Location in colon</label><br>
            <label>
                <input name="loc" value="zline" type="radio" class="input_text"> Z_line
            </label><br>
            <label>
                <input name="loc" value="polyps" type="radio" class="input_text"> Polyps
            </label><br>
            <label>
                <input name="loc" value="cecum" type="radio" class="input_text"> Cecum
            </label><br>
            <br><br>
            <label for="pimage" class='col'> Patient Colon image </label><br>
            <input type="file" name="pimage" class="input_text" />
            <br><br>
            <center>
                <input type="reset" value="Reset" id='reset_sign_up' class='btn btn-larger'>

                <input type="submit" name="submit" value="Result" id='sign' class='btn btn-larger'>
            </center>
        </form>
    </center>

    <script src="script.js">


    </script>
    <?php $conn->close(); ?>
</body>

</html>

</html>