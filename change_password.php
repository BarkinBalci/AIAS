<?php
    session_start();
    require 'db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $userId = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE id = '$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($currentPassword, $user['password'])) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = '$newPasswordHash' WHERE id = '$userId'";
                if ($conn->query($sql) === TRUE) {
                    $successMessage = "Password changed successfully.";
                } else {
                    $errorMessage = "Error changing password.";
                }
            } else {
                $errorMessage = "Invalid current password.";
            }
        } else {
            $errorMessage = "User not found.";
        }
    }
?>

<!DOCTYPE html>
<html>
<body>

<h2>Change Password</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Current Password: <input type="password" name="current_password" required><br>
  New Password: <input type="password" name="new_password" required><br>
  <input type="submit" name="change_password" value="Change Password">
</form>

</body>
</html>