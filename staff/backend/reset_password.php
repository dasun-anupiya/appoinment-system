<?php
require_once "../../db_con.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get and sanitize input
        $email = trim($_POST["email"]);
        $new_password = trim($_POST["n_password"]);
        $confirm_password = trim($_POST["c_password"]);

        // Check if passwords match
        if ($new_password !== $confirm_password) {
            echo "<script>alert('Passwords do not match!'); window.location.href='reset_password.html';</script>";
            exit();
        }

        // Check if email exists
        $sql = "SELECT user_id FROM Users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in database
            $update_sql = "UPDATE Users SET password_hash = :password WHERE email = :email";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([":password" => $hashed_password, ":email" => $email]);

            echo "<script>alert('Password reset successful! You can now log in.'); window.location.href='../login.html';</script>";
            exit();
        } else {
            echo "<script>alert('Email not found! Please check your email.'); window.location.href='reset_password.html';</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='reset_password.html';</script>";
    }
}
?>
