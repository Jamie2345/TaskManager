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
   $task_id = $_arr['task_id'];

   include("connection.php");

   $select_stmt = $conn->prepare("DELETE FROM gubble_tasks WHERE user_id = :user_id AND task_id = :task_id");


   $select_stmt -> execute(array(
      ":user_id" => $user_id,
      ":task_id" => $task_id,
   ));

   echo json_encode(['success'=>true]);
?>