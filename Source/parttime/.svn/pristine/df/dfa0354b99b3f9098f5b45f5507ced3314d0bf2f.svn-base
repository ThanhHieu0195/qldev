/*
SQLyog Ultimate v8.3 
MySQL - 5.0.45-community-nt : Database - nhilong_vongda
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`nhilong_vongda` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `nhilong_vongda`;

/*Table structure for table `chitietdoanhthu` */

DROP TABLE IF EXISTS `chitietdoanhthu`;

CREATE TABLE `chitietdoanhthu` (
  `maso` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `maloai` int(11) NOT NULL,
  `sotien` float NOT NULL,
  PRIMARY KEY  (`maso`,`maloai`),
  KEY `FK_chitietdoanhthu_loaitranh` (`maloai`),
  CONSTRAINT `FK_chitietdoanhthu_doanhthu` FOREIGN KEY (`maso`) REFERENCES `doanhthu` (`maso`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_chitietdoanhthu_loaitranh` FOREIGN KEY (`maloai`) REFERENCES `loaitranh` (`maloai`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `chitietdonhang` */

DROP TABLE IF EXISTS `chitietdonhang`;

CREATE TABLE `chitietdonhang` (
  `madon` varchar(11) collate utf8_unicode_ci NOT NULL,
  `masotranh` varchar(50) collate utf8_unicode_ci NOT NULL,
  `makho` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `giaban` float NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT '0: Chờ giao; 1: Đã giao; 2: Cần sản xuất; 3: Đang sản xuất',
  PRIMARY KEY  (`madon`,`masotranh`,`makho`),
  KEY `FK_chitietdonhang_tranh` (`masotranh`),
  KEY `FK_chitietdonhang_khohang` (`makho`),
  CONSTRAINT `FK_chitietdonhang` FOREIGN KEY (`madon`) REFERENCES `donhang` (`madon`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_chitietdonhang_khohang` FOREIGN KEY (`makho`) REFERENCES `khohang` (`makho`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_chitietdonhang_tranh` FOREIGN KEY (`masotranh`) REFERENCES `tranh` (`masotranh`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` tinytext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `dathang` */

DROP TABLE IF EXISTS `dathang`;

CREATE TABLE `dathang` (
  `masotranh` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Chuỗi mã số ghi trên bức tranh',
  `tentranh` varchar(100) collate utf8_unicode_ci default NULL,
  `maloai` int(11) default NULL,
  `dai` varchar(10) collate utf8_unicode_ci default NULL,
  `rong` varchar(10) collate utf8_unicode_ci default NULL,
  `soluong` int(11) default NULL,
  `giaban` float default NULL,
  `makho` int(11) default NULL,
  `matho` varchar(11) collate utf8_unicode_ci default NULL,
  `ghichu` text collate utf8_unicode_ci,
  `hinhanh` varchar(100) collate utf8_unicode_ci default NULL,
  `madon` varchar(11) collate utf8_unicode_ci default NULL,
  `nguoidat` varchar(50) collate utf8_unicode_ci default NULL,
  `ngaygiodat` datetime default NULL,
  `trangthai` int(11) default NULL COMMENT '0: Chờ giao; 2: cần sản xuất; 3: đang sản xuất',
  PRIMARY KEY  (`masotranh`),
  CONSTRAINT `FK_dathang_tranh` FOREIGN KEY (`masotranh`) REFERENCES `tranh` (`masotranh`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `doanhthu` */

DROP TABLE IF EXISTS `doanhthu`;

CREATE TABLE `doanhthu` (
  `maso` varchar(50) collate utf8_unicode_ci NOT NULL,
  `ngay` date NOT NULL,
  `makho` int(11) NOT NULL,
  `nguoicapnhat` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `ngaygiocapnhat` datetime NOT NULL,
  `tongso` float NOT NULL,
  `ghichu` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`maso`),
  KEY `FK_doanhthu_khohang` (`makho`),
  KEY `FK_doanhthu_nhanvien` (`nguoicapnhat`),
  CONSTRAINT `FK_doanhthu_khohang` FOREIGN KEY (`makho`) REFERENCES `khohang` (`makho`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_doanhthu_nhanvien` FOREIGN KEY (`nguoicapnhat`) REFERENCES `nhanvien` (`manv`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `donhang` */

DROP TABLE IF EXISTS `donhang`;

CREATE TABLE `donhang` (
  `madon` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  `ngaydat` date default NULL,
  `ngaygiao` date default NULL,
  `tongtien` float default NULL,
  `tiengiam` float default '0',
  `thanhtien` float default NULL,
  `duatruoc` float default NULL,
  `conlai` float default NULL,
  `manv` varchar(50) collate utf8_unicode_ci default NULL,
  `makhach` int(11) default NULL,
  `giamtheo` int(1) default '1' COMMENT '1 = giam theo phan tram',
  `trangthai` int(1) default NULL,
  `ghichu` text collate utf8_unicode_ci,
  `approved` tinyint(1) default '0',
  PRIMARY KEY  (`madon`),
  KEY `FK_manv` (`manv`),
  KEY `FK_makhach` (`makhach`),
  CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`manv`) REFERENCES `nhanvien` (`manv`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_makhach` FOREIGN KEY (`makhach`) REFERENCES `khach` (`makhach`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `khach` */

DROP TABLE IF EXISTS `khach`;

CREATE TABLE `khach` (
  `makhach` int(11) NOT NULL auto_increment,
  `manhom` int(11) default NULL,
  `hoten` varchar(100) collate utf8_unicode_ci default NULL,
  `diachi` varchar(255) collate utf8_unicode_ci default NULL,
  `quan` varchar(50) collate utf8_unicode_ci default NULL,
  `tp` varchar(50) collate utf8_unicode_ci default NULL,
  `tiemnang` int(1) default '0',
  `dienthoai1` varchar(20) collate utf8_unicode_ci default NULL,
  `dienthoai2` varchar(20) collate utf8_unicode_ci default NULL,
  `dienthoai3` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`makhach`),
  KEY `manhom` (`manhom`),
  CONSTRAINT `khach_ibfk_2` FOREIGN KEY (`manhom`) REFERENCES `nhomkhach` (`manhom`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=985 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `khohang` */

DROP TABLE IF EXISTS `khohang`;

CREATE TABLE `khohang` (
  `makho` int(11) NOT NULL auto_increment,
  `tenkho` varchar(50) collate utf8_unicode_ci default NULL,
  `diachi` varchar(100) collate utf8_unicode_ci default NULL,
  `dienthoai` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`makho`),
  UNIQUE KEY `ID_tenkho` (`tenkho`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `khung` */

DROP TABLE IF EXISTS `khung`;

CREATE TABLE `khung` (
  `makhung` varchar(20) collate utf8_unicode_ci NOT NULL,
  `tenkhung` varchar(50) collate utf8_unicode_ci default NULL,
  `hinhanh` varchar(50) collate utf8_unicode_ci default NULL,
  `ghichu` varchar(1000) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`makhung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `loaitranh` */

DROP TABLE IF EXISTS `loaitranh`;

CREATE TABLE `loaitranh` (
  `maloai` int(11) NOT NULL auto_increment,
  `tenloai` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`maloai`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `nhanvien` */

DROP TABLE IF EXISTS `nhanvien`;

CREATE TABLE `nhanvien` (
  `manv` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `macn` int(11) default NULL,
  `password` varchar(50) collate utf8_unicode_ci default NULL,
  `hoten` varchar(50) collate utf8_unicode_ci default NULL,
  `ngaysinh` date default NULL,
  `diachi` varchar(255) collate utf8_unicode_ci default NULL,
  `dienthoai` varchar(20) collate utf8_unicode_ci default NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY  (`manv`),
  KEY `macn` (`macn`),
  KEY `level` (`level`),
  CONSTRAINT `nhanvien_ibfk_5` FOREIGN KEY (`level`) REFERENCES `role` (`level`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `nhanvien_ibfk_6` FOREIGN KEY (`macn`) REFERENCES `khohang` (`makho`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `nhatky` */

DROP TABLE IF EXISTS `nhatky`;

CREATE TABLE `nhatky` (
  `manv` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `viec` int(11) NOT NULL,
  `idtranh` int(11) NOT NULL default '0',
  `ngay` date default NULL,
  `gio` time default NULL,
  PRIMARY KEY  (`manv`,`viec`,`idtranh`),
  KEY `FK_idtranh` (`idtranh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `nhomkhach` */

DROP TABLE IF EXISTS `nhomkhach`;

CREATE TABLE `nhomkhach` (
  `manhom` int(11) NOT NULL auto_increment,
  `tennhom` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`manhom`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quan` */

DROP TABLE IF EXISTS `quan`;

CREATE TABLE `quan` (
  `id` int(11) NOT NULL auto_increment,
  `tenquan` varchar(30) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ID_tenquan` (`tenquan`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `level` int(11) NOT NULL default '0',
  `name` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tentranh` */

DROP TABLE IF EXISTS `tentranh`;

CREATE TABLE `tentranh` (
  `id` int(11) NOT NULL auto_increment,
  `tentranh` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ID_tentranh` (`tentranh`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tho` */

DROP TABLE IF EXISTS `tho`;

CREATE TABLE `tho` (
  `matho` varchar(11) collate utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) collate utf8_unicode_ci default NULL,
  `ngaysinh` date default NULL,
  `dienthoai` varchar(20) collate utf8_unicode_ci default NULL,
  `diachi` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`matho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `thongbao` */

DROP TABLE IF EXISTS `thongbao`;

CREATE TABLE `thongbao` (
  `id` bigint(20) NOT NULL auto_increment,
  `tieude` tinytext collate utf8_unicode_ci NOT NULL,
  `noidung` text collate utf8_unicode_ci NOT NULL,
  `ngaygiotao` datetime NOT NULL,
  `ngaygiocapnhat` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tonkho` */

DROP TABLE IF EXISTS `tonkho`;

CREATE TABLE `tonkho` (
  `masotranh` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `makho` int(11) NOT NULL,
  `soluong` int(11) default NULL,
  PRIMARY KEY  (`masotranh`,`makho`),
  KEY `FK_tonkho_khohang` (`makho`),
  CONSTRAINT `FK_tonkho_khohang` FOREIGN KEY (`makho`) REFERENCES `khohang` (`makho`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_tonkho_tranh` FOREIGN KEY (`masotranh`) REFERENCES `tranh` (`masotranh`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `trangthai` */

DROP TABLE IF EXISTS `trangthai`;

CREATE TABLE `trangthai` (
  `state` int(11) NOT NULL default '0',
  `name` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tranh` */

DROP TABLE IF EXISTS `tranh`;

CREATE TABLE `tranh` (
  `masotranh` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Chuỗi mã số ghi trên bức tranh',
  `tentranh` varchar(100) collate utf8_unicode_ci default NULL,
  `maloai` int(11) default NULL,
  `dai` varchar(10) collate utf8_unicode_ci default NULL,
  `rong` varchar(10) collate utf8_unicode_ci default NULL,
  `giaban` float default NULL,
  `matho` varchar(11) collate utf8_unicode_ci default NULL,
  `ghichu` text collate utf8_unicode_ci,
  `hinhanh` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`masotranh`),
  KEY `FK_maloai` (`maloai`),
  KEY `FK_matho` (`matho`),
  CONSTRAINT `FK_tranh_loaitranh` FOREIGN KEY (`maloai`) REFERENCES `loaitranh` (`maloai`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_tranh_tho` FOREIGN KEY (`matho`) REFERENCES `tho` (`matho`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
