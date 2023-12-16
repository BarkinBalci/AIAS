<?php
// Connect to your database
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

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
}

// Fetch coefficient values from the database
$sql = "SELECT * FROM katsayı";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $coefficients = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No coefficients found.";
}

// Update coefficients when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST['coefficients'] as $id => $value) {
        $value = floatval($value);
        $updateSql = "UPDATE katsayı SET value = $value WHERE id = $id";
        $conn->query($updateSql);
    }
    // Redirect to settings page to reflect changes
    header("Location: panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Coefficient Settings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 30%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ac103d;
            color: #fff;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ac103d;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #780b2a;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

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
            <a class="nav-link" href="panel.php">Anasayfa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Başvuru Oluştur</a>
        </li>
</ul>
      <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ayarlar
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="coefficient_settings.php">Katsayı Ayarları</a>
          <a class="dropdown-item" href="activity_settings.php">Faaliyet Ayarları</a>
        </div>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="signout.php">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="mt-5 container">
        <h1>Katsayı Ayarları</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Katsayı Değeri</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coefficients as $coefficient): ?>
                        <tr>
                            <td><?php echo $coefficient['id']; ?></td>
                            <td>
                                <input type="number" step="0.01" name="coefficients[<?php echo $coefficient['id']; ?>]"
                                    value="<?php echo $coefficient['value']; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="modal-footer justify-content-center">
            <button type="submit">Kaydet</button>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>