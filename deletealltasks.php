<?php
   session_start();

   if (!isset($_SESSION['user'])) {
      header("Location: login.php");
      exit;
   }

   $user_id = $_SESSION['user']['id'];

   include("connection.php");

   $select_stmt = $conn->prepare("DELETE FROM gubble_tasks WHERE user_id = :user_id");


   $select_stmt -> execute(array(
      ":user_id" => $user_id,
   ));

   echo json_encode(['success'=>true]);
?>