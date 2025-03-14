<?php
require_once "../../db_con.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data and sanitize input
        $full_name = trim($_POST["full_name"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $password = trim($_POST["n_password"]);
        $confirm_password = trim($_POST["c_password"]);
        $gender = trim($_POST["gender"]);
        $dob = trim($_POST["date"]);
        $blood_type = trim($_POST["b_type"]);
        $address = trim($_POST["address"]);
        $emergency_phone = trim($_POST["eme_con"]);

        // Validate password match
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match!'); window.location.href='signup_form.html';</script>";
            exit();
        }

        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into Users table
        $sql_users = "INSERT INTO Users (full_name, email, password_hash, phone_number, user_type) 
                      VALUES (:full_name, :email, :password_hash, :phone_number, 'Patient')";
        $stmt = $pdo->prepare($sql_users);
        $stmt->execute([
            ":full_name" => $full_name,
            ":email" => $email,
            ":password_hash" => $hashed_password,
            ":phone_number" => $phone
        ]);

        // Get last inserted user ID
        $user_id = $pdo->lastInsertId();

        // Insert into Patient table
        $sql_patient = "INSERT INTO Patient (user_id, date_of_birth, gender, blood_type, address, emergency_phone) 
                        VALUES (:user_id, :dob, :gender, :blood_type, :address, :emergency_phone)";
        $stmt = $pdo->prepare($sql_patient);
        $stmt->execute([
            ":user_id" => $user_id,
            ":dob" => $dob,
            ":gender" => ucfirst($gender), // Capitalize first letter
            ":blood_type" => strtoupper($blood_type), // Convert to uppercase
            ":address" => $address,
            ":emergency_phone" => $emergency_phone
        ]);

        // Success message with redirect
        echo "<script>alert('Registration successful!'); window.location.href='../index.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='signup_form.html';</script>";
    }
}
?>
