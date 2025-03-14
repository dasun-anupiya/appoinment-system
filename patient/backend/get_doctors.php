<?php
require_once "../../db_con.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["branch_id"])) {
    $branch_id = $_POST["branch_id"];

    // Prepare the SQL query
    $sql = "SELECT s.staff_id, u.full_name
            FROM hospital_staff AS s
            JOIN users AS u ON s.user_id = u.user_id
            WHERE s.role = 'Doctor' AND s.branch_id = :branch_id";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Execute the statement with the actual branch_id value
    $stmt->execute([':branch_id' => $branch_id]);

    // Check if any doctors are found and generate the dropdown options
    echo '<option value="">Select a doctor</option>'; // Default option
    while ($doctor = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($doctor['staff_id']) . "'>" . htmlspecialchars($doctor['full_name']) . "</option>";
    }
}
?>
