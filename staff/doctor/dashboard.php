<?php
    session_start();
    require_once "../../db_con.php";
    
    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        echo "<script>alert('Please log in first!'); window.location.href='index.html';</script>";
        exit();
    }

    // Get user details from session
    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["full_name"];

    $sql = "SELECT hs.staff_id 
        FROM hospital_staff hs 
        INNER JOIN users u ON hs.user_id = u.user_id 
        WHERE u.user_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);

    $doc_id = $stmt->fetchColumn(); // Fetch the staff_id and store it in $doc_id

    if ($doc_id === false) {
        die("Error: Staff ID not found for this user.");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Newlife</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">

      <link rel="icon" href="../images/favicon.png">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="../../css/owl.carousel.min.css">
      <link rel="stylesheet" href="../../css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    </head>
    <body>
      <!-- header section start -->
      <div class="dashboard_header">
        <img src="../../images/logo.png">
        <ul>
            <li><a href="../../index.html" target="_blank">Home</a></li>
            <li><a href="../backend/logout.php">Logout</a></li>
        </ul>
      </div>
      <!-- header section end -->
      <!-- dashboard section start-->
       <div class="dashboard_section">
        <div class="dashboard_side_nav">
            <ul>
                <li><a href="dashboard.php" class="active">Appointments</a></li>
                <li><a href="patient_records.php">Patient Records</a></li>
                <li><a href="new_patient_record.php">New Patient Record</a></li>
                <li><a href="test_result.php">Patient Test Results</a></li>
                <li><a href="profile.php">My Profile</a></li>
            </ul>
        </div>
        <div class="dashboard_load_content">
            <?php
            $sql = "SELECT a.appointment_id, a.patient_id, a.appointment_date, a.appointment_time, u.full_name 
            FROM Appointments a 
            JOIN Hospital_Staff hs ON a.doctor_id = hs.staff_id 
            JOIN Patient pt ON a.patient_id = pt.patient_id 
            JOIN Users u ON pt.user_id = u.user_id 
            WHERE hs.staff_id = :doctor_id AND a.status = 'Confirmed'";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['doctor_id' => $doc_id]);

            echo "<table>";
            echo "<thead><tr><th>Patient Name</th><th>Appointment Date</th><th>Appointment Time</th><th>Action</th></tr></thead>";
            echo "<tbody>";

            while ($appointment = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($appointment['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($appointment['appointment_date']) . "</td>";
                echo "<td>" . htmlspecialchars($appointment['appointment_time']) . "</td>";
                echo "<td><a href='../backend/complete_appointment.php?appointment_id=" . urlencode($appointment['appointment_id']) . "'>
                        <button>Complete</button>
                    </a></td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
            ?>


        </div>
       </div>
       <!-- dashboard section end-->
       
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   </body>
   </html>