<!DOCTYPE html>
<html>

<head>
    <title>Enum Values Display</title>
</head>

<body>
    <?php
    // Assuming you have established a database connection

    $servername = "10.30.10.15";
    $username = "root";
    $password = "adc@sAdmin";
    $dbname = "baps";

    // Create a connection
    $connection = mysqli_connect($servername, $username, $password, $dbname);

    // Check the connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $tableName = 'r_master_class';
    $columnName = 'section';

    $query = "SHOW COLUMNS FROM $tableName WHERE Field = '$columnName'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Extract the enum values from the "Type" column
        preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);

        if (!empty($matches)) {
            $enumValues = explode("','", $matches[1]);
            // Display the enum values
            foreach ($enumValues as $value) {
                echo htmlentities($value) . "<br>";
            }
        } else {
            echo "Column $columnName is not an ENUM";
        }
    } else {
        echo "Error executing query: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
</body>

</html>