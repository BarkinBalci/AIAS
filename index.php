<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    require_once "db_connection.php";

    // Retrieve user details based on user_id stored in the session
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Display current user information
        echo "Welcome, " . $user['phone'] . "<a href='signout.php'>Sign Out</a>"; // Display whatever user information you want
    }
} else {
    // If user is not logged in, you can redirect to the signin page or perform other actions
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="tr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Akademik Teşvik</title>
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

<body class="bg-light p-4" data-new-gr-c-s-check-loaded="14.1137.0" data-gr-ext-installed="">

    <div class="responseDiv"></div>
    <div><a href="settings.php"><button class="btn btn-primary">Ayarlar</button></a></div>
    <form id="applicationForm" action="create_table.php" method="POST" class="mb-4">
        <div class="row g-0">
            <div class="col-lg-5 m-auto">
                <div class="card shadow p-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="img/logo-kucuk.png" width="140">
                            <p class="h5 opacity-75 mt-4">Akademik Teşvik Başvuru Sistemi</p>
                            <p class="h6 opacity-50">Akademik Teşvik Başvuru Formu</p>
                        </div>

                        <div class="col-12">
                            <div class="row academicInfo">
                                <div class="col-6 mt-4">
                                    <label class="fw-semibold">Ad</label>
                                    <input class="form-control" type="text" placeholder="Adınızı girin" name="name">
                                </div>

                                <div class="col-6 mt-4">
                                    <label class="fw-semibold">Soyad</label>
                                    <input class="form-control" type="text" placeholder="Soyadınızı girin"
                                        name="surname">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">E-posta</label>
                            <input class="form-control" type="email" placeholder="E-posta adresinizi girin"
                                name="email">
                        </div>

                        <div class="col-12 mt-4">
                            <label class="fw-semibold">Akademik Kadro Ünvanı</label>

                            <select class="form-control" name="title">
                                <option value="">Seçiniz...</option>
                                <option value="Prof. Dr.">Prof. Dr.</option>
                                <option value="Doç. Dr.">Doç. Dr.</option>
                                <option value="Dr. Öğr. Üyesi.">Dr. Öğr. Üyesi.</option>
                                <option value="Öğr. Gör.">Öğr. Gör.</option>
                                <option value="Arş. Gör.">Arş. Gör.</option>
                                <option value="Uzman. Gör.">Uzman. Gör.</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Fakülte</label>

                            <select class="form-control" name="faculty">
                                <option value="">Seçiniz...</option>
                                <option value="Engineering">Mühendislik ve Mimarlık Fakültesi</option>
                                <option value="Economy">İktisadi, İdari ve Sosyal Bilimler Fakültesi</option>
                                <option value="Art">Sanat ve Tasarım Fakültesi</option>
                                <option value="Medicine">Tıp Fakültesi</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Bölüm</label>
                            <input class="form-control" type="text" placeholder="Bölümünüzü girin" name="department">
                        </div>

                        <div class="col-12 mt-3 ">
                            <label class="fw-semibold">Temel Alan</label>
                            <input class="form-control" type="text" placeholder="Temel Alanınızı girin"
                                name="basic_field">
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Bilimsel Alan</label>
                            <input class="form-control" type="text" placeholder="Bilimsel Alanınızı girin"
                                name="scientific_field">
                            <small class="form-text text-muted">*En Yakın Bilim Alanını Yazınız. ÜAK Doçentlik temel
                                alanları dikkate alınacaktır.
                            </small>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Akademik Faaliyet Türü</label>
                            <select class="form-control" name="academic_activity_type"
                                onchange="updateActivityTypeOptions()">
                                <option value="">Seçiniz...</option>
                                <option value="Yayın">Yayın</option>
                                <option value="Tasarım">Tasarım</option>
                                <option value="Sergi">Sergi</option>
                                <option value="Patent">Patent</option>
                                <option value="Atıf">Atıf</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Faaliyet</label>
                            <select class="form-control" name="activity" id="activityTypeSelect">
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Eser Adı</label>
                            <input class="form-control" type="text" name="work_name">
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="fw-semibold">Kişi sayısı</label>
                            <select class="form-control" name="persons">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-12 my-4 text-center">
                            <input type="submit" class="btn btn-success-2 px-5 fw-semibold ms-3" name="submit_btn">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center text-black opacity-8 mt-3">Copyright © İstanbul Nişantaşı Üniversitesi 2023</div>
        </div>
    </form>
    <?php

    ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Teşekkür ederiz! Başvurunuz başarıyla alınmıştır!
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="modelWarningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center text-white bg-warning">
                    <h5 class="fw-semibold mb-0">Eksik bilgi!</h5>
                </div>

                <div class="modal-body pt-1">
                    <p class="mb-1 mt-3">Lütfen bütün bilgileri doldurunuz.</p>
                </div>

                <div class="modal-footer justify-content-center bg-light">
                    <button type="button" class="btn btn-sm bg-secondary text-white fw-semibold px-3"
                        data-bs-dismiss="modal">KAPAT</button>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <iframe height="1" width="1"
        style="position: absolute; top: 0px; left: 0px; border: none; visibility: hidden;"></iframe>
</body>

</html>
<script src="js/index.js"></script>