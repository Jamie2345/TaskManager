<?php
  require_once("connection.php");

  session_start();

  if(isset($_SESSION['user'])) {
    header("Location: tasks.php");
  }

  if(isset($_REQUEST['login_btn'])) {
    $email = filter_var(strtolower($_REQUEST["email"]), FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_REQUEST["password"]);

    if(empty($email)) {
      $errorMsg[] = "Must enter email";
    }

    else if(empty($password)) {
      $errorMsg[] = "Must enter password";
    }

    else {
  
      try {

        $select_stmt = $conn->prepare("SELECT * FROM gubble_users WHERE email = :email LIMIT 1");
  
        $select_stmt->execute([":email" => $email]);
  
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
        if($select_stmt->rowCount() > 0) {
          
          if(password_verify($password, $row["password"])) {
  
            $_SESSION['user']['name'] = $row['username'];
            $_SESSION['user']['email'] = $row['email'];
            $_SESSION['user']['id'] = $row['id'];
            
            header("Location: tasks.php");

          }
          else {
            $errorMsg[] = "Wrong email or password";
          }
  
        }
        else {
          $errorMsg[] = "Wrong email or password";
        }
        
      }
      catch(PDOException $e) {
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
      <?php

        if(isset($_REQUEST['msg'])) {
          echo "<p class='alert alert-warning'>".$_REQUEST['msg']."</p>";
        }

      ?>
      <div class="title">Login</div>
      <div class="content">
        <form class="login-form" id="login-form" method="POST" action="login.php">
          <div class="login-details user-details">
            <div class="login-input input-box">
              <span class="details">Email</span>
              <input id="email" name="email" type="email" placeholder="Enter your email address" required>
            </div>
            <div class="login-input input-box">
              <span class="details">Password</span>
              <input id="password" type="password" placeholder="Enter your password" name="password" pattern="^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{7,}$" title="Minimum of 7 characters. Should have at least one special character and one number and one UpperCase Letter." required>
            </div>
          </div>

          <?php

            if(isset($errorMsg)) {
              echo "<p class='small text-danger'>".$errorMsg[0]."</p>";

            }

          ?>

          <div class="button">
            <input type="submit" name="login_btn" value="Login">
          </div>
        </form>
      </div>
    </div>
  </body>
  <!--Script-->
  <script src="js/app.js"></script>
</html>