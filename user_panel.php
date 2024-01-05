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
$sql = "SELECT *, DATE_FORMAT(reg_date, '%d.%m.%Y') AS formatted_date  FROM tesvik WHERE user_id = '$userId'";
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
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="img/logo-kucuk.png" width="180">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="user_panel.php">Anasayfa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Başvuru Yap</a>
        </li>
</ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="change_password.php">Şifre Değiştir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signout.php">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="mt-5 container">
        <?php
        if ($result->num_rows > 0) {
            // Output data in a table
            echo "<table id='example' class='table table-striped' style='width:100%'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Temel Alan</th>
                <th>Bilimsel Alan</th>
                <th>Akademik Faaliyet Türü</th>
                <th>Faaliyet</th>
                <th>Eser Adı</th>
                <th>Doi Numarası</th>
                <th>Kişi</th>
                <th>Teşvik Puanı</th>
                <th>Başvuru Tarihi</th>
        
            </tr>
        </thead>";
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["basic_field"] . "</td>
                <td>" . $row["scientific_field"] . "</td>
                <td>" . $row["academic_activity_type"] . "</td>
                <td>" . $row["activity"] . "</td>
                <td>" . $row["work_name"] . "</td>
                <td>" . $row["doi_number"] . "</td>
                <td>" . $row["persons"] . "</td>
                <td>" . $row["incentive_point"] . "</td>
                <td>" . $row["formatted_date"] . "</td>
               
              </tr>";
            }
            echo "<tfoot></tfoot>";
            echo "</table>";
        } else {
            echo "Başvuru kaydınız bulunmamaktadır!";
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
    <script src="js/panel.js"></script>
    <script