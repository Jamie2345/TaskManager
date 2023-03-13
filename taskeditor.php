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
   $new_val = $_arr["new_value"];

   include("connection.php");

   function pkcs7_pad($data, $size) {
      $length = $size - strlen($data) % $size;
      return $data . str_repeat(chr($length), $length);
   }

   $enc_task = openssl_encrypt(
      pkcs7_pad($new_val, 16), // padded data
      'AES-256-CBC',        // cipher and mode
      'h72NHmPSDGCy96gubble',      // secret key
      0,                    // options (not used)
      1234567890123456                   // initialisation vector
   );

   $select_stmt = $conn->prepare("UPDATE gubble_tasks SET task = :new_task WHERE user_id = :user_id AND task_id = :task_id");

   $select_stmt -> execute(array(
      ":new_task" => $enc_task, 
      ":user_id" => $user_id,
      ":task_id" => $task_id,
   ));

   echo json_encode(['success'=>true]);
?>