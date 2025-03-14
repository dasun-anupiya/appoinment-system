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
            <h4>Insert Lab Test Result</h4>

            <!-- Form to insert lab result -->
            <form action="../backend/insert_lab_result.php" method="POST">
                <label for="patient_id">Patient ID:</label><br>
                <input type="text" name="patient_id" id="patient_id" required><br><br>

                <label for="test_id">Select Test:</label><br>
                <select name="test_id" id="test_id" required>
                    <option value="">Select Test</option>
                    <?php
                    // Fetch all tests from the database
                    require_once "../../db_con.php"; // Include DB connection

                    $stmt = $pdo->query("SELECT test_id, test_name FROM Laboratory_Tests");
                    while ($test = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $test['test_id'] . "'>" . htmlspecialchars($test['test_name']) . "</option>";
                    }
                    ?>
                </select><br><br>

                <label for="result_details">Result Details:</label><br>
                <textarea name="result_details" id="result_details" required></textarea><br><br>

                <button type="submit">Submit</button>
            </form>
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