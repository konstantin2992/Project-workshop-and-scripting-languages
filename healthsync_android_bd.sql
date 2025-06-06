-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 06 2025 г., 18:25
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `healthsync`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `appointment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration_minutes` int(11) DEFAULT 30,
  `status` enum('scheduled','completed','canceled','no_show') NOT NULL DEFAULT 'scheduled',
  `reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `nurse_id`, `institution_id`, `schedule_id`, `appointment_date`, `duration_minutes`, `status`, `reason`, `notes`, `created_at`, `updated_at`) VALUES
(16, 1, 7, NULL, 1, 6, '2025-06-09 06:00:00', 30, 'scheduled', 'Консультация', '', '2025-06-05 18:59:32', '2025-06-05 18:59:32'),
(17, 2, 9, NULL, 1, 15, '2025-06-06 15:57:41', 30, 'scheduled', 'Консультация', '', '2025-06-05 19:04:11', '2025-06-06 15:57:41');

-- --------------------------------------------------------

--
-- Структура таблицы `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `consultation_fee` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `birth_date`, `address`, `specialization_id`, `institution_id`, `license_number`, `bio`, `experience_years`, `is_available`, `consultation_fee`, `created_at`, `updated_at`, `is_active`) VALUES
(7, 'ivanov@example.com', '$2y$10$abcdefgHashedPassword1', 'Іван', 'Іванов', '+380501234567', '1980-05-15', 'вул. Лікарська, 10', 1, 1, 'LIC123456', 'Досвідчений терапевт із понад 15-річним стажем.', 15, 1, 500.00, '2025-06-05 07:23:48', '2025-06-05 07:23:48', 1),
(8, 'petrenko@example.com', '$2y$10$abcdefgHashedPassword2', 'Олена', 'Петренко', '+380671112233', '1985-08-22', 'вул. Здоров’я, 22', 2, 1, 'LIC654321', 'Кардіолог із міжнародним досвідом.', 12, 1, 700.00, '2025-06-05 07:23:48', '2025-06-05 07:23:48', 1),
(9, 'shevchenko@example.com', '$2y$10$abcdefgHashedPassword3', 'Тарас', 'Шевченко', '+380931234567', '1990-11-03', 'вул. Серцева, 5', 3, 2, 'LIC777777', 'Молодий невролог із сучасними підходами.', 7, 1, 600.00, '2025-06-05 07:23:48', '2025-06-05 07:23:48', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `lab_tests`
--

CREATE TABLE `lab_tests` (
  `test_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `medical_institutions`
--

CREATE TABLE `medical_institutions` (
  `institution_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `medical_institutions`
--

INSERT INTO `medical_institutions` (`institution_id`, `name`, `address`, `phone`, `email`, `website`) VALUES
(1, 'Центральна лікарня №1', 'вул. Медична, 1', '', NULL, NULL),
(2, 'Приватна клініка \"Здоров\'я\"', 'вул. Незалежності, 12', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `visit_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diagnosis` text DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `treatment_plan` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `doctor_id`, `nurse_id`, `institution_id`, `visit_date`, `diagnosis`, `symptoms`, `treatment_plan`, `notes`, `created_at`) VALUES
(1, 1, 7, NULL, 1, '2025-06-11 11:00:00', NULL, NULL, NULL, '', '2025-06-05 11:22:49'),
(2, 1, 8, NULL, 1, '2025-06-06 11:00:00', NULL, NULL, NULL, '', '2025-06-05 11:32:07'),
(3, 1, 7, NULL, 1, '2025-06-09 09:30:00', NULL, NULL, NULL, '', '2025-06-05 12:09:41'),
(4, 1, 8, NULL, 1, '2025-06-06 11:00:00', NULL, NULL, NULL, '', '2025-06-05 12:15:19'),
(5, 1, 8, NULL, 1, '2025-06-06 09:00:00', NULL, NULL, NULL, '', '2025-06-05 12:19:33'),
(6, 1, 8, NULL, 1, '2025-06-06 08:30:00', NULL, NULL, NULL, '', '2025-06-05 12:22:53'),
(7, 1, 9, NULL, 1, '2025-06-12 16:00:00', NULL, NULL, NULL, '', '2025-06-05 13:53:26'),
(8, 1, 9, NULL, 1, '2025-06-12 16:30:00', NULL, NULL, NULL, '', '2025-06-05 15:31:01'),
(9, 1, 7, NULL, 1, '2025-06-11 09:00:00', NULL, NULL, NULL, '', '2025-06-05 16:24:29'),
(10, 1, 7, NULL, 1, '2025-06-10 11:30:00', NULL, NULL, NULL, '', '2025-06-05 17:04:04'),
(11, 1, 8, NULL, 1, '2025-06-09 14:30:00', NULL, NULL, NULL, '', '2025-06-05 17:22:37'),
(12, 1, 8, NULL, 1, '2025-06-06 09:30:00', NULL, NULL, NULL, '', '2025-06-05 17:27:37'),
(13, 1, 8, NULL, 1, '2025-06-06 05:30:00', NULL, NULL, NULL, '', '2025-06-05 18:53:56'),
(14, 1, 8, NULL, 1, '2025-06-06 11:30:00', NULL, NULL, NULL, '', '2025-06-05 18:54:15'),
(15, 1, 7, NULL, 1, '2025-06-12 06:00:00', NULL, NULL, NULL, '', '2025-06-05 18:56:10'),
(16, 1, 7, NULL, 1, '2025-06-09 06:00:00', NULL, NULL, NULL, '', '2025-06-05 18:59:32'),
(17, 1, 9, NULL, 1, '2025-06-12 16:30:00', NULL, NULL, NULL, '', '2025-06-05 19:04:11');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_type` enum('doctor','nurse','patient') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_type` enum('doctor','nurse','patient') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `nurses`
--

CREATE TABLE `nurses` (
  `nurse_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `chronic_conditions` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `patients`
--

INSERT INTO `patients` (`patient_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `birth_date`, `address`, `gender`, `blood_type`, `allergies`, `chronic_conditions`, `emergency_contact_name`, `emergency_contact_phone`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'aa@gmail.com', '$2y$10$DckgmCxdIx3y1C1nlWdO4ehD7bjO2TWT9ClUbAg1owOxkyKQjPW.y', 'a b', 'a', '345345', '2025-05-05', 'dsfsdf', 'Чоловіча', 'B(III) Rh+', 'sdfsdfs', 'sdfsdf', 'sdfsdf', '234324', '2025-06-05 07:18:26', '2025-06-05 09:37:09', 1),
(2, 'ko@gmail.com', '$2y$10$Ys2q0/gQAwCize6XW3FJyeLZ13uwfhZwCqK8HoOts1Sbw4tICquTu', 'Константин', 'Лещенко', '+380956663332', '2002-05-31', 'черкаси', NULL, 'B(III) Rh−', 'пил', 'танзилит', '', '', '2025-06-06 14:30:44', '2025-06-06 16:14:01', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('card','cash','bank_transfer','online') NOT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `prescribed_tests`
--

CREATE TABLE `prescribed_tests` (
  `prescribed_test_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `prescribed_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  `results` text DEFAULT NULL,
  `results_date` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reminders`
--

CREATE TABLE `reminders` (
  `reminder_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `reminder_type` enum('email','sms','push') NOT NULL,
  `scheduled_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sent_time` timestamp NULL DEFAULT NULL,
  `status` enum('pending','sent','failed') DEFAULT 'pending',
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `break_start_time` time DEFAULT NULL,
  `break_end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`, `is_available`, `break_start_time`, `break_end_time`) VALUES
(6, 7, 'monday', '09:00:00', '17:00:00', 1, '13:00:00', '14:00:00'),
(7, 7, 'tuesday', '09:00:00', '17:00:00', 1, '13:00:00', '14:00:00'),
(8, 7, 'wednesday', '10:00:00', '16:00:00', 1, '12:30:00', '13:30:00'),
(9, 7, 'thursday', '09:00:00', '17:00:00', 1, NULL, NULL),
(10, 7, 'friday', '08:00:00', '14:00:00', 1, '11:00:00', '11:30:00'),
(11, 8, 'monday', '11:00:00', '19:00:00', 1, '15:00:00', '16:00:00'),
(12, 8, 'wednesday', '09:00:00', '17:00:00', 1, '12:00:00', '13:00:00'),
(13, 8, 'friday', '08:30:00', '15:30:00', 1, NULL, NULL),
(15, 9, 'thursday', '19:00:00', '20:00:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `specializations`
--

CREATE TABLE `specializations` (
  `specialization_id` int(11) NOT NULL,
  `specialization_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `role` enum('doctor','nurse') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `specializations`
--

INSERT INTO `specializations` (`specialization_id`, `specialization_name`, `description`, `role`) VALUES
(1, 'Терапевт', NULL, 'doctor'),
(2, 'Кардіолог', NULL, 'doctor'),
(3, 'Невролог', NULL, 'doctor');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `nurse_id` (`nurse_id`),
  ADD KEY `institution_id` (`institution_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Индексы таблицы `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `specialization_id` (`specialization_id`),
  ADD KEY `institution_id` (`institution_id`);

--
-- Индексы таблицы `lab_tests`
--
ALTER TABLE `lab_tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Индексы таблицы `medical_institutions`
--
ALTER TABLE `medical_institutions`
  ADD PRIMARY KEY (`institution_id`);

--
-- Индексы таблицы `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `nurse_id` (`nurse_id`),
  ADD KEY `institution_id` (`institution_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Индексы таблицы `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`nurse_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `specialization_id` (`specialization_id`),
  ADD KEY `institution_id` (`institution_id`);

--
-- Индексы таблицы `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Индексы таблицы `prescribed_tests`
--
ALTER TABLE `prescribed_tests`
  ADD PRIMARY KEY (`prescribed_test_id`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `nurse_id` (`nurse_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Индексы таблицы `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Индексы таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Индексы таблицы `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`specialization_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `medical_institutions`
--
ALTER TABLE `medical_institutions`
  MODIFY `institution_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `nurses`
--
ALTER TABLE `nurses`
  MODIFY `nurse_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `prescribed_tests`
--
ALTER TABLE `prescribed_tests`
  MODIFY `prescribed_test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reminders`
--
ALTER TABLE `reminders`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `specializations`
--
ALTER TABLE `specializations`
  MODIFY `specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`nurse_id`) REFERENCES `nurses` (`nurse_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`institution_id`) REFERENCES `medical_institutions` (`institution_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_5` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`specialization_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `doctors_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `medical_institutions` (`institution_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medical_records_ibfk_3` FOREIGN KEY (`nurse_id`) REFERENCES `nurses` (`nurse_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medical_records_ibfk_4` FOREIGN KEY (`institution_id`) REFERENCES `medical_institutions` (`institution_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`specialization_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nurses_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `medical_institutions` (`institution_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prescribed_tests`
--
ALTER TABLE `prescribed_tests`
  ADD CONSTRAINT `prescribed_tests_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `medical_records` (`record_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prescribed_tests_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prescribed_tests_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prescribed_tests_ibfk_4` FOREIGN KEY (`nurse_id`) REFERENCES `nurses` (`nurse_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prescribed_tests_ibfk_5` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescribed_tests_ibfk_6` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `reminders`
--
ALTER TABLE `reminders`
  ADD CONSTRAINT `reminders_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reminders_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
