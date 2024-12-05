-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2019 at 03:38 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm-spa`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `code`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Trị Hôi Nách', 'tri_hoi_nach', NULL, 1, '2019-05-02 17:05:30', '2019-06-02 15:36:09'),
(2, 'Triệt lông', 'triet_long', NULL, 1, '2019-05-02 17:05:46', '2019-05-02 17:05:46'),
(3, 'Tắm Trắng', 'tam_trang', NULL, 0, '2019-07-27 16:38:23', '2019-07-27 16:38:23'),
(4, 'Hồng Nhũ Hoa', 'hong_nhu_hoa', NULL, 0, '2019-07-27 16:38:44', '2019-07-27 16:38:44'),
(5, 'Trị Mụn', 'tri_mun', NULL, 0, '2019-08-05 09:24:27', '2019-08-05 09:24:27'),
(6, 'Dịch Vụ Khác', 'dich_vu_khac', NULL, 0, '2019-08-10 10:27:59', '2019-08-10 10:27:59'),
(8, 'Giảm béo', 'giam_beo', NULL, 0, '2019-08-13 03:48:23', '2019-08-13 03:48:23'),
(9, 'Trị sẹo', 'tri_seo', NULL, 0, '2019-08-13 09:32:34', '2019-08-13 09:32:34'),
(10, 'Phun Thêu', 'phun_theu', NULL, 0, '2019-08-23 02:43:20', '2019-08-23 02:43:20'),
(11, 'Mỹ phẩm', 'my_pham', NULL, 0, '2019-08-23 02:45:34', '2019-08-23 02:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `combo_services`
--

CREATE TABLE `combo_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rose_price` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hoa hồng',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commissions`
--

INSERT INTO `commissions` (`id`, `order_id`, `customer_id`, `rose_price`, `note`, `created_at`, `updated_at`) VALUES
(1, 8, '[\"2\"]', '[\"160000\"]', 'Giang up sale thành công khách đơn 3200k', '2019-06-09 18:10:07', '2019-06-09 18:10:07'),
(2, 1, '[\"2\"]', '[\"20000\"]', NULL, '2019-07-24 16:21:22', '2019-07-24 16:21:22'),
(3, 10, '[\"2\"]', '[\"20000\"]', NULL, '2019-07-29 13:12:29', '2019-07-29 13:12:29'),
(4, 16, '[\"2\"]', '[\"30000\"]', 'Tôi được 30k nhé', '2019-08-05 15:53:37', '2019-08-05 15:53:37'),
(5, 17, '[\"5\"]', '[\"20000\"]', NULL, '2019-08-05 16:52:05', '2019-08-05 16:52:05'),
(6, 24, '[\"2\"]', '[\"20000\"]', NULL, '2019-08-06 17:28:55', '2019-08-06 17:28:55'),
(7, 26, '[\"10\",\"9\"]', '[\"40000\",\"20000\"]', NULL, '2019-08-18 09:38:30', '2019-08-22 10:15:39'),
(8, 29, '[\"9\"]', '[\"20000\"]', NULL, '2019-08-22 10:50:27', '2019-08-22 10:50:27'),
(9, 35, '[\"10\"]', '[\"20000\"]', NULL, '2019-08-22 10:52:31', '2019-08-22 10:52:31'),
(10, 37, '[\"9\"]', '[\"20000\"]', NULL, '2019-08-23 02:50:13', '2019-08-23 02:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mkt_id` int(11) NOT NULL COMMENT 'Nhân viên Marketing',
  `telesales_id` int(11) DEFAULT NULL COMMENT 'Nhân viên Telesales',
  `group_id` int(11) DEFAULT '0' COMMENT 'Nhóm khách hàng (khách hàng thuộc danh mục dịch vụ)',
  `source_id` int(11) DEFAULT '0' COMMENT 'id nguồn khách hàng : facebook, zalo, google',
  `status_id` int(11) DEFAULT '0' COMMENT 'Mối quan hệ : mới, chua kết nối ...',
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã khách hàng',
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Địa chỉ khách hàng',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` int(11) NOT NULL COMMENT '0: Nữ| 1: Nam',
  `description` text COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Link Facebook',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `mkt_id`, `telesales_id`, `group_id`, `source_id`, `status_id`, `full_name`, `account_code`, `address`, `phone`, `birthday`, `gender`, `description`, `facebook`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 1, 18, 1, 'Chị Linh', 'KH1', 'Số 35 bùi xương trạch, thanh xuân , Hà nội', '0975091434', '1995-07-07', 1, 'Không có gì', 'fb.com/bibixu', '2019-06-26 17:33:34', '2019-08-19 02:42:41', NULL),
(2, 1, 2, 1, 19, 2, 'KH2', NULL, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', '0353997108', '1996-07-13', 1, 'nulllll', 'fb.com/bibixu', '2019-07-07 05:17:11', '2019-07-26 11:55:46', NULL),
(3, 6, 2, 1, 20, 2, 'Sỹ', NULL, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', '0334299996', '2019-07-01', 1, NULL, NULL, '2019-07-26 04:35:27', '2019-08-06 08:16:34', NULL),
(4, 6, 2, 1, 18, 1, 'Sỹ', NULL, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', '0334499996', '2019-07-01', 1, 'ưdeqeq', NULL, '2019-07-26 06:50:59', '2019-08-29 07:03:46', NULL),
(5, 12, 10, 6, 18, 2, 'Đỗ Thị Thu Trang', NULL, NULL, '965876365', '2019-08-13', 0, 'Giảm béo bụng', 'https://www.facebook.com/profile.php?id=100019038722279', '2019-08-13 03:12:57', '2019-08-13 03:14:20', NULL),
(6, 12, 10, 1, 18, 1, 'Đặng Bảo', NULL, NULL, '962538444', '2019-08-13', 1, NULL, 'https://www.facebook.com/profile.php?id=100029207670033', '2019-08-13 03:18:10', '2019-08-13 03:18:10', NULL),
(7, 12, 10, 1, 18, 1, 'Trần Quang Định', NULL, NULL, '369118444', '2019-08-13', 1, NULL, NULL, '2019-08-13 03:19:14', '2019-08-13 03:19:14', NULL),
(8, 12, 10, 1, 18, 1, 'YuGi Oh', NULL, NULL, '866955668', '2019-08-13', 0, NULL, 'https://www.facebook.com/khacduy.nguyen01', '2019-08-13 03:20:13', '2019-08-22 14:41:31', '2019-08-22 14:41:31'),
(9, 12, 10, 1, 18, 1, 'Phuong Hoang', NULL, NULL, '978420933', '2019-08-13', 0, NULL, 'https://www.facebook.com/profile.php?id=100012022110676', '2019-08-13 03:22:00', '2019-08-13 03:22:00', NULL),
(10, 13, 10, 1, 21, 14, 'Chị Trang', NULL, 'thái nguyên', '0386527365', '2019-08-18', 0, 'lần sau muốn triệt thêm nách', NULL, '2019-08-18 09:49:39', '2019-08-26 03:10:23', '2019-08-26 03:10:23'),
(11, 9, 10, 2, 18, 1, 'TEST', NULL, 'thái nguyên', '0325669', '2019-09-03', 0, NULL, NULL, '2019-08-22 10:49:00', '2019-09-03 14:59:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'id kh',
  `category_id` int(11) NOT NULL COMMENT 'id danh muc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `customer_id`, `category_id`) VALUES
(1, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên phòng ban',
  `parent_id` int(11) NOT NULL DEFAULT '1' COMMENT 'trực thuộc phòng ban',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Mô tả',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `parent_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ban Giám Đốc', 0, NULL, '2019-06-26 17:31:29', '2019-08-06 03:20:49'),
(2, 'Marketing', 1, NULL, '2019-06-28 14:37:29', '2019-06-28 14:37:49'),
(3, 'TELESALE', 1, NULL, '2019-06-28 14:38:42', '2019-06-28 14:38:42'),
(4, 'LỄ TÂN', 1, NULL, '2019-06-28 14:39:06', '2019-06-28 14:39:06'),
(9, 'Chăm sóc khách hàng', 1, 'phòng ban chăm sóc khách hàng', '2019-09-01 14:55:28', '2019-09-01 14:55:28'),
(10, 'Tư vấn viên', 1, 'Phòng ban tổng hợp tư vấn viên', '2019-09-01 14:56:05', '2019-09-01 14:56:05'),
(11, 'Kỹ thuật viên', 1, 'Phòng tổng hợp kỹ thuật viên', '2019-09-01 14:56:35', '2019-09-01 14:56:35'),
(12, 'Kế toán', 1, 'Phòng kế toán', '2019-09-01 15:00:44', '2019-09-01 15:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `group_comments`
--

CREATE TABLE `group_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'id khách hàng',
  `user_id` int(11) NOT NULL COMMENT 'id nhân viên',
  `messages` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_comments`
--

INSERT INTO `group_comments` (`id`, `customer_id`, `user_id`, `messages`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '<div>Quang test comment lần 1</div>', '2019-07-16 17:58:20', '2019-07-16 17:58:20'),
(2, 1, 6, '<div>adahdjsbfjsbj</div>', '2019-07-17 05:17:55', '2019-07-17 05:17:55'),
(3, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-05 01:28:06', '2019-08-05 01:28:06'),
(4, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-05 01:28:08', '2019-08-05 01:28:08'),
(5, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-05 01:28:10', '2019-08-05 01:28:10'),
(6, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-05 01:28:13', '2019-08-05 01:28:13'),
(7, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-05 01:28:15', '2019-08-05 01:28:15'),
(8, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-05 01:28:18', '2019-08-05 01:28:18'),
(9, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-06 01:37:47', '2019-08-06 01:37:47'),
(10, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-06 01:37:50', '2019-08-06 01:37:50'),
(11, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 3400000', '2019-08-06 01:37:54', '2019-08-06 01:37:54'),
(12, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-06 01:37:57', '2019-08-06 01:37:57'),
(13, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-06 01:38:00', '2019-08-06 01:38:00'),
(14, 3, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-06 01:38:02', '2019-08-06 01:38:02'),
(15, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-06 01:38:05', '2019-08-06 01:38:05'),
(16, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-12 01:28:18', '2019-08-12 01:28:18'),
(17, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-12 01:28:21', '2019-08-12 01:28:21'),
(18, 2, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-13 03:20:23', '2019-08-13 03:20:23'),
(19, 3, 9, 'Tin hệ thống : linhchum đã xóa đơn hàng trị giá 1400000', '2019-08-22 10:29:09', '2019-08-22 10:29:09'),
(20, 3, 9, 'Tin hệ thống : linhchum đã xóa đơn hàng trị giá 400000', '2019-08-22 10:29:13', '2019-08-22 10:29:13'),
(21, 3, 9, 'Tin hệ thống : linhchum đã xóa đơn hàng trị giá 800000', '2019-08-22 10:29:17', '2019-08-22 10:29:17'),
(22, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 800000', '2019-08-22 14:41:00', '2019-08-22 14:41:00'),
(23, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-22 14:41:06', '2019-08-22 14:41:06'),
(24, 3, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1400000', '2019-08-22 14:41:09', '2019-08-22 14:41:09'),
(25, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 2000000', '2019-08-22 14:41:13', '2019-08-22 14:41:13'),
(26, 10, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 1399000', '2019-08-22 14:41:16', '2019-08-22 14:41:16'),
(27, 1, 6, 'Tin hệ thống : Anh Sỹ đã xóa đơn hàng trị giá 800000', '2019-08-22 14:41:18', '2019-08-22 14:41:18');

-- --------------------------------------------------------

--
-- Table structure for table `list_calls`
--

CREATE TABLE `list_calls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_18_150615_create_categories_table', 1),
(4, '2019_04_18_150849_create_services_table', 1),
(5, '2019_04_18_151510_create_products_table', 1),
(7, '2019_04_18_151847_create_promotions_table', 1),
(8, '2019_04_18_152202_create_list_calls_table', 1),
(12, '2019_04_21_054118_create_settings_table', 1),
(13, '2019_05_26_082304_add_address_to_users', 2),
(19, '2019_04_18_152336_create_orders_table', 3),
(20, '2019_04_18_152852_create_order_detail_table', 4),
(21, '2019_05_26_085613_add_address_to_order_detail', 5),
(22, '2019_05_26_085838_add_vat_to_order_detail', 5),
(23, '2019_05_26_085903_add_percent_discount_to_order_detail', 5),
(24, '2019_05_26_085923_add_number_discount_to_order_detail', 5),
(25, '2019_05_26_103201_add_price_to_order_detail', 5),
(26, '2019_06_03_143209_add_count_day_and_the_rest_and_description_to_orders', 6),
(27, '2019_06_08_070324_add_account_code_and_description_to_users', 7),
(28, '2019_06_08_103811_add_gross_revenue_to_orders', 8),
(29, '2019_04_21_040042_create_status_table', 9),
(30, '2019_06_08_145630_add_facebook_to_users', 10),
(31, '2019_06_09_144342_create_commissions_table', 11),
(32, '2019_06_11_154523_add_payment_type_and_payment_date_to_orders', 12),
(33, '2019_06_14_151919_create_payment_histories_table', 13),
(35, '2019_06_15_132455_create_schedules_table', 14),
(36, '2019_06_23_042137_create_customers_table', 15),
(37, '2019_06_23_054605_remove_column_from_users', 15),
(38, '2019_06_23_060505_add_department_id_to_users', 15),
(39, '2019_06_26_144910_create_departments_table', 15),
(40, '2019_06_26_145413_create_positions_table', 15),
(41, '2019_07_16_154012_create_group_comments_table', 16),
(42, '2019_07_21_115046_update_schedules_tables', 17),
(43, '2019_07_28_151850_add_deleted_at_to_orders', 18),
(44, '2019_08_13_141454_add_timestamp_to_status', 19),
(45, '2019_08_18_065716_add_deleted_at_to_customers', 20),
(46, '2019_04_18_151625_create_combo_services_table', 21),
(47, '2019_08_28_094338_create_setting_customers_table', 21),
(48, '2019_09_01_142720_create_user_groups_tables', 22);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` int(11) NOT NULL,
  `all_total` bigint(20) NOT NULL,
  `count_day` int(11) NOT NULL DEFAULT '0',
  `the_rest` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `gross_revenue` bigint(20) DEFAULT NULL COMMENT 'Doanh thu',
  `payment_type` tinyint(4) DEFAULT NULL COMMENT '1: Tiền mặt| 2: Thẻ',
  `payment_date` date DEFAULT NULL COMMENT 'Ngày thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `member_id`, `all_total`, `count_day`, `the_rest`, `description`, `gross_revenue`, `payment_type`, `payment_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 2, 1400000, 0, 0, NULL, 1400000, 2, '2019-08-14', '2019-07-28 15:52:01', '2019-08-05 01:28:18', '2019-08-05 01:28:18'),
(11, 2, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-07-29 13:11:58', '2019-08-05 01:28:15', '2019-08-05 01:28:15'),
(12, 2, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-01 06:45:53', '2019-08-05 01:28:13', '2019-08-05 01:28:13'),
(13, 1, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-03 06:34:21', '2019-08-05 01:28:10', '2019-08-05 01:28:10'),
(14, 2, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-03 11:27:08', '2019-08-05 01:28:08', '2019-08-05 01:28:08'),
(15, 2, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-05 01:20:09', '2019-08-05 01:28:06', '2019-08-05 01:28:06'),
(16, 1, 1400000, 0, 400000, NULL, 1000000, 1, '2019-08-05', '2019-08-05 01:33:25', '2019-08-06 01:37:50', '2019-08-06 01:37:50'),
(17, 1, 1400000, 0, 400000, NULL, 1000000, 1, '2019-08-05', '2019-08-05 15:52:45', '2019-08-06 01:37:57', '2019-08-06 01:37:57'),
(18, 2, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-05 16:55:32', '2019-08-06 01:37:47', '2019-08-06 01:37:47'),
(19, 1, 3400000, 0, 3400000, NULL, NULL, NULL, NULL, '2019-08-05 17:01:13', '2019-08-06 01:37:54', '2019-08-06 01:37:54'),
(20, 1, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-06 01:22:47', '2019-08-06 01:38:00', '2019-08-06 01:38:00'),
(21, 3, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-06 01:23:24', '2019-08-06 01:38:02', '2019-08-06 01:38:02'),
(22, 1, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-06 01:37:12', '2019-08-06 01:38:05', '2019-08-06 01:38:05'),
(23, 2, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-06 17:27:38', '2019-08-12 01:28:18', '2019-08-12 00:00:00'),
(24, 2, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-06 17:28:03', '2019-08-12 01:28:21', '2019-08-12 01:28:21'),
(25, 2, 2000000, 0, 1000000, NULL, 1000000, NULL, '2019-08-12', '2019-08-12 04:27:30', '2019-08-13 03:20:23', '2019-08-13 03:20:23'),
(26, 3, 1400000, 4, 0, NULL, 1400000, 1, '2019-08-22', '2019-08-18 09:23:11', '2019-08-22 10:29:09', '2019-08-22 10:29:09'),
(27, 3, 400000, 0, 400000, NULL, NULL, NULL, NULL, '2019-08-18 09:23:14', '2019-08-22 10:29:13', '2019-08-22 10:29:13'),
(28, 3, 800000, 0, 800000, NULL, NULL, NULL, NULL, '2019-08-18 09:37:51', '2019-08-22 10:29:17', '2019-08-22 10:29:17'),
(29, 3, 1400000, 0, 400000, NULL, 1000000, 1, '2019-08-22', '2019-08-18 09:40:13', '2019-08-22 14:41:09', '2019-08-22 14:41:09'),
(30, 10, 1399000, 0, 1399000, NULL, NULL, NULL, NULL, '2019-08-22 10:14:49', '2019-08-22 14:41:16', '2019-08-22 14:41:16'),
(31, 1, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-22 10:19:44', '2019-08-22 14:41:06', '2019-08-22 14:41:06'),
(32, 1, 800000, 0, 800000, NULL, NULL, NULL, NULL, '2019-08-22 10:21:52', '2019-08-22 14:41:00', '2019-08-22 14:41:00'),
(33, 1, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-22 10:24:45', '2019-08-22 14:41:13', '2019-08-22 14:41:13'),
(34, 1, 800000, 0, 800000, NULL, NULL, NULL, NULL, '2019-08-22 10:45:47', '2019-08-22 14:41:18', '2019-08-22 14:41:18'),
(35, 11, 2400000, 0, 1400000, NULL, 1000000, 1, '2019-08-22', '2019-08-22 10:49:51', '2019-08-22 10:52:44', NULL),
(36, 11, 2000000, 0, 2000000, NULL, NULL, NULL, NULL, '2019-08-22 10:51:59', '2019-08-22 10:51:59', NULL),
(37, 1, 1760000, 0, 0, NULL, 1760000, 1, '2019-08-23', '2019-08-23 02:49:06', '2019-08-23 02:53:45', NULL),
(38, 3, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-28 09:07:24', '2019-08-28 09:07:24', NULL),
(39, 4, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-08-29 07:03:46', '2019-08-29 07:03:46', NULL),
(40, 3, 1400000, 0, 1400000, NULL, NULL, NULL, NULL, '2019-09-03 15:32:09', '2019-09-03 15:32:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `bill_type` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `vat` int(11) DEFAULT NULL,
  `percent_discount` int(11) DEFAULT NULL,
  `number_discount` int(11) DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `booking_id`, `quantity`, `total_price`, `bill_type`, `user_id`, `address`, `vat`, `percent_discount`, `number_discount`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 10, 1, 3500000, NULL, 1, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 3500000, NULL, NULL),
(37, 35, 7, 1, 2000000, NULL, 11, 'thái nguyên', 0, NULL, 0, 2000000, NULL, NULL),
(38, 35, 5, 1, 400000, NULL, 11, 'thái nguyên', 0, NULL, 0, 400000, NULL, NULL),
(39, 36, 7, 1, 2000000, NULL, 11, 'thái nguyên', 0, NULL, 0, 2000000, NULL, NULL),
(40, 37, 16, 1, 860000, NULL, 1, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 860000, NULL, NULL),
(41, 37, 1, 1, 900000, NULL, 1, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 900000, NULL, NULL),
(42, 38, 8, 1, 1400000, NULL, 3, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 1400000, NULL, NULL),
(43, 39, 8, 1, 1400000, NULL, 4, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 1400000, NULL, NULL),
(44, 40, 8, 1, 1400000, NULL, 3, 'Số 35 bùi xương trạch, thanh xuân , Hà nội', 0, NULL, 0, 1400000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `price` bigint(20) DEFAULT NULL COMMENT 'Số tiền thanh toán',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Ghi chú',
  `payment_date` date DEFAULT NULL COMMENT 'Ngày thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `order_id`, `price`, `description`, `payment_date`, `created_at`, `updated_at`) VALUES
(3, 8, 2300000, NULL, '2019-06-19', '2019-06-19 13:32:56', '2019-06-19 13:32:56'),
(4, 8, 1200000, 'Trả nợ', '2019-06-20', '2019-06-19 13:33:51', '2019-06-19 13:33:51'),
(5, 1, 3000000, NULL, '2019-07-02', '2019-07-02 01:27:47', '2019-07-02 01:27:47'),
(6, 4, 3000000, NULL, '2019-07-02', '2019-07-02 01:40:16', '2019-07-02 01:40:16'),
(7, 1, 500000, NULL, '2019-07-25', '2019-07-24 16:20:45', '2019-07-24 16:20:45'),
(8, 10, 1000000, NULL, '2019-07-28', '2019-07-28 15:52:31', '2019-07-28 15:52:31'),
(9, 10, 200000, NULL, '2019-07-05', '2019-07-29 13:12:12', '2019-07-29 13:12:12'),
(10, 10, 200000, NULL, '2019-08-03', '2019-08-03 06:34:40', '2019-08-03 06:34:40'),
(11, 10, 0, NULL, '2019-08-14', '2019-08-03 11:27:29', '2019-08-03 11:27:29'),
(12, 16, 1000000, NULL, '2019-08-05', '2019-08-05 01:33:45', '2019-08-05 01:33:45'),
(13, 17, 1000000, NULL, '2019-08-05', '2019-08-05 16:51:54', '2019-08-05 16:51:54'),
(14, 25, 1000000, NULL, '2019-08-12', '2019-08-12 04:27:41', '2019-08-12 04:27:41'),
(15, 26, 1000000, NULL, '2019-08-18', '2019-08-18 09:24:36', '2019-08-18 09:24:36'),
(16, 26, 400000, NULL, '2019-08-22', '2019-08-22 10:19:58', '2019-08-22 10:19:58'),
(17, 29, 1000000, NULL, '2019-08-22', '2019-08-22 10:47:13', '2019-08-22 10:47:13'),
(18, 35, 1000000, NULL, '2019-08-22', '2019-08-22 10:52:44', '2019-08-22 10:52:44'),
(19, 37, 1760000, NULL, '2019-08-23', '2019-08-23 02:53:45', '2019-08-23 02:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(11) NOT NULL COMMENT 'id phòng ban',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên chức vụ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `department_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Trưởng phòng Marketing', '2019-06-28 14:38:09', '2019-08-22 14:43:49'),
(2, 2, 'Nhân viên Marketing', '2019-06-28 14:38:18', '2019-06-28 14:38:18'),
(3, 3, 'Trưởng phòng Telesale', '2019-08-22 14:44:15', '2019-08-22 14:44:15'),
(4, 3, 'Trưởng nhóm Telesale', '2019-08-22 14:44:24', '2019-08-22 14:44:24'),
(5, 3, 'Nhân viên Telesale', '2019-08-22 14:44:32', '2019-08-22 14:44:32'),
(6, 4, 'Nhân viên', '2019-08-22 14:45:25', '2019-09-01 14:59:40'),
(7, 1, 'Tồng giám đốc', '2019-09-01 14:54:17', '2019-09-01 14:54:17'),
(8, 1, 'ADMIN', '2019-09-01 14:57:24', '2019-09-01 14:57:24'),
(9, 2, 'Phó phòng Marketing', '2019-09-01 14:58:19', '2019-09-01 14:58:19'),
(10, 4, 'Trưởng phòng', '2019-09-01 14:59:19', '2019-09-01 14:59:33'),
(11, 9, 'Trưởng phòng', '2019-09-01 15:01:17', '2019-09-01 15:01:17'),
(12, 9, 'Nhân viên', '2019-09-01 15:01:26', '2019-09-01 15:01:26'),
(13, 12, 'Trưởng phòng', '2019-09-01 15:01:56', '2019-09-01 15:01:56'),
(14, 12, 'Nhân viên', '2019-09-01 15:02:03', '2019-09-01 15:02:03'),
(15, 11, 'Trưởng phòng', '2019-09-01 15:02:30', '2019-09-01 15:02:30'),
(16, 11, 'Nhân viên', '2019-09-01 15:02:38', '2019-09-01 15:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `trademark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `money_promotion` bigint(20) NOT NULL,
  `percent_promotion` int(11) NOT NULL,
  `time_start` date NOT NULL,
  `time_end` date NOT NULL,
  `min_price` bigint(20) NOT NULL,
  `max_discount` bigint(20) NOT NULL,
  `current_quantity` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'id khach hang',
  `date` date NOT NULL COMMENT 'Ngay hen',
  `time_from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'khoang gio som nhat',
  `time_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'khoang gio som nhat',
  `creator_id` int(11) NOT NULL COMMENT 'Nhân viên tạo',
  `status` int(11) NOT NULL COMMENT 'trạng thái lịch hẹn',
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ghi chu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `person_action` int(11) DEFAULT NULL COMMENT 'người phụ trách'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `user_id`, `date`, `time_from`, `time_to`, `creator_id`, `status`, `note`, `created_at`, `updated_at`, `person_action`) VALUES
(1, 6, '2019-06-19', '09:30', '10:30', 2, 3, 'Khách đến trị hôi nách', '2019-06-18 17:29:40', '2019-08-18 09:34:52', NULL),
(2, 2, '2019-07-07', '10:00', '10:30', 6, 3, 'Khách đến chăm sóc da mặt, có thể offsale', '2019-07-07 08:00:30', '2019-07-08 12:27:20', NULL),
(3, 1, '2019-07-07', '10:15', '10:45', 6, 5, 'Anh quang đến làm tiếp liệu trình trị mụn', '2019-07-07 08:01:26', '2019-08-06 01:25:02', NULL),
(4, 2, '2019-07-08', '12:08', '03:20', 6, 2, 'aasdasdasda', '2019-07-08 12:46:42', '2019-07-21 16:51:14', 2),
(5, 2, '2019-07-24', '15:31', '16:30', 6, 3, 'wetiuewy', '2019-07-24 00:55:02', '2019-07-24 16:15:53', 2),
(6, 2, '2019-07-25', '02:30', '07:30', 6, 2, 'Triệt lông', '2019-07-24 16:17:58', '2019-07-24 16:17:58', 4),
(7, 2, '2019-07-27', '14:30', '15:30', 6, 4, 'hh', '2019-07-26 04:27:25', '2019-07-29 13:10:53', 2),
(8, 4, '2019-08-02', '08:30', '16:20', 9, 3, 'Triệt lông - 15h15 2/8', '2019-08-02 02:53:49', '2019-08-22 10:18:42', 10),
(9, 4, '2019-08-01', '15:30', '16:30', 6, 3, 'Triệt lông', '2019-08-03 06:33:03', '2019-08-18 09:22:19', 2),
(10, 4, '2019-08-19', '06:00', '08:00', 1, 3, 'ADMIN test SMS đặt lịch', '2019-08-18 17:01:38', '2019-08-22 10:19:31', 10),
(11, 2, '2019-08-19', '12:00', '12:02', 1, 1, '555', '2019-08-19 02:44:48', '2019-08-19 02:44:48', 15),
(12, 2, '2019-08-19', '02:10', '02:17', 1, 1, '555555', '2019-08-19 02:52:03', '2019-08-19 02:52:03', 15),
(13, 3, '2019-08-19', '13:29', '14:30', 1, 1, 'HỆ THỐNG TEST', '2019-08-19 03:00:40', '2019-08-19 03:00:40', 15);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_buy` bigint(20) NOT NULL,
  `price_sell` bigint(20) NOT NULL DEFAULT '0',
  `promotion_price` bigint(20) NOT NULL,
  `trademark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `category_id`, `description`, `images`, `code`, `price_buy`, `price_sell`, `promotion_price`, `trademark`, `enable`, `created_at`, `updated_at`) VALUES
(1, 'Triệt 1/2 tay', 2, 'Cùng với khuôn mặt thanh tú và vóc dáng thon gọn thì làn da sáng mịn góp phần rất lớn tạo nên sức hút và nét đẹp dịu dàng cho mỗi chị em phụ nữ. Tuy nhiên, nhiều chị em có tuyến nang lông phát triển lại không may sở hữu vùng vi ô lông rậm rạp gây ra nhiều phiền toái và làm mất đi sự tự tin vốn có.', '[\"1ec51c758ea3f31226cafa32fd771bc8_1556817089.jpg\"]', '1', 0, 500000, 0, 'Spa', 1, '2019-05-02 17:11:29', '2019-06-02 15:36:53'),
(2, 'Triệt 1/2 chân', 2, NULL, NULL, '2', 0, 2400000, 0, 'Spa', 1, '2019-06-02 15:37:28', '2019-06-02 15:37:28'),
(3, 'Triệt cả chân', 2, NULL, NULL, '3', 0, 3400000, 0, 'Spa', 1, '2019-06-02 15:39:57', '2019-06-02 15:39:57'),
(4, 'Triệt cả tay', 2, NULL, NULL, '4', 0, 2400000, 0, NULL, 1, '2019-06-02 15:40:13', '2019-06-02 15:40:13'),
(5, 'Triệt Nách', 2, NULL, NULL, '5', 0, 400000, 0, 'Spa', 1, '2019-06-02 15:41:15', '2019-06-02 15:41:15'),
(6, 'Triệt Mép', 2, NULL, NULL, '6', 0, 800000, 0, 'Spa', 1, '2019-06-02 15:41:35', '2019-06-02 15:41:35'),
(7, 'Triệt Cả Bikini', 2, NULL, NULL, '7', 0, 2000000, 0, NULL, 1, '2019-06-02 15:42:01', '2019-06-02 15:42:01'),
(8, 'Triệt Bikini Tạo Hình', 2, NULL, NULL, '8', 0, 1400000, 0, 'Spa', 1, '2019-06-02 15:42:32', '2019-06-02 15:42:32'),
(13, 'Tắm trắng', 3, NULL, NULL, '13', 0, 0, 0, NULL, 1, '2019-08-13 09:33:29', '2019-08-13 09:33:29'),
(15, 'Phun môi', 10, NULL, NULL, '15', 0, 0, 0, NULL, 1, '2019-08-23 02:44:14', '2019-08-23 02:44:14'),
(16, 'Nước hoa hồng', 11, NULL, NULL, '16', 0, 860000, 0, NULL, 1, '2019-08-23 02:47:51', '2019-08-23 02:47:51'),
(17, 'Tế bào gốc', 11, NULL, NULL, '17', 0, 600000, 0, NULL, 1, '2019-08-23 02:58:14', '2019-08-23 02:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_customers`
--

CREATE TABLE `setting_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'id người dùng',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên cột',
  `status` tinyint(1) NOT NULL COMMENT 'Trạng thái cột: 0: inactive| 1: active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `code`, `color`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Mới', 'moi', '#ff80ff', 3, '2019-08-13 00:00:00', '2019-09-03 13:40:11'),
(2, 'Nóng', 'nong', '#ff0000', 3, '2019-08-01 00:00:00', '2019-09-03 13:40:44'),
(4, 'Chưa tiếp cận được', 'chua_tiep_can_duoc', '#0080c0', 3, '2019-08-04 00:00:00', '2019-09-03 13:41:15'),
(5, 'Tiềm năng', 'tiem_nang', '#ffffff', 3, '2019-08-08 00:00:00', '2019-08-23 11:39:19'),
(12, 'Tiềm năng cao', 'tiem_nang_cao', '#ffffff', 3, '2019-08-01 00:00:00', '2019-08-23 11:39:06'),
(13, 'Đã hẹn lịch', 'da_hen_lich', '#ff8000', 3, '2019-08-13 00:00:00', '2019-08-14 00:00:00'),
(14, 'Đã mua DV', 'da_mua_dv', '#ffffff', 3, '2019-08-02 00:00:00', '2019-08-23 11:38:36'),
(16, 'Không mua', 'khong_mua', '#408080', 3, '2019-07-10 00:00:00', '2019-07-12 00:00:00'),
(17, 'Vip 1', 'vip_1', '#ffff00', 3, '2019-06-11 00:00:00', '2019-07-13 00:00:00'),
(18, 'Facebook', 'facebook', '#400040', 2, '2019-06-11 00:00:00', '2019-06-05 00:00:00'),
(19, 'Tool Facebook', 'tool_facebook', '#808000', 2, '2019-06-05 00:00:00', '2019-06-07 00:00:00'),
(20, 'Hotline', 'hotline', '#800080', 2, '2019-08-04 00:00:00', '2019-08-15 00:00:00'),
(21, 'Khách Giới Thiệu', 'khach_gioi_thieu', '#808080', 2, '2019-08-07 00:00:00', '2019-08-07 00:00:00'),
(22, 'Nóng', 'nong', '#ff0000', 3, '2019-08-02 00:00:00', '2019-08-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT '0',
  `active` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL COMMENT 'Phòng ban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `avatar`, `phone`, `email`, `role`, `password`, `gender`, `branch_id`, `active`, `remember_token`, `updated_at`, `created_at`, `department_id`) VALUES
(1, 'Admin', NULL, '0975091435', NULL, 1, '$2y$10$o/199f082jFNBhZz11Gsw.ZPHq.NBM5gup5udG00SLICsajjHFcgu', 1, 0, 1, NULL, '2019-07-01 05:00:00', '2019-07-01 09:00:00', NULL),
(4, 'Tùng Trương Thanh', NULL, '0699776812', 'thanhtunghb@gmail.com', 1, '$2y$10$90.LgOLzJ5DxfcA4qFOj1.jC0uOmNhkT3kxMNNPikXsWv6Akhw9Oi', 1, NULL, 1, NULL, '2019-08-04 15:19:34', '2019-06-01 08:53:00', 2),
(6, 'Anh Sỹ', NULL, '0334299996', NULL, 1, '$2y$10$bvGwXrlrO0ZViqK.ZI6LCecDMBuS8U1pp3DXF..76dIt/Oz/O2pOi', 1, NULL, 1, NULL, '2019-07-07 07:31:12', '2019-06-10 17:43:53', NULL),
(9, 'linhchum', '/images/users/2019-08-01_5d428b4d63d25.jpg', '0963977508', NULL, 1, '$2y$10$D9KoQqL1O6ddCxBU63v4FeV.CGOYbbDl.nhJF3hVaOeVHy0JHGZCq', 0, 0, 1, NULL, '2019-08-01 06:48:45', '2019-08-01 06:48:45', NULL),
(10, 'Thu Thao', NULL, '0386154136', NULL, 3, '$2y$10$z/xC3Wo/0k9LeZrqvcX/H.McM5ZzMwBrjoANY6rpLFeKBMljRUizG', 0, 0, 1, NULL, '2019-08-02 10:41:56', '2019-08-02 10:41:56', NULL),
(11, 'Adam Thiên', NULL, '0989996738', 'thientyphu@gmail.com', 1, '$2y$10$2DWUOVijRn5aWHodyWYQWec4KJ06Vet66CofCyrsfQCzkBNhOfwbe', 1, 0, 1, NULL, '2019-08-06 03:19:03', '2019-08-06 03:19:03', 1),
(12, 'Do Dinh Thao', NULL, '0386286935', NULL, 2, '$2y$10$NRXLWD3n53Jxh2ml3l0J..Id9wE1KmkDUANWSIsEoVpIy9SX1KWuG', 1, 0, 1, NULL, '2019-08-10 08:55:17', '2019-08-10 08:55:17', NULL),
(13, 'Pham Hong Gam', NULL, '0968922611', NULL, 1, '$2y$10$cUt2E.wFgpPb3Xm5TXRAcOzSB5K.26m1GTy3fcY/xG4/evmGZ6yty', 0, 0, 1, NULL, '2019-08-10 09:02:45', '2019-08-10 09:02:45', NULL),
(14, 'Nguyễn Hồng Gấm', NULL, '0386527365', NULL, 4, '$2y$10$ZSSAvasfO86KDK4WDItMgOFAk8LrnOprF6a.t4VcDUa0hoIOXBVKm', 0, 0, 1, NULL, '2019-08-18 09:27:56', '2019-08-18 09:27:37', 4),
(15, 'HỆ THỐNG TEST', NULL, '0387571919', 'quangvv123@vinsofts.net', 4, '$2y$10$cw2gfpKpgs56Bh3uAPUSY.Nu65apG.7nEEqWei/Zkymr5N.tRAed6', 1, 0, 1, NULL, '2019-08-19 02:44:19', '2019-08-19 02:44:19', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_services`
--
ALTER TABLE `combo_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_comments`
--
ALTER TABLE `group_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_calls`
--
ALTER TABLE `list_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_customers`
--
ALTER TABLE `setting_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `combo_services`
--
ALTER TABLE `combo_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `group_comments`
--
ALTER TABLE `group_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `list_calls`
--
ALTER TABLE `list_calls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `setting_customers`
--
ALTER TABLE `setting_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
