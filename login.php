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
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT email FROM `Doctor` WHERE email='$email';";
    $db_emails = $conn->query($sql);
    $row = $db_emails->fetch_assoc();
    if (empty($row)) {
      echo '<script>alert("Email Not Correct")</script>';
    } elseif ($email === $row["email"]) {
      $sql_1 = "SELECT id, password  FROM `Doctor` WHERE email='$email';";
      $db_password = $conn->query($sql_1);
      $row_1 = $db_password->fetch_assoc();
      $user_id = $row_1["id"];
      if ($password === $row_1["password"]) {
        $_SESSION['user_id'] = $user_id;
        //  header('Location:base.php?user_id='.$user_id); 
        header('Location:home.php');
      } else {
        echo '<script>alert("Password Not Correct")
        </script>';
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
  <!-- jQuery library -->
  <script src="js/jquery.min.js"></script>
	<link rel='stylesheet' href='css/bootstrap.min.css'>
  <!-- Latest compiled JavaScript -->
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body style="background-image: url('background.jpg')">
  <center>
    <form id="form_login" method="post">
      <center>
        <legend class="form__title">Login Form</legend>
      </center>
      <center> <label for="email_1" class="col">Email:</label></center>
      <center><input id="email_1" class='input_text' type="Email" placeholder="Enter Email" name="email" required></center>
      <br>
      <label for="pass_1" class="col">Password:</label>
      <input id="pass_1" type="password" class='input_text' placeholder="Password" name="password" required>
      <br><br>
      <input id='sign' type="submit" name="submit" value="SIGN IN " class='btn btn-larger '>
      <br><br><br><br><br>
      <p id='text'> Not a member ?</p>
      <a id='text' href="register.php" type="submit" name="submit" style="color: rgb(32, 137, 202);">Create New Account</a>
  </center>
  </form>

</body>

</html> 

