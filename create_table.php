<?php

function calculateCofficient($persons)
{
    // Database connection details
    $servername = "localhost"; // Change this if your database is on a different server
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "aias"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check if the katsayı table exists
    $tableCheckQuery = "SHOW TABLES LIKE 'katsayı'";
    $tableResult = $conn->query($tableCheckQuery);

    if ($tableResult->num_rows == 0) {
        // Table does not exist, create it
        $createTableQuery = "CREATE TABLE katsayı (
        id INT AUTO_INCREMENT PRIMARY KEY,
        value DECIMAL(10, 2)
    )";
        if ($conn->query($createTableQuery) === TRUE) {
            // Table created successfully, insert values
            $insertValuesQuery = "INSERT INTO katsayı (value) VALUES (1), (0.6), (0.4), (0.3)";
            if ($conn->query($insertValuesQuery) === TRUE) {
                echo "Values inserted into katsayı table successfully.";
            } else {
                echo "Error inserting values: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {
        echo "Table katsayı already exists.";
    }
    // Fetch coefficient values from the database
    $sql = "SELECT value FROM katsayı WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $coefficients = [1, 0.6, 0.4, 0.3]; // Default coefficients

    if ($stmt) {
        for ($i = 1; $i <= 4; $i++) {
            $stmt->bind_param("i", $i);
            $stmt->execute();
            $stmt->bind_result($value);
            $stmt->fetch();
            $coefficients[$i - 1] = $value;
        }
        $stmt->close();
    }


    switch ($persons) {
        case "1":
            return $coefficients[0];
        case "2":
            return $coefficients[1];
        case "3":
            return $coefficients[2];
        case "4":
            return $coefficients[3];
        default:
            return 1 / $persons;
    }
}

function calculateIncentivePoint($academic_activity_type, $activity, $coefficient)
{
    switch ($academic_activity_type) {
        case "Yayın":
            switch ($activity) {
                case "1.1.a":
                    return $coefficient * 125;
                case "1.1.b":
                    return $coefficient * 100;
                case "1.1.c":
                    return $coefficient * 85;
                case "1.1.d":
                    return $coefficient * 65;
                case "1.2.a":
                    return $coefficient * 65;
                case "1.2.b":
                    return $coefficient * 60;
                case "1.2.c":
                    return $coefficient * 55;
                case "1.2.d":
                    return $coefficient * 50;
                case "1.3.a":
                    return $coefficient * 50;
                case "1.4.a":
                    return $coefficient * 40;
                case "1.5.a":
                    return $coefficient * 30;
                case "1.6.a":
                    return $coefficient * 20;
                case "1.7.a":
                    return $coefficient * 40;
                case "1.8.a":
                    return $coefficient * 10;
                case "1.9.a":
                    return $coefficient * 20;
                case "1.10.a":
                    return $coefficient * 10;
                // Add more subcategories for "YAYIN" if needed
                default:
                    return 0;
            }

        case "Tasarım":
            switch ($activity) {
                case "2.1.a":
                    return $coefficient * 20;
                // Add more subcategories as needed for 2.TASARIM
                default:
                    return 0;
            }

        case "Sergi":
            switch ($activity) {
                case "3.1.a":
                    return $coefficient * 40;
                case "3.2.a":
                    return $coefficient * 20;
                case "3.3.a":
                    return $coefficient * 20;
                case "3.4.a":
                    return $coefficient * 15;
                // Add more subcategories as needed for 3.SERGİ
                default:
                    return 0;
            }

        case "Patent":
            switch ($activity) {
                case "4.1.a":
                    return $coefficient * 120;
                case "4.2.a":
                    return $coefficient * 100;
                case "4.3.a":
                    return $coefficient * 80;
                case "4.4.a":
                    return $coefficient * 60;
                // Add more subcategories as needed for 4.PATENT
                default:
                    return 0;
            }

        case "Atıf":
            switch ($activity) {
                case "5.1.a":
                    return $coefficient * 1;
                case "5.2.a":
                    return $coefficient * (3 / 4);
                case "5.3.a":
                    return $coefficient * (1 / 2);
                case "5.4.a":
                    return $coefficient * (1 / 4);
                case "5.5.a":
                    return $coefficient * 1;
                case "5.6.a":
                    return $coefficient * (3 / 4);
                case "5.7.a":
                    return $coefficient * (1 / 2);
                case "5.8.a":
                    return $coefficient * (1 / 4);
                // Add more subcategories for "ATIF" if needed
                default:
                    return 0;
            }

        default:
            return 0; // Return 0 if activity type doesn't match any case
    }
}

// Start the session
session_start();
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table exists
$table_name = "tesvik"; // Replace with your table name
$table_check_query = "SHOW TABLES LIKE '$table_name'";
$table_result = $conn->query($table_check_query);

if ($table_result->num_rows == 0) {
    // Table does not exist, create it
    $sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        title VARCHAR(50),
        faculty VARCHAR(50),
        department VARCHAR(50),
        basic_field VARCHAR(50),
        scientific_field VARCHAR(50),
        academic_activity_type VARCHAR(50),
        activity VARCHAR(100),
        work_name VARCHAR(100),
        persons INT(3),
        coefficient DECIMAL(10,2),
        incentive_point DECIMAL(10,2),
        user_id INT(11),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,file_name VARCHAR(100),
        file_path VARCHAR(255),
        file_size INT(11)
    )";

    // Execute the query to create table
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}


// Insert data from POST request into the table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // session_start();
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        // $userId = $_SESSION['user_id'];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $title = $_POST["title"];
        $faculty = $_POST["faculty"];
        $department = $_POST["department"];
        $basic_field = $_POST["basic_field"];
        $scientific_field = $_POST["scientific_field"];
        $academic_activity_type = $_POST["academic_activity_type"];
        $activity = $_POST["activity"];
        $work_name = $_POST["work_name"];
        $persons = $_POST["persons"];

        // Katsayısının hesaplanması
        $coefficient = calculateCofficient($persons);

        // Teşvik puanı hesaplama
        $incentive_point = calculateIncentivePoint($academic_activity_type, $activity, $coefficient);

        // SQL query to insert data into the table
        $insert_query = "INSERT INTO $table_name (name, surname, email, title, faculty, department, basic_field, scientific_field, academic_activity_type, activity, work_name, persons, coefficient, user_id, incentive_point ) VALUES ('$name', '$surname', '$email', '$title', '$faculty', '$department', '$basic_field', '$scientific_field', '$academic_activity_type', '$activity', '$work_name', '$persons', '$coefficient', '$userId', '$incentive_point')";

        if ($conn->query($insert_query) === TRUE) {
            // echo "Data inserted successfully";
            // File upload handling
            if (isset($_FILES['file_upload'])) {
                $file_name = $_FILES['file_upload']['name'];
                print '' . $file_name . '';
                $file_temp = $_FILES['file_upload']['tmp_name'];
                print '' . $file_temp . '';
                $file_size = $_FILES['file_upload']['size'];
                print 'size' . $file_size . '';

                if ($file_temp != "") {
                    $upload_dir = '/Applications/XAMPP/xamppfiles/temp/';
                    if (move_uploaded_file($file_temp, $upload_dir . $file_name)) {
                        $file_insert_query = "UPDATE $table_name SET file_name = '$file_name', file_path = '$upload_dir$file_name', file_size = '$file_size' WHERE id = LAST_INSERT_ID()";

                        if ($conn->query($file_insert_query) === TRUE) {
                            echo "File uploaded and metadata saved to the database successfully.";
                            header("Location: user_panel.php");
                        } else {
                            echo "Error inserting file data: " . $conn->error;
                        }
                    } else {
                        echo "Error uploading file." . print_r(error_get_last(), true);
                        ;
                    }
                }
            }

        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        echo "User ID not found in session.";
    }
}


// Close the connection
$conn->close();
?>