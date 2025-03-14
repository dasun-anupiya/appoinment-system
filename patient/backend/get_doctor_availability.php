<?php
require_once "../../db_con.php"; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["doctor_id"])) {
    $doctor_id = $_POST["doctor_id"];

    // Query to get available days, available times, and booked appointments
    $sql = "SELECT 
                a.available_day, 
                a.available_from, 
                a.available_to, 
                ap.appointment_time 
            FROM doctor_availability AS a 
            LEFT JOIN appointments AS ap 
            ON a.doctor_id = ap.doctor_id 
            AND a.available_day = DAYNAME(ap.appointment_date) 
            WHERE a.doctor_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$doctor_id]);
    $availability = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize days and times HTML
    $days_html = '';
    $times_html = '';

    // Days loop: Display available days as radio buttons
    $all_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    foreach ($all_days as $day) {
        $disabled = 'disabled'; // Default: Disabled
        foreach ($availability as $slot) {
            if ($slot['available_day'] == $day) {
                $disabled = ''; // Enable if doctor is available on this day
                break;
            }
        }
        // Add radio button for the day
        $days_html .= "<input type='radio' name='available_day' value='$day' $disabled id='$day'> 
                       <label for='$day'>$day</label><br>";
    }

    // Times loop: Divide available times into 15-minute slots & disable booked ones
    foreach ($availability as $slot) {
        $available_from = new DateTime($slot['available_from']);
        $available_to = new DateTime($slot['available_to']);
        $booked_times = [];

        // Store booked times in an array
        if (!empty($slot['appointment_time'])) {
            $booked_times[] = date('H:i', strtotime($slot['appointment_time']));
        }

        // Generate time slots
        while ($available_from <= $available_to) {
            $time = $available_from->format('H:i');
            $disabled = in_array($time, $booked_times) ? 'disabled' : ''; // Disable if booked

            // Add radio button for each time slot
            $times_html .= "<input type='radio' name='available_time' value='$time' $disabled id='$time'> 
                            <label for='$time'>$time</label><br>";
            
            $available_from->add(new DateInterval('PT15M')); // Add 15 minutes
        }
    }

    // Return the HTML for days and times as JSON
    echo json_encode(['days' => $days_html, 'times' => $times_html]);
}
?>
