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
        // Include the database connection
        require_once "../../db_con.php";

        // Assume $patient_id is passed via session or from the URL
        $patient_id = $_SESSION['user_id']; // Replace this with the correct value for patient_id

        // Query to get lab test results for the patient
        $sql = "
            SELECT lr.result_id, lr.result_details, lr.test_date, lt.test_name, lt.description, lt.price
            FROM Lab_Results lr
            INNER JOIN Laboratory_Tests lt ON lr.test_id = lt.test_id
            WHERE lr.patient_id = :patient_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all the results
        $lab_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

            <h4>Laboratory Test Results</h4>

            <table>
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Test Date</th>
                        <th>Result Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lab_results)): ?>
                        <?php foreach ($lab_results as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['test_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['description']); ?></td>
                                <td><?php echo number_format($result['price'], 2); ?> LKR</td>
                                <td><?php echo htmlspecialchars($result['test_date']); ?></td>
                                <td><?php echo htmlspecialchars($result['result_details']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No results found for the patient.</td>
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