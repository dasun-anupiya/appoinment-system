-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 01:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `care_compass_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  `appointment_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `status`, `appointment_time`) VALUES
(7, 1, 4, '2025-02-24', 'Cancelled', '09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`) VALUES
(1, 'Colombo'),
(2, 'Kurunegala'),
(3, 'Kandy');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'Cardiology'),
(2, 'Neurology'),
(3, 'Orthopedics');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `av_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `available_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `available_from` time NOT NULL,
  `available_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`av_id`, `doctor_id`, `available_day`, `available_from`, `available_to`) VALUES
(7, 4, 'Monday', '09:00:00', '17:00:00'),
(8, 4, 'Tuesday', '09:00:00', '17:00:00'),
(9, 4, 'Wednesday', '09:00:00', '17:00:00'),
(10, 4, 'Thursday', '09:00:00', '17:00:00'),
(11, 4, 'Friday', '09:00:00', '17:00:00'),
(12, 4, 'Saturday', '09:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_staff`
--

CREATE TABLE `hospital_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `qualifications` text NOT NULL,
  `role` enum('Doctor','Nurse','Technician','Receptionist','Admin') NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_staff`
--

INSERT INTO `hospital_staff` (`staff_id`, `user_id`, `department_id`, `specialty`, `qualifications`, `role`, `branch_id`) VALUES
(4, 2, 1, 'Cardiologist', 'MBBS, MD', 'Doctor', 1),
(5, 3, 2, 'Neurologist', 'MBBS, MD', 'Doctor', 2),
(6, 4, 3, 'Orthopedic Surgeon', 'MBBS, MS', 'Doctor', 3);

-- --------------------------------------------------------

--
-- Table structure for table `laboratory_tests`
--

CREATE TABLE `laboratory_tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory_tests`
--

INSERT INTO `laboratory_tests` (`test_id`, `test_name`, `description`, `price`) VALUES
(1, 'Blood Test', 'A general blood test to check for various health conditions.', 50.00),
(2, 'X-ray', 'A diagnostic imaging technique to visualize the inside of the body.', 100.00),
(3, 'CT Scan', 'A detailed imaging test used to diagnose serious medical conditions.', 200.00),
(4, 'MRI', 'A medical imaging technique for detailed images of the body, especially soft tissues.', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `lab_results`
--

CREATE TABLE `lab_results` (
  `result_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `result_details` text NOT NULL,
  `test_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_results`
--

INSERT INTO `lab_results` (`result_id`, `patient_id`, `test_id`, `result_details`, `test_date`) VALUES
(1, 1, 1, 'Normal blood count. No abnormalities found.', '2025-02-24 10:00:00'),
(2, 2, 2, 'Clear X-ray image. No issues detected.', '2025-02-23 14:30:00'),
(3, 3, 3, 'CT scan shows minor inflammation in the abdominal area.', '2025-02-22 09:15:00'),
(4, 1, 4, 'MRI shows no sign of neurological issues.', '2025-02-20 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text DEFAULT NULL,
  `test_results` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `user_id`, `date_of_birth`, `gender`, `blood_type`, `address`, `emergency_phone`) VALUES
(1, 1, '2012-05-14', 'Male', 'O+', 'kandy', '0664455997'),
(2, 3, '1990-05-14', 'Male', 'O+', '123 Main St, Colombo', '0712345678'),
(3, 3, '1985-09-22', 'Female', 'A-', '456 Elm St, Kurunegala', '0712345679');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Failed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `query_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `query_text` text NOT NULL,
  `response_text` text DEFAULT NULL,
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` enum('Admin','Doctor','Lab','Patient') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`, `phone_number`, `user_type`, `created_at`) VALUES
(1, 'Tony Stark', 'rrr@gmail.com', '$2y$10$Y7BHEHy8asRrFmnImshiieuEm33QE5dBhzD80XF47sOcVp8pWLYN.', '0704546162', 'Patient', '2025-02-23 14:03:24'),
(2, 'John Doe', 'john.doe@example.com', '$2y$10$xnEfDTmgzbiOKM9NAf2Lx.0OFQVpyNiwpl8da9sQLP9E.R62gOn22', '0771234567', 'Doctor', '2025-02-23 16:06:58'),
(3, 'Jane Smith', 'jane.smith@example.com', 'password_hash_2', '0777654321', '', '2025-02-23 16:06:58'),
(4, 'Mark Johnson', 'mark.johnson@example.com', 'password_hash_3', '0779876543', 'Patient', '2025-02-23 16:06:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`av_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `hospital_staff`
--
ALTER TABLE `hospital_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `fk_branch` (`branch_id`);

--
-- Indexes for table `laboratory_tests`
--
ALTER TABLE `laboratory_tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`query_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `av_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital_staff`
--
ALTER TABLE `hospital_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laboratory_tests`
--
ALTER TABLE `laboratory_tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lab_results`
--
ALTER TABLE `lab_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `hospital_staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD CONSTRAINT `doctor_availability_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `hospital_staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `hospital_staff`
--
ALTER TABLE `hospital_staff`
  ADD CONSTRAINT `fk_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `hospital_staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_staff_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE SET NULL;

--
-- Constraints for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD CONSTRAINT `lab_results_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_results_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `laboratory_tests` (`test_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `hospital_staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
