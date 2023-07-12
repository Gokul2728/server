<?php

include 'db/connection.php';
$db = db();
$res = array();
if ($db) {
    try {
        if (isset($_POST['staff'])) {
            $staff = $_POST['staff'];
            // $email = isset($_POST['email']) ? $_POST['email'] : null;
            $pass_e = password_hash($staff, PASSWORD_DEFAULT);
            $sql = $db->prepare('INSERT INTO users(password,username,status,test) VALUES(?,?,1,?)');
            $sql->bind_param('sss', $pass_e, $staff, $email);
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
            $res['message'] = 'Invalid';
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
