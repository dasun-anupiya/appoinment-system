<?php
// Include the database connection
require_once "../../db_con.php"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $diagnosis = htmlspecialchars($_POST['diagnosis']);
    $prescription = htmlspecialchars($_POST['prescription']);
    $test_result = htmlspecialchars($_POST['test_result']);
    $doctor_id = $_POST['doctor_id']; // Assumed to be passed as a hidden input
    $patient_id = $_POST['patient_id']; // Assumed to be passed as a hidden input

    // Check if all fields are provided
    if (!empty($diagnosis) && !empty($prescription) && !empty($test_result) && !empty($doctor_id) && !empty($patient_id)) {
        try {
            // Prepare the SQL query to insert the data into the Medical_Records table
            $sql = "INSERT INTO Medical_Records (patient_id, doctor_id, diagnosis, prescription, test_results) 
                    VALUES (:patient_id, :doctor_id, :diagnosis, :prescription, :test_results)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters to the query
            $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
            $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
            $stmt->bindParam(':diagnosis', $diagnosis, PDO::PARAM_STR);
            $stmt->bindParam(':prescription', $prescription, PDO::PARAM_STR);
            $stmt->bindParam(':test_results', $test_result, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Record inserted successfully!'); window.location.href = 'my_records.php';</script>";
            } else {
                echo "<script>alert('Error inserting record!');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields!');</script>";
    }
}
?>
