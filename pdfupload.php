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
?>
<!-- /////////////////////// -->
<?php
// Set up database connection

$host = '121.200.55.62';
$username = 'ragav';
$password = 'ragav';
$database = 'ecom';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdf']) && isset($_FILES['pdf1'])) {

        $pdf_file = $_FILES['pdf']['tmp_name'];
        $pdf_file1 = $_FILES['pdf1']['tmp_name'];

        $pdf_name = $_FILES['pdf']['name'];
        $pdf_name1 = $_FILES['pdf1']['name'];

        $upload_dir = '../../../pdf/english/product/';
        $upload_dir1 = '../../../pdf/tamil/product/';

        $upload_path = $upload_dir . basename($pdf_name);
        $upload_path1 = $upload_dir1 . basename($pdf_name1);

        if (move_uploaded_file($pdf_file, $upload_path) && move_uploaded_file($pdf_file1, $upload_path1)) {

            $sql->prepare("INSERT INTO product_master (pdf_english,pdf_tamil,product_category) VALUES (?,?,?)");
            $sql->bind_params('sss', $pdf_name, $pdf_name1, 5);

            if ($conn->query($sql) === TRUE) {
                echo 'PDF file uploaded and saved to database.';
            } else {
                echo 'Error saving PDF file to database: ' . $conn->error;
            }
        } else {
            echo 'Error uploading PDF file.';
        }
    } else {
        echo 'No PDF file uploaded.';
    }
}

$conn->close();
