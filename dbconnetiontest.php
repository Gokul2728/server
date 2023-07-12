<?php
include 'db/connection.php';
$db = db();
$res = array();
if ($db) {
    $query = $db->prepare("SELECT * FROM workers_list ORDER BY id DESC");
    #bind prame#
    $query->execute();
    $result = $query->get_result();
    while ($row = mysqli_fetch_assoc($result)) {
        $res[] = $row;
    }
} else {
    echo 'error . check tha db';
}
header('Content-Type: application/json');

// Convert the data array to JSON and output it
echo json_encode($res);
