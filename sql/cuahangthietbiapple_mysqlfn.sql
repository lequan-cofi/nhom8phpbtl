-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 09:01 AM
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
-- Database: `cuahangthietbiapple_mysql`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_sales_list_settings`
--

CREATE TABLE `admin_sales_list_settings` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDLoaiThietBi` bigint(20) UNSIGNED NOT NULL,
  `SoLuongHienThi` int(11) NOT NULL DEFAULT 5,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng cài đặt hiển thị danh sách ưu đãi theo loại thiết bị';

--
-- Dumping data for table `admin_sales_list_settings`
--

INSERT INTO `admin_sales_list_settings` (`ID`, `IDLoaiThietBi`, `SoLuongHienThi`, `IsActive`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 1, 4, 1, '2025-05-31 06:13:28', '2025-05-31 11:11:30', NULL),
(2, 10, 3, 0, '2025-05-31 11:16:16', '2025-05-31 11:17:30', NULL),
(3, 4, 4, 1, '2025-05-31 11:17:16', '2025-05-31 11:20:33', NULL),
(4, 10, 5, 1, '2025-05-31 11:21:21', '2025-05-31 11:34:08', NULL),
(5, 2, 4, 0, '2025-05-31 11:22:06', '2025-05-31 11:28:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `TieuDe` varchar(255) NOT NULL COMMENT 'Tiêu đề chính của bài viết',
  `Slug` varchar(255) NOT NULL COMMENT 'Đường dẫn thân thiện, không dấu, các từ nối bằng gạch ngang',
  `NoiDungTomTat` text DEFAULT NULL COMMENT 'Nội dung tóm tắt hiển thị ở trang danh sách',
  `NoiDungDayDu` longtext NOT NULL COMMENT 'Toàn bộ nội dung bài viết, hỗ trợ HTML',
  `HinhDaiDien` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn tới file ảnh đại diện',
  `TrangThai` enum('draft','published','archived') NOT NULL DEFAULT 'draft' COMMENT 'Trạng thái bài viết: bản nháp, đã xuất bản, đã lưu trữ',
  `LuotXem` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượt xem bài viết',
  `TacGia` varchar(1000) NOT NULL,
  `DanhMucID` int(10) UNSIGNED DEFAULT NULL COMMENT 'Khóa ngoại trỏ tới ID danh mục trong bảng danh_muc',
  `MetaTieuDe` varchar(255) DEFAULT NULL COMMENT 'Tiêu đề hiển thị trên tab trình duyệt và kết quả tìm kiếm (SEO)',
  `MetaMoTa` varchar(255) DEFAULT NULL COMMENT 'Mô tả ngắn gọn cho máy tìm kiếm (SEO)',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXuatBan` timestamp NULL DEFAULT NULL COMMENT 'Ngày dự kiến hoặc đã xuất bản bài viết'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bai_viet`
--

INSERT INTO `bai_viet` (`ID`, `TieuDe`, `Slug`, `NoiDungTomTat`, `NoiDungDayDu`, `HinhDaiDien`, `TrangThai`, `LuotXem`, `TacGia`, `DanhMucID`, `MetaTieuDe`, `MetaMoTa`, `NgayTao`, `NgayCapNhat`, `NgayXuatBan`) VALUES
(1, 'Apple chính thức ra mắt iPhone 16 Series với nhiều nâng cấp đột phá về AI', 'apple-ra-mat-iphone-16-series-voi-nhieu-nang-cap-ai', 'Sau nhiều chờ đợi, Apple đã chính thức giới thiệu dòng iPhone 16 với tâm điểm là các tính năng AI tích hợp sâu vào hệ điều hành iOS 18.', '<p>Sự kiện \"Wonderlust\" của Apple đã không làm người hâm mộ thất vọng khi trình làng bộ bốn iPhone 16, iPhone 16 Plus, iPhone 16 Pro và iPhone 16 Pro Max. Lần này, \"nhân vật chính\" không chỉ là phần cứng mà còn là trí tuệ nhân tạo.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>', 'blog/iphone-16-launch.jpg', 'published', 3929, 'Admin iStore', 1, 'Apple ra mắt iPhone 16 Series với nâng cấp AI đột phá', 'Apple giới thiệu dòng iPhone 16 với các tính năng AI tích hợp sâu vào iOS 18, hứa hẹn trải nghiệm người dùng hoàn toàn mới.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-05-20 02:00:00'),
(2, 'Đánh giá chi tiết MacBook Air M4: Mỏng hơn, mạnh hơn và \"thông minh\" hơn', 'danh-gia-chi-tiet-macbook-air-m4', 'MacBook Air M4 tiếp tục khẳng định vị thế laptop siêu di động hàng đầu với hiệu năng ấn tượng từ chip M4 và thiết kế được tinh chỉnh.', '<p>Chip M4 mới không chỉ mang lại hiệu năng xử lý đồ họa vượt trội mà còn tối ưu cho các tác vụ AI. Thời lượng pin vẫn là điểm sáng giá, đáp ứng thoải mái một ngày làm việc cường độ cao.</p><p>Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat.</p>', 'blog/macbook-air-m4-review.jpg', 'published', 570, 'Admin iStore', 2, 'Đánh giá MacBook Air M4: Mỏng, mạnh và thông minh', 'Đánh giá chi tiết hiệu năng, thiết kế và thời lượng pin của MacBook Air M4 mới nhất từ Apple.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-05-15 04:30:00'),
(3, '5 mẹo sử dụng iOS 18 giúp bạn làm chủ iPhone của mình', '5-meo-su-dung-ios-18', 'iOS 18 mang đến hàng loạt tính năng mới. Hãy cùng khám phá 5 mẹo nhỏ nhưng cực kỳ hữu ích để tận dụng tối đa sức mạnh của hệ điều hành này.', '<p>Từ việc tùy biến Control Center đến các tính năng AI hỗ trợ soạn thảo email, iOS 18 thực sự là một bản cập nhật đáng giá. Bài viết này sẽ hướng dẫn bạn các thủ thuật hay nhất.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'blog/ios-18-tips.jpg', 'published', 963, 'Admin iStore', 3, '5 mẹo hay trên iOS 18 bạn nên biết', 'Khám phá 5 mẹo và thủ thuật hữu ích trên iOS 18 để cải thiện trải nghiệm sử dụng iPhone hàng ngày.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-05-10 08:00:00'),
(4, 'So sánh Apple Watch Series 10 và Samsung Galaxy Watch 7: Cuộc chiến trên cổ tay', 'so-sanh-apple-watch-10-va-galaxy-watch-7', 'Apple Watch Series 10 và Galaxy Watch 7 đều là những smartwatch hàng đầu. Đâu là lựa chọn phù hợp nhất cho bạn?', '<p>Chúng tôi sẽ đặt lên bàn cân thiết kế, tính năng sức khỏe, hệ sinh thái và thời lượng pin của hai đối thủ sừng sỏ này để giúp bạn đưa ra quyết định dễ dàng hơn.</p><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>', 'blog/watch-comparison.jpg', 'published', 3004, 'Trang Công Nghệ', 4, 'So sánh Apple Watch 10 và Galaxy Watch 7', 'So sánh chi tiết về thiết kế, tính năng và hiệu năng giữa Apple Watch Series 10 và Samsung Galaxy Watch 7.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-05-05 13:00:00'),
(5, 'Tổng hợp các chương trình khuyến mãi tháng 5 tại iStore', 'tong-hop-khuyen-mai-thang-5', 'Đừng bỏ lỡ cơ hội sở hữu các sản phẩm Apple với mức giá ưu đãi nhất trong tháng 5 này tại iStore.', '<p>iStore mang đến chương trình giảm giá sâu cho các dòng iPhone 15, MacBook Air M3 cùng nhiều quà tặng hấp dẫn khác. Xem chi tiết ngay!</p><p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>', 'blog/may-promo.jpg', 'published', 2032, 'Admin iStore', 1, 'Khuyến mãi tháng 5: Sắm đồ Apple giá hời', 'Tổng hợp tất cả các chương trình khuyến mãi, giảm giá sản phẩm Apple hot nhất tháng 5 tại hệ thống iStore.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-05-01 01:00:00'),
(6, 'Hướng dẫn cách tối ưu hóa thời lượng pin trên MacBook', 'huong-dan-toi-uu-thoi-luong-pin-macbook', 'Làm thế nào để kéo dài thời gian sử dụng MacBook giữa các lần sạc? Hãy áp dụng ngay những tinh chỉnh đơn giản nhưng hiệu quả sau.', '<p>Từ việc quản lý các ứng dụng chạy nền, điều chỉnh độ sáng màn hình đến việc sử dụng chế độ Low Power Mode trên macOS, tất cả sẽ được bật mí trong bài viết này.</p><p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>', 'blog/macbook-battery-tips.jpg', 'published', 1047, 'Trang Công Nghệ', 3, 'Mẹo tối ưu hóa pin cho MacBook', 'Hướng dẫn chi tiết các cách cài đặt và thói quen sử dụng giúp kéo dài tối đa thời lượng pin cho MacBook của bạn.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-04-28 07:00:00'),
(7, 'Đánh giá camera iPhone 16 Pro: Liệu có xứng danh \"máy ảnh di động\"?', 'danh-gia-camera-iphone-16-pro', 'Hệ thống camera trên iPhone 16 Pro được nâng cấp mạnh mẽ với cảm biến lớn hơn và khả năng quay video ProRes LOG. Chất lượng ảnh thực tế ra sao?', '<p>Chúng tôi đã thử nghiệm camera iPhone 16 Pro trong nhiều điều kiện ánh sáng khác nhau, từ chụp đêm, chụp chân dung đến quay video chuyên nghiệp. Hãy xem kết quả.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>', 'blog/iphone-16-pro-camera.jpg', 'published', 4040, 'Admin iStore', 2, 'Đánh giá camera iPhone 16 Pro', 'Đánh giá chi tiết chất lượng ảnh chụp, khả năng quay video và các tính năng mới trên hệ thống camera của iPhone 16 Pro.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-04-22 03:00:00'),
(8, 'macOS 15 Sequoia: Những tính năng đáng mong chờ nhất', 'macos-15-sequoia-nhung-tinh-nang-dang-mong-cho', 'Apple đã hé lộ những thông tin đầu tiên về macOS 15 với tên gọi Sequoia. Đâu là những thay đổi sẽ tác động lớn đến trải nghiệm người dùng Mac?', '<p>Trí tuệ nhân tạo, cải tiến giao diện và khả năng kết nối liền mạch với các thiết bị khác trong hệ sinh thái là những điểm nhấn chính của macOS 15.</p><p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>', 'blog/macos-15.jpg', 'published', 1958, 'Admin iStore', 1, 'Các tính năng mới đáng chờ đợi trên macOS 15 Sequoia', 'Tổng hợp những tính năng mới và cải tiến đáng chú ý nhất sẽ có mặt trên macOS 15 Sequoia sắp tới.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-04-18 11:00:00'),
(9, 'Lý do nên chọn Apple Watch cho việc theo dõi sức khỏe', 'ly-do-nen-chon-apple-watch-theo-doi-suc-khoe', 'Không chỉ là một phụ kiện thời trang, Apple Watch là một thiết bị theo dõi sức khỏe mạnh mẽ với các cảm biến đo nhịp tim, ECG, SpO2 và phát hiện té ngã.', '<p>Bài viết sẽ phân tích sâu về độ chính xác của các cảm biến, hệ sinh thái ứng dụng sức khỏe và cách Apple Watch có thể thực sự giúp bạn sống khỏe hơn mỗi ngày.</p><p>Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>', 'blog/why-apple-watch.jpg', 'published', 2569, 'Trang Công Nghệ', 2, 'Tại sao nên dùng Apple Watch để theo dõi sức khỏe?', 'Phân tích những lý do khiến Apple Watch trở thành công cụ theo dõi sức khỏe cá nhân hàng đầu thế giới.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-04-12 04:00:00'),
(10, 'iPhone 16 vs iPhone 16 Pro: Nên chọn phiên bản nào?', 'iphone-16-vs-iphone-16-pro-nen-chon-ban-nao', 'Cùng ra mắt nhưng iPhone 16 và iPhone 16 Pro lại hướng đến những đối tượng người dùng khác nhau. Sự khác biệt có đáng để bạn chi thêm tiền cho bản Pro?', '<p>Bài viết sẽ so sánh chi tiết về màn hình, hiệu năng, hệ thống camera và các tính năng độc quyền để giúp bạn tìm ra chiếc iPhone phù hợp nhất với nhu cầu và ngân sách của mình.</p><p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.</p>', 'blog/iphone-16-vs-pro.jpg', 'published', 1874, 'Admin iStore', 4, 'So sánh iPhone 16 và iPhone 16 Pro: Chọn máy nào?', 'So sánh chi tiết giúp bạn lựa chọn giữa iPhone 16 và iPhone 16 Pro dựa trên nhu cầu sử dụng và ngân sách.', '2025-05-31 11:57:42', '2025-05-31 11:57:42', '2025-04-10 02:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet_the`
--

CREATE TABLE `bai_viet_the` (
  `BaiVietID` bigint(20) UNSIGNED NOT NULL,
  `TheID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bai_viet_the`
--

INSERT INTO `bai_viet_the` (`BaiVietID`, `TheID`) VALUES
(1, 1),
(1, 4),
(2, 2),
(2, 5),
(3, 1),
(3, 4),
(4, 3),
(5, 6),
(6, 2),
(6, 7),
(7, 1),
(7, 8),
(8, 2),
(8, 5),
(9, 3),
(10, 1),
(10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` int(11) NOT NULL,
  `image` varchar(10000) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `category`, `author`, `image`, `status`, `created_date`, `updated_date`) VALUES
(1, 'sdfgsdfg', 'fdgsdfg', 'technology', 1, '', 'draft', '2025-05-31 19:19:45', '2025-06-02 11:57:02'),
(2, 'bizagi bai mau ', 'EDASDASD', 'lifestyle', 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-ipad-nav-202405?wid=400&hei=260&fmt=png-alpha&.v=dW5XbHI1eDVpd01qWUU4bFRtWGZXNGFLQTJVNnlNQmQrVmRBYnZYei9jckUzelNmMnRxajE0NHhmMWtLazl6eG53M0FRZHBXNTh1U1lFVEtSR2YzTm5qbE56RWRpRFNIRXZvbkd2S0l5dTg', 'published', '2025-05-31 22:23:51', '2025-05-31 22:25:31'),
(3, 'bizagi bai mau ', 'zdxfsd', 'business', 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airpods-nav-202409?wid=400&hei=260&fmt=png-alpha&.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1yNlJ5eGFhR1FVd2NNNDB0VWRUSzVCUFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFI0R1M4eFpKRTFIclV0ZHRqakVRd1k', 'published', '2025-05-31 22:28:57', '2025-06-02 11:56:35'),
(4, 'sdfs', 'sdfs', 'technology', 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airpods-nav-202409?wid=400&hei=260&fmt=png-alpha&.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1yNlJ5eGFhR1FVd2NNNDB0VWRUSzVCUFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFI0R1M4eFpKRTFIclV0ZHRqakVRd1k', 'published', '2025-05-31 22:29:07', NULL),
(5, 'sdfsdf', 'sdfsdfsdf', 'business', 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airpods-nav-202409?wid=400&hei=260&fmt=png-alpha&.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1yNlJ5eGFhR1FVd2NNNDB0VWRUSzVCUFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFI0R1M4eFpKRTFIclV0ZHRqakVRd1k', 'published', '2025-05-31 22:29:23', '2025-06-02 11:56:46'),
(6, 'sdfsdf', 'sdfsdf', 'technology', 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airpods-nav-202409?wid=400&hei=260&fmt=png-alpha&.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1yNlJ5eGFhR1FVd2NNNDB0VWRUSzVCUFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFI0R1M4eFpKRTFIclV0ZHRqakVRd1k', 'published', '2025-05-31 22:29:34', '2025-06-02 11:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDDonHang` bigint(20) UNSIGNED NOT NULL,
  `IDThietBi` bigint(20) UNSIGNED NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `Gia` decimal(15,2) NOT NULL COMMENT 'Giá tại thời điểm mua',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng chi tiết các sản phẩm trong đơn hàng';

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`ID`, `IDDonHang`, `IDThietBi`, `SoLuong`, `Gia`, `NgayTao`, `NgayCapNhat`) VALUES
(1, 1, 1, 1, 33990000.00, '2025-05-29 03:30:00', '2025-05-29 03:30:00'),
(2, 2, 2, 1, 42500000.00, '2025-05-29 03:31:00', '2025-05-29 03:31:00'),
(3, 2, 6, 1, 26000000.00, '2025-05-29 03:31:00', '2025-05-29 03:31:00'),
(4, 3, 3, 1, 24990000.00, '2025-05-30 03:32:00', '2025-05-30 03:32:00'),
(7, 8, 1, 1, 33990000.00, '2025-06-02 00:45:11', '2025-06-02 00:45:11'),
(8, 9, 1, 2, 33990000.00, '2025-06-02 00:56:47', '2025-06-02 00:56:47'),
(9, 10, 1, 1, 33990000.00, '2025-06-02 00:57:19', '2025-06-02 00:57:19'),
(10, 11, 20, 1, 28990000.00, '2025-06-02 01:03:58', '2025-06-02 01:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `chitietthongsothietbi`
--

CREATE TABLE `chitietthongsothietbi` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDThietBi` bigint(20) UNSIGNED NOT NULL,
  `IDThongSo` bigint(20) UNSIGNED NOT NULL,
  `GiaTri` varchar(255) NOT NULL COMMENT 'Giá trị của thông số cho thiết bị cụ thể',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng nối giữa Thiết Bị và Thông Số Kỹ Thuật, lưu giá trị cụ thể';

--
-- Dumping data for table `chitietthongsothietbi`
--

INSERT INTO `chitietthongsothietbi` (`ID`, `IDThietBi`, `IDThongSo`, `GiaTri`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 1, 1, '256GB', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(2, 1, 2, 'Titan tự nhiên', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(3, 1, 3, 'A17 Pro', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(4, 1, 4, '6.7-inch', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(5, 2, 1, '1TB', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(6, 2, 2, 'Đen không gian', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(7, 2, 3, 'M3 Max (16-nhân CPU, 40-nhân GPU)', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(8, 2, 4, '16.2-inch', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(9, 2, 5, '48GB', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(10, 9, 1, '256GB', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(11, 9, 2, 'Titan Tự Nhiên', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(12, 9, 2, 'Titan Xanh', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(13, 9, 2, 'Titan Trắng', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(14, 9, 2, 'Titan Đen', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(15, 9, 3, 'A17 Pro', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(16, 9, 4, '6.7 inch Super Retina XDR', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(17, 9, 6, '2023', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(18, 9, 5, '8GB', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(19, 10, 1, '512GB', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(20, 10, 2, 'Titan Tự Nhiên', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(21, 10, 2, 'Titan Xanh', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(22, 10, 2, 'Titan Trắng', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(23, 10, 2, 'Titan Đen', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(24, 10, 3, 'A17 Pro', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(25, 10, 4, '6.7 inch Super Retina XDR', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(26, 10, 6, '2023', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(27, 10, 5, '8GB', '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(28, 11, 1, '256GB SSD', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(29, 11, 2, 'Bạc (Silver)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(30, 11, 2, 'Xám Không Gian (Space Gray)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(31, 11, 2, 'Vàng Ánh Sao (Starlight)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(32, 11, 2, 'Xanh Đen (Midnight)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(33, 11, 3, 'Apple M3 (8-core CPU, 8-core GPU)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(34, 11, 4, '13.6 inch Liquid Retina', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(35, 11, 6, '2024', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(36, 11, 5, '8GB', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(37, 12, 1, '512GB SSD', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(38, 12, 2, 'Bạc (Silver)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(39, 12, 2, 'Xám Không Gian (Space Gray)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(40, 12, 2, 'Vàng Ánh Sao (Starlight)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(41, 12, 2, 'Xanh Đen (Midnight)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(42, 12, 3, 'Apple M3 (8-core CPU, 10-core GPU)', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(43, 12, 4, '13.6 inch Liquid Retina', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(44, 12, 6, '2024', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(45, 12, 5, '8GB', '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(55, 14, 1, '256GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(56, 14, 2, 'Titan Tự Nhiên', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(57, 14, 2, 'Titan Xanh', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(58, 14, 2, 'Titan Trắng', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(59, 14, 2, 'Titan Đen', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(60, 14, 3, 'A17 Pro', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(61, 14, 4, '6.7 inch Super Retina XDR', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(62, 14, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(63, 14, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(64, 15, 1, '128GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(65, 15, 2, 'Titan Tự Nhiên', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(66, 15, 2, 'Titan Xanh', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(67, 15, 2, 'Titan Trắng', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(68, 15, 2, 'Titan Đen', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(69, 15, 3, 'A17 Pro', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(70, 15, 4, '6.1 inch Super Retina XDR', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(71, 15, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(72, 15, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(73, 16, 1, '128GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(74, 16, 2, 'Hồng', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(75, 16, 2, 'Vàng', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(76, 16, 2, 'Xanh Lá', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(77, 16, 2, 'Xanh Dương', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(78, 16, 2, 'Đen', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(79, 16, 3, 'A16 Bionic', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(80, 16, 4, '6.1 inch Super Retina XDR', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(81, 16, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(82, 16, 5, '6GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(83, 17, 1, '256GB SSD', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(84, 17, 2, 'Bạc (Silver)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(85, 17, 2, 'Xám Không Gian (Space Gray)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(86, 17, 2, 'Vàng Ánh Sao (Starlight)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(87, 17, 2, 'Xanh Đen (Midnight)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(88, 17, 3, 'Apple M3 (8-nhân CPU, 8-nhân GPU)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(89, 17, 4, '13.6 inch Liquid Retina', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(90, 17, 6, '2024', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(91, 17, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(92, 18, 1, '512GB SSD', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(93, 18, 2, 'Bạc (Silver)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(94, 18, 2, 'Xám Không Gian (Space Gray)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(95, 18, 3, 'Apple M3 (8-nhân CPU, 10-nhân GPU)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(96, 18, 4, '14.2 inch Liquid Retina XDR', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(97, 18, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(98, 18, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(99, 19, 1, '128GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(100, 19, 2, 'Xanh Dương', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(101, 19, 2, 'Tím', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(102, 19, 2, 'Vàng Ánh Sao (Starlight)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(103, 19, 2, 'Xám Không Gian (Space Gray)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(104, 19, 3, 'Apple M2', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(105, 19, 4, '10.9 inch Liquid Retina', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(106, 19, 6, '2024', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(107, 19, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(108, 20, 1, '256GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(109, 20, 2, 'Bạc', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(110, 20, 2, 'Đen Không Gian', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(111, 20, 3, 'Apple M4 (9-nhân CPU)', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(112, 20, 4, '11 inch Ultra Retina XDR', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(113, 20, 6, '2024', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(114, 20, 5, '8GB', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(115, 21, 2, 'Vỏ Nhôm Hồng - Dây Thể Thao Hồng', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(116, 21, 2, 'Vỏ Nhôm Ánh Sao - Dây Thể Thao Ánh Sao', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(117, 21, 2, 'Vỏ Nhôm Bạc - Dây Thể Thao Winter Blue', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(118, 21, 2, 'Vỏ Nhôm Đen Midnight - Dây Thể Thao Đen Midnight', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(119, 21, 2, 'Vỏ Nhôm (PRODUCT)RED - Dây Thể Thao (PRODUCT)RED', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(120, 21, 3, 'S9 SiP', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(121, 21, 4, '41mm Always-On Retina', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(122, 21, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(123, 22, 3, 'H2 Apple SiP', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(124, 22, 6, '2023', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(125, 23, 3, 'H1 Apple SiP', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(126, 23, 6, '2021', '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `ID` int(11) NOT NULL,
  `TieuDe` varchar(255) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `DuongDanHinhAnh` varchar(1000) DEFAULT NULL,
  `DuongDanLienKet` varchar(255) DEFAULT NULL COMMENT 'Liên kết đến danh mục sản phẩm hoặc khuyến mãi',
  `IsActive` tinyint(1) DEFAULT 1,
  `SortOrder` int(11) DEFAULT 0,
  `NgayTao` timestamp NOT NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT NULL,
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`ID`, `TieuDe`, `MoTa`, `NoiDung`, `DuongDanHinhAnh`, `DuongDanLienKet`, `IsActive`, `SortOrder`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 'Mừng khai trương chi nhánh mới a', 'Ưu đãi cực sốc nhân dịp khai trương', 'Giảm giá toàn bộ sản phẩm từ 20% đến 50%', '', '/khuyen-mai/khai-truong', 1, 1, '2025-05-30 23:51:56', '2025-05-31 00:18:02', '2025-05-31 00:18:14'),
(2, 'Black Friday 2025', 'Siêu giảm giá ngày thứ sáu đen tối', 'Tất cả sản phẩm công nghệ đồng giá từ 99K!', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone16pro-digitalmat-gallery-3-202409?wid=728&hei=666&fmt=p-jpg&qlt=95&.v=VWJuckJvbkZqeTMwRFJZSHhSVnN1K2tBbTY2NGE0RXZvM3VONU9MVlluajBVMUIwNFV6MXNoZGhsYWgvZGlmdEJnNER5bEtzeFpoMTlNVnpVcXBTR0NDaXNCSFl3ajdkc3ZBMkZreEM2YjArdUxKZmY1NUtWbjl2NkdEREpaOVo', '/khuyen-mai/black-friday', 1, 2, '2025-05-30 23:51:56', NULL, NULL),
(3, 'Tết Nguyên Đán', 'Mua sắm thả ga', 'Giảm thêm 200K', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone16pro-digitalmat-gallery-4-202409?wid=728&amp;hei=666&amp;fmt=p-jpg&amp;qlt=95&amp;.v=VWJuckJvbkZqeTMwRFJZSHhSVnN1MkFHWWpDb2ppck82bmpENkNWZUM0NzBVMUIwNFV6MXNoZGhsYWgvZGlmdEJnNER5bEtzeFpoMTlNVnpVcXBTR0NDaXNCSFl3ajdkc3ZBMkZreEM2YjI0NE5IR1RUbnBUQTJGS1ZGNEhUQXQ', '/khuyen-mai/tet-2025', 1, 3, '2025-05-30 23:51:56', '2025-05-31 00:40:00', NULL),
(4, 'Nhận voucher ', 'Tri ân khách hàng', 'Chia sẻ link giới thiệu và nhận ngay ưu đãi', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone16pro-digitalmat-gallery-6-202409?wid=728&amp;hei=666&amp;fmt=p-jpg&amp;qlt=95&amp;.v=VWJuckJvbkZqeTMwRFJZSHhSVnN1MHBNenpFWXFNMi9za2Z0azRyVHRmYjBVMUIwNFV6MXNoZGhsYWgvZGlmdEJnNER5bEtzeFpoMTlNVnpVcXBTR0NDaXNCSFl3ajdkc3ZBMkZreEM2YjI3UDJPSGpmV2pyeTVpc1NnNCs1Vzg', '/chuong-trinh/gioi-thieu-ban-be', 1, 4, '2025-05-30 23:51:56', '2025-05-31 00:40:06', NULL),
(5, 'Mừng khai trương chi nhánh mới a', 'sadas', 'ádasd', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone16pro-digitalmat-gallery-4-202409?wid=728&amp;hei=666&amp;fmt=p-jpg&amp;qlt=95&amp;.v=VWJuckJvbkZqeTMwRFJZSHhSVnN1MkFHWWpDb2ppck82bmpENkNWZUM0NzBVMUIwNFV6MXNoZGhsYWgvZGlmdEJnNER5bEtzeFpoMTlNVnpVcXBTR0NDaXNCSFl3ajdkc3ZBMkZreEM2YjI0NE5IR1RUbnBUQTJGS1ZGNEhUQXQ', '/khuyen-mai/khai-truong', 1, 1, '2025-05-31 00:29:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuahang`
--

CREATE TABLE `cuahang` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `google_map` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuahang`
--

INSERT INTO `cuahang` (`id`, `ten`, `diachi`, `google_map`, `created_at`) VALUES
(1, 'Chùa bộc', 'Phương Sơn, Đồng Văn, Thanh Chương, Nghệ An', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.620376963612!2d105.82534911266791!3d21.00784918055534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac806cfc0845%3A0x3848505bd3b9490f!2zMTIgUC4gQ2jDuWEgQuG7mWMsIFF1YW5nIFRydW5nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpIDEwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1748700343912!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', '2025-05-31 14:10:15'),
(2, 'Chùa bộc', 'Phương Sơn, Đồng Văn, Thanh Chương, Nghệ An', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.620376963612!2d105.82534911266791!3d21.00784918055534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac806cfc0845%3A0x3848505bd3b9490f!2zMTIgUC4gQ2jDuWEgQuG7mWMsIFF1YW5nIFRydW5nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpIDEwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1748700343912!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', '2025-05-31 14:10:16'),
(3, 'Chùa bộc', 'Phương Sơn, Đồng Văn, Thanh Chương, Nghệ An', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.620376963612!2d105.82534911266791!3d21.00784918055534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac806cfc0845%3A0x3848505bd3b9490f!2zMTIgUC4gQ2jDuWEgQuG7mWMsIFF1YW5nIFRydW5nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpIDEwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1748700343912!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', '2025-05-31 14:10:17'),
(4, 'Chùa bộc ', 'Phương Sơn, Đồng Văn, Thanh Chương, Nghệ An', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.620376963612!2d105.82534911266791!3d21.00784918055534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac806cfc0845%3A0x3848505bd3b9490f!2zMTIgUC4gQ2jDuWEgQuG7mWMsIFF1YW5nIFRydW5nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpIDEwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1748700343912!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', '2025-05-31 14:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc`
--

CREATE TABLE `danh_muc` (
  `ID` int(10) UNSIGNED NOT NULL,
  `TenDanhMuc` varchar(255) NOT NULL COMMENT 'Tên của danh mục',
  `Slug` varchar(255) NOT NULL COMMENT 'Đường dẫn thân thiện của danh mục',
  `MoTa` text DEFAULT NULL COMMENT 'Mô tả ngắn về danh mục',
  `ParentID` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của danh mục cha (nếu có)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_muc`
--

INSERT INTO `danh_muc` (`ID`, `TenDanhMuc`, `Slug`, `MoTa`, `ParentID`) VALUES
(1, 'Tin tức', 'tin-tuc', 'Cập nhật các tin tức mới nhất về Apple và thế giới công nghệ.', NULL),
(2, 'Đánh giá sản phẩm', 'danh-gia-san-pham', 'Các bài viết đánh giá chi tiết về iPhone, MacBook, Apple Watch...', NULL),
(3, 'Thủ thuật', 'thu-thuat', 'Mẹo và thủ thuật hay để sử dụng sản phẩm Apple hiệu quả hơn.', NULL),
(4, 'So sánh', 'so-sanh', 'So sánh các sản phẩm Apple với nhau và với các đối thủ.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDNguoiDung` bigint(20) UNSIGNED DEFAULT NULL,
  `TenKhachHang` varchar(255) NOT NULL,
  `GioiTinh` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(255) NOT NULL,
  `DiaChiGiaoHang` varchar(255) NOT NULL,
  `PhuongThucThanhToan` varchar(255) NOT NULL,
  `GhiChu` varchar(255) DEFAULT NULL,
  `TongTien` decimal(15,2) NOT NULL,
  `TrangThaiDonHang` enum('Chờ xử lý','Đang xử lý','Đã vận chuyển','Hoàn thành','Đã hủy') NOT NULL DEFAULT 'Chờ xử lý',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL,
  `MaChuyenKhoan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng thông tin đơn hàng';

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`ID`, `IDNguoiDung`, `TenKhachHang`, `GioiTinh`, `SoDienThoai`, `DiaChiGiaoHang`, `PhuongThucThanhToan`, `GhiChu`, `TongTien`, `TrangThaiDonHang`, `NgayTao`, `NgayCapNhat`, `NgayXoa`, `MaChuyenKhoan`) VALUES
(1, 1, 'Nguyễn Văn A', 'Nam', '0901111111', '123 Đường ABC, Quận 1, TP.HCM', 'Thẻ tín dụng', 'Khắc tên \"NVA\"', 33990000.00, '', '2025-05-29 03:30:00', '2025-06-02 04:25:03', NULL, NULL),
(2, 2, 'Trần Thị B', 'Nữ', '0902222222', '456 Đường XYZ, Quận Ba Đình, Hà Nội', 'Chuyển khoản ngân hàng', NULL, 68500000.00, 'Chờ xử lý', '2025-05-29 03:31:00', '2025-05-29 03:31:00', NULL, NULL),
(3, 3, 'Lê Văn C', 'Nam', '0903333333', '789 Đường DEF, Quận Hải Châu, Đà Nẵng', 'COD', 'Gọi trước khi giao', 24990000.00, 'Đã vận chuyển', '2025-05-30 03:32:00', '2025-05-30 03:32:00', NULL, NULL),
(4, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Chuyển khoản', NULL, 177960000.00, 'Chờ xử lý', '2025-06-02 00:37:27', '2025-06-02 00:37:27', NULL, NULL),
(5, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Chuyển khoản', NULL, 177960000.00, 'Chờ xử lý', '2025-06-02 00:38:55', '2025-06-02 00:38:55', NULL, NULL),
(8, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Thu hộ (COD)', NULL, 33990000.00, 'Đang xử lý', '2025-06-02 00:45:11', '2025-06-02 04:29:25', NULL, NULL),
(9, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Chuyển khoản', NULL, 67980000.00, 'Đã vận chuyển', '2025-06-02 00:56:47', '2025-06-02 04:47:31', NULL, NULL),
(10, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Chuyển khoản', NULL, 33990000.00, 'Đang xử lý', '2025-06-02 00:57:19', '2025-06-02 04:40:00', NULL, NULL),
(11, 4, 'Lê Quân', 'Nam', '0836357898', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', 'Chuyển khoản', NULL, 28990000.00, 'Hoàn thành', '2025-06-02 01:03:58', '2025-06-02 04:47:48', NULL, 'ISTORE_4_1748826233983_8921');

-- --------------------------------------------------------

--
-- Table structure for table `giaodichthanhtoan`
--

CREATE TABLE `giaodichthanhtoan` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `CongThanhToan` varchar(50) NOT NULL COMMENT 'Cổng thanh toán (ví dụ: Stripe, PayPal, ApplePay, COD)',
  `NgayGiaoDich` datetime NOT NULL,
  `SoTaiKhoan` varchar(50) DEFAULT NULL COMMENT 'Số thẻ đã mã hóa, email PayPal, v.v.',
  `TaiKhoanPhu` varchar(50) DEFAULT NULL,
  `MaGiaoDichCongTT` varchar(100) DEFAULT NULL COMMENT 'ID giao dịch của cổng thanh toán',
  `NoiDung` varchar(150) NOT NULL COMMENT 'Nội dung giao dịch (ví dụ: Thanh toán cho Đơn hàng #XYZ)',
  `LoaiGiaoDich` enum('Thanh toán','Chuyển khoản','Hoàn tiền') NOT NULL,
  `MoTa` varchar(500) DEFAULT NULL,
  `SoTienChuyen` decimal(15,2) NOT NULL,
  `MaDonHangThamChieu` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID đơn hàng liên quan',
  `TrangThaiGiaoDich` enum('Chờ xử lý','Thành công','Thất bại') NOT NULL DEFAULT 'Chờ xử lý',
  `IDNguoiDung` bigint(20) UNSIGNED DEFAULT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng ghi lại các giao dịch thanh toán';

--
-- Dumping data for table `giaodichthanhtoan`
--

INSERT INTO `giaodichthanhtoan` (`ID`, `CongThanhToan`, `NgayGiaoDich`, `SoTaiKhoan`, `TaiKhoanPhu`, `MaGiaoDichCongTT`, `NoiDung`, `LoaiGiaoDich`, `MoTa`, `SoTienChuyen`, `MaDonHangThamChieu`, `TrangThaiGiaoDich`, `IDNguoiDung`, `NgayTao`, `NgayCapNhat`) VALUES
(1, 'ApplePay', '2025-05-29 11:00:00', 'user_apple_pay_token_1', NULL, 'AP_TXN_20250529_001', 'Thanh toán đơn hàng #1', 'Thanh toán', 'Thanh toán Apple Pay cho đơn hàng #1 (iPhone 15 Pro Max)', 33990000.00, 1, 'Thành công', 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11'),
(2, 'Visa', '2025-05-29 11:01:00', '************1234', NULL, 'VISA_TXN_20250529_002', 'Thanh toán đơn hàng #2', 'Thanh toán', 'Thanh toán Visa cho đơn hàng #2 (MacBook Pro + MacBook Air)', 68500000.00, 2, 'Chờ xử lý', 2, '2025-05-30 18:57:11', '2025-05-30 18:57:11'),
(3, 'COD', '2025-05-30 11:02:00', NULL, NULL, 'COD_TXN_20250530_003', 'Thanh toán đơn hàng #3', 'Thanh toán', 'Thanh toán COD cho đơn hàng #3 (iPad Air)', 24990000.00, 3, 'Chờ xử lý', 3, '2025-05-30 18:57:11', '2025-05-30 18:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `hinhanhthietbi`
--

CREATE TABLE `hinhanhthietbi` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDThietBi` bigint(20) UNSIGNED NOT NULL,
  `DuongDanHinhAnh` varchar(1000) NOT NULL,
  `LaAnhChinh` tinyint(1) DEFAULT 0 COMMENT '1 nếu là ảnh chính, 0 nếu là ảnh phụ',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng hình ảnh của thiết bị';

--
-- Dumping data for table `hinhanhthietbi`
--

INSERT INTO `hinhanhthietbi` (`ID`, `IDThietBi`, `DuongDanHinhAnh`, `LaAnhChinh`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone15-digitalmat-gallery-3-202309?wid=728&hei=666&fmt=png-alpha&.v=NkhGM3Yvbkc1OWtnb1BCdWdROVRSeHlVUVRHTkd5alQ5aFd0OWdSZUk0SnUrR0lqbjI0aE84b21HR0crWjlkeTJSWWg0TDRLSXM4czBZQjZvUHdsVFBFdXZXU0s3eWUyazNzMjdHYVZ4Q0l6eWVtSll3b3d3K1M5ZDk3bFIzS04', 1, '2025-05-30 18:57:11', '2025-05-31 05:20:19', NULL),
(2, 1, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/iphone15-digitalmat-gallery-3-202309?wid=728&hei=666&fmt=png-alpha&.v=NkhGM3Yvbkc1OWtnb1BCdWdROVRSeHlVUVRHTkd5alQ5aFd0OWdSZUk0SnUrR0lqbjI0aE84b21HR0crWjlkeTJSWWg0TDRLSXM4czBZQjZvUHdsVFBFdXZXU0s3eWUyazNzMjdHYVZ4Q0l6eWVtSll3b3d3K1M5ZDk3bFIzS04', 0, '2025-05-30 18:57:11', '2025-05-31 05:20:10', NULL),
(3, 2, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mbp16-spaceblack-select-202310?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1697311054284', 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(4, 9, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-7inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692845702708', 1, '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL),
(5, 10, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-7inch-bluetitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692845699235', 1, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(6, 11, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mba13-midnight-select-202402?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1707 seleccionarMidnight', 1, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(7, 12, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mba13-starlight-select-202402?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1707414036895', 1, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL),
(8, 14, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-7inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692845702708', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(9, 15, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692845802483', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(10, 16, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-15-finish-select-202309-6-1inch-pink?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692925287219', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(11, 17, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mba13-midnight-select-202402?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1707Midnight', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(12, 18, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mbp14-spacegray-select-202310?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1697230830200', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(13, 19, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/ipad-air-select-wifi-blue-202405?wid=470&hei=556&fmt=png-alpha&.v=1713578490180', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(14, 20, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/ipad-pro-11-select-cell-silver-202405?wid=470&hei=556&fmt=png-alpha&.v=1713578490180', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(15, 21, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MPGW3ref_VW_34FR+watch-41-alum-pink-nc-s9_VW_34FR+watch-face-41-s9-circular-pink_VW_34FR_WF_CO?wid=750&hei=712&trim=1%2C0&fmt=p-jpg&qlt=95&.v=1694505164003', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(16, 22, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MTJV3?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=1694014871985', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(17, 23, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MME73?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=1632861342000', 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL),
(19, 5, 'https://www.apple.com/v/airpods/x/images/overview/pro_endframe__e2wscfy18pme_large_2x.jpg', 1, '2025-05-31 05:28:52', '2025-05-31 05:28:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `TenKhuyenMai` varchar(255) NOT NULL,
  `MucGiamGia` decimal(5,2) NOT NULL COMMENT 'Mức giảm giá (có thể là % hoặc số tiền cụ thể)',
  `NgayBatDau` timestamp NULL DEFAULT NULL,
  `NgayKetThuc` timestamp NULL DEFAULT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng thông tin các chương trình khuyến mãi';

--
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`ID`, `TenKhuyenMai`, `MucGiamGia`, `NgayBatDau`, `NgayKetThuc`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 'Ưu đãi tựu trường cho MacBook', 10.00, '2025-06-30 17:00:00', '2025-09-30 16:59:59', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(2, 'Giảm giá ra mắt iPhone 16', 5.00, '2025-09-14 17:00:00', '2025-09-22 16:59:59', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(3, 'AirPods đặc biệt mùa lễ hội', 15.00, '2025-11-19 17:00:00', '2025-12-25 16:59:59', '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(4, 'abc', 10.00, '2025-06-06 03:20:00', '2025-06-05 03:20:00', '2025-06-02 03:20:23', '2025-06-02 03:20:35', '2025-06-02 03:20:35'),
(5, 'abc', 12.00, '2025-06-05 03:21:00', '2025-06-20 03:21:00', '2025-06-02 03:21:14', '2025-06-02 03:21:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lienhe`
--

CREATE TABLE `lienhe` (
  `ID` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ChuDe` varchar(200) NOT NULL,
  `NoiDung` text NOT NULL,
  `TrangThai` enum('Chưa xử lý','Đã xử lý') NOT NULL DEFAULT 'Chưa xử lý',
  `NgayTao` timestamp NOT NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lienhe`
--

INSERT INTO `lienhe` (`ID`, `HoTen`, `Email`, `ChuDe`, `NoiDung`, `TrangThai`, `NgayTao`, `NgayCapNhat`) VALUES
(1, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'sdasd', 'Chưa xử lý', '2025-06-02 01:58:16', NULL),
(2, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'quá tuyệt với', 'Chưa xử lý', '2025-06-02 02:00:15', NULL),
(3, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:23', NULL),
(4, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:24', NULL),
(5, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:24', NULL),
(6, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:25', NULL),
(7, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:25', NULL),
(8, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:25', NULL),
(9, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Chưa xử lý', '2025-06-02 02:00:25', NULL),
(10, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Đã xử lý', '2025-06-02 02:00:26', '2025-06-02 04:48:03'),
(11, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', 'Đã xử lý', '2025-06-02 02:00:26', '2025-06-02 04:37:21'),
(12, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'ưer', '', '2025-06-02 02:00:27', '2025-06-02 03:53:06'),
(13, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'Mua hàng', 'quá', '', '2025-06-02 02:00:51', '2025-06-02 03:52:46'),
(14, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'sad', 'ád', '', '2025-06-02 02:32:21', '2025-06-02 03:51:09'),
(15, 'Lê Quân', 'lexuanthanhquan275@gmail.com', 'sdfsdf', 'sdfsdf', '', '2025-06-02 02:33:07', '2025-06-02 03:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `loaithietbi`
--

CREATE TABLE `loaithietbi` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `Ten` varchar(255) NOT NULL COMMENT 'Tên loại thiết bị (iPhone, MacBook,...)',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL,
  `DuongDanHinhAnh` varchar(1000) NOT NULL,
  `DuongDanLienKet` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng danh mục các loại thiết bị';

--
-- Dumping data for table `loaithietbi`
--

INSERT INTO `loaithietbi` (`ID`, `Ten`, `NgayTao`, `NgayCapNhat`, `NgayXoa`, `DuongDanHinhAnh`, `DuongDanLienKet`) VALUES
(1, 'iPhone', NULL, '2025-06-01 11:39:17', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-iphone-nav-202502_GEO_US?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=dW5XbHI1eDVpd01qWUU4bFRtWGZXMGIwbkQ3THNNRjRsZmFuY3ZnUksrQTA2bGFaODVwaytiT1psSXc2dlhUWUwyZnhVM3hmakh4cEVIbk1pcnBIRXFpaVlBSTdOOXplUDUwZUNmQnR2OUxuakp5ZFBaaHhUOUJXVGFwbk9vT2k', ''),
(2, 'Mac', NULL, '2025-06-01 11:37:56', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-mac-nav-202503?wid=400&amp;amp;hei=260&amp;amp;fmt=png-alpha&amp;amp;.v=M1Q3OGxnb1lBaHhqNjZ2OVRXZmx4VEpBUDFBeEhMZS9GUnNSYXdEd0hscisrUlZaSVRoWVYzU0Qra0FoTmUwNng2bitObzZwQzk4cEorV1dZdzhIazVVcFlOTkdoMWg4ZkdDS1ovMUlzcW8', ''),
(3, 'iPad', NULL, '2025-05-31 01:19:53', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-ipad-nav-202405?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=dW5XbHI1eDVpd01qWUU4bFRtWGZXNGFLQTJVNnlNQmQrVmRBYnZYei9jckUzelNmMnRxajE0NHhmMWtLazl6eG53M0FRZHBXNTh1U1lFVEtSR2YzTm5qbE56RWRpRFNIRXZvbkd2S0l5dTg', ''),
(4, 'Apple Watch', NULL, '2025-05-31 01:20:05', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-watch-nav-202409?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=S0tSVzBtSkRkSFFhMm1zS1NmeWtkNDJNVmlnVytwalkvOTJ2M1BKWUREdkh5NTJ6cGtEemJOblBHR043ZjFkZzAzOVFHb3N0MkVmS01ZcFh0d1Y4R2oxdUo4aWtyK05IRkZuWjBWbW5HM00', ''),
(5, 'AirPods', NULL, '2025-05-31 01:20:20', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airpods-nav-202409?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1yNlJ5eGFhR1FVd2NNNDB0VWRUSzVCUFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFI0R1M4eFpKRTFIclV0ZHRqakVRd1k', ''),
(10, 'AirTag', '2025-05-31 01:21:33', '2025-05-31 01:21:33', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-airtags-nav-202108?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=Q0Z1bWFqMUpRRnp3T0Y0VWJpdk1ydzduWDk4YUM5R1JVL2gwcEZnWWNaRFd1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFpQclc0OVE3cmhmS3FBaXd6cG8yYzg', ''),
(11, 'Apple TV 4K', '2025-05-31 01:22:07', '2025-05-31 01:22:07', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-appletv-nav-202210?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=T0wvM1N3YUcxQ09qK0VNRkl1RU1BZFM5WnN0RmVZRmVXQ0FCUWJjbnJDald1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFZ3YmJrVi9SakQxWUcrYWQwVXc5VTA', ''),
(12, 'HomePod', '2025-05-31 01:22:33', '2025-05-31 01:22:33', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-homepod-nav-202301?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=WVcvamRucHVMMWs5SXZ3bVJ3Q2hpZGR0czFXNWdCUW14eTN2U29pLzNMcld1aTN5QlRYNG5PRjJxc2d1RklXbVM0TjRWdzF2UjRGVEY0c3dBQVZ6VFJmbWU0TjJLamxsdTltNkZVZ1RhbDA', ''),
(15, 'Accessories', '2025-05-31 01:26:37', '2025-05-31 01:26:37', NULL, 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-accessories-nav-202503?wid=400&amp;hei=260&amp;fmt=png-alpha&amp;.v=QnhsNk96S0o4R1dkN2FveStNM1hwNzZGMHVrNGw2NTM5Vmk2bHZzMXQ3aUJGVHdnWkxMaklDeW9JYU5tT3FWeVBrcjVFNVdueFRVbVY3TGtiL2RjUVhQYS92MS9scmN4eTZLbFFkMHVzTVhuL2FLN3hwSUJhbzdFUHltVU1ldnQ', '');

-- --------------------------------------------------------

--
-- Table structure for table `mucgiohang`
--

CREATE TABLE `mucgiohang` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDNguoiDung` bigint(20) UNSIGNED NOT NULL,
  `IDThietBi` bigint(20) UNSIGNED NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng chứa các mục trong giỏ hàng của người dùng';

--
-- Dumping data for table `mucgiohang`
--

INSERT INTO `mucgiohang` (`ID`, `IDNguoiDung`, `IDThietBi`, `SoLuong`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 1, 1, 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(2, 1, 5, 2, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(3, 2, 3, 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL),
(4, 4, 2, 1, '2025-06-01 22:28:11', '2025-06-02 00:39:52', '2025-06-02 00:39:52'),
(6, 4, 1, 3, '2025-06-01 22:38:42', '2025-06-02 00:39:52', '2025-06-02 00:39:52'),
(7, 5, 1, 1, '2025-06-01 23:37:39', '2025-06-01 23:37:39', NULL),
(8, 4, 1, 1, '2025-06-02 00:45:03', '2025-06-02 00:45:11', '2025-06-02 00:45:11'),
(9, 4, 1, 2, '2025-06-02 00:50:00', '2025-06-02 00:56:47', '2025-06-02 00:56:47'),
(10, 4, 1, 1, '2025-06-02 00:56:56', '2025-06-02 00:57:19', '2025-06-02 00:57:19'),
(11, 4, 20, 1, '2025-06-02 00:57:26', '2025-06-02 01:03:58', '2025-06-02 01:03:58'),
(12, 4, 1, 1, '2025-06-02 03:36:33', '2025-06-02 03:36:33', NULL),
(13, 5, 2, 1, '2025-06-02 05:56:14', '2025-06-02 05:56:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `Ten` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `EmailDaXacMinh` timestamp NULL DEFAULT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(255) NOT NULL,
  `VaiTro` varchar(50) NOT NULL DEFAULT 'Người dùng' COMMENT 'Vai trò người dùng (Người dùng, Quản trị viên)',
  `TokenGhiNho` varchar(100) DEFAULT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL,
  `GioiTinh` varchar(50) DEFAULT NULL,
  `XacSuatRoiBo` decimal(5,2) DEFAULT NULL,
  `SoNgayMuaCuoi` int(11) NOT NULL DEFAULT 0,
  `TanSuatMuaHang` int(11) NOT NULL DEFAULT 0,
  `GiaTriTienTe` decimal(15,2) NOT NULL DEFAULT 0.00,
  `TyLeGioHangBiBo` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng thông tin người dùng';

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`ID`, `Ten`, `Email`, `EmailDaXacMinh`, `MatKhau`, `DiaChi`, `SoDienThoai`, `VaiTro`, `TokenGhiNho`, `NgayTao`, `NgayCapNhat`, `NgayXoa`, `GioiTinh`, `XacSuatRoiBo`, `SoNgayMuaCuoi`, `TanSuatMuaHang`, `GiaTriTienTe`, `TyLeGioHangBiBo`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', '2025-05-27 20:00:00', '$2y$10$hashedpasswordexampleTC', '123 Đường ABC, Quận 1, TP.HCM', '0901111111', 'Quản trị viên', NULL, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, 'Nam', 0.01, 5, 10, 500000000.00, 0.05),
(2, 'Trần Thị B', 'tranthib@example.com', '2025-05-27 20:00:00', '$2y$10$hashedpasswordexampleCF', '456 Đường XYZ, Quận Ba Đình, Hà Nội', '0902222222', 'Người dùng', NULL, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, 'Nữ', 0.05, 10, 5, 150000000.00, 0.10),
(3, 'Lê Văn C', 'levanc@example.com', '2025-05-27 20:00:00', '$2y$10$hashedpasswordexampleAA', '789 Đường DEF, Quận Hải Châu, Đà Nẵng', '0903333333', 'Người dùng', NULL, '2025-05-30 18:57:11', '2025-06-02 03:43:36', '2025-06-02 03:43:36', 'Nam', 0.02, 7, 8, 250000000.00, 0.07),
(4, 'Lê Quân', 'lexuanthanhquan275@gmail.com', NULL, '$2y$10$5j4Ixo5Q46QhSuJw1rrx/e0OGy/EfHgksaDGqjdDLegh4tJOVK37q', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', '0836357898', 'Người dùng', NULL, '2025-06-01 14:56:31', '2025-06-02 03:43:26', NULL, 'Nam', 0.00, 0, 0, 0.00, 0.00),
(5, 'Lê Quân', 'lexuanthanhquan5@gmail.com', NULL, '$2y$10$WYdWtvKyPAT/1kSgH78ENuN8pIcBZbYxlP8yrLwSdBegYUxMO8U7G', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', '08363578989', 'Quản trị viên', NULL, '2025-06-01 16:31:48', '2025-06-02 00:41:44', NULL, 'Nam', NULL, 0, 0, 0.00, NULL),
(6, 'Lê Quân', 'lexuanthanhquan@gmail.com', NULL, '$2y$10$SSjA45VrzqTYoAFkjtWMIOnieP1qsySTWgZwpp0Q32oVjluov8Dpq', 'Phuong Son, Dong Van, Thanh Chuong, Nghe An', '083635789', 'Người dùng', NULL, '2025-06-02 03:44:06', '2025-06-02 03:44:06', NULL, 'Nữ', NULL, 0, 0, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phanhoi`
--

CREATE TABLE `phanhoi` (
  `ID` int(11) NOT NULL,
  `IDLienHe` int(11) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayTao` timestamp NOT NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phanhoi`
--

INSERT INTO `phanhoi` (`ID`, `IDLienHe`, `NoiDung`, `NgayTao`, `NgayCapNhat`) VALUES
(1, 15, 'fdgdfg', '2025-06-02 03:50:54', NULL),
(2, 14, 'sfđs', '2025-06-02 03:51:09', NULL),
(3, 13, 'sdfdsf', '2025-06-02 03:52:46', NULL),
(4, 12, 'ádasd', '2025-06-02 03:53:06', NULL),
(5, 10, 'sdfsdf', '2025-06-02 03:53:11', NULL),
(6, 10, 'dfghd', '2025-06-02 04:19:56', NULL),
(7, 11, 'h', '2025-06-02 04:20:10', NULL),
(8, 11, 'drgd', '2025-06-02 04:33:49', NULL),
(9, 11, 'dcs', '2025-06-02 04:36:03', NULL),
(10, 11, 'aaaaaaaaaaaawdasdasdasda', '2025-06-02 04:37:21', NULL),
(11, 10, 'édf', '2025-06-02 04:48:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phantich`
--

CREATE TABLE `phantich` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `ChiSo` varchar(255) NOT NULL COMMENT 'Chỉ số phân tích (ví dụ: Tổng doanh thu)',
  `GiaTri` decimal(15,2) NOT NULL COMMENT 'Giá trị của chỉ số',
  `Ngay` date NOT NULL COMMENT 'Ngày áp dụng của chỉ số',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu trữ dữ liệu phân tích';

--
-- Dumping data for table `phantich`
--

INSERT INTO `phantich` (`ID`, `ChiSo`, `GiaTri`, `Ngay`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 'Tổng doanh thu', 125500000.00, '2025-05-28', '2025-05-29 02:33:00', '2025-05-29 02:33:00', NULL),
(2, 'Số lượng đơn hàng', 150.00, '2025-05-28', '2025-05-29 02:33:00', '2025-05-29 02:33:00', NULL),
(3, 'Lượt xem trang', 25000.00, '2025-05-28', '2025-05-29 02:33:00', '2025-05-29 02:33:00', NULL),
(4, 'Tổng doanh thu', 98750000.00, '2025-05-29', '2025-05-30 02:33:00', '2025-05-30 02:33:00', NULL),
(5, 'Số lượng đơn hàng', 120.00, '2025-05-29', '2025-05-30 02:33:00', '2025-05-30 02:33:00', NULL),
(6, 'Lượt xem trang', 22000.00, '2025-05-29', '2025-05-30 02:33:00', '2025-05-30 02:33:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poster_settings`
--

CREATE TABLE `poster_settings` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Image` varchar(1000) NOT NULL,
  `IDKhuyenMai` bigint(20) UNSIGNED NOT NULL,
  `MaxDisplayProducts` int(11) NOT NULL DEFAULT 5,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `NgayTao` timestamp NOT NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poster_settings`
--

INSERT INTO `poster_settings` (`ID`, `Title`, `Description`, `Image`, `IDKhuyenMai`, `MaxDisplayProducts`, `IsActive`, `NgayTao`, `NgayCapNhat`) VALUES
(2, 'AirPods đặc biệt mùa lễ hội', 'âsass', '/uploads/poster/683a8333da733.png', 3, 3, 0, '2025-05-31 04:12:22', '2025-05-31 05:22:03'),
(3, 'AirPods đặc biệt mùa lễ hội', '', '/uploads/poster/undefined', 3, 6, 1, '2025-05-31 05:22:21', '2025-05-31 10:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_khuyenmai`
--

CREATE TABLE `sanpham_khuyenmai` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDThietBi` bigint(20) UNSIGNED NOT NULL COMMENT 'Khóa ngoại đến bảng thietbi',
  `IDKhuyenMai` bigint(20) UNSIGNED NOT NULL COMMENT 'Khóa ngoại đến bảng khuyenmai',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng nối giữa Thiết Bị và Khuyến Mãi';

--
-- Dumping data for table `sanpham_khuyenmai`
--

INSERT INTO `sanpham_khuyenmai` (`ID`, `IDThietBi`, `IDKhuyenMai`, `NgayTao`, `NgayCapNhat`) VALUES
(1, 2, 1, '2025-05-31 02:01:26', '2025-05-31 02:01:26'),
(2, 6, 1, '2025-05-31 02:01:26', '2025-05-31 02:01:26'),
(3, 1, 2, '2025-05-31 02:01:26', '2025-05-31 02:01:26'),
(4, 5, 3, '2025-05-31 02:01:26', '2025-05-31 02:01:26'),
(5, 23, 3, '2025-05-31 02:01:26', '2025-05-31 02:01:26'),
(7, 2, 3, '2025-05-31 11:05:15', '2025-05-31 11:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `the`
--

CREATE TABLE `the` (
  `ID` int(10) UNSIGNED NOT NULL,
  `TenThe` varchar(100) NOT NULL COMMENT 'Tên của thẻ',
  `Slug` varchar(100) NOT NULL COMMENT 'Đường dẫn thân thiện của thẻ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `the`
--

INSERT INTO `the` (`ID`, `TenThe`, `Slug`) VALUES
(1, 'iPhone', 'iphone'),
(2, 'MacBook', 'macbook'),
(3, 'Apple Watch', 'apple-watch'),
(4, 'iOS', 'ios'),
(5, 'macOS', 'macos'),
(6, 'Khuyến mãi', 'khuyen-mai'),
(7, 'Pin', 'pin'),
(8, 'Camera', 'camera');

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `Ten` varchar(255) NOT NULL COMMENT 'Tên thiết bị',
  `Gia` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Giá thiết bị',
  `SoLuongTonKho` int(11) NOT NULL DEFAULT 0 COMMENT 'Số lượng tồn kho',
  `IDLoaiThietBi` bigint(20) UNSIGNED NOT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL,
  `DuongDanLienKet` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn tùy chỉnh cho sản phẩm (vd: link review, landing page...)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng danh sách các thiết bị Apple';

--
-- Dumping data for table `thietbi`
--

INSERT INTO `thietbi` (`ID`, `Ten`, `Gia`, `SoLuongTonKho`, `IDLoaiThietBi`, `NgayTao`, `NgayCapNhat`, `NgayXoa`, `DuongDanLienKet`) VALUES
(1, 'iPhone 15 Pro Max', 33990000.00, 50, 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(2, 'MacBook Pro 16-inch M3 Max', 75990000.00, 20, 2, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(3, 'iPad Air M2 13-inch', 20990000.00, 30, 3, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(4, 'Apple Watch Series 9 GPS 45mm', 10490000.00, 75, 4, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(5, 'AirPods Pro (thế hệ 2)', 6190000.00, 100, 5, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(6, 'MacBook Air 13-inch M3', 27990000.00, 40, 2, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(7, 'iPhone 15', 22990000.00, 60, 1, '2025-05-30 18:57:11', '2025-05-30 18:57:11', NULL, NULL),
(9, 'iPhone 15 Pro Max 256GB', 33990000.00, 50, 1, '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL, NULL),
(10, 'iPhone 15 Pro Max 512GB', 39990000.00, 30, 1, '2025-05-30 19:06:42', '2025-05-30 19:06:42', NULL, NULL),
(11, 'MacBook Air 13 inch M3 256GB', 27990000.00, 40, 2, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL, NULL),
(12, 'MacBook Air 13 inch M3 512GB', 32990000.00, 35, 2, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL, NULL),
(13, 'Apple Watch Series 9 GPS 41mm Nhôm', 9990000.00, 70, 4, '2025-05-30 19:06:43', '2025-05-30 19:06:43', NULL, NULL),
(14, 'iPhone 15 Pro Max 256GB', 33990000.00, 50, 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(15, 'iPhone 15 Pro 128GB', 27990000.00, 60, 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(16, 'iPhone 15 128GB', 21990000.00, 70, 1, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(17, 'MacBook Air 13 inch M3 256GB', 27990000.00, 40, 2, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(18, 'MacBook Pro 14 inch M3 512GB', 39990000.00, 25, 2, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(19, 'iPad Air 11 inch M2 128GB', 16990000.00, 30, 3, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(20, 'iPad Pro 11 inch M4 256GB', 28990000.00, 20, 3, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(21, 'Apple Watch Series 9 GPS 41mm Nhôm', 9990000.00, 70, 4, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(22, 'AirPods Pro (thế hệ 2) với hộp sạc MagSafe (USB-C)', 6190000.00, 120, 5, '2025-05-30 19:08:49', '2025-05-30 19:08:49', NULL, NULL),
(23, 'AirPods (thế hệ 3) với hộp sạc Lightning', 4490000.00, 1500, 5, '2025-05-30 19:08:49', '2025-05-31 03:41:24', NULL, ''),
(25, 'ád', 2342.00, 12, 1, '2025-06-02 03:34:40', '2025-06-02 03:34:53', '2025-06-02 03:34:53', '');

-- --------------------------------------------------------

--
-- Table structure for table `thongsokythuat`
--

CREATE TABLE `thongsokythuat` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `Ten` varchar(255) NOT NULL COMMENT 'Tên thông số kỹ thuật (ví dụ: Dung lượng lưu trữ, Màu sắc)',
  `KieuDuLieu` varchar(255) NOT NULL DEFAULT 'string' COMMENT 'Kiểu dữ liệu của thông số',
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng các loại thông số kỹ thuật của thiết bị';

--
-- Dumping data for table `thongsokythuat`
--

INSERT INTO `thongsokythuat` (`ID`, `Ten`, `KieuDuLieu`, `NgayTao`, `NgayCapNhat`, `NgayXoa`) VALUES
(1, 'Dung lượng lưu trữ', 'string', '2025-05-28 10:04:22', '2025-05-28 10:04:22', NULL),
(2, 'Màu sắc', 'string', '2025-05-28 10:04:22', '2025-05-28 10:04:22', NULL),
(3, 'Chip', 'string', '2025-05-28 10:04:22', '2025-05-28 10:04:22', NULL),
(4, 'Kích thước màn hình', 'string', '2025-05-28 10:04:22', '2025-05-28 10:04:22', NULL),
(5, 'RAM', 'string', '2025-05-29 03:00:00', '2025-05-29 03:00:00', NULL),
(6, 'Năm sản xuất', 'integer', '2025-05-29 03:00:00', '2025-05-29 03:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_sales_list_settings`
--
ALTER TABLE `admin_sales_list_settings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDLoaiThietBi` (`IDLoaiThietBi`);

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uq_baiviet_slug` (`Slug`),
  ADD KEY `idx_baiviet_tacgia` (`TacGia`(768)),
  ADD KEY `idx_baiviet_danhmuc` (`DanhMucID`);

--
-- Indexes for table `bai_viet_the`
--
ALTER TABLE `bai_viet_the`
  ADD PRIMARY KEY (`BaiVietID`,`TheID`),
  ADD KEY `fk_bvt_the` (`TheID`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDDonHang` (`IDDonHang`),
  ADD KEY `IDThietBi` (`IDThietBi`);

--
-- Indexes for table `chitietthongsothietbi`
--
ALTER TABLE `chitietthongsothietbi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDThietBi` (`IDThietBi`),
  ADD KEY `IDThongSo` (`IDThongSo`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cuahang`
--
ALTER TABLE `cuahang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uq_danhmuc_slug` (`Slug`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDNguoiDung` (`IDNguoiDung`);

--
-- Indexes for table `giaodichthanhtoan`
--
ALTER TABLE `giaodichthanhtoan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MaDonHangThamChieu` (`MaDonHangThamChieu`),
  ADD KEY `IDNguoiDung` (`IDNguoiDung`),
  ADD KEY `IDX_GiaoDich_MaGiaoDichCongTT` (`MaGiaoDichCongTT`);

--
-- Indexes for table `hinhanhthietbi`
--
ALTER TABLE `hinhanhthietbi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDThietBi` (`IDThietBi`);

--
-- Indexes for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `loaithietbi`
--
ALTER TABLE `loaithietbi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mucgiohang`
--
ALTER TABLE `mucgiohang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDNguoiDung` (`IDNguoiDung`),
  ADD KEY `IDThietBi` (`IDThietBi`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`);

--
-- Indexes for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDLienHe` (`IDLienHe`);

--
-- Indexes for table `phantich`
--
ALTER TABLE `phantich`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `poster_settings`
--
ALTER TABLE `poster_settings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDKhuyenMai` (`IDKhuyenMai`);

--
-- Indexes for table `sanpham_khuyenmai`
--
ALTER TABLE `sanpham_khuyenmai`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UK_ThietBi_KhuyenMai` (`IDThietBi`,`IDKhuyenMai`),
  ADD KEY `IDKhuyenMai` (`IDKhuyenMai`);

--
-- Indexes for table `the`
--
ALTER TABLE `the`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uq_the_slug` (`Slug`);

--
-- Indexes for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDLoaiThietBi` (`IDLoaiThietBi`);

--
-- Indexes for table `thongsokythuat`
--
ALTER TABLE `thongsokythuat`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_sales_list_settings`
--
ALTER TABLE `admin_sales_list_settings`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chitietthongsothietbi`
--
ALTER TABLE `chitietthongsothietbi`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cuahang`
--
ALTER TABLE `cuahang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `giaodichthanhtoan`
--
ALTER TABLE `giaodichthanhtoan`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hinhanhthietbi`
--
ALTER TABLE `hinhanhthietbi`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loaithietbi`
--
ALTER TABLE `loaithietbi`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mucgiohang`
--
ALTER TABLE `mucgiohang`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phanhoi`
--
ALTER TABLE `phanhoi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `phantich`
--
ALTER TABLE `phantich`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poster_settings`
--
ALTER TABLE `poster_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sanpham_khuyenmai`
--
ALTER TABLE `sanpham_khuyenmai`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `the`
--
ALTER TABLE `the`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `thongsokythuat`
--
ALTER TABLE `thongsokythuat`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_sales_list_settings`
--
ALTER TABLE `admin_sales_list_settings`
  ADD CONSTRAINT `admin_sales_list_settings_ibfk_1` FOREIGN KEY (`IDLoaiThietBi`) REFERENCES `loaithietbi` (`ID`);

--
-- Constraints for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `fk_baiviet_danhmuc` FOREIGN KEY (`DanhMucID`) REFERENCES `danh_muc` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `bai_viet_the`
--
ALTER TABLE `bai_viet_the`
  ADD CONSTRAINT `fk_bvt_baiviet` FOREIGN KEY (`BaiVietID`) REFERENCES `bai_viet` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bvt_the` FOREIGN KEY (`TheID`) REFERENCES `the` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `FK_ChiTietDonHang_DonHang` FOREIGN KEY (`IDDonHang`) REFERENCES `donhang` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ChiTietDonHang_ThietBi` FOREIGN KEY (`IDThietBi`) REFERENCES `thietbi` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `chitietthongsothietbi`
--
ALTER TABLE `chitietthongsothietbi`
  ADD CONSTRAINT `FK_ChiTietThongSo_ThietBi` FOREIGN KEY (`IDThietBi`) REFERENCES `thietbi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ChiTietThongSo_ThongSo` FOREIGN KEY (`IDThongSo`) REFERENCES `thongsokythuat` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `FK_DonHang_NguoiDung` FOREIGN KEY (`IDNguoiDung`) REFERENCES `nguoidung` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `giaodichthanhtoan`
--
ALTER TABLE `giaodichthanhtoan`
  ADD CONSTRAINT `FK_GiaoDichTT_DonHang` FOREIGN KEY (`MaDonHangThamChieu`) REFERENCES `donhang` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GiaoDichTT_NguoiDung` FOREIGN KEY (`IDNguoiDung`) REFERENCES `nguoidung` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `hinhanhthietbi`
--
ALTER TABLE `hinhanhthietbi`
  ADD CONSTRAINT `FK_HinhAnh_ThietBi` FOREIGN KEY (`IDThietBi`) REFERENCES `thietbi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mucgiohang`
--
ALTER TABLE `mucgiohang`
  ADD CONSTRAINT `FK_MucGioHang_NguoiDung` FOREIGN KEY (`IDNguoiDung`) REFERENCES `nguoidung` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MucGioHang_ThietBi` FOREIGN KEY (`IDThietBi`) REFERENCES `thietbi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `phanhoi_ibfk_1` FOREIGN KEY (`IDLienHe`) REFERENCES `lienhe` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `poster_settings`
--
ALTER TABLE `poster_settings`
  ADD CONSTRAINT `poster_settings_ibfk_1` FOREIGN KEY (`IDKhuyenMai`) REFERENCES `khuyenmai` (`ID`);

--
-- Constraints for table `sanpham_khuyenmai`
--
ALTER TABLE `sanpham_khuyenmai`
  ADD CONSTRAINT `FK_SanPham_KhuyenMai_KhuyenMai` FOREIGN KEY (`IDKhuyenMai`) REFERENCES `khuyenmai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SanPham_KhuyenMai_ThietBi` FOREIGN KEY (`IDThietBi`) REFERENCES `thietbi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `FK_ThietBi_LoaiThietBi` FOREIGN KEY (`IDLoaiThietBi`) REFERENCES `loaithietbi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
