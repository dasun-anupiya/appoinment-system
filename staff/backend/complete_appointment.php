<?php
session_start(); // Start the session to store data in $_SESSION
require_once "../../db_con.php"; // Include database connection

// Check if the appointment_id is passed
if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Query to get the patient_id for the selected appointment
    $sql = "SELECT patient_id FROM Appointments WHERE appointment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$appointment_id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the appointment exists
    if ($appointment) {
        // Store the patient_id in the session
        $_SESSION['patient_id'] = $appointment['patient_id'];

        // Update the status of the appointment to 'Completed'
        $update_sql = "UPDATE Appointments SET status = 'Completed' WHERE appointment_id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$appointment_id]);

        // Redirect to a page (e.g., patient profile or any other page)
        echo "<script>alert('Appointment marked as completed.'); window.location.href = '../doctor/new_patient_record.php';</script>";
    } else {
        // If the appointment does not exist
        echo "<script>alert('Appointment not found.'); window.location.href = '../doctor/dashboard.php';</script>";
    }
}
?>
