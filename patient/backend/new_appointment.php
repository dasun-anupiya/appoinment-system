<?php
require_once "../../db_con.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $doctor_id = $_POST['doctor'] ?? null;
    $appointment_date = $_POST['available_day'] ?? null;
    $appointment_time = $_POST['available_time'] ?? null;

    // Validate input
    if (!$user_id || !$doctor_id || !$appointment_date || !$appointment_time) {
        echo "<script>
                alert('All fields are required!');
                window.location.href = '../appointment_form.php'; // Redirect back to form
              </script>";
        exit();
    }

    try {
        // Convert day name to date (next available occurrence)
        $target_date = new DateTime("next $appointment_date");

        // Insert appointment
        $sql = "INSERT INTO Appointments (patient_id, doctor_id, appointment_date, appointment_time, status) 
                VALUES (?, ?, ?, ?, 'Pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $doctor_id, $target_date->format('Y-m-d'), $appointment_time]);

        echo "<script>
                alert('Appointment booked successfully!');
                window.location.href = '../my_appointments.php'; // Redirect to appointment list
              </script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>
                alert('Database error: " . addslashes($e->getMessage()) . "');
                window.location.href = '../appointment_form.php'; // Redirect back to form
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Invalid request!');
            window.location.href = '../appointment_form.php'; // Redirect back to form
          </script>";
    exit();
}
?>
