<?php

    // Check if the required form fields are present and valid
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the required form fields are present and valid
        if (
            isset($_POST['id']) &&
            is_numeric($_POST['id']) &&
            isset($_POST['name']) &&
            isset($_POST['surname']) &&
            isset($_POST['title']) &&
            isset($_POST['department']) &&
            isset($_POST['basic_field']) &&
            isset($_POST['scientific_field']) &&
            isset($_POST['academic_activity_type']) &&
            isset($_POST['activity']) &&
            isset($_POST['work_name']) &&
            isset($_POST['persons'])
            // Ensure all the fields you want to update are included here
        ) {
            // Database connection details
            $servername = "localhost"; // Replace with your server name if different
            $username = "root"; // Replace with your MySQL username
            $password = ""; // Replace with your MySQL password
            $dbname = "aias"; // Replace with your database name
        }

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $id = $_POST['id'];

        // Prepare and execute SQL to update 'onay_durumu' column to a desired value (e.g., 'Approved')
        $onay_durumu = 'Approved'; // Change this value to what you want
        $sql = "UPDATE tesvik SET onay_durumu = '$onay_durumu' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Row approved successfully";
        } else {
            echo "Error approving row: " . $conn->error;
        }

        // Close database connection
        $conn->close();
    } else {
        echo "Invalid form data received";
    }

?>
