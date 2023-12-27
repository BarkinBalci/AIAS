<?php
require_once "db_connection.php";

$errorMessage = "";

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $phone = $_POST['telefon']; // Telefon numarasını doğrudan 'telefon' alanından alıyoruz
    $password = $_POST['sifre']; // Şifreyi doğrudan 'sifre' alanından alıyoruz

    // Perform validations and sanitize data

    // Hash the password (use a secure hashing algorithm like bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if a user with the same phone number exists
    $phoneCheckQuery = "SELECT * FROM users WHERE phone = '$phone'";
    $phoneCheckResult = $conn->query($phoneCheckQuery);

    if ($phoneCheckResult->num_rows > 0) {
        // User with the same phone number already exists, display an error or handle as needed
        $errorMessage = "User with this phone number already exists. Please sign in.";
    } else {
        // Proceed with signup
        // Insert user data into the database
        $sql = "INSERT INTO users (phone, password) VALUES ('$phone', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            // Signup success, redirect to index.php
            header("Location: signin.php");
            exit();
        } else {
            // Handle signup failure
            $errorMessage = "Signup failed. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="tr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Akademik Teşvik - Yetkili Kayıt</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/main.css?v=17">

    <style>
        /* Hide the up and down arrows for all browsers */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            appearance: none;
            margin: 0;
            /* Optional: You can add margin if needed */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="p-4 bg-light">
    <!-- Görsel arayüzünüzü buraya ekleyebilirsiniz -->
    <div class="d-none loader d-flex align-items-center justify-content-center position-fixed w-100 h-100"
        style="top:0; left:0; z-index:66">
        <div class="line-scale-pulse-out">
            <div class="bg-white"></div>
            <div class="bg-white"></div>
            <div class="bg-white"></div>
            <div class="bg-white"></div>
            <div class="bg-white"></div>
        </div>
    </div>
    <!-- ... -->
    <div class="col-md-6 m-auto max-w-500-px">
        <div class="card p-5 shadow">
            <form action="signup.php" method="post" id="kayitForm">
                <div class="text-center">
                    <img src="img/logo-kucuk.png" width="140">
                </div>

                <div class="text-center mt-4">
                    <h4 class="fw-semibold opacity-75">Akademik Teşvik Sistemi</h4>
                    <h6 class="fw-semibold opacity-75">Yetkili Kayıt Paneli</h6>
                </div>

                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-phone"></i>
                    </span>
                    <input type="text" class="form-control telefon" name="telefon" placeholder="(5__) ___ __ __">
                </div>

                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <input type="text" class="form-control" name="sifre" placeholder="*****">
                </div>

                <div class="row mt-3">
                    <div class="col-6 text-start d-flex align-items-center">

                    </div>
                    <div class="col-6 text-end">
                        <button type="submit" class="btn btn-info-2 fw-semibold" name="signup">Kaydet</button>
                    </div>
                </div>

                <?php if (!empty($errorMessage)): ?>
                    <div class="error-message mt-3">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
            </form>
            <div>
                <a href="signin.php"><button class="btn btn-primary">Kullanıcı Girişi</button> </a>
            </div>
        </div>

        <div class="text-center text-black opacity-8 mt-3">Copyright © İstanbul Nişantaşı Üniversitesi 2023</div>
    </div>

    <!-- JavaScript dosyalarını buraya ekleyebilirsiniz -->
</body>

</html>