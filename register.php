<?php
  include_once("connection.php");

  session_start();
  
  if (isset($_SESSION['user'])) {
    header('location: tasks.php');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = filter_var(strtolower($_REQUEST["username"]), FILTER_SANITIZE_STRING);
    $email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_REQUEST["password"]);

    # Extra validation even though it was done in javaScript

    if (empty($username)) {
      $errorMsg[0][] = "Name required";
    }

    if (empty($email)) {
      $errorMsg[1][] = "Email required";
    }

    if (empty($password)) {
      $errorMsg[2][] = "Strong password required";
    }

    if (strlen($password) < 7) {
      $errorMsg[3][] = "Password too short (7 or more characters needed)";
    }
    
    if (empty($errorMsg)) {

      try {
        $select_stmt = $conn->prepare("SELECT username,email FROM gubble_users WHERE email = :email");
        $select_stmt->execute(array(":email" => $email));
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($row["email"]) == $email) {
          $errorMsg[4][] = "Email already registered, please choose another or login instead.";
        }

        else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $created = new DateTime();
          $created = $created->format("Y-m-d H:i:s");

          $insert_stmt = $conn->prepare("INSERT INTO gubble_users (username,email,password,created) VALUES (:u_name, :u_email, :hashed_password, :created)");

          if(
            $insert_stmt->execute(array(
              ":u_name" => $username,
              ":u_email" => $email,
              ":hashed_password" => $hashed_password,
              ":created" => $created
            ))
          ){
            header("Location: login.php?msg=".urlencode('Please verify your email address before logging in.'));
          }

        }

      }

      catch (PDOException $e) {
        echo $e->getMessage();
      }

    }

  }

?>

<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gubble Task Managing</title>
  </head>
  <body class="form-page-body">
    <div class="container">
      <div class="title">Registration</div>
      <div class="content">
        <form id="sign-up-form" type="POST" action="register.php">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Username</span>
              <input id="username" name="username" type="text" placeholder="Enter your username" autocomplete="off" required>
            </div>
            <div class="input-box">
              <span class="details">Email</span>
              <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="off" required>
            </div>
            <div class="input-box">
              <span class="details">Password</span>
              <input id="password" name="password" type="password" placeholder="Enter your password" pattern="^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{7,}$" title="Minimum of 7 characters. Should have at least one special character and one number and one UpperCase Letter." autocomplete="off" required>
            </div>
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input id="confirm-password" type="password" placeholder="Confirm your password" pattern="^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{7,}$" title="Minimum of 7 characters. Should have at least one special character and one number and one UpperCase Letter." autocomplete="off" required>
            </div>
          </div>
          <p class="password-message"></p>

          <?php

            if(isset($errorMsg[4])) {
              foreach ($errorMsg[4] as $emailErrors){
                echo "<p class='small text-danger'>".$emailErrors."</p>";
                echo "<p class='login-link'><a class='small' href='login.php'>Click here to login</a></p>";
              }
            }

          ?>

          <div class="button">
            <input type="button" value="Register" name="register_btn" onclick="validateForm()">
          </div>
        </form>
      </div>
    </div>
  </body>
  <!--Script-->
  <script src="js/app.js">
  </script>
</html>