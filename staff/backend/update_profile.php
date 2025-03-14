<?php
session_start();

require_once "../../db_con.php";  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    // Get current values from the database
    $sql = "SELECT 
                u.full_name, 
                u.email, 
                p.date_of_birth, 
                p.gender, 
                p.blood_type, 
                p.address, 
                p.emergency_phone 
            FROM 
                Hospital_Staff p
            INNER JOIN Users u ON p.user_id = u.user_id
            WHERE p.staff_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get form data
    $name = $_POST['name'] ?? $patient['full_name'];
    $email = $_POST['email'] ?? $patient['email'];
    $dob = $_POST['dob'] ?? $patient['date_of_birth'];
    $gender = $_POST['gender'] ?? $patient['gender'];
    $blood_type = $_POST['blood_type'] ?? $patient['blood_type'];
    $address = $_POST['address'] ?? $patient['address'];
    $emergency_phone = $_POST['emergency_phone'] ?? $patient['emergency_phone'];
    
    // Initialize array to store update statements
    $update_fields = [];
    $params = [];
    
    // Check each field and only add it to the update query if it has changed
    if ($name != $patient['full_name']) {
        $update_fields[] = "u.full_name = ?";
        $params[] = $name;
    }
    if ($email != $patient['email']) {
        $update_fields[] = "u.email = ?";
        $params[] = $email;
    }
    if ($dob != $patient['date_of_birth']) {
        $update_fields[] = "p.date_of_birth = ?";
        $params[] = $dob;
    }
    if ($gender != $patient['gender']) {
        $update_fields[] = "p.gender = ?";
        $params[] = $gender;
    }
    if ($blood_type != $patient['blood_type']) {
        $update_fields[] = "p.blood_type = ?";
        $params[] = $blood_type;
    }
    if ($address != $patient['address']) {
        $update_fields[] = "p.address = ?";
        $params[] = $address;
    }
    

    // If any field has been changed, update the database
    if (count($update_fields) > 0) {
        // Combine the update fields into a single string for the SQL query
        $sql_update = "UPDATE Users u
                    INNER JOIN Hospital_Staff p ON u.user_id = p.user_id
                    SET " . implode(", ", $update_fields) . "
                    WHERE p.staff_id = ?";
        
        // Add the patient ID to the parameters
        $params[] = $user_id;
        
        // Prepare and execute the update query
        $stmt = $pdo->prepare($sql_update);
        $stmt->execute($params);
        
        // Send success message to the frontend
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
        exit();
    } else {
        // If no changes were made, return a message
        echo json_encode(['status' => 'info', 'message' => 'No changes made.']);
        exit();
    }
}
