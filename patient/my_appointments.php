<?php
    session_start();
    require_once "../db_con.php";
    
    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        echo "<script>alert('Please log in first!'); window.location.href='index.html';</script>";
        exit();
    }

    // Get user details from session
    $user_id = $_SESSION["user_id"];
    $full_name = $_SESSION["full_name"];
    $user_type = $_SESSION["user_type"];
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
            <div class="previous_appointments">
                <div class="pending_appointments">
                    <h4>Pending Appointments</h4>
                    <?php
                    $sql = "SELECT users.full_name, 
                                appointments.appointment_id, 
                                appointments.appointment_date, 
                                appointments.appointment_time 
                            FROM appointments 
                            JOIN users ON appointments.patient_id = users.user_id 
                            WHERE appointments.status = 'Pending' 
                            AND appointments.patient_id = ?";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$user_id]);
                    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <table>
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($appointment['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                    <td>
                                        <form action="backend/cancel_appointment.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                            <button type="submit">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="approved_appointments">
                    <br><br><h4>Approved Appointments</h4>
                <?php
                $sql = "SELECT 
                            users.full_name, 
                            appointments.appointment_id, 
                            appointments.appointment_date, 
                            appointments.appointment_time 
                        FROM 
                            appointments 
                        INNER JOIN users ON appointments.patient_id = users.user_id 
                        WHERE 
                            appointments.status = 'approved' 
                            AND appointments.patient_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id]);
                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- HTML Table to Display the Appointments -->
                <table class="approved_appointments">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                </div>
            </div>
        </div>
       </div>
       <!-- dashboard section end-->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function () {
            $("#branch").change(function () {
                var branchId = $(this).val(); // Get selected branch ID

                if (branchId) {
                    $.ajax({
                        url: "backend/get_doctors.php",
                        type: "POST",
                        data: { branch_id: branchId },
                        success: function (response) {
                            $("#doctor").html(response); // Load doctors into dropdown
                        }
                    });
                } else {
                    $("#doctor").html('<option value="">Select a doctor</option>'); // Reset if no branch is selected
                }
            });
        });
        </script>

        <script>
        $(document).ready(function () {
            $("#doctor").change(function () {
                var doctorId = $(this).val();

                if (doctorId) {
                    $.ajax({
                        url: "backend/get_doctor_availability.php",
                        type: "POST",
                        data: { doctor_id: doctorId },
                        success: function (response) {
                            // Parse the response into JSON
                            var data = JSON.parse(response);
                            
                            // Populate the days and times
                            $(".days").html(data.days);
                            $(".times").html(data.times);
                        }
                    });
                } else {
                    $(".days").html('<label>Select Available Day:</label>');
                    $(".times").html('<label>Select Available Time:</label>');
                }
            });
        });
        </script>


      
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