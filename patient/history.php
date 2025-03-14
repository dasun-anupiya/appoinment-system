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

      <link rel="icon" href="images/favicon.png">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="../css/owl.carousel.min.css">
      <link rel="stylesheet" href="../css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    </head>
    <body>
      <!-- header section start -->
      <div class="dashboard_header">
        <img src="../images/logo.png">
        <ul>
            <li><a href="../index.html" target="_blank">Home</a></li>
            <li><a href="backend/logout.php">Logout</a></li>
        </ul>
      </div>
      <!-- header section end -->
      <!-- dashboard section start-->
       <div class="dashboard_section">
        <div class="dashboard_side_nav">
            <ul>
                <li><a href="dashboard.php" class="active">Appointments</a></li>
                <li><a href="my_appointments.php">My Appointments</a></li>
                <li><a href="reports.php">Lab Reports</a></li>
                <li><a href="history.php">My Medical history</a></li>
                <li><a href="profile.php">My Profile</a></li>
            </ul>
        </div>
        <div class="dashboard_load_content">
        <?php
        session_start();  // Start the session to access session variables

        require_once "../db_con.php";  // Include your database connection file

        $user_id = $_SESSION['user_id']; 

        // SQL query to fetch medical records for the logged-in user
        $sql = "SELECT 
                    users.full_name AS doctor_name, 
                    medical_records.diagnosis, 
                    medical_records.prescription, 
                    medical_records.test_results, 
                    medical_records.created_at 
                FROM 
                    medical_records
                INNER JOIN users ON medical_records.doctor_id = users.user_id
                WHERE 
                    medical_records.patient_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $medical_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- HTML Table to Display the Medical Records -->
        <table class="medical_records">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Diagnosis</th>
                    <th>Prescription</th>
                    <th>Test Results</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medical_records as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                        <td><?php echo htmlspecialchars($record['prescription']); ?></td>
                        <td><?php echo htmlspecialchars($record['test_results']); ?></td>
                        <td><?php echo htmlspecialchars($record['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
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