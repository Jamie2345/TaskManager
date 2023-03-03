<?php
  require_once("connection.php");
  session_start();

  if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Gubble Task Managing</title>
  </head>
  <body id="tasks-page">
    <div class="full-page-container" id="blur">
      <header id="header">
        <nav id="nav-bar">
          <div id="gubble-title-container">
            <span class="gubble-nav-title">Gubble Task Management</span>
          </div>
          <div id="links-container">
            <ul class="nav-links">
              <li><a class="nav-link" href="tasks.php">All Tasks</a></li>

              <li><a class="nav-link" href="schedule.php">Schedule</a></li>

              <li><a class="nav-link" href="calender.php">Calender</a></li>

            </ul>
          </div>
          <div id="account-container">
            <a href="account.php"><img src="images/account.jpg" class="account-photo"></a>
            
            <?php
              echo "<a href='account.php'><span>". ucfirst($_SESSION['user']['name'])."</span></a>"
            ?>

          </div>

        </nav>
      </header>
      <main>
        <div class="main-container">
          <h1>Tasks</h1>
          
          <?php
      
            echo "<h2> Welcome User: ". ucfirst($_SESSION['user']['name']). "</h2>";
      
          ?>
      
          <p class="logout-text"><a href="logout.php">Logout</a></p>
          <div class="tasks-container">
            <ul class="tasks-instructions">
              <li id="done-task-instruction">Completed</li>
              <li id="todo-instruction">Task To Do</li>
              <li id="edit-or-delete-instruction">Edit Or Delete</li>
            </ul>
            <?php
              include("connection.php");

              $user_id = $_SESSION['user']['id'];


              $select_stmt = $conn->prepare("SELECT * FROM gubble_tasks WHERE user_id = :user_id");

              $select_stmt->execute([":user_id" => $user_id]);

              $next_task_id = 0;

              while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $next_task_id ++;
                $task = $row['task'];
                $task_id = $row['task_id'];
                $checked = $row['completed'];
                $tick_text = "";

                if ($checked) {
                  $tick_text = "checked";
                }
                
                echo "<div class='task-container'><div class='done-button-container'><input type='checkbox' id='done-checkbox' $tick_text onclick=\"taskStatus(this, '$task_id')\"></div><div class='task-text' data-task-text='$task'>".$task."</div><div class='task-management-buttons-container'><button><i class='ri-pencil-fill' id='edit-btn' onclick=\"editTaskButton('$task', '$task_id')\"></i></button><button><i class='ri-delete-bin-7-fill' id='delete-btn' onclick=\"deleteTaskButton('$task', '$task_id')\"></i></button></div></div>";
              }

              echo $next_task_id;
            ?>
            
            <div class="all-tasks-operations-container">
              <div class="operation-container">
                <?php
                  echo "<button onclick=\"addTaskButton('$next_task_id')\"><i class='ri-add-fill' id='add-btn'></i></button>";
                ?>
                <span>Add Task</span>
              </div>
              <div class="operation-container">
                <button onclick="deleteAllTasks()"><i class='ri-delete-bin-2-fill' id='delete-all-btn'></i></button>
                <span>Delete All Tasks</span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="task-edit-popup">
      <div class="close-div">
        <button class="popup-close" id="task-edit-close-button">&times;</button>
      </div>
      <div class="popup-content">
        <h2 class="popup-title">Edit Task</h2>
        <div class="inputBox">
          <input id="edit_box" name="edit_box" required="" type="text">
        </div>
        <div class="controlsBox">
          <button id="edit_conf_btn">Confirm Edit</button>
          
          <button id="edit_cancel_btn">Cancel Edit</button>
          
        </div>
      </div>
    </div>
    <div id="task-delete-popup">
      <div class="close-div">
        <button class="popup-close" id="task-delete-close-button">&times;</button>
      </div>
      <div class="popup-content">
        <h2 class="popup-title">Delete Task</h2>
        <div class="task-text-box">
          <span id="task-delete-task-text"></span>
        </div>
        <div class="controlsBox">
          <button id="delete_conf_btn">Delete</button>
        </div>
      </div>
    </div>
    <div id="task-add-popup">
      <div class="close-div">
        <button class="popup-close" id="task-add-close-button">&times;</button>
      </div>
      <div class="popup-content">
        <h2 class="popup-title">Add Task</h2>
        <div class="inputBox">
          <input id="add_box" name="add_box" required="" type="text" placeholder="Enter Task">
        </div>
        <div class="controlsBox">
          <button id="add_conf_btn">Confirm Add</button>
          <button id="add_cancel_btn">Cancel Add</button>
        </div>
      </div>
    </div>
    <div id="delete-all-popup">
      <div class="close-div">
        <button class="popup-close" id="delete-all-close-button">&times;</button>
      </div>
      <div class="popup-content">
        <h2 class="popup-title">Delete All Tasks</h2>
        <div class="controlsBox">
          <button id="delete_all_conf_btn">Delete All</button>
        </div>
      </div>
    </div>
  </body>
  <!--Script-->
  <script src="js/app.js">
  </script>
</html>