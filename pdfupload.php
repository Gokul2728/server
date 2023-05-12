<?php
include 'db/connection.php';
$db = db();
$res = array();

echo "Hello";
if ($db) {
    if (isset($_FILES['pdf'])) {

        $errors = array();
        $file_name = $_FILES['pdf']['name'];
        $file_size = $_FILES['pdf']['size'];
        $file_tmp = $_FILES['pdf']['tmp_name'];
        $file_type = $_FILES['pdf']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['pdf']['name'])));

        $extensions = array("pdf");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a PDF file.";
        }

        if ($file_size > 10485760) {
            $errors[] = 'File size cannot exceed 10 MB';
        }
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "db/images/" . $file_name);

            $sql = $db->prepare('INSERT INTO pdf(pdf_name) VALUES(?)');
            $sql->bind_param('s', $file_name);
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
            echo "Upload Success!";
        } else {
            print_r($errors);
        }
    }
} else {
    echo "Out of file";
}