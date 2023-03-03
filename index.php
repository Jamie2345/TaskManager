<?php
  require_once("connection.php");

  session_start();

  if(isset($_SESSION['user'])) {
    header("Location: tasks.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
    <title>Gubble Task Managing</title>
  </head>
  <body>
    <main>
      <section>
        <div class="introduction-container">
          <div class="intro">
            <h1>Gubble helps teams move work forward.</h1>
            <p>Collaborate, manage projects, and reach new productivity peaks. From high rises to the home office, the way your team works is unique—accomplish it all.</p>
            <div class="signup-login">
              <a href="register.php">
                <button class="btn-hover color-3">Sign Up</button>
              </a>
              <a href="login.php">
                <button class="btn-hover color-1">Log In</button>
              </a>
            </div>
          </div>
          <div class="image-container">
            <img src="images/TaskManaging.png">
          </div>
        </div>
      </section>
    </main>
  </body>
  <!--Script-->
  <script src="js/app.js">
  </script>
</html>