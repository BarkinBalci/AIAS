<?php
// folder_view.php
$folder_path = $_GET['folder_path'];

// Prepend the htdocs directory path to make it an absolute path
$folder_path = 'C:\xampp\htdocs' . $folder_path;

$files = scandir($folder_path);
?>

<html>
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
    .container {
        margin-top: 20px;
        margin-left: 20px;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Klasördeki dosyalar:</h2>

    <ul>
    <?php foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                    // Convert local file system path to URL
                    $file_path = rtrim($folder_path, '/') . '/' . $file; // Remove trailing slash before concatenating
                    $file_path = str_replace('\\', '/', $file_path); // Replace backslashes with forward slashes
                    $relative_path = str_replace('C:/xampp/htdocs', '', $file_path); // Get the path relative to the root of the web server
                    $file_url = 'http://localhost' . $relative_path;
                    ?>
                    <li><a href="<?php echo $file_url; ?>"><?php echo $file; ?></a></li>
                    <?php
            }
    } ?>
    </ul>

    <?php
    // If a file path is provided, read and output the file
    if (isset($_GET['file_path'])) {
            $file_path = $_GET['file_path'];
            header('Content-Type: ' . mime_content_type($file_path));
            readfile($file_path);
    }
    ?>
</div>

</body>
</html>
