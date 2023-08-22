<?php
include 'db/connection.php';
$db = db();
$res = array();

if ($db) {

   if (isset($_POST['username']) && isset($_POST['password'])) {
      extract($_POST);
      $sql = $db->prepare('SELECT * FROM users WHERE username=?,password = ?');
      $sql->bind_param('s,s', $username, $password);
      $sql->execute();
      $result = $sql->get_result();
      $count = mysqli_num_rows($result);
      $row = mysqli_fetch_assoc($result);
      if ($count == 0) {
         return "Connection Failed";
      } else {
         $res['success'] = false;
         $res['username'] = $row['username'];
         $res['password'] = $row['password'];
      }
   } else {
      $res['success'] = false;
      $res['message'] = 'DB Not Connected';
   }
}
