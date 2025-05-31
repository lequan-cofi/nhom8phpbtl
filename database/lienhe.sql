-- Table for storing customer contacts
CREATE TABLE IF NOT EXISTS `lienhe` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ChuDe` varchar(200) NOT NULL,
  `NoiDung` text NOT NULL,
  `TrangThai` enum('Chưa xử lý','Đã xử lý') NOT NULL DEFAULT 'Chưa xử lý',
  `NgayTao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NgayCapNhat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for storing admin responses
CREATE TABLE IF NOT EXISTS `phanhoi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDLienHe` int(11) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayTao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NgayCapNhat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `IDLienHe` (`IDLienHe`),
  CONSTRAINT `phanhoi_ibfk_1` FOREIGN KEY (`IDLienHe`) REFERENCES `lienhe` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 