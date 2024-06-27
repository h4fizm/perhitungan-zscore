-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2024 pada 09.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `argon_dashboard`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bb-laki-laki`
--

CREATE TABLE `bb-laki-laki` (
  `UMUR` int(11) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bb-laki-laki`
--

INSERT INTO `bb-laki-laki` (`UMUR`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(0, 2.10, 2.50, 2.90, 3.30, 3.90, 4.40, 5.00, NULL, NULL),
(1, 2.90, 3.40, 3.90, 4.50, 5.10, 5.80, 6.60, NULL, NULL),
(2, 3.80, 4.30, 4.90, 5.60, 6.30, 7.10, 8.00, NULL, NULL),
(3, 4.40, 5.00, 5.70, 6.40, 7.20, 8.00, 9.00, NULL, NULL),
(4, 4.90, 5.60, 6.20, 7.00, 7.80, 8.70, 9.70, NULL, NULL),
(5, 5.30, 6.00, 6.70, 7.50, 8.40, 9.30, 10.40, NULL, NULL),
(6, 5.70, 6.40, 7.10, 7.90, 8.80, 9.80, 10.90, NULL, NULL),
(7, 5.90, 6.70, 7.40, 8.30, 9.20, 10.30, 11.40, NULL, NULL),
(8, 6.20, 6.90, 7.70, 8.60, 9.60, 10.70, 11.90, NULL, NULL),
(9, 6.40, 7.10, 8.00, 8.90, 9.90, 11.00, 12.30, NULL, NULL),
(10, 6.60, 7.40, 8.20, 9.20, 10.20, 11.40, 12.70, NULL, NULL),
(11, 6.80, 7.60, 8.40, 9.40, 10.50, 11.70, 13.00, NULL, NULL),
(12, 6.90, 7.70, 8.60, 9.60, 10.80, 12.00, 13.30, NULL, NULL),
(13, 7.10, 7.90, 8.80, 9.90, 11.00, 12.30, 13.70, NULL, NULL),
(14, 7.20, 8.10, 9.00, 10.10, 11.30, 12.60, 14.00, NULL, NULL),
(15, 7.40, 8.30, 9.20, 10.30, 11.50, 12.80, 14.30, NULL, NULL),
(16, 7.50, 8.40, 9.40, 10.50, 11.70, 13.10, 14.60, NULL, NULL),
(17, 7.70, 8.60, 9.60, 10.70, 12.00, 13.40, 14.90, NULL, NULL),
(18, 7.80, 8.80, 9.80, 10.90, 12.20, 13.70, 15.30, NULL, NULL),
(19, 8.00, 8.90, 10.00, 11.10, 12.50, 13.90, 15.60, NULL, NULL),
(20, 8.10, 9.10, 10.10, 11.30, 12.70, 14.20, 15.90, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bb-perempuan`
--

CREATE TABLE `bb-perempuan` (
  `UMUR` int(11) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bb-perempuan`
--

INSERT INTO `bb-perempuan` (`UMUR`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(0, 2.00, 2.40, 2.80, 3.20, 3.70, 4.20, 4.80, NULL, NULL),
(1, 2.70, 3.20, 3.60, 4.20, 4.80, 5.50, 6.20, NULL, NULL),
(2, 3.40, 3.90, 4.50, 5.10, 5.80, 6.60, 7.50, NULL, NULL),
(3, 4.00, 4.50, 5.20, 5.80, 6.60, 7.50, 8.50, NULL, NULL),
(4, 4.40, 5.00, 5.70, 6.40, 7.30, 8.20, 9.30, NULL, NULL),
(5, 4.80, 5.40, 6.10, 6.90, 7.80, 8.80, 10.00, NULL, NULL),
(6, 5.10, 5.70, 6.50, 7.30, 8.20, 9.30, 10.60, NULL, NULL),
(7, 5.30, 6.00, 6.80, 7.60, 8.60, 9.80, 11.10, NULL, NULL),
(8, 5.60, 6.30, 7.00, 7.90, 9.00, 10.20, 11.60, NULL, NULL),
(9, 5.80, 6.50, 7.30, 8.20, 9.30, 10.50, 12.00, NULL, NULL),
(10, 5.90, 6.70, 7.50, 8.50, 9.60, 10.90, 12.40, NULL, NULL),
(11, 6.10, 6.90, 7.70, 8.70, 9.90, 11.20, 12.80, NULL, NULL),
(12, 6.30, 7.00, 7.90, 8.90, 10.10, 11.50, 13.10, NULL, NULL),
(13, 6.40, 7.20, 8.10, 9.20, 10.40, 11.80, 13.50, NULL, NULL),
(14, 6.60, 7.40, 8.30, 9.40, 10.60, 12.10, 13.80, NULL, NULL),
(15, 6.70, 7.60, 8.50, 9.60, 10.90, 12.40, 14.10, NULL, NULL),
(16, 6.90, 7.70, 8.70, 9.80, 11.10, 12.60, 14.50, NULL, NULL),
(17, 7.00, 7.90, 8.90, 10.00, 11.40, 12.90, 14.80, NULL, NULL),
(18, 7.20, 8.10, 9.10, 10.20, 11.60, 13.20, 15.10, NULL, NULL),
(19, 7.30, 8.20, 9.20, 10.40, 11.80, 13.50, 15.40, NULL, NULL),
(20, 7.50, 8.40, 9.40, 10.60, 12.10, 13.70, 15.70, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bbtb-laki-laki`
--

CREATE TABLE `bbtb-laki-laki` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `TB` decimal(5,1) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bbtb-laki-laki`
--

INSERT INTO `bbtb-laki-laki` (`id`, `TB`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(1, 45.0, 1.90, 2.00, 2.20, 2.40, 2.70, 3.00, 3.30, NULL, NULL),
(2, 45.5, 1.90, 2.10, 2.30, 2.50, 2.80, 3.10, 3.40, NULL, NULL),
(3, 46.0, 2.00, 2.20, 2.40, 2.60, 2.90, 3.10, 3.50, NULL, NULL),
(4, 46.5, 2.10, 2.30, 2.50, 2.70, 3.00, 3.20, 3.60, NULL, NULL),
(5, 47.0, 2.10, 2.30, 2.50, 2.80, 3.00, 3.30, 3.70, NULL, NULL),
(6, 47.5, 2.20, 2.40, 2.60, 2.90, 3.10, 3.40, 3.80, NULL, NULL),
(7, 48.0, 2.30, 2.50, 2.70, 2.90, 3.20, 3.60, 3.90, NULL, NULL),
(8, 48.5, 2.30, 2.60, 2.80, 3.00, 3.30, 3.70, 4.00, NULL, NULL),
(9, 49.0, 2.40, 2.60, 2.90, 3.10, 3.40, 3.80, 4.20, NULL, NULL),
(10, 49.5, 2.50, 2.70, 3.00, 3.20, 3.50, 3.90, 4.30, NULL, NULL),
(11, 50.0, 2.60, 2.80, 3.00, 3.30, 3.60, 4.00, 4.40, NULL, NULL),
(12, 50.5, 2.70, 2.90, 3.10, 3.40, 3.80, 4.10, 4.50, NULL, NULL),
(13, 51.0, 2.70, 3.00, 3.20, 3.50, 3.90, 4.20, 4.70, NULL, NULL),
(14, 51.5, 2.80, 3.10, 3.30, 3.60, 4.00, 4.40, 4.80, NULL, NULL),
(15, 52.0, 2.90, 3.20, 3.50, 3.80, 4.10, 4.50, 5.00, NULL, NULL),
(16, 52.5, 3.00, 3.30, 3.60, 3.90, 4.20, 4.60, 5.10, NULL, NULL),
(17, 53.0, 3.10, 3.40, 3.70, 4.00, 4.40, 4.80, 5.30, NULL, NULL),
(18, 53.5, 3.20, 3.50, 3.80, 4.10, 4.50, 4.90, 5.40, NULL, NULL),
(19, 54.0, 3.30, 3.60, 3.90, 4.30, 4.70, 5.10, 5.60, NULL, NULL),
(20, 54.5, 3.40, 3.70, 4.00, 4.40, 4.80, 5.30, 5.80, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bbtb-perempuan`
--

CREATE TABLE `bbtb-perempuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `TB` decimal(5,1) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bbtb-perempuan`
--

INSERT INTO `bbtb-perempuan` (`id`, `TB`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(1, 45.0, 1.90, 2.10, 2.30, 2.50, 2.70, 3.00, 3.30, NULL, NULL),
(2, 45.5, 2.00, 2.10, 2.30, 2.50, 2.80, 3.10, 3.40, NULL, NULL),
(3, 46.0, 2.00, 2.20, 2.40, 2.60, 2.90, 3.20, 3.50, NULL, NULL),
(4, 46.5, 2.10, 2.30, 2.50, 2.70, 3.00, 3.30, 3.60, NULL, NULL),
(5, 47.0, 2.20, 2.40, 2.60, 2.80, 3.10, 3.40, 3.70, NULL, NULL),
(6, 47.5, 2.20, 2.40, 2.60, 2.90, 3.20, 3.50, 3.80, NULL, NULL),
(7, 48.0, 2.30, 2.50, 2.70, 3.00, 3.30, 3.60, 4.00, NULL, NULL),
(8, 48.5, 2.40, 2.60, 2.80, 3.10, 3.40, 3.70, 4.10, NULL, NULL),
(9, 49.0, 2.40, 2.60, 2.90, 3.20, 3.50, 3.80, 4.20, NULL, NULL),
(10, 49.5, 2.50, 2.70, 3.00, 3.30, 3.60, 3.90, 4.30, NULL, NULL),
(11, 50.0, 2.60, 2.80, 3.00, 3.40, 3.70, 4.00, 4.50, NULL, NULL),
(12, 50.5, 2.70, 2.90, 3.10, 3.50, 3.80, 4.10, 4.60, NULL, NULL),
(13, 51.0, 2.80, 3.00, 3.20, 3.60, 3.90, 4.20, 4.70, NULL, NULL),
(14, 51.5, 2.80, 3.10, 3.30, 3.70, 4.00, 4.40, 4.90, NULL, NULL),
(15, 52.0, 2.90, 3.20, 3.50, 3.80, 4.10, 4.50, 5.00, NULL, NULL),
(16, 52.5, 3.00, 3.30, 3.60, 3.90, 4.20, 4.60, 5.10, NULL, NULL),
(17, 53.0, 3.10, 3.40, 3.70, 4.00, 4.40, 4.80, 5.30, NULL, NULL),
(18, 53.5, 3.20, 3.50, 3.80, 4.20, 4.50, 4.90, 5.40, NULL, NULL),
(19, 54.0, 3.30, 3.60, 3.90, 4.30, 4.70, 5.10, 5.60, NULL, NULL),
(20, 54.5, 3.40, 3.70, 4.00, 4.40, 4.80, 5.30, 5.90, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_location` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius` double(15,2) NOT NULL,
  `value` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `name_location`, `latitude`, `longitude`, `radius`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Surabaya', -7.25750000, 112.75210000, 31068.31, 55.00, '2024-06-25 22:50:18', '2024-06-25 22:50:18'),
(2, 'Malang', -7.96660000, 112.63260000, 31068.31, 20.00, '2024-06-25 22:50:18', '2024-06-25 22:50:18'),
(3, 'Sidoarjo', -7.44780000, 112.71810000, 31068.31, 5.00, '2024-06-25 22:50:18', '2024-06-25 22:50:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_27_143418_create_location_table', 1),
(6, '2024_05_11_083408_pasien', 1),
(7, '2024_05_11_171319_bblaki', 1),
(8, '2024_05_11_171718_tblaki', 1),
(9, '2024_05_11_172411_bbperempuan', 1),
(10, '2024_05_11_172805_tbperempuan', 1),
(11, '2024_06_08_162327_bbtblaki', 1),
(12, '2024_06_08_162336_bbtbperempuan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `id_location` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengukuran` date NOT NULL,
  `umur` int(11) NOT NULL,
  `berat_badan` decimal(8,2) NOT NULL,
  `tinggi_badan` decimal(8,2) NOT NULL,
  `status_gizi` enum('stunting','normal','obesitas') NOT NULL,
  `status_tinggi` enum('pendek','normal','tinggi') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nik`, `nama`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `id_location`, `tanggal_pengukuran`, `umur`, `berat_badan`, `tinggi_badan`, `status_gizi`, `status_tinggi`, `created_at`, `updated_at`) VALUES
(1, '3578072009002001', 'Faris Ardiansyah Putra', 'Mojo, Surabaya', '2024-02-20', 'laki-laki', 1, '2024-06-26', 4, 0.00, 0.00, 'normal', 'normal', '2024-06-25 23:58:22', '2024-06-25 23:58:22'),
(2, '3578072009002001', 'Faris Ardiansyah Putra', 'Mojo, Surabaya', '2024-02-20', 'laki-laki', 1, '2024-06-26', 4, 3.00, 50.00, 'normal', 'normal', '2024-06-25 23:58:35', '2024-06-25 23:58:35'),
(3, '3578072009002001', 'Faris Ardiansyah Putra', 'Mojo, Surabaya', '2024-02-20', 'laki-laki', 1, '2024-06-26', 4, 12.00, 50.00, 'normal', 'normal', '2024-06-25 23:58:58', '2024-06-26 00:07:47'),
(6, '3567829009020001', 'Muhammad Aditya Jihanto', 'Buduran, Sidoarjo', '2024-03-02', 'laki-laki', 3, '2024-06-26', 3, 0.00, 0.00, 'normal', 'normal', '2024-06-26 00:08:28', '2024-06-26 00:08:28'),
(7, '3567829009020001', 'Muhammad Aditya Jihanto', 'Buduran, Sidoarjo', '2024-03-02', 'laki-laki', 3, '2024-06-26', 3, 12.00, 60.00, 'normal', 'normal', '2024-06-26 00:08:52', '2024-06-26 00:08:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb-laki-laki`
--

CREATE TABLE `tb-laki-laki` (
  `UMUR` int(11) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb-laki-laki`
--

INSERT INTO `tb-laki-laki` (`UMUR`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(0, 44.20, 46.10, 48.00, 49.90, 51.80, 53.70, 55.60, NULL, NULL),
(1, 48.90, 50.80, 52.80, 54.70, 56.70, 58.60, 60.60, NULL, NULL),
(2, 52.40, 54.40, 56.40, 58.40, 60.40, 62.40, 64.40, NULL, NULL),
(3, 55.30, 57.30, 59.40, 61.40, 63.50, 65.50, 67.60, NULL, NULL),
(4, 57.60, 59.70, 61.80, 63.90, 66.00, 68.00, 70.10, NULL, NULL),
(5, 59.60, 61.70, 63.80, 65.90, 68.00, 70.10, 72.20, NULL, NULL),
(6, 61.20, 63.30, 65.50, 67.60, 69.80, 71.90, 74.00, NULL, NULL),
(7, 62.70, 64.80, 67.00, 69.20, 71.30, 73.50, 75.70, NULL, NULL),
(8, 64.00, 66.20, 68.40, 70.60, 72.80, 75.00, 77.20, NULL, NULL),
(9, 65.20, 67.50, 69.70, 72.00, 74.20, 76.50, 78.70, NULL, NULL),
(10, 66.40, 68.70, 71.00, 73.30, 75.60, 77.90, 80.10, NULL, NULL),
(11, 67.60, 69.90, 72.20, 74.50, 76.90, 79.20, 81.50, NULL, NULL),
(12, 68.60, 71.00, 73.40, 75.70, 78.10, 80.50, 82.90, NULL, NULL),
(13, 69.60, 72.10, 74.50, 76.90, 79.30, 81.80, 84.20, NULL, NULL),
(14, 70.60, 73.10, 75.60, 78.00, 80.50, 83.00, 85.50, NULL, NULL),
(15, 71.60, 74.10, 76.60, 79.10, 81.70, 84.20, 86.70, NULL, NULL),
(16, 72.50, 75.00, 77.60, 80.20, 82.80, 85.40, 88.00, NULL, NULL),
(17, 73.30, 76.00, 78.60, 81.20, 83.90, 86.50, 89.20, NULL, NULL),
(18, 74.20, 76.90, 79.60, 82.30, 85.00, 87.70, 90.40, NULL, NULL),
(19, 75.00, 77.70, 80.50, 83.20, 86.00, 88.80, 91.50, NULL, NULL),
(20, 75.80, 78.60, 81.40, 84.20, 87.00, 89.80, 92.60, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb-perempuan`
--

CREATE TABLE `tb-perempuan` (
  `UMUR` int(11) NOT NULL,
  `N3SD` decimal(8,2) NOT NULL,
  `N2SD` decimal(8,2) NOT NULL,
  `N1SD` decimal(8,2) NOT NULL,
  `MEDIAN` decimal(8,2) NOT NULL,
  `P1SD` decimal(8,2) NOT NULL,
  `P2SD` decimal(8,2) NOT NULL,
  `P3SD` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb-perempuan`
--

INSERT INTO `tb-perempuan` (`UMUR`, `N3SD`, `N2SD`, `N1SD`, `MEDIAN`, `P1SD`, `P2SD`, `P3SD`, `created_at`, `updated_at`) VALUES
(0, 43.60, 45.40, 47.30, 49.10, 51.00, 52.90, 54.70, NULL, NULL),
(1, 47.80, 49.80, 51.70, 53.70, 55.60, 57.60, 59.50, NULL, NULL),
(2, 51.00, 53.00, 55.00, 57.10, 59.10, 61.10, 63.20, NULL, NULL),
(3, 53.50, 55.60, 57.70, 59.80, 61.90, 64.00, 66.10, NULL, NULL),
(4, 55.60, 57.80, 59.90, 62.10, 64.30, 66.40, 68.60, NULL, NULL),
(5, 57.40, 59.60, 61.80, 64.00, 66.20, 68.50, 70.70, NULL, NULL),
(6, 58.90, 61.20, 63.50, 65.70, 68.00, 70.30, 72.50, NULL, NULL),
(7, 60.30, 62.70, 65.00, 67.30, 69.60, 71.90, 74.20, NULL, NULL),
(8, 61.70, 64.00, 66.40, 68.70, 71.10, 73.50, 75.80, NULL, NULL),
(9, 62.90, 65.30, 67.70, 70.10, 72.60, 75.00, 77.40, NULL, NULL),
(10, 64.10, 66.50, 69.00, 71.50, 73.90, 76.40, 78.90, NULL, NULL),
(11, 65.20, 67.70, 70.30, 72.80, 75.30, 77.80, 80.30, NULL, NULL),
(12, 66.30, 68.90, 71.40, 74.00, 76.60, 79.20, 81.70, NULL, NULL),
(13, 67.30, 70.00, 72.60, 75.20, 77.80, 80.50, 83.10, NULL, NULL),
(14, 68.30, 71.00, 73.70, 76.40, 79.10, 81.70, 84.40, NULL, NULL),
(15, 69.30, 72.00, 74.80, 77.50, 80.20, 83.00, 85.70, NULL, NULL),
(16, 70.20, 73.00, 75.80, 78.60, 81.40, 84.20, 87.00, NULL, NULL),
(17, 71.10, 74.00, 76.80, 79.70, 82.50, 85.40, 88.20, NULL, NULL),
(18, 72.00, 74.90, 77.80, 80.70, 83.60, 86.50, 89.40, NULL, NULL),
(19, 72.80, 75.80, 78.80, 81.70, 84.70, 87.60, 90.60, NULL, NULL),
(20, 73.70, 76.70, 79.70, 82.70, 85.70, 88.70, 91.70, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', '2024-06-25 22:50:19', '$2y$12$epHRecYeCsMvm9vBY6bAmOLlcg0ujKvEbhPY517eiuuHD5KLV1V4y', 'XL3vELzDoq', '2024-06-25 22:50:19', '2024-06-25 22:50:19'),
(2, 'Guest', 'Guest', 'guest@guest.com', '2024-06-25 22:50:19', '$2y$12$6VJQM12opuRsv1k9DcUQo.NARfGM8AXftzP2sTyhWKP97bwzawVY2', 'uAi5L65F7s', '2024-06-25 22:50:19', '2024-06-25 22:50:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bb-laki-laki`
--
ALTER TABLE `bb-laki-laki`
  ADD PRIMARY KEY (`UMUR`);

--
-- Indeks untuk tabel `bb-perempuan`
--
ALTER TABLE `bb-perempuan`
  ADD PRIMARY KEY (`UMUR`);

--
-- Indeks untuk tabel `bbtb-laki-laki`
--
ALTER TABLE `bbtb-laki-laki`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bbtb-perempuan`
--
ALTER TABLE `bbtb-perempuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id_location_foreign` (`id_location`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `tb-laki-laki`
--
ALTER TABLE `tb-laki-laki`
  ADD PRIMARY KEY (`UMUR`);

--
-- Indeks untuk tabel `tb-perempuan`
--
ALTER TABLE `tb-perempuan`
  ADD PRIMARY KEY (`UMUR`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bbtb-laki-laki`
--
ALTER TABLE `bbtb-laki-laki`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `bbtb-perempuan`
--
ALTER TABLE `bbtb-perempuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_id_location_foreign` FOREIGN KEY (`id_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
