<?php
session_start(); // Start session
require_once "../../db_con.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get and sanitize input
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Check if email exists
        $sql = "SELECT user_id, full_name, password_hash, user_type FROM Users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user["password_hash"])) {
                // Set session variables
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["full_name"] = $user["full_name"];
                switch ($user["user_type"]){
                    case "Admin": echo "<script>alert('Admin Login successful! Redirecting...'); window.location.href='../admin/dashboard.php';</script>";
                    break;
                    case "Doctor": echo "<script>alert('Login successful! Redirecting...'); window.location.href='../doctor/dashboard.php';</script>";
                    break;
                    case "Lab": echo "<script>alert('Login successful! Redirecting...'); window.location.href='../lab/dashboard.php';</script>";
                    break;
                }
                exit();
            } else {
                // Wrong password
                echo "<script>alert('Invalid password! Please try again.'); window.location.href='../index.html';</script>";
                exit();
            }
        } else {
            // Email not found
            echo "<script>alert('Email not registered! Please sign up.'); window.location.href='signup.html';</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='login.html';</script>";
    }
}
?>
