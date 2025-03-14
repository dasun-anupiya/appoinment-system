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
          <div class="edit_profile">
          <?php
          session_start();  // Start the session to access session variables

          require_once "../db_con.php";  // Include your database connection file

          $user_id = $_SESSION['user_id']; 

          // Query to get patient and user details based on the logged-in user
          $sql = "SELECT 
                      u.full_name, 
                      u.email, 
                      u.phone_number,
                      s.date_of_birth, 
                      s.gender, 
                      s.blood_type, 
                      s.address
                  FROM 
                      Hospital_Staff s
                  INNER JOIN Users u ON s.user_id = u.user_id
                  WHERE s.staff_id = ?";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$user_id]);

          $patient = $stmt->fetch(PDO::FETCH_ASSOC);

          // If no data found, redirect to another page or show an error (optional)
          if (!$patient) {
              // Redirect to an error page or show an alert
              echo "No Staff found!";
              exit;
          }
          ?>

          <form action="../backend/update_profile.php" method="POST">
              <label for="name">Full Name: </label><br>
              <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($patient['full_name']); ?>"><br>
              
              <label for="email">Email: </label><br>
              <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($patient['email']); ?>"><br>

              <label for="ph">Phone Number: </label><br>
              <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($patient['phone_number']); ?>"><br>


              <label for="dob">Date of Birth: </label><br>
              <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>"><br>
              
              <label for="gender">Gender: </label><br>
              <select name="gender" id="gender">
                  <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                  <option value="Other" <?php echo $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
              </select><br>

              <label for="blood_type">Blood Type: </label><br>
              <input type="text" name="blood_type" id="blood_type" value="<?php echo htmlspecialchars($patient['blood_type']); ?>"><br>

              <label for="address">Address: </label><br>
              <textarea name="address" id="address"><?php echo htmlspecialchars($patient['address']); ?></textarea><br>
              
              <button type="submit">Update</button>
          </form>

          </div>
        </div>
       </div>
       <!-- dashboard section end-->
       <script>
          // Handle form submission
          const form = document.querySelector('form');

          form.addEventListener('submit', function(event) {
              event.preventDefault();  // Prevent the default form submission

              const formData = new FormData(form);

              // Create an XMLHttpRequest to submit the form data
              const xhr = new XMLHttpRequest();
              xhr.open('POST', form.action, true);

              xhr.onload = function() {
                  if (xhr.status === 200) {
                      const response = JSON.parse(xhr.responseText);

                      if (response.status === 'success') {
                          alert(response.message);  // Display success message
                          // Optionally, you can redirect to a different page after success
                          // window.location.href = 'profile_updated.php';
                      } else if (response.status === 'info') {
                          alert(response.message);  // Display info message
                      } else {
                          alert('An error occurred. Please try again.');
                      }
                  } else {
                      alert('An error occurred while processing the request.');
                  }
              };

              xhr.send(formData);
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