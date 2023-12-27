<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="tr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Akademik Teşvik - Yetkili Giriş</title>
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
    <div class="d-none loader"
        style="background:#0000009c; border:none; margin:0px; padding:0px; width:100%; height:100%; top:0px; left:0px; position:fixed; z-index:1">
    </div>

    <div class="responseDiv">
        <?php
        require_once "db_connection.php";


        // Handle signin form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            // Retrieve user data based on the provided phone number
            $sql = "SELECT * FROM users WHERE phone = '$phone'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, create session/token for the user
                    session_start();
                    $userId = $user["id"];
                    $_SESSION['user_id'] = $userId;

                    // Redirect to authenticated user's page
                    header("Location: user_panel.php");
                    exit();
                } else {
                    // Invalid credentials, display error message
                    $errorMessage = "Invalid phone number or password.";
                }
            } else {
                // User not found, display error message
                $errorMessage = "User not found.";
            }
        }
        ?>

        <div class="col-md-6 m-auto max-w-500-px">
            <div class="card p-5 shadow">
                <form id="girisForm" action="signin.php" method="post">
                    <div class="text-center">
                        <img src="img/logo-kucuk.png" width="140">
                    </div>

                    <div class="text-center mt-4">
                        <h4 class="fw-semibold opacity-75">Akademik Teşvik Sistemi</h4>
                        <h6 class="fw-semibold opacity-75">Yetkili Giriş Paneli</h6>
                    </div>

                    <div class="input-group mt-4">
                        <span class="input-group-text">
                            <i class="bi bi-phone"></i>
                        </span>
                        <input type="text" class="form-control telefon" name="phone" placeholder="(5__) ___ __ __">
                    </div>

                    <div class="input-group mt-2">
                        <span class="input-group-text">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="*****">
                    </div>

                    <?php if (isset($errorMessage)): ?>
                        <div class="error-message">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>

                    <div class="row mt-3">
                        <div class="col-6 text-start d-flex align-items-center">
                            <a href="javascript:void(0);" id="sifreGonder"
                                class="btn btn-sm fw-semibold btn-link text-dark text-decoration-none px-0">Şifremi
                                Unuttum</a>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-info-2 fw-semibold" name="signin">GİRİŞ YAP</button>
                        </div>
                    </div>
                </form>
                <div>
                    <a href="signup.php"><button class="btn btn-primary">Kayıt Ol</button> </a>
                </div>
            </div>
            <div class="text-center text-black opacity-8 mt-3">Copyright © İstanbul Nişantaşı Üniversitesi 2023</div>
        </div>

        <script>
            $(".telefon").inputmask("(599) 999 99 99");

            $("#girisForm").submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("name", "gorevliGiris");

                $.ajax({
                    type: "POST",
                    url: "gorevli/giris-islem",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function (response) {
                        $(".loader").toggleClass("d-none");
                    },
                    success: function (response) {
                        if (response.yonlendirme) {
                            window.location.href = response.yonlendirme;
                        }

                        $(".responseDiv").empty();
                        if (response.mesaj) {
                            $(".responseDiv").append(response.mesaj);

                            $("#mesajModal").modal("show");
                        }

                        $(".loader").toggleClass("d-none");
                    }
                });
            });

            $("#sifreGonder").click(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "gorevli/giris-islem",
                    dataType: 'json',
                    data: {
                        "name": "sifreGonder",
                        telefon: $(".telefon").val()
                    },
                    beforeSend: function (response) {
                        $(".loader").toggleClass("d-none");
                    },
                    success: function (response) {
                        $(".responseDiv").empty();
                        if (response.mesaj) {
                            $(".responseDiv").append(response.mesaj);

                            $("#mesajModal").modal("show");
                        }

                        $(".loader").toggleClass("d-none");
                    }
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
            integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </div>
</body>

</html>