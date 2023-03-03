<?php
   session_start();

   if (!isset($_SESSION['user'])) {
      header("Location: login.php");
      exit;
   }

   $content = trim(file_get_contents("php://input"));

   //this content should be a json already
   //{"first_name":"first name","last_name":"last name"}
   
   //if want to access values
   $_arr = json_decode($content, true);

   $user_id = $_SESSION['user']['id'];
   $task = $_arr['task'];
   $task_id = $_arr['task_id'];

   include("connection.php");

   $select_stmt = $conn->prepare("INSERT INTO gubble_tasks (user_id, task_id, task, completed) VALUES (:user_id, :task_id, :task, :completed)");
  
   $select_stmt -> execute(array(
      ":user_id" => $user_id,
      ":task" => $task,
      ":task_id" => $task_id,
      ":completed" => 0,
   ));

   echo json_encode(['success'=>true]);
?>