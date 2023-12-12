<?php
// Assuming $conn is the database connection
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


$tableName = "activities";

// Check if the table exists
$checkTableQuery = "SHOW TABLES LIKE '$tableName'";
$tableExists = $conn->query($checkTableQuery);

if ($tableExists->num_rows === 0) {
    // Table does not exist, create it
    $createTableQuery = "CREATE TABLE $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        academic_activity_type VARCHAR(100) NOT NULL, 
        activity_id VARCHAR(50) NOT NULL,
        description TEXT NOT NULL,
        point DECIMAL(10,2)
    )";

    if ($conn->query($createTableQuery) === TRUE) {
        echo "Table '$tableName' created successfully";
        $activities = [

            'Yayın' => [
                ['1.1.a', 'WoS Quartile Q1', 125],
                ['1.1.b', 'WoS Quartile Q2', 100],
                ['1.1.c', 'WoS Quartile Q3', 85],
                ['1.1.d', 'WoS Quartile Q4', 65],
                ['1.2.a', 'SCOPUS Quartile Q1', 65],
                ['1.2.b', 'SCOPUS Quartile Q2', 60],
                ['1.2.c', 'SCOPUS Quartile Q3', 55],
                ['1.2.d', 'SCOPUS Quartile Q4', 50],
                [
                    '1.3.a',
                    'WoS tarafından taranan ESCI, ESSCI vb. gibi dergilerde yayımlanmış araştırma makalesi',
                    50
                ],
                [
                    '1.4.a',
                    'WoS ve SCOPUS tarafından taranan konferans (sempozyum) kitaplarında yayımlanmış araştırma makalesi',
                    40
                ],
                [
                    '1.5.a',
                    'Diğer uluslararası hakemli dergilerde yayımlanmış araştırma makalesi',
                    30
                ],
                [
                    '1.6.a',
                    'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergilerde yayımlanmış araştırma makalesi',
                    20
                ],
                [
                    '1.7.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitap',

                    40
                ],
                [
                    '1.8.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm yazarlığı',
                    10
                ],
                [
                    '1.9.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitap',
                    20
                ],
                [
                    '1.10.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm',
                    10
                ],
            ],
            'Tasarım' => [
                [
                    '2.1.a',
                    'Endüstriyel, çevresel veya grafiksel tasarım; sahne, moda veya çalgı tasarımı',
                    20
                ],
            ],
            'Sergi' => [
                ['3.1.a', 'Özgün yurtdışı bireysel etkinlik', 40],
                ['3.2.a', 'Özgün yurtiçi bireysel etkinlik', 20],
                ['3.3.a', 'Özgün yurtdışı grup/karma/toplu etkinlik', 20],
                ['3.4.a', 'Özgün yurtiçi grup/karma/toplu etkinlik', 15],
            ],
            'Patent' => [
                ['4.1.a', 'Uluslararası patent', 120],
                ['4.2.a', 'Ulusal patent', 100],
                ['4.3.a', 'Uluslararası Faydalı Model', 80],
                ['4.4.a', 'Ulusal Faydalı Model', 60],
            ],
            'Atıf' => [
                [
                    '5.1.a',
                    'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayımlanmış makalelerde atıf',
                    1
                ],
                [
                    '5.2.a',
                    'Alan endeksleri (varsa) kapsamındaki dergilerde yayımlanmış makalelerde atıf',
                    0.75
                ],
                [
                    '5.3.a',
                    'Diğer uluslararası hakemli dergilerde yayımlanmış makalelerde atı',
                    0.5
                ],
                [
                    '5.4.a',
                    'ULAKBİM tarafından taranan ulusal hakemli dergilerde yayımlanmış makalelerde atıf',
                    0.25
                ],
                [
                    '5.5.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf',
                    1
                ],
                [
                    '5.6.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf',
                    0.75
                ],
                [
                    '5.7.a',
                    'Güzel sanatlardaki eserlerin uluslararası kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi',
                    0.5
                ],
                [
                    '5.8.a',
                    'Güzel sanatlardaki eserlerin ulusal kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi',
                    0.25
                ],
            ],

        ];

        foreach ($activities as $academic_activity_type => $activityList) {
            foreach ($activityList as $activity) {
                $activityId = $activity[0];
                $description = $activity[1];
                $point = $activity[2];
                $insertQuery = "INSERT INTO activities (academic_activity_type, activity_id, description, point) VALUES ('$academic_activity_type','$activityId', '$description', '$point')";
                $conn->query($insertQuery);
            }
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    //echo "Table '$tableName' already exists";
}




// Handle form submission for updating or adding activities
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_activity"])) {
        // Process the submitted form for updating activities

        foreach ($_POST["activity_id"] as $id => $activity_id) {
            $id = intval($id);
            $description = $_POST["description"][$id];
            $academic_activity_type = $_POST["academic_activity_type"][$id];
            $point = $_POST["point"][$id];
            // Update the activity in the database
            $updateQuery = "UPDATE activities SET activity_id = '$activity_id', description = '$description', academic_activity_type = '$academic_activity_type', point = '$point' WHERE id = $id";
            $conn->query($updateQuery);
        }

        // Redirect to the settings page or perform other actions
        header("Location: settings.php");
        exit();
    } elseif (isset($_POST["add_activity"])) {
        // Process the submitted form for adding a new activity

        $newActivityId = $_POST["new_activity_id"];
        $newDescription = $_POST["new_description"];
        $newPoint = $_POST["new_point"];
        $newAcademicActivityType = $_POST["new_academic_activity_type"];
        // Insert the new activity into the database
        $insertQuery = "INSERT INTO activities (academic_activity_type, activity_id, description, point) VALUES ('$newAcademicActivityType','$newActivityId', '$newDescription', '$newPoint')";
        $conn->query($insertQuery);

        // Redirect to the settings page or perform other actions
        header("Location: settings.php");
        exit();
    }
}

// Fetch activities from the database
$selectQuery = "SELECT * FROM activities";
$result = $conn->query($selectQuery);

$activities = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
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


        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ac103d;
            color: #fff;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
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

        form {
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
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
<div class="container mt-5">
    <h2>Akademik Faaliyetler</h2>
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th>Akademik Faaliyet Türü</th>
                    <th>Faaliyet Id</th>
                    <th>Faaliyet</th>
                    <th>Değer</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        <td>
                            <input type="text" name="academic_activity_type[<?php echo $activity['id']; ?>]"
                                value="<?php echo $activity['academic_activity_type']; ?>" required>
                        </td>
                        <td>
                            <input type="text" name="activity_id[<?php echo $activity['id']; ?>]"
                                value="<?php echo $activity['activity_id']; ?>" required>

                        </td>
                        <td>
                            <textarea name="description[<?php echo $activity['id']; ?>]"
                                required><?php echo $activity['description']; ?></textarea>
                        </td>
                        <td>
                            <textarea name="point[<?php echo $activity['id']; ?>]"
                                required><?php echo $activity['point']; ?></textarea>
                        </td>
                        <td>
                            <button type="submit" name="update_activity[<?php echo $activity['id']; ?>]">
                                Güncelle
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </form>
    </div>
    <div class="container mt-5">
    <form action="" method="post">
        <h2>Yeni Faaliyet Ekle</h2>
        <div>
            <label for="new_academic_activity_type">Yeni Akademik Faaliyet Türü:</label>
            <input type="text" name="new_academic_activity_type" required>
            <label for="new_activity_id">Yeni Faaliyet Id:</label>
            <input type="text" name="new_activity_id" required>

            <label for="new_description">Yeni Faaliyet Adı:</label>
            <textarea name="new_description" required></textarea>
            <label for="new_point">Yeni Faaliyet Değeri:</label>
            <input type="text" name="new_point" required>
        </div>
        <div class="container mt-5 modal-footer justify-content-center">
        <button type="submit" name="add_activity">Faaliyet Ekle</button>
        </div>
    </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>