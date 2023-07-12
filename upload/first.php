<?php
// Assuming you have a MySQL database setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a new connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the form

$name = $_POST["name"];
$email = $_POST["email"];

// Prepare and execute the SQL statement
$sql = "INSERT INTO users (username, email) VALUES ('$name', '$email')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
