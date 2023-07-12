<?php

include 'db/connection.php';
$db = db();
$res = array();
if ($db) {
    try {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            extract($_POST);
            // $sql = mysqli_query($db,'');
            $sql = $db->prepare('SELECT * FROM users WHERE username = ?');
            $sql->bind_param('s', $username);
            $sql->execute();
            $result = $sql->get_result();
            $count = mysqli_num_rows($result);
            // login($db, 'INSERT INTO users(username ,password) VALUES(?,?)', $username);
            if ($count == 0) {
                $pass_e = md5($password);
                // login($db, "SELECT*FROM user where id =1", 'ss', $username);
                $sql = $db->prepare('INSERT INTO users(username ,password) VALUES(?,?)');
                $sql->bind_param('ss', $username, $pass_e);
                $sql->execute();
                if ($sql->error) {
                    $res['success'] = false;
                    $res['message'] = $sql->error;
                } else {
                    $res['success'] = true;
                    $res['message'] = 'Inserted Successfully';
                }
            } else {
                $res['success'] = false;
                $res['message'] = 'Missing Parameter';
            }
        } else {
            $res['success'] = false;
            $res['message'] = 'Already Exists';
        }
    } catch (Exception $throw) {
        $res['success'] = false;
        $res['message'] = $throw->__toString();
    }
} else {
    $res['success'] = false;
    $res['message'] = 'DB Not Connected';
}
echo json_encode($res);

function login($db, $querry, $bind, $username)
{
    $sql = $db->prepare($querry);
    $sql->bind_param($bind, $username);
    $sql->execute();
    $result = $sql->get_result();
    $count = mysqli_num_rows($result);
}
