<?php
include 'db/connection.php';
$db = db();
$res = array();

if ($db) {

    // File upload handling
    if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["photo"]["tmp_name"];
        $photoData = addslashes(file_get_contents($file)); // Read the file data

        // Insert photo into the database
        $sql = "INSERT INTO photos (photo_blob) VALUES ('$photoData')";
        if ($conn->query($sql) === TRUE) {
            echo "Photo uploaded successfully.";
        } else {
            echo "Error uploading photo: " . $conn->error;
        }
    } else {
        echo "Error uploading photo.";
    }
}
// Output uploaded photo
$sql = "SELECT photo_blob FROM photos ORDER BY id DESC LIMIT 1"; // Get the last uploaded photo
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $photoData = $row["photo_blob"];
    $photoType = mime_content_type($photoData); // Get the MIME type of the photo
    header("Content-type: $photoType"); // Set the Content-type header
    echo $photoData; // Output the photo data
} else {
    echo "No photo found.";
}

$conn->close();
