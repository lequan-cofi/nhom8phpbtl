CREATE TABLE `admin_sales_list_settings` (
  `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `IDLoaiThietBi` bigint(20) UNSIGNED NOT NULL,
  `SoLuongHienThi` int(11) NOT NULL DEFAULT 5,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `NgayCapNhat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NgayXoa` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDLoaiThietBi` (`IDLoaiThietBi`),
  CONSTRAINT `admin_sales_list_settings_ibfk_1` FOREIGN KEY (`IDLoaiThietBi`) REFERENCES `loaithietbi` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng cài đặt hiển thị danh sách ưu đãi theo loại thiết bị'; 