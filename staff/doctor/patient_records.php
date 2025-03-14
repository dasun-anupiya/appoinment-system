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
            if (isset($_SESSION['patient_id'])) {
                $patient_id = $_SESSION['patient_id'];

                // SQL query to get medical records for the specific patient, with doctor and patient names
                $sql = "SELECT mr.record_id, u.full_name AS patient_name, mr.diagnosis, mr.prescription, mr.test_results, mr.created_at
                        FROM Medical_Records AS mr
                        JOIN Patient AS p ON mr.patient_id = p.patient_id
                        JOIN Users AS u ON p.user_id = u.user_id
                        WHERE mr.patient_id = ?";

                // Prepare and execute the query
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$patient_id]);

                // Fetch all records
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>
            <h4>Medical Records of patient</h4>
            <table>
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Test Results</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($records): ?>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <td><?= htmlspecialchars($record['record_id']) ?></td>
                                <td><?= htmlspecialchars($record['patient_name']) ?></td>
                                <td><?= htmlspecialchars($record['diagnosis']) ?></td>
                                <td><?= htmlspecialchars($record['prescription']) ?></td>
                                <td><?= htmlspecialchars($record['test_results']) ?></td>
                                <td><?= htmlspecialchars($record['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No medical records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>


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