<?php
require_once "../../db_con.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appointment_id"])) {
    $appointment_id = $_POST["appointment_id"];

    // Update the appointment status to 'Cancelled'
    $sql = "UPDATE appointments SET status = 'Cancelled' WHERE appointment_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$appointment_id])) {
        echo "<script>
                alert('Appointment canceled successfully!');
                window.location.href = '../my_appointments.php';
              </script>";
    } else {
        echo "<script>
                alert('Error canceling appointment.');
                window.location.href = 'my_appointments.php';
              </script>";
    }
}
?>
