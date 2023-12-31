<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    require_once "db_connection.php";

    // Retrieve user details based on user_id stored in the session
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);
    $user = null;
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        //echo "<div class='container d-flex justify-content-between'>" . "Welcome, " . $user['phone'] . "</div>";  // Display whatever user information you want
    }
} else {
    // If user is not logged in, you can redirect to the signin page or perform other actions
    header("Location: signin.php");
    exit();
}
?>
<?php
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

// Fetch data from the database
$sql = "SELECT *, DATE_FORMAT(reg_date, '%d.%m.%Y') AS formatted_date FROM tesvik"; // Extract date only from reg_date column
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">


    <title>Akademik Teşvik</title>

    <link rel="stylesheet" href="css/main.css">
    
    <style>
  .ms-auto {
    margin-left: auto !important;
  }
</style>
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
            <a class="nav-link" href="change_password.php">Şifre Değiştir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signout.php">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="mt-5 container ">

    <?php
if ($result->num_rows > 0) {
    // Output data in a table
    echo "<table id='example' class='table table-striped' style='width:100%'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ünvan</th>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Departman</th>
                    <th>Temel Alan</th>
                    <th>Bilimsel Alan</th>
                    <th>Akademik Faaliyet Türü</th>
                    <th>Faaliyet</th>
                    <th>Eser Adı</th>
                    <th>Doi Numarası</th>
                    <th>Kişi</th>
                    <th>Teşvik Puanı</th>
                    <th>Başvuru Tarihi</th>
                    <th>Klasör</th>
                    <th>Onay Durum</th>
                </tr>
            </thead>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["surname"] . "</td>
                <td>" . $row["department"] . "</td>
                <td>" . $row["basic_field"] . "</td>
                <td>" . $row["scientific_field"] . "</td>
                <td>" . $row["academic_activity_type"] . "</td>
                <td>" . $row["activity"] . "</td>
                <td>" . $row["work_name"] . "</td>
                <td>" . $row["doi_number"] . "</td>
                <td>" . $row["persons"] . "</td>
                <td>" . $row["incentive_point"] . "</td>
                <td>" . $row["formatted_date"] . "</td>
                <td>
                    <a href='folder_view.php?folder_path=" . $row["folder_path"] . "' target='_blank' class='btn btn-dark p-2'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-folder' viewBox='0 0 16 16'>
                            <path d='M2 1a1 1 0 0 0-1 1v1.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V2a1 1 0 0 0-1-1H2zm0 2h13v11H2V3zm2 1a1 1 0 0 1 1 1v1a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4zm1 1v1h6V5H5z'/>
                        </svg>
                    </a>
                </td>
                <td>";

        if (isset($row["onay_durum"])) {
            echo $row["onay_durum"];
        } else {
            echo "Beklemede";
        }

        echo "</td></tr>";
    }

    echo "</tbody><tfoot></tfoot></table>";
} else {
    echo "Başvuru kaydınız bulunmamaktadır!";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>


    </div>


    <!-- Modal for updating/deleting -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update/Delete Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Form fields to update data -->
                    <form id="updateForm">
                        <!-- Input fields to update values -->
                        <input type="hidden" id="rowId">
                        <label for="title">Title:</label>
                        <input type="text" id="title" class="form-control">

                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" required>

                        <label for="surname">Surname:</label>
                        <input type="text" id="surname" class="form-control" required>
                        
                        <input type="hidden" id="rowId">
                        <label for="title">Title:</label>
                        <input type="text" id="title" class="form-control">

                        
                        <!-- Add input fields for other columns -->


                        <label for="department">Department:</label>
                        <input type="text" id="department" class="form-control">

                        <label for="basic_field">Basic Field:</label>
                        <input type="text" id="basic_field" class="form-control">

                        <label for="scientific_field">Scientific Field:</label>
                        <input type="text" id="scientific_field" class="form-control">

                        <label for="academic_activity_type">Academic Activity Type:</label>
                        <input type="text" id="academic_activity_type" class="form-control">

                        <label for="activity">Activity:</label>
                        <input type="text" id="activity" class="form-control">

                        <label for="work_name">Work Name:</label>
                        <input type="text" id="work_name" class="form-control">

                        <label for="doi_number">Doi Number:</label>
                        <input type="text" id="doi_number" class="form-control">                        
                        
                        <label for="persons">Persons:</label>
                        <input type="text" id="persons" class="form-control">

                        <label for="department">Department:</label>
                        <input type="text" id="department" class="form-control">

                        <label for="basic_field">Basic Field:</label>
                        <input type="text" id="basic_field" class="form-control">

                        
    
                        <!-- Buttons to update or delete -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" id="updateBtn">Güncelle</button>
                        <button type="button" class="btn btn-danger" id="deleteBtn">Sil</button>
                        <button type="submit" class="btn btn-success" id="approveBtn">Onayla</button>
                        <button type="submit" class="btn btn-danger" id="rejectBtn">Reddet</button>
                    </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/panel.js"></script>
    <script>


        $('#example tbody').on('click', 'tr', function () {
            // Get the data from the clicked row
            var rowData = $('#example').DataTable().row(this).data();
            if (rowData) {
                // Populate modal with row data
                $('#rowId').val(rowData[0]);
                $('#title').val(rowData[1]);
                $('#name').val(rowData[2]);
                $('#surname').val(rowData[3]);
                $('#department').val(rowData[4]);
                $('#basic_field').val(rowData[5]);
                $('#scientific_field').val(rowData[6]);
                $('#academic_activity_type').val(rowData[7]);
                $('#activity').val(rowData[8]);
                $('#work_name').val(rowData[9]);
                $('#doi_number').val(rowData[10]);
                $('#persons').val(rowData[11]);
                
                // Show the modal
                $('#updateModal').modal({
                    "backdrop": "static",
                    "show": true
                });
            }
        });

        $('.btn-close').on('click', function () {
            // Get the data from the clicked row

            $('#updateModal').modal('hide');

        });


        // Function to handle delete button click
        $('#deleteBtn').on('click', function () {
            var rowId = $('#rowId').val(); // Get row ID from the hidden field
            // Send AJAX request to delete the row
            $.ajax({
                url: 'delete_row.php', // Replace with your PHP script to handle deletion
                method: 'POST',
                data: { id: rowId },
                success: function (response) {
                    // Refresh the page or update the table after deletion
                    // $('#example').html(response); // Update the table content
                    $('#updateModal').modal('hide');
                    setTimeout(function () {
                        location.reload(); // Reload the page for simplicity, you can update the table via AJAX too
                    }, 500);
                }, error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        });

       // Function to handle form submission for updating data
$('#updateBtn').on('click', function (event) {
    event.preventDefault(); // Prevent default form submission
    var rowId = $('#rowId').val();
    var rowName = $("#name").val();
    var rowSurname = $("#surname").val();
    var rowTitle = $("#title").val();
    var rowDepartment = $("#department").val();
    var rowBasicField = $("#basic_field").val();
    var rowScientificField = $("#scientific_field").val();
    var rowAcademicActivityType = $("#academic_activity_type").val();
    var rowActivity = $("#activity").val();
    var rowWorkName = $("#work_name").val();
    var rowDoiNumber = $("#doi_number").val();
    var rowPersons = $("#persons").val();

    $.ajax({
        url: 'update_row.php', // Replace with your PHP script to handle update
        method: 'POST',
        data: {
            id: rowId,
            name: rowName,
            surname: rowSurname,
            title: rowTitle,
            department: rowDepartment,
            basic_field: rowBasicField,
            scientific_field: rowScientificField,
            academic_activity_type: rowAcademicActivityType,
            activity: rowActivity,
            work_name: rowWorkName,
            doi_number: rowDoiNumber,
            persons: rowPersons
            // Add more fields as needed
        },
        success: function (response) {
            // Handle success (e.g., close modal, refresh table)
            $('#updateModal').modal('hide'); // Hide the modal after update
            setTimeout(function () {
                location.reload(); // Reload the page for simplicity; update the table via AJAX too if needed
            }, 1000);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});

$('#approveBtn').on('click', function () {
    var rowId = $('#rowId').val(); // Seçili satırın ID'sini alın
    $.ajax({
        url: 'approve_row.php',
        method: 'POST',
        data: { id: rowId },
        success: function (response) {
            console.log(response); // İşlem başarılıysa konsola göster
            // İşlem başarılı olduğunda gerekli işlemleri yapabilirsiniz, örneğin bir mesaj gösterebilirsiniz.
            updateContent(); // İçeriği güncellemek için bu fonksiyonu çağırın
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});

$('#rejectBtn').on('click', function () {
    var rowId = $('#rowId').val(); // Seçili satırın ID'sini alın
    $.ajax({
        url: 'reject_row.php',
        method: 'POST',
        data: { id: rowId },
        success: function (response) {
            console.log(response); // İşlem başarılıysa konsola göster
            // İşlem başarılı olduğunda gerekli işlemleri yapabilirsiniz, örneğin bir mesaj gösterebilirsiniz.
            updateContent(); // İçeriği güncellemek için bu fonksiyonu çağırın
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});
// İçeriği güncellemek için AJAX ile veri alın
function updateContent() {
    $.ajax({
        url: 'update_row.php', // Verileri güncelleyecek olan PHP dosyasının adı ve yolu
        method: 'GET', // GET veya POST isteği olarak ayarlayın, uygun şekilde düzenleyin
        success: function (data) {
            // Yeni verilerle içeriği güncelleyin
            $('#contentDiv').html(data); // Güncellenecek içeriğin bulunduğu elemanın ID'sini seçin
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

        

    </script>
</body>

</html>