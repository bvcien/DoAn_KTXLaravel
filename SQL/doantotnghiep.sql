-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 26, 2025 lúc 05:52 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doantotnghiep`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(255) NOT NULL,
  `stk` varchar(255) NOT NULL,
  `ctk` varchar(255) NOT NULL,
  `taikhoan` varchar(255) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banks`
--

INSERT INTO `banks` (`id`, `bank`, `stk`, `ctk`, `taikhoan`, `matkhau`, `created_at`, `updated_at`) VALUES
(15, 'MBBank', '19999191003', 'BUI VAN CHIEN', '0366024144', 'Chienbui2003%', '2025-05-23 23:22:07', '2025-05-23 23:22:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `name`, `image`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Banner 01', 'Banner1742024758.jpg', '0', '2025-03-15 00:45:58', '2025-03-15 00:45:58'),
(2, 'phu 1', 'Banner.png', '1', '2025-03-15 04:15:37', '2025-03-15 04:15:37'),
(3, 'phu 2', 'Banner2.png', '2', '2025-03-15 04:15:44', '2025-03-15 04:15:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `pttt` varchar(255) NOT NULL DEFAULT 'online',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transactionDate` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bills`
--

INSERT INTO `bills` (`id`, `idUser`, `totalPrice`, `content`, `status`, `pttt`, `created_at`, `updated_at`, `transactionDate`) VALUES
(17, 18, 1200000.00, 'NTQ200317', 1, 'Online', '2025-04-12 00:42:23', '2025-04-16 01:03:09', ''),
(18, 18, 300000.00, 'NTQ200318', 1, 'Online', '2025-04-14 00:47:58', '2025-04-19 19:02:43', ''),
(25, 31, 10000.00, 'BVC200325', 1, 'Online', '2025-05-12 03:27:37', '2025-05-12 03:28:23', ''),
(26, 6, 10000.00, 'BVC200326', 1, 'Online', '2025-05-16 06:09:59', '2025-05-16 06:11:07', '16/05/2025 13:10:59'),
(27, 31, 10000.00, 'BVC200327', 0, 'Online', '2025-05-24 01:19:12', '2025-05-24 01:19:12', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bills_detail`
--

CREATE TABLE `bills_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idBill` bigint(20) UNSIGNED NOT NULL,
  `idPay` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bills_detail`
--

INSERT INTO `bills_detail` (`id`, `idBill`, `idPay`, `price`, `created_at`, `updated_at`) VALUES
(21, 17, 29, 300000.00, '2025-04-12 00:42:23', '2025-04-12 00:42:23'),
(22, 17, 31, 300000.00, '2025-04-12 00:42:23', '2025-04-12 00:42:23'),
(23, 17, 33, 300000.00, '2025-04-12 00:42:23', '2025-04-12 00:42:23'),
(24, 17, 35, 300000.00, '2025-04-12 00:42:23', '2025-04-12 00:42:23'),
(25, 18, 39, 300000.00, '2025-04-12 00:47:58', '2025-04-12 00:47:58'),
(32, 25, 82, 10000.00, '2025-05-12 03:27:37', '2025-05-12 03:27:37'),
(33, 26, 83, 10000.00, '2025-05-16 06:09:59', '2025-05-16 06:09:59'),
(34, 27, 84, 10000.00, '2025-05-24 01:19:12', '2025-05-24 01:19:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `address`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Tòa G', 'Category1741917808.jpg', 'Tam Lư - Đồng Nguyên - Từ Sơn - Bắc Ninh', 'Tòa G, kí túc xá sinh viên', '2025-03-13 19:03:28', '2025-05-06 14:24:07'),
(7, 'Tòa D', 'Category1742013641.jpg', 'Tam Lư - Đồng Nguyên - Từ Sơn - Bắc Ninh', 'Tòa D, kí túc xá sinh viên, an toàn, giá rẻ', '2025-03-14 21:40:41', '2025-05-06 14:24:14'),
(8, 'Tòa E', 'Category1742013668.jpg', 'Tam Lư - Đồng Nguyên - Từ Sơn - Bắc Ninh', 'Tòa E, kí túc xá sinh viên, toàn cho Nữ', '2025-03-14 21:41:08', '2025-05-06 14:24:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idNews` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `idUser`, `idNews`, `parent_id`, `content`, `created_at`, `updated_at`) VALUES
(8, 6, 7, NULL, 'Bài viết hay !!!', '2025-05-23 15:08:28', '2025-05-23 15:08:28'),
(9, 31, 7, 8, 'Cảm ơn bạn !!!', '2025-05-23 15:08:55', '2025-05-23 15:08:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED DEFAULT NULL,
  `idRoom` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `msv` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `members`
--

INSERT INTO `members` (`id`, `idUser`, `idRoom`, `name`, `msv`, `status`, `created_at`, `updated_at`) VALUES
(29, 19, 3, 'Trần Thị C', 'MSV002', 0, '2025-04-02 12:08:56', '2025-05-11 05:49:34'),
(30, 20, 3, 'Lê Văn Chiến', 'MSV003', 0, '2025-04-02 12:09:03', '2025-05-11 05:49:52'),
(32, 22, 5, 'Hoàng Văn E', 'MSV005', 0, '2025-04-02 12:09:13', '2025-04-02 12:09:13'),
(33, 23, 3, 'Đỗ Thị F', 'MSV006', 0, '2025-04-02 12:09:18', '2025-04-02 12:09:18'),
(34, 24, 6, 'Vũ Văn G', 'MSV007', 0, '2025-04-02 12:09:22', '2025-04-02 12:09:22'),
(35, 25, 6, 'Bùi Thị H', 'MSV008', 0, '2025-04-02 12:09:29', '2025-04-02 12:09:29'),
(37, 27, 7, 'Trịnh Thị K', 'MSV010', 0, '2025-04-02 12:09:40', '2025-04-02 12:09:40'),
(39, NULL, 3, 'Nguyen The Quang', '21111062283', 0, '2025-04-08 13:01:24', '2025-04-08 13:01:38'),
(50, 31, 1, 'Bùi Văn Chiến', '559595995', 0, '2025-05-24 01:13:21', '2025-05-24 01:14:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idSender` bigint(20) UNSIGNED DEFAULT NULL,
  `idReceiver` bigint(20) UNSIGNED DEFAULT NULL,
  `content` varchar(999) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `idSender`, `idReceiver`, `content`, `created_at`, `updated_at`) VALUES
(3, 6, NULL, 'test', '2025-04-08 07:02:41', '2025-04-08 07:02:41'),
(4, 6, NULL, 'test 2', '2025-04-08 07:03:12', '2025-04-08 07:03:12'),
(5, 6, NULL, 'test', '2025-04-08 07:15:14', '2025-04-08 07:15:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '0001_01_01_000000_create_users_table', 1),
(6, '2025_03_12_200151_create_categories_table', 1),
(7, '2025_03_12_200232_create_rooms_table', 1),
(8, '2025_03_12_200237_create_members_table', 1),
(10, '2025_03_14_195146_create_news_table', 2),
(11, '2025_03_14_195146_create_news_likes_table', 3),
(13, '2025_03_15_011334_create_pays_table', 4),
(14, '2025_03_15_072529_create_banners_table', 5),
(15, '2025_03_15_082651_create_bills_table', 6),
(16, '2025_03_15_082943_create_bills_detail_table', 7),
(17, '2025_03_15_090341_add_pttt_to_bills_table', 8),
(18, '2025_03_30_192649_create_comments_table', 9),
(19, '2025_04_07_092038_add_cccd_and_sex_to_users_table', 10),
(20, '2025_04_07_092321_add_cccd_sex_competence_to_users_table', 11),
(21, '2025_04_07_183815_create_messages_table', 12),
(22, '2025_04_08_200431_create_banks_table', 13),
(23, '2025_04_21_183626_add_type_to_rooms_table', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(9999) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `idUser`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(7, 6, 'SINH VIÊN VIẾT VỀ KÝ TÚC XÁ', 'Cuộc sống đem lại cho mỗi cá nhân con người chúng ta những trải nghiệm khác nhau. Vô vàn những cảm xúc. Cùng một ngôi nhà chung là trái đất cùng một bầu không khí trong lành nhưng lại ở những chỗ khác nhau trên trái đất tròn này. Tôi một cô sinh viên năm 3 da ngâm dáng người thấp bé và hơi tròn trĩnh. Cảm giác tự ti vẫn luôn ở trong tôi. Nó bao vây lấy tôi từng ngày. Cuộc sống chỉ có ở nhà và đến trường. Nó cứ lặp đi lặp lại khiến tôi cảm thấy\r\nchán cuộc sống này. Từ nhà đến trường mất khoảng 30 phút xe buýt cho 20 cây số,thức dậy từ năm giờ sáng và về nhà sau khi tan học ở trường. Đây là khoảng thời gian đầu năm nhất của tôi ở mảnh đất Sài Gòn nhộn nhịp này. Cảm giác cô đơn khi những đứa bạn chúng nó đều ở xa mình, mỗi lần họp lớp mình đều không đi được. Không hình dung được cái Sài Gòn này nó như thế nào. Quận một lộng lẫy xa hoa ra sao mà chỉ hình dung được ngôi trường này sao mà lớn thế, mọi người ở đây năng động quá.Còn mình một cô bé nhà quê chẳng biết gì cả. Có những cơ hội chỉ đến với mình một lần để rồi không kịp bắt lấy thì nó sẽ vụt mất.”Còn chỗ ở kí túc xá em có muốn ở không ?” .Đó là câu nói mà chị đăng kí viên nói với tôi ngày đầu làm hồ sơ nhập học ở trường. Tôi đã cười và lắc đầu thay vì nói lời từ chối.Ở trọ đến hết năm nhất đến đầu năm hai thì kí túc xá cơ sở hai ở quận chín khánh thành. Hơi xa trường nhưng tôi vẫn quyết định đăng kí ở kí túc xá vì muốn bản thân mình được hòa nhập với mọi người xung quanh hơn. Tôi còn nhớ rõ lắm cái ngày mà tên tôi nằm ở cái danh sách sinh viên được ở kí túc xá. Mừng như muốn nhảy lên rồi hét thật to vậy. Ngay sau kí hợp đồng ở văn phòng kí túc xá D1. Tôi tức tốc chạy về phòng chuyển hết đồ đạc thu dọn sẵn sàng đâu đấy từ\r\nhôm trước chạy qua thằng bạn mượn chiếc xe của nó tống hết đồ lên đó rồi chuyển ngay sang\r\nD2. Đến kí túc xá thì tôi là người đầu tiên vào phòng của mình và được chọn một trong tám cái giường. Cảm giác đầu tiên là kí túc xá lớn quá đến tận chín tầng nhìn mỏi cả mắt luôn ấy chứ. Phòng thì rộng đến cả cái toilet cũng đẹp quá trời. Chọn ngay cho mình một chiếc giường tầng trên cạnh cửa sổ để tiện ngắm cảnh. Phòng tôi đối diện kí túc xá của Giao Thông Vận Tải. Nhưng các bạn ấy chưa được ở buồn lắm.\r\nCuộc sống mới ở đây đang rất thú vị. Những thứ mới mẻ', 'New1743639221.png', '2025-04-02 17:13:41', '2025-04-02 17:13:41'),
(8, 6, 'Kích thước sân bóng đá tiêu chuẩn và những điều bạn cần biết', 'Ngày nay, khi mà bóng đá đang ngày càng trở nên phổ biến và được coi là môn thể thao vua tại Việt Nam, ngày càng có nhiều những sân bóng cỏ nhân tạo được ra đời để đáp ứng được những yêu cầu vô cùng lớn của những người đam mê trái bóng tròn. Tại Việt Nam, bên cạnh sân bóng 11 người dành cho các cầu thủ chuyên nghiệp, thì sân 7 và sân 5 được coi là hai kích thước sân bóng phổ biến và được lựa chọn bởi đại đa số anh em chơi bóng đá phong trào. Tuy nhiên, điều có thể dễ dàng nhận thấy tại các sân bóng cỏ nhân tạo tại Việt Nam hiện nay, đó chính là điều đa dạng trong kích cỡ sân bãi. Tại các sân cỏ phía Bắc nói chung và Hà Nội nói riêng, sân bóng 7 người có diện tích sân có phần bé hơn, gôn cũng nhỏ hơn khá nhiều so với các sân bóng 7 tại Hồ Chí Minh và phía Nam, nơi mà các sân bóng 5 có cường độ và cách chơi tương đồng với futsal (bóng đá trong nhà) có phần phổ biến hơn. Và liệu bạn có tò mò, đâu là kích cỡ tiêu chuẩn của các sân bóng 5,7 và 11 người hay không?', 'New1743639260.jpeg', '2025-04-02 17:14:20', '2025-04-02 17:14:20'),
(9, 6, 'Giao cấp xã quản lý trường học từ mầm non đến THCS', 'Sau khi bỏ cấp huyện, hệ thống trường mầm non, tiểu học, THCS được giao về cấp xã quản lý, theo Bộ Giáo dục và Đào tạo.\r\n\r\nTối 11/4, Bộ cho biết đề nghị các địa phương rà soát, xác định những nội dung đang thuộc quản lý của cấp huyện để chuyển về cấp tỉnh và xã. Việc chuyển giao theo nguyên tắc: cấp tiếp nhận phải đủ cơ sở vật chất, tài chính, nhân lực để duy trì hoạt động, phát triển giáo dục; phân biệt rõ nhiệm vụ chuyên môn và nhiệm vụ hành chính.\r\n\r\nCác tỉnh, thành giữ nguyên trạng trường học, chuyển giao cho chính quyền cấp xã quản lý bậc mầm non, tiểu học, THCS, thay vì huyện như hiện nay.\r\n\r\nCông tác tuyển dụng, sắp xếp, điều động giáo viên sẽ do Sở Giáo dục và Đào tạo (cấp tỉnh) thực hiện, nhằm khắc phục tình trạng thừa, thiếu nhân lực cục bộ. Hiện, cấp huyện đảm nhận nhiệm vụ này với bậc mầm non, tiểu học, THCS; cấp tỉnh phụ trách giáo viên THPT.\r\n\r\nTrong quá trình chuyển giao, Bộ đề nghị địa phương không để xảy ra khoảng trống, chồng chéo hoặc phân tán quản lý, nhất là các lĩnh vực then chốt như chuyên môn, nội dung chương trình, quản lý giáo viên, tài chính, cơ sở vật chất trường học...\r\n\r\nTất cả nhằm duy trì, nâng cao chất lượng hoạt động của các trường công lập khi thực hiện chính quyền địa phương hai cấp (tỉnh và xã).', 'New1744442946.jpg', '2025-04-12 00:27:29', '2025-04-12 00:29:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_like`
--

CREATE TABLE `news_like` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idNew` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news_like`
--

INSERT INTO `news_like` (`id`, `idUser`, `idNew`, `status`, `created_at`, `updated_at`) VALUES
(5, 6, 8, '1', '2025-04-12 02:26:12', '2025-04-12 02:26:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pays`
--

CREATE TABLE `pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idMember` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `time_at` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pays`
--

INSERT INTO `pays` (`id`, `idMember`, `price`, `time_at`, `time_out`, `note`, `status`, `created_at`, `updated_at`) VALUES
(72, 30, 200.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16'),
(74, 33, 200.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16'),
(75, 34, 300000.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16'),
(76, 35, 300000.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16'),
(77, 37, 400000.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16'),
(78, 39, 200.00, '2024-11-10 17:00:00', '2025-11-10 17:00:00', NULL, '0', '2025-05-08 07:37:16', '2025-05-08 07:37:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `idCategory` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `image`, `quantity`, `price`, `description`, `status`, `idCategory`, `created_at`, `updated_at`, `type`) VALUES
(1, 'G103', 'Room1746943110.png', 8, 10000.00, 'Phòng mới, chất lượng tốt', 0, 6, '2025-03-14 08:20:04', '2025-05-12 03:19:19', 'nam'),
(3, 'D101', 'Room1742045457.jpg', 8, 200.00, 'Phòng mới nâng cấp, cho nam', 0, 7, '2025-03-15 06:30:57', '2025-04-21 11:43:09', 'nam'),
(4, 'E101', 'Room1742045478.jpg', 8, 400000.00, 'Phòng mới nâng cấp, cho nữ', 0, 8, '2025-03-15 06:31:18', '2025-03-15 06:31:18', NULL),
(5, 'G101', 'Room1742045520.jpg', 6, 40.00, 'Phòng nâng cấp các thiết bị hiện đại, cho nam', 0, 7, '2025-03-15 06:32:00', '2025-04-21 11:43:00', 'nữ'),
(6, 'G201', 'Room1742045571.jpg', 6, 300000.00, 'Phòng mới nâng cấp, cho nữ', 0, 6, '2025-03-15 06:32:51', '2025-03-15 06:32:51', NULL),
(7, 'G202', 'Room1742045615.jpg', 6, 400000.00, 'Phòng mới nâng cấp, cho nữ', 0, 6, '2025-03-15 06:33:35', '2025-03-15 06:33:35', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2N93VcN17wKU8NbA9KkoEy0RDrgyEM8oLHHpYMjN', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMUt2ZkVvNkNJcFQyaDNnV3BxTnV1a2NNYmxwMkpCZVhwRVdnUnVWbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvY2hlY2stYmlsbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1748049751),
('uk3Tk8XcUUWm5IO1hGDCmLYdKTbRo7roBIqDlqpI', 31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmpKMUtzdE9EcmtYTFdkODVsSkoyZzRIVTZVbkNFN2J5ZWhyclNHMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvY2hlY2stYmlsbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTt9', 1748049737);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `msv` varchar(255) NOT NULL,
  `cccd` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `competence` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(4) NOT NULL,
  `role` int(11) NOT NULL,
  `code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `msv`, `cccd`, `sex`, `competence`, `name`, `image`, `email`, `password`, `tel`, `address`, `date`, `status`, `role`, `code`, `created_at`, `updated_at`) VALUES
(6, 'ADMIN001', '027203004586', '0', 0, 'Admin', '1743384825.png', 'admin@gmail.com', '$2y$12$i.WBnt5wta.VrTMMCF1mQOlnPJUn1IPYyUMBIo57262TARAGx7U8q', '0123456788', 'Hà Nội', '2025-03-31', 0, 0, NULL, '2025-03-30 18:33:10', '2025-04-08 18:25:48'),
(18, 'MSV001', '1111111111111111', '0', 0, 'Nguyễn Văn A', NULL, 'nguoidung1@gmail.com', '$2y$12$D8CXSXsRiHpU859Jj5u2jeDc4PumPREZCmPptshsE6JPgKWZpChpy', '0987654321', 'Hà Nội', '2000-01-01', 1, 1, 0, '2025-04-02 19:00:34', '2025-04-18 20:17:17'),
(19, 'MSV002', '', '', 0, 'Trần Thị B', NULL, 'nguoidung2@gmail.com', '$2y$12$1KP5BSdx0PkAaht/sxpX1eBJihG2xz/LVlE9x8ygopTM2aCQVIUG6', '0987654322', 'Hồ Chí Minh', '1999-02-02', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 12:02:58'),
(20, 'MSV003', '', '', 0, 'Lê Văn C', NULL, 'nguoidung3@gmail.com', '$2y$12$tHUayNaZqs02ObsddnGju.ZEE0dJNPVVg73i.W5RddMzbNe4uKkwa', '0987654323', 'Đà Nẵng', '2001-03-03', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-03 00:03:21'),
(21, 'MSV004', '', '', 0, 'Phạm Thị D', NULL, 'nguoidung4@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654324', 'Hải Phòng', '1998-04-04', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(22, 'MSV005', '', '', 0, 'Hoàng Văn E', NULL, 'nguoidung5@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654325', 'Cần Thơ', '2002-05-05', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(23, 'MSV006', '', '', 0, 'Đỗ Thị F', NULL, 'nguoidung6@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654326', 'Huế', '2003-06-06', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(24, 'MSV007', '', '', 0, 'Vũ Văn G', NULL, 'nguoidung7@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654327', 'Bắc Ninh', '2000-07-07', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(25, 'MSV008', '', '', 0, 'Bùi Thị H', NULL, 'nguoidung8@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654328', 'Nam Định', '1997-08-08', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(26, 'MSV009', '', '', 0, 'Ngô Văn I', NULL, 'nguoidung9@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654329', 'Nghệ An', '1996-09-09', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(27, 'MSV010', '', '', 0, 'Trịnh Thị K', NULL, 'nguoidung10@gmail.com', '$2y$10$abcdefghij1234567890klmnopqrstuvwx', '0987654330', 'Thanh Hóa', '1995-10-10', 1, 2, 0, '2025-04-02 19:00:34', '2025-04-02 19:00:34'),
(29, 'test', '33333', '0', 1, 'Nguyen The Quangt', NULL, 'admintest@gmail.com', '$2y$12$st4xoTHF9hQj9hrKcrEqyO0dZOkTnUwte.ryQBmJJM9KtEZsl34E.', '0971622323', 'Từ Sơn, Bắc Ninh', '2025-04-09', 0, 1, NULL, '2025-04-08 18:18:26', '2025-04-11 12:20:04'),
(31, '559595995', '027203005688', '0', 0, 'Bùi Văn Chiến', NULL, 'chienbuitsbn@gmail.com', '$2y$12$Nk0VfYrRjfMrngsbk8BfBu1hDq7ahlzzBmHAVJMmlRjVKM.Bdt9tW', '0366024144', 'Từ Sơn, Bắc Ninh', '2003-10-19', 0, 2, NULL, '2025-05-08 03:10:21', '2025-05-23 16:47:33');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_iduser_foreign` (`idUser`);

--
-- Chỉ mục cho bảng `bills_detail`
--
ALTER TABLE `bills_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_detail_idbill_foreign` (`idBill`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_iduser_foreign` (`idUser`),
  ADD KEY `comments_idnews_foreign` (`idNews`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Chỉ mục cho bảng `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_iduser_foreign` (`idUser`),
  ADD KEY `members_idroom_foreign` (`idRoom`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_idsender_foreign` (`idSender`),
  ADD KEY `messages_idreceiver_foreign` (`idReceiver`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_iduser_foreign` (`idUser`);

--
-- Chỉ mục cho bảng `news_like`
--
ALTER TABLE `news_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_like_iduser_foreign` (`idUser`),
  ADD KEY `news_like_idnew_foreign` (`idNew`);

--
-- Chỉ mục cho bảng `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pays_idmember_foreign` (`idMember`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_idcategory_foreign` (`idCategory`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_msv_unique` (`msv`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `bills_detail`
--
ALTER TABLE `bills_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `news_like`
--
ALTER TABLE `news_like`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `pays`
--
ALTER TABLE `pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bills_detail`
--
ALTER TABLE `bills_detail`
  ADD CONSTRAINT `bills_detail_idbill_foreign` FOREIGN KEY (`idBill`) REFERENCES `bills` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_idnews_foreign` FOREIGN KEY (`idNews`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_idroom_foreign` FOREIGN KEY (`idRoom`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `members_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_idreceiver_foreign` FOREIGN KEY (`idReceiver`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_idsender_foreign` FOREIGN KEY (`idSender`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news_like`
--
ALTER TABLE `news_like`
  ADD CONSTRAINT `news_like_idnew_foreign` FOREIGN KEY (`idNew`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_like_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `pays`
--
ALTER TABLE `pays`
  ADD CONSTRAINT `pays_idmember_foreign` FOREIGN KEY (`idMember`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_idcategory_foreign` FOREIGN KEY (`idCategory`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
