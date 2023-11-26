<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

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

// Retrieve user ID from session
$userId = $_SESSION['user_id'];

// Query forms associated with the user ID
$sql = "SELECT * FROM tesvik WHERE user_id = '$userId'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <title>Akademik Teşvik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav class="navbar navbar-default container d-flex">
        <div>
            <div class="navbar-header">
                <img src="img/logo-kucuk.png" width="140">
            </div>
        </div>
        <div class="text-end">
            <a href="index.php" class="btn btn-warning">Yeni Başvuru</a>
            <a href='signout.php' class='btn btn-danger'>Çıkış Yap</a>
        </div>
    </nav>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            // Output data in a table
            echo "<table id='example' class='table table-striped' style='width:100%'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Akademik Faaliyet Türü</th>
                    <th>Faaliyet</th>
                    <th>Kişi</th>
                    <th>Teşvik Puanı</th>
                </tr>
            </thead>";
            
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["surname"] . "</td>
                    <td>" . $row["academic_activity_type"] . "</td>
                    <td>" . $row["activity"] . "</td>
                    <td>" . $row["persons"] . "</td>
                    <td>" . $row["incentive_point"] . "</td>
                </tr>";
            }
            
            echo "<tfoot></tfoot>";
            echo "</table>";
        } else {
            echo "No data available";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <!-- Modal for updating/deleting -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <!-- ... Modal içeriği ... -->
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script
