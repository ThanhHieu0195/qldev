-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `chitiethangmuccongtrinh`;
CREATE TABLE `chitiethangmuccongtrinh` (
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `ngaydukienbatdau` date NOT NULL,
  `ngaydukienketthuc` date NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `dongiahangmuc` double NOT NULL,
  `khoiluongdutoan` int(11) NOT NULL,
  `khoiluongthucte` int(11) NOT NULL,
  `khoiluongphatsinh` int(11) NOT NULL,
  `iddoithicong` int(11) NOT NULL,
  `dongiathicong` double NOT NULL,
  `tiendachi` double NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ghichu` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idcongtrinh`,`idhangmuc`),
  KEY `fk_chitiethangmuccongtrinh_hangmucthicong` (`idhangmuc`),
  KEY `fk_chitiethangmuccongtrinh_trangthaihangmuc` (`trangthai`),
  KEY `fk_chitiethangmuccongtrinh_danhsachdoithicong` (`iddoithicong`),
  CONSTRAINT `fk_chitiethangmuccongtrinh_danhsachcongtrinh` FOREIGN KEY (`idcongtrinh`) REFERENCES `danhsachcongtrinh` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chitiethangmuccongtrinh_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chitiethangmuccongtrinh_trangthaihangmuc` FOREIGN KEY (`trangthai`) REFERENCES `trangthaihangmuc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `chitiethangmuccongtrinh` (`idcongtrinh`, `idhangmuc`, `ngaydukienbatdau`, `ngaydukienketthuc`, `ngaybatdau`, `ngayketthuc`, `dongiahangmuc`, `khoiluongdutoan`, `khoiluongthucte`, `khoiluongphatsinh`, `iddoithicong`, `dongiathicong`, `tiendachi`, `trangthai`, `ghichu`) VALUES
(31,	3,	'0000-00-00',	'0000-00-00',	'2017-01-12',	'2017-01-17',	120000,	0,	10,	0,	0,	0,	0,	0,	''),
(31,	8,	'0000-00-00',	'0000-00-00',	'2017-01-14',	'2017-01-19',	700000,	10,	10,	0,	0,	0,	0,	0,	''),
(32,	3,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	120000,	10,	0,	0,	0,	0,	0,	0,	''),
(33,	1,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	120000,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	3,	'2017-01-12',	'2017-01-17',	'2017-01-12',	'2017-01-17',	120000,	0,	100,	0,	0,	0,	0,	0,	'Hi'),
(34,	4,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	500000,	11,	0,	0,	0,	0,	0,	0,	''),
(34,	5,	'0000-00-00',	'2017-01-12',	'0000-00-00',	'0000-00-00',	500000,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	6,	'2017-01-12',	'2017-01-17',	'0000-00-00',	'0000-00-00',	170000,	11,	0,	0,	0,	0,	0,	0,	''),
(34,	7,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	100000,	1,	0,	0,	0,	0,	0,	0,	''),
(34,	8,	'2017-01-14',	'2017-01-19',	'0000-00-00',	'0000-00-00',	700000,	110,	10,	0,	0,	0,	0,	0,	''),
(34,	9,	'2017-01-14',	'2017-01-20',	'0000-00-00',	'0000-00-00',	200000,	110,	0,	0,	0,	0,	0,	0,	''),
(34,	10,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	500000,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	11,	'2017-01-13',	'2017-01-14',	'2017-01-02',	'2017-01-03',	100000,	101,	120,	0,	0,	0,	0,	0,	''),
(34,	12,	'2017-01-14',	'2017-01-17',	'0000-00-00',	'0000-00-00',	200000,	170,	0,	0,	0,	0,	0,	0,	''),
(34,	13,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	14,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	15,	'2017-01-13',	'2017-01-14',	'0000-00-00',	'0000-00-00',	0,	11,	0,	0,	0,	0,	0,	0,	''),
(34,	16,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	17,	'2017-01-12',	'2017-01-13',	'0000-00-00',	'0000-00-00',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	18,	'2017-01-12',	'2017-01-13',	'2017-01-12',	'2017-01-13',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	19,	'0000-00-00',	'0000-00-00',	'0000-00-00',	'0000-00-00',	0,	10,	0,	0,	0,	0,	0,	0,	''),
(34,	21,	'2017-01-13',	'2017-01-14',	'2017-01-12',	'2017-01-13',	100000,	101,	10,	0,	0,	0,	0,	0,	'Hi all')
ON DUPLICATE KEY UPDATE `idcongtrinh` = VALUES(`idcongtrinh`), `idhangmuc` = VALUES(`idhangmuc`), `ngaydukienbatdau` = VALUES(`ngaydukienbatdau`), `ngaydukienketthuc` = VALUES(`ngaydukienketthuc`), `ngaybatdau` = VALUES(`ngaybatdau`), `ngayketthuc` = VALUES(`ngayketthuc`), `dongiahangmuc` = VALUES(`dongiahangmuc`), `khoiluongdutoan` = VALUES(`khoiluongdutoan`), `khoiluongthucte` = VALUES(`khoiluongthucte`), `khoiluongphatsinh` = VALUES(`khoiluongphatsinh`), `iddoithicong` = VALUES(`iddoithicong`), `dongiathicong` = VALUES(`dongiathicong`), `tiendachi` = VALUES(`tiendachi`), `trangthai` = VALUES(`trangthai`), `ghichu` = VALUES(`ghichu`);

DROP TABLE IF EXISTS `chitietvattucongtrinh`;
CREATE TABLE `chitietvattucongtrinh` (
  `id` int(11) NOT NULL,
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `idvattu` int(11) NOT NULL,
  `dongiavattu` double NOT NULL,
  `soluongdutoan` int(11) NOT NULL,
  `soluongthucte` int(11) NOT NULL,
  `soluongphatsinh` int(11) NOT NULL,
  `soluongdamua` int(11) NOT NULL,
  `idnhacungcap` int(11) NOT NULL,
  `dongiamua` double NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ghichu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chitiethangmucthicong_danhsachcongtrinh` (`idcongtrinh`),
  KEY `fk_chitiethangmucthicong_hangmucthicong` (`idhangmuc`),
  CONSTRAINT `fk_chitiethangmucthicong_danhsachcongtrinh` FOREIGN KEY (`idcongtrinh`) REFERENCES `danhsachcongtrinh` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chitiethangmucthicong_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `chitietvattucongtrinh` (`id`, `idcongtrinh`, `idhangmuc`, `idvattu`, `dongiavattu`, `soluongdutoan`, `soluongthucte`, `soluongphatsinh`, `soluongdamua`, `idnhacungcap`, `dongiamua`, `trangthai`, `ghichu`) VALUES
(1,	34,	3,	3,	11200,	0,	1000,	10,	0,	0,	0,	0,	''),
(2,	31,	3,	3,	11200,	0,	10,	0,	0,	0,	0,	0,	''),
(3,	32,	3,	3,	11200,	10,	0,	0,	0,	0,	0,	0,	'')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `idcongtrinh` = VALUES(`idcongtrinh`), `idhangmuc` = VALUES(`idhangmuc`), `idvattu` = VALUES(`idvattu`), `dongiavattu` = VALUES(`dongiavattu`), `soluongdutoan` = VALUES(`soluongdutoan`), `soluongthucte` = VALUES(`soluongthucte`), `soluongphatsinh` = VALUES(`soluongphatsinh`), `soluongdamua` = VALUES(`soluongdamua`), `idnhacungcap` = VALUES(`idnhacungcap`), `dongiamua` = VALUES(`dongiamua`), `trangthai` = VALUES(`trangthai`), `ghichu` = VALUES(`ghichu`);

DROP TABLE IF EXISTS `congviechangmucthicong`;
CREATE TABLE `congviechangmucthicong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idhangmuc` int(11) NOT NULL,
  `motacongviec` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tieuchihoanthanh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_congviechangmucthicong_hangmucthicong` (`idhangmuc`),
  CONSTRAINT `fk_congviechangmucthicong_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `congviechangmucthicong` (`id`, `idhangmuc`, `motacongviec`, `tieuchihoanthanh`) VALUES
(1,	1,	'Dán cửa',	'Kín hết cửa'),
(2,	1,	'Dán bản vẽ',	'Đủ bản vẽ'),
(3,	1,	'Dán Qui Định',	'Dán xong nội qui'),
(4,	1,	'Trải bạt bảo vệ phòng giặt',	'Trải hết phòng giặt'),
(5,	1,	'Lắp bàn cầu tạm',	'Hoàn thành'),
(6,	1,	'Tập kết vật tư',	'Đủ cho phần xây dựng')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `idhangmuc` = VALUES(`idhangmuc`), `motacongviec` = VALUES(`motacongviec`), `tieuchihoanthanh` = VALUES(`tieuchihoanthanh`);

DROP TABLE IF EXISTS `danhsachcongtrinh`;
CREATE TABLE `danhsachcongtrinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tencongtrinh` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `makhach` int(11) NOT NULL,
  `manvsale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manvthietke` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manvgiamsat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ngaykhoicong` date NOT NULL,
  `ngaydukienhoanthanh` date NOT NULL,
  `giatridutoan` double NOT NULL,
  `giatriphatsinh` double NOT NULL,
  `giatrithucte` double NOT NULL,
  `tiendathu` double NOT NULL,
  `tiendachi` double NOT NULL,
  PRIMARY KEY (`id`,`tencongtrinh`),
  KEY `fk_danhsachcongtrinh_trangthaicongtrinh` (`trangthai`),
  KEY `fk_danhsachcongtrinh_khach` (`makhach`),
  CONSTRAINT `fk_danhsachcongtrinh_khach` FOREIGN KEY (`makhach`) REFERENCES `khach` (`makhach`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_danhsachcongtrinh_trangthaicongtrinh` FOREIGN KEY (`trangthai`) REFERENCES `trangthaicongtrinh` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `danhsachcongtrinh` (`id`, `tencongtrinh`, `diachi`, `makhach`, `manvsale`, `manvthietke`, `manvgiamsat`, `trangthai`, `ngaykhoicong`, `ngaydukienhoanthanh`, `giatridutoan`, `giatriphatsinh`, `giatrithucte`, `tiendathu`, `tiendachi`) VALUES
(31,	'TEST999',	'Q10',	6996,	'admin',	'admin',	'admin',	3,	'2017-01-12',	'2017-01-15',	9510000,	0,	8312000,	0,	0),
(32,	'GGG',	'fdf',	6999,	'admin',	'admin',	'admin',	0,	'2017-01-12',	'2017-01-13',	1312000,	0,	0,	0,	0),
(33,	'YYYYY',	'DDD',	6999,	'admin',	'admin',	'admin',	0,	'2017-01-13',	'2017-01-13',	0,	0,	0,	0,	0),
(34,	'CONGTRINH01',	'Q7',	7000,	'admin',	'admin',	'admin',	3,	'2017-01-13',	'2017-01-15',	186414000,	0,	43200000,	0,	0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `tencongtrinh` = VALUES(`tencongtrinh`), `diachi` = VALUES(`diachi`), `makhach` = VALUES(`makhach`), `manvsale` = VALUES(`manvsale`), `manvthietke` = VALUES(`manvthietke`), `manvgiamsat` = VALUES(`manvgiamsat`), `trangthai` = VALUES(`trangthai`), `ngaykhoicong` = VALUES(`ngaykhoicong`), `ngaydukienhoanthanh` = VALUES(`ngaydukienhoanthanh`), `giatridutoan` = VALUES(`giatridutoan`), `giatriphatsinh` = VALUES(`giatriphatsinh`), `giatrithucte` = VALUES(`giatrithucte`), `tiendathu` = VALUES(`tiendathu`), `tiendachi` = VALUES(`tiendachi`);

DROP TABLE IF EXISTS `danhsachdoithicong`;
CREATE TABLE `danhsachdoithicong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tendoi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sodienthoai` varchar(255) CHARACTER SET latin1 NOT NULL,
  `madoi` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nanglucdapung` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `danhsachdoithicong` (`id`, `tendoi`, `diachi`, `sodienthoai`, `madoi`, `nanglucdapung`) VALUES
(3,	'LSX',	'Q7',	'0992919192',	'LSX0001',	NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `tendoi` = VALUES(`tendoi`), `diachi` = VALUES(`diachi`), `sodienthoai` = VALUES(`sodienthoai`), `madoi` = VALUES(`madoi`), `nanglucdapung` = VALUES(`nanglucdapung`);

DROP TABLE IF EXISTS `danhsachnhacungcap`;
CREATE TABLE `danhsachnhacungcap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(255) CHARACTER SET latin1 NOT NULL,
  `dienthoai` varchar(255) CHARACTER SET latin1 NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `manhacc` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_danhsachnhacungcap_hangmucthicong` (`idhangmuc`),
  CONSTRAINT `fk_danhsachnhacungcap_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `danhsachnhacungcap` (`id`, `ten`, `diachi`, `dienthoai`, `idhangmuc`, `manhacc`) VALUES
(1,	'NHI LONG',	'Quan 7',	'0873048948',	1,	'NHILONG')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `ten` = VALUES(`ten`), `diachi` = VALUES(`diachi`), `dienthoai` = VALUES(`dienthoai`), `idhangmuc` = VALUES(`idhangmuc`), `manhacc` = VALUES(`manhacc`);

DROP TABLE IF EXISTS `hangmucdoithicong`;
CREATE TABLE `hangmucdoithicong` (
  `madoithicong` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `giatien` double NOT NULL,
  PRIMARY KEY (`madoithicong`,`idhangmuc`),
  KEY `fk_hangmucdoithicong_hangmucthicong` (`idhangmuc`),
  CONSTRAINT `fk_hangmucdoithicong_danhsachdoithicong` FOREIGN KEY (`madoithicong`) REFERENCES `danhsachdoithicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hangmucdoithicong_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `hangmucdoithicong` (`madoithicong`, `idhangmuc`, `giatien`) VALUES
(3,	4,	100000),
(3,	10,	1000000)
ON DUPLICATE KEY UPDATE `madoithicong` = VALUES(`madoithicong`), `idhangmuc` = VALUES(`idhangmuc`), `giatien` = VALUES(`giatien`);

DROP TABLE IF EXISTS `hangmucthicong`;
CREATE TABLE `hangmucthicong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenhangmuc` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nhomhangmuc` varchar(25) CHARACTER SET latin1 NOT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `songaythicong` int(11) DEFAULT NULL,
  `dongiathdutoan` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `hangmucthicong` (`id`, `tenhangmuc`, `nhomhangmuc`, `mota`, `songaythicong`, `dongiathdutoan`) VALUES
(1,	'Chuan bi',	'1',	'Chuẩn bị thi công',	2,	120000),
(3,	'Xay Dung',	'1',	'Xây tô tường ngăn',	5,	120000),
(4,	'Dien Nuoc',	'2',	'Phần Điện Nước',	4,	500000),
(5,	'Dien Lanh',	'4',	'Điện Lạnh',	3,	500000),
(6,	'Tran Thach Cao',	'2',	'Làm trần thạch cao',	5,	170000),
(7,	'Khoet Den Lon',	'3',	'Khoét Đèn Lon',	1,	100000),
(8,	'Lot Gach - Can Nen',	'2',	'Lót Gạch - Cán Nền',	5,	700000),
(9,	'Ba Bot - Son Nuoc',	'2',	'Bả Bột - Sơn Nước',	6,	200000),
(10,	'Nghiem Thu Tho',	'3',	'Nghiệm Thu Thô',	1,	500000),
(11,	'Chinh Sua Tho',	'1',	'Chỉnh Sửa Thô',	1,	100000),
(12,	'Son Nuoc Hoan Thien',	'2',	'Sơn Nước Hoàn Thiện',	3,	200000),
(13,	'Lap Dat Thiet Bi',	'3',	'Lắp Đặt Thiết Bị',	2,	0),
(14,	'Lap dat San Go',	'3',	'Lắp Đặt Sàn Gỗ',	1,	0),
(15,	'Lap Cua Di',	'2',	'Lắp Cửa Đi',	1,	0),
(16,	'Lap Do Go Module',	'4',	'Lắp Module',	1,	0),
(17,	'Vach Trang Tri - Mat Da',	'2',	'Vách Trang Trí - Mặt Đá',	1,	0),
(18,	'Lap Phan Bu - Do Roi',	'1',	'Lắp Phần Bù và Giao đồ rời',	1,	1000000),
(19,	'Hoan Thien va Giao Nha',	'3',	'Làm vệ sinh, Silicon và giao nhà',	2,	0),
(21,	'Test',	'1',	'TTT',	1,	100000)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `tenhangmuc` = VALUES(`tenhangmuc`), `nhomhangmuc` = VALUES(`nhomhangmuc`), `mota` = VALUES(`mota`), `songaythicong` = VALUES(`songaythicong`), `dongiathdutoan` = VALUES(`dongiathdutoan`);

DROP TABLE IF EXISTS `lichchitiendoithicong`;
CREATE TABLE `lichchitiendoithicong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `iddoithicong` int(11) NOT NULL,
  `ngaychi` date NOT NULL,
  `phantram` int(11) NOT NULL,
  `noidungchi` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT '0:chuachi,1:dachi',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `lichsukiemtracongtrinh`;
CREATE TABLE `lichsukiemtracongtrinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `manhanvien` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngaykiemtra` datetime NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT '0:Yeucau,1:Dakiemtra,2:Daduyet',
  `hinhanh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ghichu` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `trangthaicongtrinh`;
CREATE TABLE `trangthaicongtrinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `trangthaicongtrinh` (`id`, `mota`) VALUES
(0,	'Khởi tạo\n'),
(1,	'Chờ duyệt dự toán'),
(2,	'Chờ dữ liệu sau thiết kế'),
(3,	'Đang thi công'),
(4,	'Hoàn tất')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `mota` = VALUES(`mota`);

DROP TABLE IF EXISTS `trangthaihangmuc`;
CREATE TABLE `trangthaihangmuc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `trangthaihangmuc` (`id`, `mota`) VALUES
(0,	'Khởi tạo'),
(1,	'Chọn thầu'),
(2,	'Yêu cầu vật tư'),
(3,	'Vật tư sẳn sàng'),
(4,	'Đang thi công'),
(5,	'Cần kiểm soát'),
(6,	'Hoàn thành'),
(7,	'Đã thanh toán')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `mota` = VALUES(`mota`);

DROP TABLE IF EXISTS `vattuhangmucthicong`;
CREATE TABLE `vattuhangmucthicong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idhangmuc` int(11) NOT NULL,
  `tenvattu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thongso` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `giathap` double NOT NULL,
  `giacao` double NOT NULL,
  `donvitinh` int(11) NOT NULL COMMENT '0:m2,1:cai',
  PRIMARY KEY (`id`),
  KEY `fk_vattuhangmucthicong_hangmucthicong` (`idhangmuc`),
  CONSTRAINT `fk_vattuhangmucthicong_hangmucthicong` FOREIGN KEY (`idhangmuc`) REFERENCES `hangmucthicong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `vattuhangmucthicong` (`id`, `idhangmuc`, `tenvattu`, `thongso`, `giathap`, `giacao`, `donvitinh`) VALUES
(1,	1,	'VT01',	'2mx5m',	10000,	11000,	1),
(2,	1,	'Xi mang Ha Tien',	'0x6',	100000,	120000,	3),
(3,	3,	'Gach',	'1x2',	10000,	11200,	3)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `idhangmuc` = VALUES(`idhangmuc`), `tenvattu` = VALUES(`tenvattu`), `thongso` = VALUES(`thongso`), `giathap` = VALUES(`giathap`), `giacao` = VALUES(`giacao`), `donvitinh` = VALUES(`donvitinh`);

DROP TABLE IF EXISTS `yeucauthaydoihangmuc`;
CREATE TABLE `yeucauthaydoihangmuc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `ngayyeucau` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `khoiluongbandau` int(11) NOT NULL,
  `khoiluongthaydoi` int(11) NOT NULL,
  `nhanvienyeucau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvienduyet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT '0:open,1:approved,2:rejected',
  `ghichu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `yeucauthaydoivattu`;
CREATE TABLE `yeucauthaydoivattu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcongtrinh` int(11) NOT NULL,
  `idhangmuc` int(11) NOT NULL,
  `idvattu` int(11) NOT NULL,
  `ngayyeucau` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `khoiluongbandau` int(11) NOT NULL,
  `khoiluongthaydoi` int(11) NOT NULL,
  `nhanvienyeucau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvienduyet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT '0:open,1:approved,2:rejected',
  `ghichu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2017-01-14 00:02:24