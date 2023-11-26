<?php
// Check if the form data is received
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

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $title = $_POST['title'];
        $department = $_POST['department'];
        $basic_field = $_POST['basic_field'];
        $scientific_field = $_POST['scientific_field'];
        $academic_activity_type = $_POST['academic_activity_type'];
        $activity = $_POST['activity'];
        $work_name = $_POST['work_name'];
        $persons = $_POST['persons'];
        // Add more fields as necessary

        // Prepare and execute SQL to update row with the specified ID
        $sql = "UPDATE tesvik SET 
                name = '$name', 
                surname = '$surname', 
                title = '$title', 
                department = '$department', 
                basic_field = '$basic_field', 
                scientific_field = '$scientific_field', 
                academic_activity_type = '$academic_activity_type', 
                activity = '$activity', 
                work_name = '$work_name', 
                persons = '$persons' 
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Row updated successfully";
        } else {
            echo "Error updating row: " . $conn->error;
        }

        // Close database connection
        $conn->close();
    } else {
        echo "Invalid form data received";
    }
} else {
    echo "Invalid request method";
}
?>