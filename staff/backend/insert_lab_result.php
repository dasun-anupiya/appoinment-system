<?php
// Include the database connection
require_once "../../db_con.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form values
    $patient_id = $_POST['patient_id'];
    $test_id = $_POST['test_id'];
    $result_details = $_POST['result_details'];

    // Prepare the SQL query to insert the lab result
    $sql = "INSERT INTO Lab_Results (patient_id, test_id, result_details) VALUES (:patient_id, :test_id, :result_details)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the query
    $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
    $stmt->bindParam(':test_id', $test_id, PDO::PARAM_INT);
    $stmt->bindParam(':result_details', $result_details, PDO::PARAM_STR);

    // Execute the query and check if the insertion is successful
    if ($stmt->execute()) {
        // Success, redirect or show success message
        echo "<script>alert('Lab result inserted successfully.'); window.location.href='../lab/dashboard.php';</script>";
    } else {
        // Failure, show error message
        echo "<script>alert('Error inserting lab result.'); window.location.href='../lab/dashboard.php';</script>";
    }
}
?>
