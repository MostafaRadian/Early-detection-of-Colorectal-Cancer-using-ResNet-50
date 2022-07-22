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
  if (isset($_POST['submit'])) {
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hospital = $_POST['hospital'];


    if (isset($_FILES['image'])) {
      $errors = array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); 

      $extensions = array("jpeg", "jpg", "png");
      // echo $file_name . "<br>" . $file_size . "<br>" . $file_tmp . "<br>" . $file_type . "<br>" . $file_ext . "<br>";
      if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
      }
      if (empty($errors) == true) {
        move_uploaded_file($file_tmp,"/Applications/MAMP/htdocs/GraduationProject/Images/".$file_name);
        $sql = "INSERT INTO `Doctor`(`fname`, `lname`, `email`, `password`, `phone`, `hospital`, `image`) VALUES ('$first_name','$last_name','$email','$password','$phone','$hospital','$file_name');";
        if ($conn->query($sql) === TRUE) {
          header('Location:login.php');
        } else {
          $error = $conn->error;
          if (str_contains($error, 'Duplicate')) {
            echo '<script>alert("Eamil is already used")</script>';
          }
        }
      }
    }
  }
}










// Close connection
$conn->close();
?>
<html>

<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- jQuery library -->
  <script src="js/jquery.min.js"></script>
	<link rel='stylesheet' href='css/bootstrap.min.css'>
  <!-- Latest compiled JavaScript -->
  <script src="js/bootstrap.min.js"></script>
</head>


<body style="background-image: url('background.jpg')">
<center>
    <form method="post" id="form_sign_up" onsubmit="return validate()" enctype="multipart/form-data">
      <center>
        <legend class="form__title">Register Form</legend>
      </center>
      <label for="fname" class='col'>First Name <span class="required">*</span> </label><br>
      <input id="fname" type="text" class='input_text' placeholder="Enter your first Name" name="fname" required>
      <br><br>
      <label for="lname" class='col'>Last Name <span class="required">*</span> </label><br>
      <input id="lname" type="text" class="input_text" placeholder="Enter your last Name" name="lname" required>
      <br><br>
      <label for="email_2" class='col'>Email <span class="required">*</span></label><br>
      <input id="email_2" type="Email" class="input_text" placeholder="Enter Email" name="email" required>
      <br><br>
      <label for="pass_2" class='col'>Password <span class="required">*</span></label><br>
      <input id="pass_2" type="password" class="input_text" placeholder="Password" name="password" required>
      <br><br>
      <label for="phone_2" for="phone" class='col'>phone </label><br>
      <input id="phone_2" type="tel" class="input_text" name="phone" placeholder="01125698532" pattern="[0-9]{11}"><br>
      <br>

      <label for="hospital" class='col'>Hospital </label><br>
      <input id="hospital" type="tel" class="input_text" name="hospital"><br>
      <br>
      <label for="image" class='col'>Add Image </label><br>
      <input type="file" name="image" class="input_text" required/>
      <br>
      <center>
        <input type="reset" value="Reset" id='reset_sign_up' class="btn btn-larger">
        <input type="submit" name="submit" value="Sign Up"  class="btn btn-larger">
      </center>
    </form>
  </center>


</body>

</html>