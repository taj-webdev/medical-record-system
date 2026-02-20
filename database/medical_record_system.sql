-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 20, 2026 at 06:19 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical_record_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_id` bigint DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` bigint NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Klinik Umum', 'Umum', '2026-02-10 23:59:09'),
(2, 'Klinik Gigi', 'Gigi', '2026-02-11 00:00:15'),
(4, 'Klinik Kulit dan Kelamin', 'Kulit dan Kelamin', '2026-02-11 00:01:18'),
(5, 'Klinik Kebidanan dan Kandungan', 'Kebidanan dan Kandungan', '2026-02-11 00:01:37'),
(6, 'Klinik Psikologi dan Psikiatri', 'Psikologi dan Psikiatri', '2026-02-11 00:02:00'),
(8, 'Klinik Estetika/Kecantikan', 'Estetika/Kecantikan', '2026-02-11 00:08:11'),
(9, 'Klinik Andrologi', 'Andrologi', '2026-02-11 00:08:30'),
(10, 'Klinik Bedah', 'Bedah', '2026-02-11 00:08:44'),
(11, 'Klinik Rehabilitasi Medis/Fisioterapi', 'Rehabilitasi Medis/Fisioterapi', '2026-02-11 00:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` bigint NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `code`, `name`, `created_at`) VALUES
(1, '10969', 'KANKER PARAH', '2026-02-11 22:42:56'),
(3, '004', 'STADIUM 4', '2026-02-11 22:44:19'),
(4, '003', 'STADIUM 3', '2026-02-11 22:44:32'),
(5, '002', 'STADIUM 2', '2026-02-11 22:44:45'),
(7, '001', 'STADIUM 1', '2026-02-11 22:47:07'),
(8, '005', 'MASIH AMAN', '2026-02-16 01:17:38'),
(9, '006', 'MASIH STABIL', '2026-02-16 01:17:51'),
(10, '007', 'MASIH NORMAL', '2026-02-16 01:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `phone`, `is_active`, `created_at`) VALUES
(1, 'LOORAND SPOOFY', 'Umum', '082366776650', 1, '2026-02-11 00:54:28'),
(3, 'LOID FORGER', 'Psikologi dan Psikiatri', '082258589090', 1, '2026-02-11 01:09:26'),
(4, 'JAMES BORRIS PARRO', 'Gigi', '083109091010', 1, '2026-02-12 00:35:52'),
(5, 'ARLOTT LIONEL ARMANDO', 'Bedah', '083867765640', 1, '2026-02-12 00:36:38'),
(6, 'YURI BRIAR', 'Andrologi', '085144332211', 1, '2026-02-13 01:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint NOT NULL,
  `registration_id` bigint NOT NULL,
  `invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(14,2) NOT NULL,
  `status` enum('unpaid','paid','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `registration_id`, `invoice_number`, `total_amount`, `status`, `created_at`) VALUES
(1, 17, 'INV/20260219/0001', 2100000.00, 'paid', '2026-02-18 21:33:44'),
(2, 1, 'INV/20260219/0002', 605000.00, 'paid', '2026-02-18 21:35:16'),
(3, 4, 'INV/20260219/0003', 2000000.00, 'paid', '2026-02-18 22:47:13'),
(4, 3, 'INV/20260219/0004', 1600000.00, 'paid', '2026-02-18 22:47:19'),
(5, 5, 'INV/20260219/0005', 2800000.00, 'paid', '2026-02-19 00:06:23'),
(6, 6, 'INV/20260219/0006', 1600000.00, 'paid', '2026-02-19 00:06:42'),
(7, 7, 'INV/20260220/0001', 1250000.00, 'paid', '2026-02-19 19:17:56'),
(8, 8, 'INV/20260220/0002', 5200000.00, 'paid', '2026-02-19 19:18:27'),
(9, 10, 'INV/20260220/0003', 2175000.00, 'paid', '2026-02-19 19:18:34'),
(10, 9, 'INV/20260220/0004', 5925000.00, 'paid', '2026-02-19 19:18:39'),
(11, 11, 'INV/20260220/0005', 5855000.00, 'paid', '2026-02-19 19:23:19'),
(12, 13, 'INV/20260220/0006', 850000.00, 'paid', '2026-02-19 19:23:30'),
(13, 12, 'INV/20260220/0007', 1750000.00, 'paid', '2026-02-19 19:23:35'),
(14, 14, 'INV/20260220/0008', 3425000.00, 'paid', '2026-02-19 19:23:42'),
(15, 16, 'INV/20260220/0009', 4750000.00, 'paid', '2026-02-19 19:24:22'),
(16, 15, 'INV/20260220/0010', 1550000.00, 'paid', '2026-02-19 19:24:52'),
(17, 18, 'INV/20260220/0011', 4700000.00, 'paid', '2026-02-19 19:39:33'),
(18, 20, 'INV/20260220/0012', 550000.00, 'paid', '2026-02-19 19:39:42'),
(19, 19, 'INV/20260220/0013', 600000.00, 'paid', '2026-02-19 19:39:48'),
(20, 21, 'INV/20260220/0014', 6600000.00, 'paid', '2026-02-19 19:39:53'),
(21, 22, 'INV/20260220/0015', 2400000.00, 'paid', '2026-02-19 19:40:03'),
(22, 23, 'INV/20260220/0016', 11700000.00, 'paid', '2026-02-19 19:40:08'),
(23, 24, 'INV/20260220/0017', 16050000.00, 'paid', '2026-02-19 20:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `medical_actions`
--

CREATE TABLE `medical_actions` (
  `id` bigint NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_actions`
--

INSERT INTO `medical_actions` (`id`, `name`, `cost`, `created_at`) VALUES
(1, 'RECOVERY', 1500000.00, '2026-02-11 22:48:20'),
(2, 'URGENT', 2000000.00, '2026-02-11 22:48:41'),
(3, 'EMERGENCY', 2500000.00, '2026-02-11 22:53:40'),
(4, 'FORBIDDEN', 750000.00, '2026-02-11 22:54:06'),
(5, 'RESPAWN', 500000.00, '2026-02-11 22:54:26'),
(7, 'EXECUTE', 4500000.00, '2026-02-11 23:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint NOT NULL,
  `registration_id` bigint NOT NULL,
  `complaint` text COLLATE utf8mb4_unicode_ci,
  `diagnosis_id` bigint DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `registration_id`, `complaint`, `diagnosis_id`, `notes`, `created_at`) VALUES
(1, 13, 'SAKIT KEPALA', 8, 'Bawa Istirahat Saja Dulu', '2026-02-16 01:18:48'),
(2, 6, 'MIGRAIN', 10, 'Istirahat dengan Resep Obat tertentu', '2026-02-16 01:19:19'),
(3, 1, 'KANTONG KERING', 1, 'HARUS EXECUTE', '2026-02-16 01:19:39'),
(4, 7, 'GIGI BERLUBANG', 8, 'OPERASI GIGI', '2026-02-16 01:28:17'),
(5, 3, 'GUSI BERDARAH', 8, 'BERIKAN OBAT', '2026-02-16 01:28:35'),
(6, 11, 'TEST BEDAH', 7, 'CEK RUTIN BERKALA + RESEP', '2026-02-17 18:56:34'),
(7, 5, 'BEDAH JANTUNG', 7, 'CEK BERKALA + RESEP', '2026-02-17 18:56:56'),
(8, 12, 'MENTAL ILNESS', 5, 'TERAPI TINGKAT LANJUT AWAL', '2026-02-17 18:57:38'),
(9, 10, 'ANXIETY', 5, 'TERAPI TINGKAT LANJUT AWAL', '2026-02-17 18:57:54'),
(10, 4, 'MENTAL BREAKDOWN', 5, 'TERAPI TINGKAT LANJUT AWAL', '2026-02-17 18:58:13'),
(11, 9, 'PERIKSA ALAT REPRODUKSI', 8, 'AMAN TAPI KASIH RESEP RUTIN', '2026-02-17 18:59:26'),
(12, 8, 'PERIKSA KEJANTANAN', 10, 'NORMAL TAPI KASIH RESEP RUTIN', '2026-02-17 18:59:42'),
(13, 15, 'INSECURE TIPIS', 9, 'TERAPI RINGAN DAN SINGKAT', '2026-02-18 01:08:56'),
(14, 14, 'MENTALL BREAKDOWN', 7, 'TERAPI LANJUTAN DENGAN SEDIKIT RESEP', '2026-02-18 01:10:10'),
(15, 16, 'PASANG BEHEL PREMIUM', 10, 'OK LANJUTKAN', '2026-02-18 01:11:28'),
(16, 17, 'TELINGA SEBELAH SUSAH MENDENGAR', 8, 'BERSIHKAN TELINGAN DENGAN KASIH SEDIKIT RESEP', '2026-02-18 21:08:19'),
(17, 18, 'CEK BEDAH JANTUNG', 7, 'MASIH BISA ASAL KASIH RESEP', '2026-02-18 21:23:28'),
(18, 19, 'CEK ALAT REPRODUKSI', 10, 'OKE RESEP DIKIT', '2026-02-18 23:04:34'),
(19, 20, 'CEK URINE', 8, 'OKE MASIH AMAN', '2026-02-18 23:09:43'),
(20, 21, 'PASANG BEHEL PREMIUM', 8, 'OK', '2026-02-19 19:28:54'),
(21, 22, 'BERSIHKAN KARANG GIGI', 9, 'OKE', '2026-02-19 19:35:42'),
(22, 23, 'EKSEKUSI GIGI BERLUBANG', 8, 'OKE', '2026-02-19 19:36:48'),
(23, 24, 'CEK KESEHATAN MENTAL ILLNES', 7, 'RESEP DIKIT', '2026-02-19 19:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `medical_record_actions`
--

CREATE TABLE `medical_record_actions` (
  `id` bigint NOT NULL,
  `medical_record_id` bigint NOT NULL,
  `medical_action_id` bigint NOT NULL,
  `cost` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_record_actions`
--

INSERT INTO `medical_record_actions` (`id`, `medical_record_id`, `medical_action_id`, `cost`) VALUES
(1, 1, 4, 750000.00),
(2, 2, 1, 1500000.00),
(3, 3, 5, 500000.00),
(4, 4, 5, 500000.00),
(5, 5, 1, 1500000.00),
(6, 8, 1, 1500000.00),
(7, 9, 2, 2000000.00),
(8, 10, 1, 1500000.00),
(9, 6, 7, 4500000.00),
(10, 7, 3, 2500000.00),
(11, 11, 7, 4500000.00),
(12, 12, 7, 4500000.00),
(13, 13, 1, 1500000.00),
(14, 14, 1, 1500000.00),
(15, 14, 5, 500000.00),
(16, 15, 7, 4500000.00),
(17, 16, 5, 500000.00),
(18, 16, 1, 1500000.00),
(19, 17, 3, 2500000.00),
(20, 17, 1, 1500000.00),
(21, 18, 5, 500000.00),
(22, 19, 5, 500000.00),
(23, 20, 7, 4500000.00),
(24, 20, 1, 1500000.00),
(25, 21, 1, 1500000.00),
(26, 21, 4, 750000.00),
(27, 22, 7, 4500000.00),
(28, 22, 1, 1500000.00),
(29, 23, 3, 2500000.00),
(30, 23, 2, 2000000.00),
(31, 23, 1, 1500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `unit`, `price`, `stock`, `created_at`) VALUES
(1, 'MALEFIC GUN', 'STRIP', 250000.00, 100, '2026-02-11 23:52:00'),
(2, 'HUNTER STRIKE', 'STRIP', 35000.00, 50, '2026-02-11 23:52:24'),
(5, 'WINDTALKER', 'PCS', 5000.00, 250, '2026-02-11 23:56:24'),
(6, 'DIVINE GLAIVE', 'PCS', 10000.00, 150, '2026-02-11 23:56:56'),
(7, 'ELEGANT GEM', 'KTK', 50000.00, 20, '2026-02-11 23:57:27');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint NOT NULL,
  `medical_record_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `medical_record_number`, `name`, `nik`, `gender`, `birth_date`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'TAJWDV-001-MRS', 'NUNO GOMEZ', '1501', 'M', '1985-06-10', '081130304040', 'LISBON', '2026-02-04 22:07:46', '2026-02-04 22:09:44'),
(2, 'TAJWDV-002-MRS', 'CASEY WINSTON', '1502', 'F', '2000-05-10', '081253534545', 'LONDON', '2026-02-04 22:12:23', '2026-02-04 22:18:03'),
(5, 'TAJWDV-003-MRS', 'SYDNEY MARTHA BIZZARA', '1503', 'F', '1997-12-19', '081351526767', 'MELBOURNE', '2026-02-04 22:21:02', '2026-02-04 22:22:22'),
(6, 'TAJWDV-004-MRS', 'ROMMY ARMANDO PEREZ', '1504', 'M', '2002-07-18', '081530304040', 'BELGIUM', '2026-02-05 01:16:47', '2026-02-10 00:45:45'),
(7, 'TAJWDV-005-MRS', 'ROCK LEE', '1505', 'M', '1998-11-20', '081920203030', 'KONOHAGAKURE', '2026-02-11 00:38:04', NULL),
(8, 'TAJWDV-006-MRS', 'CHA HAE-IN', '1506', 'F', '2000-05-25', '08214045050', 'SEOUL', '2026-02-11 00:39:01', NULL),
(9, 'TAJWDV-007-MRS', 'SUNG JIN-WOO', '1507', 'M', '2000-02-15', '082210102020', 'GANGNAM', '2026-02-11 00:40:02', NULL),
(10, 'TAJWDV-008-MRS', 'FRINCE MIGUEL RAMIREZ', '1508', 'M', '2003-11-22', '085120203030', 'MANILA', '2026-02-16 00:41:01', NULL),
(11, 'TAJWDV-009-MRS', 'MARK GENZON SOJERO RUSIANA', '1509', 'M', '2005-04-14', '085249137676', 'MINDANAO', '2026-02-16 00:43:05', NULL),
(12, 'TAJWDV-010-MRS', 'NICOLE HUANG', '1510', 'F', '2004-07-16', '0853776677', 'WASHINGTON D.C', '2026-02-16 00:45:13', NULL),
(13, 'TAJWDV-011-MRS', 'JESSICA QI-YAO CAO', '1511', 'F', '2006-12-25', '085188990011', 'WASHINGTON D.C', '2026-02-16 00:47:11', NULL),
(14, 'TAJWDV-012-MRS', 'ASHLEY ANN', '1512', 'F', '2003-09-12', '085988776655', 'WASHINGTON D.C', '2026-02-16 00:53:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint NOT NULL,
  `invoice_id` bigint NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `payment_method`, `amount`, `paid_at`) VALUES
(1, 1, 'Cash', 2100000.00, '2026-02-19 05:53:34'),
(2, 2, 'Cash', 605000.00, '2026-02-19 05:53:56'),
(3, 3, 'Cash', 2000000.00, '2026-02-19 05:59:48'),
(4, 4, 'Cash', 1600000.00, '2026-02-19 06:22:01'),
(5, 5, 'QRIS', 2800000.00, '2026-02-19 07:06:32'),
(6, 6, 'QRIS', 1600000.00, '2026-02-19 07:06:48'),
(7, 7, 'QRIS', 1250000.00, '2026-02-20 02:18:02'),
(8, 8, 'Transfer', 5200000.00, '2026-02-20 02:19:07'),
(9, 9, 'Transfer', 2175000.00, '2026-02-20 02:19:25'),
(10, 10, 'Debit', 5925000.00, '2026-02-20 02:19:37'),
(11, 11, 'Debit', 5855000.00, '2026-02-20 02:25:06'),
(12, 12, 'Transfer', 850000.00, '2026-02-20 02:25:14'),
(13, 13, 'Cash', 1750000.00, '2026-02-20 02:38:46'),
(14, 14, 'Transfer', 3425000.00, '2026-02-20 02:38:56'),
(15, 15, 'Debit', 4750000.00, '2026-02-20 02:39:06'),
(16, 16, 'QRIS', 1550000.00, '2026-02-20 02:39:14'),
(17, 17, 'Cash', 4700000.00, '2026-02-20 02:48:07'),
(18, 18, 'Transfer', 550000.00, '2026-02-20 02:48:15'),
(19, 19, 'Debit', 600000.00, '2026-02-20 02:48:23'),
(20, 20, 'QRIS', 6600000.00, '2026-02-20 02:48:34'),
(21, 21, 'QRIS', 2400000.00, '2026-02-20 02:48:42'),
(22, 22, 'Debit', 11700000.00, '2026-02-20 02:48:50'),
(23, 23, 'Transfer', 16050000.00, '2026-02-20 03:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint NOT NULL,
  `medical_record_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `medical_record_id`, `created_at`) VALUES
(1, 1, '2026-02-17 20:28:37'),
(2, 2, '2026-02-17 20:28:53'),
(3, 3, '2026-02-17 20:29:09'),
(4, 4, '2026-02-17 20:32:06'),
(5, 5, '2026-02-17 20:32:54'),
(6, 8, '2026-02-17 20:34:42'),
(7, 9, '2026-02-17 20:35:03'),
(8, 10, '2026-02-17 20:35:25'),
(9, 6, '2026-02-17 20:40:06'),
(10, 7, '2026-02-17 20:40:39'),
(11, 11, '2026-02-17 20:43:08'),
(12, 12, '2026-02-17 20:44:08'),
(13, 13, '2026-02-18 01:09:20'),
(14, 14, '2026-02-18 01:10:33'),
(15, 15, '2026-02-18 01:11:48'),
(16, 16, '2026-02-18 21:08:58'),
(17, 17, '2026-02-18 21:31:18'),
(18, 18, '2026-02-18 23:09:12'),
(19, 19, '2026-02-18 23:10:23'),
(20, 20, '2026-02-19 19:29:23'),
(21, 21, '2026-02-19 19:36:16'),
(22, 22, '2026-02-19 19:37:12'),
(23, 23, '2026-02-19 19:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE `prescription_items` (
  `id` bigint NOT NULL,
  `prescription_id` bigint NOT NULL,
  `medicine_id` bigint NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescription_items`
--

INSERT INTO `prescription_items` (`id`, `prescription_id`, `medicine_id`, `quantity`, `price`) VALUES
(1, 1, 6, 10, 10000.00),
(2, 2, 7, 2, 50000.00),
(3, 3, 2, 3, 35000.00),
(4, 4, 1, 3, 250000.00),
(5, 5, 5, 20, 5000.00),
(6, 6, 7, 5, 50000.00),
(7, 7, 2, 5, 35000.00),
(8, 8, 1, 2, 250000.00),
(9, 9, 7, 10, 50000.00),
(10, 9, 2, 3, 35000.00),
(11, 9, 1, 3, 250000.00),
(12, 10, 5, 20, 5000.00),
(13, 10, 6, 20, 10000.00),
(14, 11, 2, 5, 35000.00),
(15, 11, 1, 5, 250000.00),
(16, 12, 7, 10, 50000.00),
(17, 12, 6, 20, 10000.00),
(18, 13, 5, 10, 5000.00),
(19, 14, 1, 5, 250000.00),
(20, 14, 2, 5, 35000.00),
(21, 15, 7, 5, 50000.00),
(22, 16, 5, 20, 5000.00),
(23, 17, 2, 10, 35000.00),
(24, 17, 2, 10, 35000.00),
(25, 18, 6, 10, 10000.00),
(26, 19, 5, 10, 5000.00),
(27, 20, 7, 10, 50000.00),
(28, 20, 6, 10, 10000.00),
(29, 21, 5, 10, 5000.00),
(30, 21, 6, 10, 10000.00),
(31, 22, 2, 20, 35000.00),
(32, 22, 1, 20, 250000.00),
(33, 23, 2, 30, 35000.00),
(34, 23, 1, 30, 250000.00),
(35, 23, 7, 30, 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint NOT NULL,
  `patient_id` bigint NOT NULL,
  `clinic_id` bigint NOT NULL,
  `doctor_id` bigint DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `status` enum('waiting','examined','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `patient_id`, `clinic_id`, `doctor_id`, `registration_date`, `status`, `created_at`) VALUES
(1, 1, 1, 1, '2026-02-12 14:55:00', 'completed', '2026-02-12 00:55:39'),
(3, 2, 2, 4, '2026-02-12 15:10:00', 'completed', '2026-02-12 01:08:30'),
(4, 5, 6, 3, '2026-02-12 15:10:00', 'completed', '2026-02-12 01:09:19'),
(5, 6, 10, 5, '2026-02-13 09:50:00', 'completed', '2026-02-12 19:48:56'),
(6, 7, 1, 1, '2026-02-13 10:40:00', 'completed', '2026-02-12 20:39:53'),
(7, 8, 2, 4, '2026-02-13 15:15:00', 'completed', '2026-02-13 01:15:57'),
(8, 9, 9, 6, '2026-02-13 15:16:00', 'completed', '2026-02-13 01:16:12'),
(9, 10, 9, 6, '2026-02-16 14:55:00', 'completed', '2026-02-16 00:55:24'),
(10, 11, 6, 3, '2026-02-16 14:55:00', 'completed', '2026-02-16 00:55:43'),
(11, 12, 10, 5, '2026-02-16 14:58:00', 'completed', '2026-02-16 00:58:44'),
(12, 13, 6, 3, '2026-02-16 15:00:00', 'completed', '2026-02-16 00:59:32'),
(13, 14, 1, 1, '2026-02-16 15:00:00', 'completed', '2026-02-16 00:59:50'),
(14, 12, 6, 3, '2026-02-18 09:00:00', 'completed', '2026-02-17 19:01:21'),
(15, 13, 1, 1, '2026-02-18 09:01:00', 'completed', '2026-02-17 19:01:54'),
(16, 14, 2, 4, '2026-02-18 09:01:00', 'completed', '2026-02-17 19:02:25'),
(17, 10, 1, 1, '2026-02-19 10:06:00', 'completed', '2026-02-18 20:06:39'),
(18, 9, 10, 5, '2026-02-19 10:06:00', 'completed', '2026-02-18 20:07:07'),
(19, 1, 9, 6, '2026-02-19 10:07:00', 'completed', '2026-02-18 20:07:35'),
(20, 11, 9, 6, '2026-02-19 10:07:00', 'completed', '2026-02-18 20:07:57'),
(21, 8, 2, 4, '2026-02-19 13:18:00', 'completed', '2026-02-18 23:18:49'),
(22, 14, 2, 4, '2026-02-19 13:19:00', 'completed', '2026-02-18 23:19:28'),
(23, 7, 2, 4, '2026-02-20 09:15:00', 'completed', '2026-02-19 19:16:07'),
(24, 6, 6, 3, '2026-02-20 09:16:00', 'completed', '2026-02-19 19:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Admin', 'Administrator', '2026-01-30 07:23:55'),
(2, 'Doctor', 'Doctor', '2026-01-30 07:57:38'),
(3, 'Nurse', 'Nurse', '2026-01-30 07:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `role_id` bigint NOT NULL,
  `doctor_id` bigint DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `doctor_id`, `name`, `email`, `username`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 'LOORAND SPOOFY', 'loorandspoofy@gmail.com', 'loorand', '$2y$12$5VzcxB1iB.0svnLue1prKeCDDbctv0JN2BQjFppkRY96mwhhMd8fS', 1, '2026-02-02 20:34:59', NULL),
(4, 3, NULL, 'VALENCIA RAMIREZ', 'valenciarami@gmail.com', 'valencia', '$2y$12$dKlr6HrQkgDbmL.G4tTO5.f.klqBc7GN2Wy5c0ars5.8xu2XI7jBi', 1, '2026-02-02 21:04:50', NULL),
(5, 1, NULL, 'KING CYRIC PEREZ', 'kingkongph@gmail.com', 'kingkong', '$2y$12$OPQmirZsVh6omst7noi8fu38eKx4kOfHm1tajmSn/gRa1fdoOhU22', 1, '2026-02-02 21:08:09', NULL),
(6, 2, 3, 'LOID FORGER', 'loidspy@gmail.com', 'loid123', '$2y$12$hMlArZtko26Cc3qQwk9YF.2fl5Q12Htdr7LrzdW4tsf4nbKw2ayfm', 1, '2026-02-11 01:08:25', NULL),
(7, 2, 5, 'ARLOTT LIONEL ARMANDO', 'arlottdoctor@gmail.com', 'arlott', '$2y$12$lPHtjQsO7Ho.GELK1/PrDe9wFYWsV98AoZV31WCY4IdhKJg4cp5JK', 1, '2026-02-12 00:01:15', NULL),
(9, 2, 4, 'JAMES BORRIS PARRO', 'bruskoonph@gmail.com', 'brusko123', '$2y$12$HlLLTZ8zZGPyQUpxrHRCH.H5PsqlZijju1x4wxXOTEmQDFwemQAyi', 1, '2026-02-12 00:28:21', NULL),
(10, 2, 6, 'YURI BRIAR', 'yuribriar@gmail.com', 'yurispy123', '$2y$12$/ZA3FVGT2fY0cUKGZleg/uOlhLQsbb1FU0Cj5avNTEgp5rzH.2hXO', 1, '2026-02-13 01:10:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vital_signs`
--

CREATE TABLE `vital_signs` (
  `id` bigint NOT NULL,
  `registration_id` bigint NOT NULL,
  `blood_pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heart_rate` int DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vital_signs`
--

INSERT INTO `vital_signs` (`id`, `registration_id`, `blood_pressure`, `heart_rate`, `temperature`, `weight`, `height`, `created_at`) VALUES
(1, 3, '120/80', 100, 37.0, 50.00, 160.00, '2026-02-12 01:22:11'),
(2, 4, '120/80', 80, 35.0, 50.00, 160.00, '2026-02-12 01:22:46'),
(3, 1, '120/80', 115, 35.0, 75.00, 180.00, '2026-02-12 01:23:17'),
(4, 5, '125/85', 100, 36.0, 66.00, 175.00, '2026-02-12 21:16:39'),
(5, 6, '125/85', 80, 37.0, 60.00, 170.00, '2026-02-12 21:18:17'),
(6, 7, '120/80', 90, 34.0, 50.00, 160.00, '2026-02-13 01:18:07'),
(7, 8, '120/80', 95, 36.0, 65.00, 180.00, '2026-02-13 01:19:31'),
(8, 10, '122/80', 100, 37.0, 65.00, 166.00, '2026-02-16 01:11:30'),
(9, 9, '125/85', 90, 35.0, 65.00, 172.00, '2026-02-16 01:11:55'),
(10, 11, '120/80', 94, 34.0, 54.00, 165.00, '2026-02-16 01:15:11'),
(11, 13, '120/80', 96, 35.0, 55.00, 162.00, '2026-02-16 01:15:26'),
(12, 12, '120/80', 96, 36.0, 54.00, 160.00, '2026-02-16 01:15:42'),
(13, 15, '120/80', 100, 35.0, 55.00, 160.00, '2026-02-18 01:06:44'),
(14, 16, '120/80', 98, 35.0, 55.00, 163.00, '2026-02-18 01:07:01'),
(15, 14, '120/80', 90, 34.0, 54.00, 160.00, '2026-02-18 01:07:15'),
(16, 18, '120/80', 95, 35.0, 66.00, 180.00, '2026-02-18 20:08:57'),
(17, 17, '120/80', 99, 36.0, 65.00, 178.00, '2026-02-18 20:09:15'),
(18, 20, '122/80', 90, 35.0, 62.00, 165.00, '2026-02-18 21:29:04'),
(19, 19, '122/80', 100, 36.0, 66.00, 190.00, '2026-02-18 21:29:39'),
(20, 21, '120/80', 120, 35.0, 55.00, 160.00, '2026-02-19 19:26:26'),
(21, 22, '120/80', 120, 34.0, 55.00, 160.00, '2026-02-19 19:26:39'),
(22, 23, '125/85', 125, 36.0, 65.00, 180.00, '2026-02-19 19:26:55'),
(23, 24, '125/85', 120, 30.0, 66.00, 178.00, '2026-02-19 19:27:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_user` (`user_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `fk_inv_reg` (`registration_id`);

--
-- Indexes for table `medical_actions`
--
ALTER TABLE `medical_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mr_reg` (`registration_id`),
  ADD KEY `fk_mr_diag` (`diagnosis_id`);

--
-- Indexes for table `medical_record_actions`
--
ALTER TABLE `medical_record_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mra_mr` (`medical_record_id`),
  ADD KEY `fk_mra_action` (`medical_action_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_record_number` (`medical_record_number`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pay_inv` (`invoice_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pres_mr` (`medical_record_id`);

--
-- Indexes for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pi_pres` (`prescription_id`),
  ADD KEY `fk_pi_med` (`medicine_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reg_patient` (`patient_id`),
  ADD KEY `fk_reg_clinic` (`clinic_id`),
  ADD KEY `fk_reg_doctor` (`doctor_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_roles` (`role_id`),
  ADD KEY `fk_users_doctor` (`doctor_id`);

--
-- Indexes for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vital_reg` (`registration_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medical_actions`
--
ALTER TABLE `medical_actions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medical_record_actions`
--
ALTER TABLE `medical_record_actions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vital_signs`
--
ALTER TABLE `vital_signs`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_inv_reg` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `fk_mr_diag` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnoses` (`id`),
  ADD CONSTRAINT `fk_mr_reg` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`);

--
-- Constraints for table `medical_record_actions`
--
ALTER TABLE `medical_record_actions`
  ADD CONSTRAINT `fk_mra_action` FOREIGN KEY (`medical_action_id`) REFERENCES `medical_actions` (`id`),
  ADD CONSTRAINT `fk_mra_mr` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pay_inv` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `fk_pres_mr` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`);

--
-- Constraints for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD CONSTRAINT `fk_pi_med` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `fk_pi_pres` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_reg_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`),
  ADD CONSTRAINT `fk_reg_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `fk_reg_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD CONSTRAINT `fk_vital_reg` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
