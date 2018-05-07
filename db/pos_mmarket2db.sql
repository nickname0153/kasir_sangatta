-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2015 at 11:00 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos_mmarket2db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `kd_barang` char(7) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `kd_jenis` char(5) NOT NULL,
  `kd_merek` char(4) NOT NULL,
  `satuan_beli` varchar(20) NOT NULL,
  `beli_isi` int(4) NOT NULL,
  `satuan_jual` varchar(20) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `diskon` int(4) NOT NULL,
  `stok` int(4) NOT NULL,
  `stok_opname` int(4) NOT NULL,
  `stok_minimal` int(4) NOT NULL,
  `stok_maksimal` int(4) NOT NULL,
  PRIMARY KEY (`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `barcode`, `nm_barang`, `kd_jenis`, `kd_merek`, `satuan_beli`, `beli_isi`, `satuan_jual`, `harga_beli`, `harga_jual`, `diskon`, `stok`, `stok_opname`, `stok_minimal`, `stok_maksimal`) VALUES
('B000002', 'S000004317', 'Kunci Mas Minyak Goreng Botol 1.9L', 'J0001', 'M014', 'Kds', 12, 'Btl', 23000, 27900, 0, 24, 0, 10, 40),
('B000001', 'S000004318 ', 'Kunci Mas Minyak Goreng Pouch 2L', 'J0001', 'M014', 'Kds', 12, 'Pch', 25000, 30100, 0, 24, 0, 8, 30),
('B000003', 'S000011252 ', 'Tropical Minyak Goreng Botol 1000ml', 'J0001', 'M021', 'Kds', 12, 'Btl', 11000, 15000, 0, 24, 0, 10, 48),
('B000004', 'S000011253 ', 'Tropical Minyak Goreng Botol 2000ml', 'J0001', 'M021', 'Kds', 12, 'Btl', 24000, 29700, 0, 24, 0, 8, 36),
('B000005', 'S000004312 ', 'Filma Minyak Goreng Botol 1L', 'J0001', 'M009', 'Kds', 12, 'Botol', 10000, 14500, 0, 0, 0, 8, 36),
('B000006', 'S000015255 ', 'Sania Minyak Goreng Botol 1L', 'J0001', 'M019', 'Kds', 12, 'Btl', 11000, 16900, 0, 0, 0, 10, 48),
('B000007', 'S000015256 ', 'Sania Minyak Goreng Botol 2L', 'J0001', 'M019', 'Kds', 12, 'Botol', 25000, 30500, 0, 0, 0, 8, 48),
('B000008', 'S000015258 ', 'Sania Minyak Goreng Jerigen 5L', 'J0001', 'M019', 'Kds', 12, 'Jerigen ', 60000, 74900, 0, 0, 0, 7, 24),
('B000009', 'S000015260 ', 'Sania Minyak Goreng Pouch 2L', 'J0001', 'M019', 'Kds', 12, 'Pch', 25000, 299000, 0, 0, 0, 8, 48),
('B000010', 'S000015263 ', 'Sovia Minyak Goreng Pouch 2L', 'J0001', 'M020', 'Kds', 12, 'Pch', 23000, 27900, 0, 0, 0, 8, 48),
('B000011', 'S000011254 ', 'Tropical Minyak Goreng Jerigen 5L', 'J0001', 'M021', 'Kds', 12, 'Jerigen ', 60000, 74900, 0, 12, 0, 6, 36),
('B000012', 'S000011250 ', 'Tropical Minyak Goreng Refill Pouch 1000ml', 'J0001', 'M021', 'Kds', 12, 'Pch', 9000, 14000, 0, 24, 0, 10, 60),
('B000013', 'S000007890 ', 'Filma Minyak Goreng Jerigen 5L', 'J0001', 'M009', 'Kds', 12, 'Jerigen ', 65000, 78900, 0, 0, 0, 6, 36),
('B000014', 'S000004314', 'Filma Minyak Goreng Pouch 2L', 'J0001', 'M009', 'Kds', 12, 'Pch', 15000, 19500, 0, 0, 0, 10, 48),
('B000015', 'S000011251 ', 'Tropical Minyak Goreng Refill Pouch 2000ml', 'J0001', 'M021', 'Kds', 12, 'Kds', 24000, 28800, 0, 0, 0, 8, 48),
('B000016', 'S000000272 ', 'Bimoli Classic 2L', 'J0001', 'M003', 'Kds', 12, 'Pch', 25000, 30500, 0, 0, 0, 8, 48),
('B000017', 'S000000273 ', 'Bimoli Classic Pouch 2L', 'J0001', 'M003', 'Kds', 12, 'Pch', 26000, 31900, 0, 0, 0, 8, 48),
('B000018', 'S000000274 ', 'Bimoli Special 2L', 'J0001', 'M003', 'Kds', 12, 'Pch', 27000, 32500, 0, 0, 0, 8, 48),
('B000019', 'S000030869 ', '(Promosi) Forvita Minyak Goreng Refill 1.8L + Forvita Margarine 200g', 'J0001', 'M010', 'Kds', 12, 'Pch', 20000, 24900, 0, 0, 0, 12, 48),
('B000020', 'S000016303', 'Forvita Minyak Goreng Refill 1.8L', 'J0001', 'M010', 'Kds', 12, 'Pch', 23000, 27900, 0, 0, 0, 12, 48),
('B000021', 'S000019490', 'Mama Suka Minyak Goreng Jagung 900Ml', 'J0001', 'M015', 'Kds', 12, 'Btl', 40000, 48000, 0, 0, 0, 12, 60),
('B000022', 'S000019489 ', 'Mama Suka Minyak Goreng Kedelai 900Ml', 'J0001', 'M015', 'Kds', 12, 'Btl', 33000, 39900, 0, 0, 0, 12, 48),
('B000023', 'S000000038 ', 'ABC Minyak Wijen 195ml', 'J0001', 'M001', 'Kds', 12, 'Btl', 24000, 29900, 0, 0, 0, 10, 60),
('B000024', 'S000005436', 'Tropicana Slim Corn Oil 1000ml', 'J0001', 'M022', 'Kds', 12, 'Pck', 60000, 72000, 0, 0, 0, 8, 60),
('B000025', 'S000019719 ', 'S&W Distilled White Vinegar 32Oz', 'J0001', 'M018', 'Kds', 12, 'Btl', 35000, 43300, 0, 0, 0, 12, 72),
('B000026', 'S000019721', 'S&W Red Wine Vinegar 16Oz', 'J0001', 'M018', 'Kds', 12, 'Btl', 25000, 31500, 0, 0, 0, 12, 72),
('B000027', 'S000019722', 'S&W Ripe Olive Extra Large Pitted (Hijau) 396g', 'J0001', 'M018', 'Kds', 12, 'Klg', 26000, 32500, 0, 0, 0, 12, 60),
('B000028', 'S000019723', 'S&W Ripe Olive Large Pitted (Merah) 396g', 'J0001', 'M018', 'Kds', 12, 'Klg', 26000, 32500, 0, 0, 0, 12, 60),
('B000029', 'S000014095', 'Rafael Salgado Olive Pomace Oil Blended 250ml', 'J0001', 'M017', 'Kds', 12, 'Btl', 28000, 34900, 0, 24, 0, 10, 60),
('B000030', 'S000014096', 'Rafael Salgado Olive Pomace Oil Blended 500ml', 'J0001', 'M017', 'Kds', 12, 'Btl', 52000, 62900, 0, 24, 0, 10, 72),
('B000031', 'S000018041 ', 'Mazola Canola Oil 450ml', 'J0001', 'M016', 'Kds', 12, 'Btl', 31000, 38500, 0, 0, 0, 10, 48),
('B000032', 'S000002500', 'Mazola Corn Oil 1.5L', 'J0001', 'M016', 'Kds', 12, 'Btl', 90000, 111900, 0, 0, 0, 8, 36),
('B000033', 'S000018040 ', 'Mazola Corn Oil 450ml', 'J0001', 'M016', 'Kds', 12, 'Btl', 30000, 37500, 0, 0, 0, 12, 50),
('B000034', 'S000018043', 'Mazola Soya Bean Oil 450ml', 'J0001', 'M016', 'Kds', 12, 'Btl', 26000, 31900, 0, 0, 0, 8, 48),
('B000035', 'S000002506', 'Mazola Soya Bean Oil 900ml', 'J0001', 'M016', 'Kds', 12, 'Btl', 45000, 54900, 0, 0, 0, 12, 60),
('B000036', 'S000018042 ', 'Mazola Sunflower Oil 450ml', 'J0001', 'M016', 'Kds', 12, 'Btl', 27000, 32500, 0, 0, 0, 8, 40),
('B000037', 'S000012009', 'Green Tosca Macadamia Oil 500ml', 'J0001', 'M012', 'Kds', 12, 'Btl', 145000, 175900, 0, 0, 0, 10, 48),
('B000038', 'S000012014 ', 'Green Tosca Apricot Kernel Oil 500ml', 'J0001', 'M012', 'Kds', 12, 'Btl', 17000, 203500, 0, 0, 0, 10, 36),
('B000039', 'S000012012', 'Green Tosca Sesame Oil 500ml', 'J0001', 'M012', 'Kds', 12, 'Btl', 170000, 203500, 0, 0, 0, 8, 48),
('B000040', 'S000019401', 'Fraiswell Refill 2L', 'J0001', 'M011', 'Kds', 12, 'Pch', 22000, 26500, 0, 0, 0, 8, 48),
('B000041', 'S000005900', 'Clovis Sherry Vinegar 500ml', 'J0001', 'M005', 'Kds', 12, 'Btl', 55000, 67400, 0, 0, 0, 8, 36),
('B000042', 'S000004884', 'Dougo Corn Oil 1L', 'J0001', 'M006', 'Kds', 12, 'Btl', 57000, 68500, 0, 0, 0, 8, 36),
('B000043', 'S000018044', 'Filippo Berio Extra Virgin Olive Oil 250ml', 'J0001', 'M007', 'Kds', 12, 'Btl', 36000, 44900, 0, 0, 0, 8, 36),
('B000044', 'S000018046', 'Filippo Extra Light Olive Oil 250ml', 'J0001', 'M007', 'Kds', 12, 'Btl', 35000, 43900, 0, 0, 0, 10, 48),
('B000045', 'S000018048', 'Filippo Extra Light Olive Oil Spray 200ml', 'J0001', 'M007', 'Kds', 12, 'Btl', 52000, 62400, 0, 0, 0, 8, 36),
('B000046', 'S000018047', 'Filippo Extra Virgin Olive Oil Spray 200ml', 'J0001', 'M007', 'Kds', 12, 'Btl', 57000, 67500, 0, 0, 0, 8, 36),
('B000047', 'S000018045 ', 'Filippo Pure Olive Oil 250ml', 'J0001', 'M007', 'Kds', 12, 'Btl', 36000, 44900, 0, 0, 0, 10, 40),
('B000048', 'S000002831', 'Filippo Berio Balsamic Vinegar of Modena 500ml', 'J0001', 'M008', 'Kds', 12, 'Btl', 45000, 54900, 0, 0, 0, 8, 36),
('B000049', 'S000002832', 'Filippo Berio Extra Light Olive Oil 500ml', 'J0001', 'M008', 'Kds', 12, 'Btl', 63000, 76500, 0, 0, 0, 8, 36),
('B000050', 'S000002834', 'Filippo Berio Extra Virgin Olive Oil 500ml', 'J0001', 'M008', 'Kds', 12, 'Btl', 68000, 81500, 0, 0, 0, 8, 36),
('B000051', 'S000002833', 'Filippo Berio Pure Olive Oil 500ml', 'J0001', 'M008', 'Kds', 12, 'Btl', 65000, 77500, 0, 0, 0, 8, 36),
('B000052', 'S000007887', 'Bertolli Classico Olive Oil 1L', 'J0001', 'M002', 'Kds', 12, 'Btl', 130000, 158900, 0, 0, 0, 8, 30),
('B000053', 'S000002148 ', 'Bertolli Classico Olive Oil 250ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 36000, 43900, 0, 0, 0, 10, 38),
('B000054', 'S000002119 ', 'Bertolli Classico Olive Oil 500ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 67000, 80900, 0, 0, 0, 8, 30),
('B000055', 'S000002147', 'Bertolli Extra Light Olive Oil 250ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 36000, 43900, 0, 0, 0, 10, 38),
('B000056', 'S000002146', 'Bertolli Extra Virgin Olive Oil 250ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 38000, 46900, 0, 0, 0, 10, 38),
('B000057', 'S000002118', 'Bertolli Extra Light Olive Oil 500ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 67000, 80900, 0, 0, 0, 8, 30),
('B000058', 'S000007888', 'Bertolli Extra Light Olive Oil 1L', 'J0001', 'M002', 'Kds', 12, 'Btl', 132000, 158900, 0, 0, 0, 8, 30),
('B000059', 'S000002117 ', 'Bertolli Extra Virgin Olive Oil 500ml', 'J0001', 'M002', 'Kds', 12, 'Btl', 71000, 75900, 0, 0, 0, 8, 30),
('B000060', 'S000001172', 'Blue Band Margarine Cake & Cookie Tin 1 kg', 'J0002', 'M023', 'Kds', 12, 'Klg', 37000, 44500, 0, 24, 0, 10, 38),
('B000061', 'S000023533 ', 'Blue Band Serbaguna Sachet 200g', 'J0002', 'M023', 'Kds', 12, 'Sct', 4500, 6200, 0, 36, 0, 12, 84),
('B000062', 'S000023532 ', 'Blue Band Serbaguna Tube 250g', 'J0002', 'M023', 'Kds', 12, 'Tub', 8000, 10500, 0, 36, 0, 12, 72),
('B000063', 'S000001176', 'Blue Band Margarine Tub 250g', 'J0002', 'M023', 'Kds', 12, 'Tub', 8000, 10200, 0, 36, 0, 12, 72),
('B000064', 'S000004315 ', 'Filma Margarine 250g', 'J0002', 'M024', 'Kds', 12, 'Sct', 6000, 8000, 0, 0, 0, 10, 60),
('B000065', 'S000011256 ', 'Forvita Margarine 200g', 'J0002', 'M025', 'Kds', 12, 'tub', 3500, 4500, 0, 0, 0, 12, 48),
('B000066', 'S000000913 ', 'Bogasari Tepung Terigu Segitiga Biru Premium 1 kg', 'J0007', 'M026', 'Kds', 12, 'Pck', 80000, 99000, 0, 24, 0, 10, 48),
('B000067', 'S000000915 ', 'Bogasari Tepung Terigu Cakra Kembar 1 kg', 'J0007', 'M026', 'Kds', 12, 'Pck', 8500, 10900, 0, 24, 0, 10, 60),
('B000068', 'S000000914 ', 'Bogasari Tepung Terigu Kunci Biru Premium 1 kg', 'J0007', 'M026', 'Kds', 12, 'Pck', 80000, 99000, 0, 0, 0, 10, 48),
('B000069', 'S000005249 ', 'Hercules Tepung Custard 300g', 'J0007', 'M027', 'Kds', 12, 'Pck', 21000, 25900, 0, 0, 0, 12, 60),
('B000070', 'S000003253', 'Kruawangthip Tempura Flavour Seafood 500g', 'J0007', 'M029', 'Kds', 12, 'Pck', 20000, 24900, 0, 0, 0, 10, 60),
('B000071', 'Mama Suka Tepung Rot', 'Mama Suka Tepung Roti 200G', 'J0007', 'M030', 'Kds', 12, 'Pck', 10500, 13600, 0, 0, 0, 10, 60),
('B000072', 'S000011309 ', 'Honig Maizena 150g', 'J0007', 'M028', 'Box', 12, 'Sct', 4000, 6500, 0, 0, 0, 12, 60),
('B000073', 'S000011310', 'Honig Maizena 300g', 'J0007', 'M028', 'Kds', 12, 'Sct', 8500, 11500, 0, 0, 0, 12, 60),
('B000074', 'S000009187 ', 'Sajiku Tepung Bumbu Golden Crispy 200g', 'J0007', 'M032', 'Kds', 12, 'Pck', 4000, 5900, 0, 36, 0, 12, 60),
('B000075', 'S000009185 ', 'Sajiku Tepung Bumbu Pedas 80g x 10 Pcs', 'J0007', 'M032', 'Box', 12, 'Box', 20000, 24900, 0, 20, 0, 12, 60),
('B000076', 'S000022431', 'Ratu Bumbu Gado-Gado Biasa 200G', 'J0007', 'M031', 'Box', 12, 'Sct', 14000, 16800, 0, 0, 0, 10, 48),
('B000077', 'S000022432 ', 'Ratu Bumbu Gado-Gado Pedas 200G', 'J0007', 'M031', 'Box', 12, 'Sct', 14000, 16800, 0, 0, 0, 10, 48),
('B000078', 'S000022433', 'Ratu Bumbu Pecel 200G', 'J0007', 'M031', 'Kds', 12, 'Pck', 14000, 16800, 0, 0, 0, 8, 36),
('B000079', 'S000019506 ', 'Daesang Instant Soup-Cream 60G', 'J0011', 'M033', 'Kds', 12, 'Pck', 9500, 10500, 0, 0, 0, 10, 48),
('B000080', 'S000019507', 'Daesang Instant Soup-Garlic 60G', 'J0011', 'M033', 'Kds', 12, 'Pck', 9500, 11500, 0, 0, 0, 12, 60),
('B000081', 'S000019491', 'Mama Suka Sup Krim 2X55G Rasa Ayam', 'J0011', 'M030', 'Kds', 12, 'Pck', 9500, 11500, 0, 36, 0, 12, 60),
('B000082', 'S000019493', 'Mama Suka Sup Krim 2X55G Rasa Jagung', 'J0011', 'M030', 'Kds', 12, 'Pck', 9500, 11500, 0, 36, 0, 8, 48),
('B000083', 'S000019509', 'Daesang Roasted Laver 8*8 Het Grim', 'J0010', 'M033', 'Kds', 12, 'Pck', 13000, 15900, 0, 0, 0, 12, 48),
('B000084', 'S000019508 ', 'Daesang Roasted Laver 8*8 Parae Gim', 'J0010', 'M033', 'Kds', 12, 'Pck', 13000, 15900, 0, 0, 0, 8, 48),
('B000085', 'S000019687 ', 'Elephant Brand Dried Bean Curd (Kembang Tahu Gepeng) 200g', 'J0010', 'M034', 'Kds', 12, 'Pck', 23000, 27900, 0, 0, 0, 10, 60),
('B000086', 'S000019497', 'Mamasuka Crispy Seaweed 40G', 'J0010', 'M030', 'Kds', 12, 'Pck', 15000, 18900, 0, 0, 0, 12, 60),
('B000087', 'S000019498', 'Mamasuka Tempura Seaweed 40G', 'J0010', 'M030', 'Kds', 12, 'Pck', 14000, 17900, 0, 0, 0, 10, 72),
('B000088', 'S000011307 ', 'Sunmaid Raisin 250g', 'J0010', 'M035', 'Kds', 12, 'Pck', 26000, 31900, 0, 0, 0, 12, 72),
('B000089', 'S000011308', 'Sunmaid Raisin 500g', 'J0010', 'M035', 'Kds', 12, 'Pck', 57000, 68500, 0, 0, 0, 12, 60),
('B000090', 'S000001171 ', 'Bango Kecap Manis Pouch 600ml', 'J0005', 'M036', 'Kds', 12, 'Pch', 17000, 20900, 0, 0, 0, 8, 48),
('B000091', 'S000016246 ', 'Bango Kecap Manis 135ml', 'J0005', 'M036', 'Kds', 12, 'Pch', 6000, 8000, 0, 0, 0, 12, 72),
('B000092', 'S000001170 ', 'Bango Kecap Manis Pedas Gurih 220ml', 'J0005', 'M036', 'Kds', 12, 'Pch', 7200, 9200, 0, 0, 0, 10, 60),
('B000093', 'S000010781', 'Bango Kecap Manis Pouch 220ml', 'J0005', 'M036', 'Kds', 12, 'Pch', 6500, 8500, 0, 0, 0, 12, 72),
('B000094', 'S000001169 ', 'Bango Manis Botol Beling 620ml', 'J0005', 'M036', 'Kds', 12, 'Btl', 27000, 32500, 0, 0, 0, 10, 60),
('B000095', 'S000009191', 'Saori Saus Tiram Botol 275ml', 'J0005', 'M064', 'Kds', 12, 'Btl', 14000, 16800, 0, 0, 0, 8, 48),
('B000096', 'S000016406 ', 'Saori Saus Teriyaki Botol 135ml', 'J0005', 'M064', 'Kds', 12, 'Btl', 6500, 8500, 0, 0, 0, 12, 60),
('B000097', 'S000009192', 'Saori Saus Tiram Botol 1000ml', 'J0005', 'M064', 'Kds', 12, 'Btl', 31000, 38500, 0, 0, 0, 8, 48),
('B000098', 'S000016405', 'Saori Saus Tiram Botol 135ml', 'J0005', 'M064', 'Kds', 12, 'Btl', 6500, 8500, 0, 0, 0, 10, 60),
('B000099', 'S000009233', 'La Fonte Saus Pasta Barbeque 280g', 'J0005', 'M049', 'Kds', 12, 'Pch', 15000, 18900, 0, 0, 0, 12, 72),
('B000100', 'S000009229 ', 'La Fonte Saus Pasta Bolognese 315g', 'J0004', 'M049', 'Kds', 12, 'Pch', 14000, 16900, 0, 0, 0, 10, 60),
('B000101', 'S000009232 ', 'La Fonte Saus Pasta Hot Tuna 270g', 'J0005', 'M049', 'Kds', 12, 'Pch', 18500, 22500, 0, 0, 0, 10, 60),
('B000102', 'S000009231 ', 'La Fonte Spaghetti dengan Saus Ayam 117g', 'J0005', 'M049', 'Kds', 12, 'Pch', 3400, 5500, 0, 0, 0, 10, 84),
('B000103', 'S000009230', 'La Fonte Spaghetti dengan Saus Jamur 117g', 'J0005', 'M049', 'Kds', 12, 'Pch', 3000, 5000, 0, 0, 0, 12, 96),
('B000104', 'S000000033', 'ABC Kecap Asin Botol 620ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 9000, 10800, 0, 0, 0, 8, 36),
('B000105', 'S000017755', 'ABC Kecap Extra Pedas Botol 135g', 'J0005', 'M001', 'Kds', 12, 'Btl', 4000, 6200, 0, 0, 0, 12, 60),
('B000106', 'S000017754', 'ABC Kecap Extra pedas Pouch 400g', 'J0005', 'M001', 'Kds', 12, 'Pch', 10000, 12500, 0, 0, 0, 10, 48),
('B000107', 'S000000037', 'ABC Kecap Inggris 195ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 5500, 7500, 0, 0, 0, 12, 72),
('B000108', 'S000000029', 'ABC Kecap Manis Black Gold 275ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 10000, 12800, 0, 0, 0, 8, 48),
('B000109', 'S000000026', 'ABC Kecap Manis Black Gold Pouch 500ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 15000, 18900, 0, 0, 0, 12, 48),
('B000110', 'S000000030', 'ABC Kecap Manis Pet 600ml', 'J0005', 'M001', 'Kds', 12, 'Pet', 16000, 19200, 0, 0, 0, 10, 48),
('B000111', 'S000000024 ', 'ABC Kecap Manis Pouch 225ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 5500, 17900, 0, 0, 0, 10, 60),
('B000112', 'S000000032', 'ABC Kecap Manis Pouch 580ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 15000, 17900, 0, 0, 0, 10, 48),
('B000113', 'S000000025', 'ABC Kecap Manis Tanggung 275ml', 'J0005', 'M001', 'Kds', 12, 'Pch', 10000, 12900, 0, 0, 0, 10, 60),
('B000114', 'S000017757 ', 'ABC Sambal Ayam Goreng 135ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 3000, 5000, 0, 0, 0, 12, 84),
('B000115', 'S000017758 ', 'ABC Sambal Extra Pedas Kecil 135ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 3000, 5000, 0, 0, 0, 12, 84),
('B000116', 'S000017756 ', 'ABC Sambal Manis Pedas Beling 335ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 9000, 11900, 0, 0, 0, 10, 60),
('B000117', 'S000017759 ', 'ABC Sambal Manis Pedas Kecil 135ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 3000, 5000, 0, 0, 0, 10, 48),
('B000118', 'S000017760 ', 'ABC Sambal Masak 190g', 'J0005', 'M001', 'Kds', 12, 'Btl', 10000, 12900, 0, 0, 0, 10, 48),
('B000119', 'S000000042 ', 'ABC Saus Sambal Asli 275ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 7000, 9100, 0, 0, 0, 12, 60),
('B000120', 'S000017753 ', 'ABC Saus Sambal Asli 5.7kg', 'J0005', 'M001', 'Kds', 12, 'Pch', 95000, 114900, 0, 0, 0, 8, 36),
('B000121', 'S000000046', 'ABC Saus Sambal Ayam Goreng Botol 340ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 8000, 11500, 0, 0, 0, 12, 48),
('B000122', 'S000000043', 'ABC Saus Sambal Extra Pedas 275ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 6500, 9100, 0, 0, 0, 12, 60),
('B000123', 'S000000045 ', 'ABC Saus Sambal Extra Pedas 335ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 8500, 11500, 0, 0, 0, 8, 48),
('B000124', 'S000000041 ', 'ABC Saus Sambal Terasi Jar 200g', 'J0005', 'M001', 'Kds', 12, 'Btl', 13000, 15600, 0, 0, 0, 10, 48),
('B000125', 'S000000036 ', 'ABC Saus Tiram 425ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 18000, 24600, 0, 0, 0, 8, 48),
('B000126', 'S000000035 ', 'ABC Saus Tiram Tanggung 195ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 7500, 10200, 0, 0, 0, 12, 60),
('B000127', 'S000017763', 'ABC Saus Tomat 275ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 5000, 7700, 0, 0, 0, 12, 60),
('B000128', 'S000000047', 'ABC Saus Tomat Botol 335ml', 'J0005', 'M001', 'Kds', 12, 'Btl', 7500, 10300, 0, 0, 0, 8, 48),
('B000129', 'S000021854 ', 'ABC Saus Tomat Jerigen 5,7kg', 'J0005', 'M001', 'Kds', 12, 'Jerigen ', 65000, 78500, 0, 0, 0, 7, 36),
('B000130', 'S000017770 ', 'ABC Terasi Pedas 18 Pcs X 4,5g', 'J0005', 'M001', 'Kds', 12, 'Pck', 3000, 5000, 0, 0, 0, 24, 120),
('B000131', 'S000017769 ', 'ABC Terasi Udang 20 Pcs X 4,5g', 'J0005', 'M001', 'Kds', 12, 'Pck', 3000, 4900, 0, 0, 0, 24, 132),
('B000132', 'S000017997 ', 'MD Organic White Rice Pandan Wangi 2Kg', 'J0009', 'M065', 'Sak', 10, 'Sak', 50200, 54000, 0, 15, 0, 5, 25),
('B000133', 'S000017998', 'MD Organic White Rice Pandan Wangi 5Kg', 'J0009', 'M065', 'Sak', 10, 'Sak', 105000, 126000, 0, 15, 0, 5, 25),
('B000134', 'S000007228 ', 'Hotel Beras Merah 2kg', 'J0009', 'M066', 'Sak', 10, 'Sak', 55500, 60500, 0, 0, 0, 7, 30),
('B000135', 'S000007233', 'Hotel Beras Putih Pandan Wangi 2kg', 'J0009', 'M066', 'Sak', 10, 'Sak', 57500, 62500, 0, 0, 0, 7, 30),
('B000136', 'S000014496 ', 'Sipulen Pandan Wangi 10kg', 'J0009', 'M067', 'Sak', 10, 'Sak', 115900, 225900, 0, 0, 0, 7, 30),
('B000137', 'S000015227', 'Sipulen Pandan Wangi 20kg', 'J0009', 'M067', 'Sak', 10, 'Sak', 505900, 520900, 0, 0, 0, 7, 25),
('B000138', 'S000014495', 'Sipulen Pandan Wangi 5kg', 'J0009', 'M067', 'Sak', 10, 'Sak', 97000, 116400, 0, 0, 0, 8, 30),
('B000139', 'S000003070 ', 'Gulaku Pillow Pack Gula Tebu (Gula Kristal Kuning) 1kg', 'J0003', 'M068', 'Kds', 12, 'Pck', 13000, 15600, 0, 0, 0, 10, 60),
('B000140', 'S000003072', 'Gulaku Pillow Pack Premium (Gula Kristal Putih) 1kg', 'J0003', 'M068', 'Kds', 12, 'Pck', 14000, 16800, 0, 0, 0, 10, 60),
('B000141', 'S000003069 ', 'Gulaku Gula Kristal Putih Pouch 750g', 'J0003', 'M068', 'Kds', 12, 'Pch', 11000, 13200, 0, 0, 0, 10, 60),
('B000142', 'S000014142', 'Gulaku Premium 500g', 'J0003', 'M068', 'Kds', 12, 'Pck', 7500, 9000, 0, 0, 0, 10, 60),
('B000143', 'S000011387 ', 'Diabetasol Sweetener 50 Sachet', 'J0003', 'M069', 'Kds', 12, 'Box', 24000, 28800, 0, 0, 0, 8, 36),
('B000144', 'S000007238', 'Tropicana Slim Sweet Diabtx 100 Sachet', 'J0003', 'M022', 'Kds', 12, 'Box', 72000, 86400, 0, 0, 0, 8, 36),
('B000145', 'S000006064 ', 'Tropicana Slim Sweetener 100 Pieces', 'J0003', 'M022', 'Kds', 12, 'Box', 69000, 82800, 0, 0, 0, 8, 36),
('B000146', 'S000005431', 'Tropicana Slim Sweetener Classic 50 Sachet', 'J0003', 'M022', 'Kds', 12, 'Box', 37000, 44400, 0, 0, 0, 8, 36),
('B000147', 'S000009190 ', 'Sajiku Ikan Goreng 20g x 10 Pcs', 'J0004', 'M070', 'Kds', 12, 'Pck', 14000, 16800, 0, 0, 0, 12, 60),
('B000148', 'S000009178 ', 'Ajinomoto 1000g', 'J0004', 'M072', 'Box', 12, 'Pck', 32500, 35000, 0, 0, 0, 10, 60),
('B000149', 'S000009177 ', 'Ajinomoto 250g', 'J0004', 'M072', 'Box', 12, 'Pck', 7500, 9000, 0, 0, 0, 10, 60),
('B000150', 'S000000304 ', 'Indofood Bumbu Instant Nasi Goreng 45g', 'J0004', 'M073', 'Box', 12, 'Pck', 5000, 6000, 0, 0, 0, 12, 84),
('B000151', 'S000000307 ', 'Indofood Bumbu Instant Nasi Goreng Pedas 45g', 'J0004', 'M073', 'Box', 12, 'Pck', 4000, 4900, 0, 0, 0, 12, 84),
('B000152', 'S000000306', 'Indofood Bumbu Instant Rendang 45g', 'J0004', 'M073', 'Box', 12, 'Pck', 4000, 4900, 0, 0, 0, 12, 84),
('B000153', 'S000000907', 'Indofood Bumbu Instant Soto Box 45gr', 'J0004', 'M073', 'Box', 12, 'Pck', 4000, 4900, 0, 0, 0, 12, 84),
('B000154', 'S000000305', 'Indofood Bumbu Instant Opor 45g', 'J0004', 'M073', 'Box', 12, 'Pck', 4000, 4900, 0, 0, 0, 12, 84),
('B000155', 'S000011507 ', 'Royco Bk-Sayur Asem Bening 22g', 'J0004', 'M071', 'Box', 12, 'Sct', 1300, 1900, 0, 0, 0, 12, 96),
('B000156', 'S000011508', 'Royco Bk-Tahu/Tempe Goreng 20g', 'J0004', 'M071', 'Box', 12, 'Sct', 800, 1500, 0, 0, 0, 12, 48),
('B000157', 'S000001488 ', 'Royco Beef 200g', 'J0004', 'M071', 'Box', 12, 'Sct', 6500, 7800, 0, 0, 0, 10, 48),
('B000158', 'S000001489', 'Royco Chicken 200g', 'J0004', 'M071', 'Pcs', 12, 'Sct', 6500, 7800, 0, 0, 0, 12, 60),
('B000159', 'S000011509 ', 'Royco Bk-Ikan Goreng 22.5g', 'J0004', 'M071', 'Box', 12, 'Sct', 1500, 2000, 0, 0, 0, 12, 60),
('B000160', 'S000009179 ', 'Masako Ayam 250g', 'J0004', 'M074', 'Box', 12, 'Pck', 8000, 9000, 0, 0, 0, 12, 60),
('B000161', 'S000009180 ', 'Masako Sapi 250g', 'J0004', 'M074', 'Box', 12, 'Pck', 8000, 9000, 0, 0, 0, 10, 60),
('B000162', 'S000008279', 'Mama Suka Tepung Tempe Goreng 80g', 'J0004', 'M030', 'Kds', 12, 'Pck', 2000, 2500, 0, 0, 0, 12, 72),
('B000163', 'S000008275 ', 'Mama Suka Tepung Bakwan 250g', 'J0004', 'M030', 'Kds', 12, 'Pck', 4000, 5000, 0, 0, 0, 10, 60),
('B000164', 'S000006636 ', 'Pop Mie Rasa Ayam Bawang Jumbo (PABJ) x 24 Pieces', 'J0015', 'M091', 'Kds', 24, 'Pck', 90000, 108000, 0, 0, 0, 12, 48),
('B000165', 'S000006632', 'Pop Mie Rasa Ayam Jumbo (PMAJ) x 24 Pieces', 'J0015', 'M091', 'Kds', 24, 'Pck', 82000, 90400, 0, 0, 0, 10, 48),
('B000166', 'S000006638 ', 'Pop Mie Rasa Ayam Spesial (PAS) x 24 Pieces', 'J0015', 'M091', 'Kds', 24, 'Pck', 95000, 109900, 0, 0, 0, 10, 48),
('B000167', 'S000009653 ', 'Pop Mie Goreng Sosis Bakar Pedas Jumbo x 24 Pcs', 'J0015', 'M091', 'Kds', 24, 'Pck', 90000, 100800, 0, 0, 0, 12, 48),
('B000168', 'S000003861 ', 'Migelas Misehat Rasa Ayam Bawang 6 x 28g', 'J0015', 'M090', 'Kds', 40, 'Pck', 7500, 9000, 0, 0, 0, 10, 60),
('B000169', 'S000003859 ', 'Migelas Misehat Rasa Baso Sapi 6 x 28g', 'J0015', 'M090', 'Kds', 40, 'Pck', 7500, 9000, 0, 0, 0, 12, 40),
('B000170', 'S000003858 ', 'Migelas Misehat Rasa Kari Ayam 6 x 28g', 'J0015', 'M091', 'Kds', 0, 'Pck', 7500, 9000, 0, 0, 0, 10, 38),
('B000171', 'S000003860 ', 'Migelas Misehat Rasa Soto Ayam 6 x 28g', 'J0015', 'M090', 'Kds', 0, 'Pck', 7500, 9000, 0, 0, 0, 10, 40),
('B000172', 'S000004541 ', 'Indomie Mie Instant Rasa Ayam Bawang 69g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 74000, 80000, 0, 0, 0, 10, 40),
('B000173', 'S000004543', 'Indomie Mie Instant Rasa Ayam Special 68g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 75000, 80000, 0, 0, 0, 10, 40),
('B000174', 'S000004578 ', 'Indomie Kari Ayam Bawang Goreng 72g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 78000, 81000, 0, 0, 0, 10, 40),
('B000175', 'S000004542 ', 'Indomie Mie Instant Rasa Soto Mie 75g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 72000, 78900, 0, 0, 0, 12, 40),
('B000176', 'S000004539 ', 'Indomie Goreng Special 85g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 75000, 82000, 0, 0, 0, 12, 40),
('B000177', 'S000004583', 'Indomie Mi Goreng Rasa Cabe Ijo 85g x 40 Pcs', 'J0015', 'M086', 'Kds', 40, 'Pck', 75000, 82000, 0, 0, 0, 12, 40),
('B000178', 'S000004549', 'Indomie Jumbo Goreng Special 129g x 24 Pcs', 'J0015', 'M086', 'Kds', 24, 'Pck', 65000, 71000, 0, 0, 0, 10, 48),
('B000179', 'S000004580 ', 'Sedaap Mie Instant Goreng 91g x 40 Pcs', 'J0015', 'M092', 'Kds', 40, 'Pck', 71000, 78900, 0, 0, 0, 10, 40),
('B000180', 'S000004603', 'Sedaap Mie Instant Kari Ayam 72g x 40 Pcs', 'J0015', 'M092', 'Kds', 40, 'Pck', 71000, 78900, 0, 0, 0, 12, 40),
('B000181', 'S000004582 ', 'Sedaap Mie Instant Soto 75g x 40 Pcs', 'J0015', 'M092', 'Kds', 40, 'Pck', 65000, 74000, 0, 0, 0, 12, 40),
('B000182', 'S000004581 ', 'Sedaap Mie Instant Ayam Bawang 70g x 40 Pcs', 'J0015', 'M092', 'Pck', 40, 'Pck', 65000, 74000, 0, 0, 0, 10, 40),
('B000183', 'S000019400 ', 'Ritz Cracker 100g', 'J0021', 'M096', 'Kds', 24, 'Pck', 4000, 6000, 0, 0, 0, 8, 36),
('B000184', 'S000018301', 'Ritz Sandwiches Cheese 27gr', 'J0021', 'M096', 'Kds', 24, 'Pck', 1500, 3000, 0, 0, 0, 12, 40),
('B000185', 'S000006350 ', 'Ritz Sandwitch Cheese 118g', 'J0021', 'M096', 'Kds', 24, 'Pck', 5500, 7500, 0, 0, 0, 10, 38),
('B000186', 'S000004963', 'Holland Butter Cookies 600g', 'J0015', 'M093', 'Kds', 12, 'Klg', 70000, 85000, 0, 0, 0, 8, 38),
('B000187', 'S000015239 ', 'Selamat Biscuit Colection 240g', 'J0021', 'M098', 'Kds', 12, 'Klg', 45000, 55000, 0, 0, 0, 12, 50),
('B000188', 'S000005882 ', 'Selamat Wafer 750g', 'J0021', 'M098', 'Kds', 12, 'Klg', 50000, 59900, 0, 0, 0, 12, 48),
('B000189', 'S000011996 ', 'Oreo Vanila Milk 29,4g', 'J0021', 'M095', 'Box', 24, 'Pcs', 1000, 2500, 0, 0, 0, 10, 50),
('B000190', 'S000018072 ', 'Oreo Vanilla Milk 137g', 'J0021', 'M095', 'Kds', 12, 'Pcs', 6000, 8000, 0, 0, 0, 10, 38),
('B000191', 'S000006346 ', 'Oreo Strawberry Cream 137g', 'J0021', 'M095', 'Kds', 12, 'Pcs', 6500, 8000, 0, 0, 0, 8, 40),
('B000192', 'S000021604 ', 'Oreo Strawberry Cream 29,4G', 'J0021', 'M095', 'Box', 24, 'Pcs', 1000, 2500, 0, 0, 0, 10, 40),
('B000193', 'S000011801 ', 'Tango Wafer Pandan 171g', 'J0021', 'M099', 'Kds', 36, 'Pck', 9500, 11900, 0, 0, 0, 10, 36),
('B000194', 'S000001641', 'Tango Wafer Chocolate Box 171g', 'J0021', 'M099', 'Kds', 36, 'Box', 9500, 11900, 0, 0, 0, 10, 36),
('B000195', 'S000001644 ', 'Tango Wafer Strawberry Jam Box 171g', 'J0021', 'M099', 'Kds', 36, 'Box', 9500, 11900, 0, 0, 0, 10, 36),
('B000196', 'S000016564 ', 'Tango Wafer Vanilla 20 X 17g', 'J0021', 'M099', 'Kds', 36, 'Box', 18000, 21600, 0, 0, 0, 10, 36),
('B000197', 'S000001640', 'Tango Wafer Chocolate Tin 385g', 'J0021', 'M099', 'Kds', 6, 'Klg', 27000, 32400, 0, 0, 0, 8, 32),
('B000198', 'S000001642 ', 'Tango Wafer Vanilla Tin 385g', 'J0021', 'M099', 'Kds', 6, 'Klg', 32000, 38400, 0, 0, 0, 8, 32),
('B000199', 'S000003848 ', 'Roma Biscuit Kelapa 388g', 'J0021', 'M097', 'Kds', 12, 'Pck', 10000, 12900, 0, 0, 0, 12, 40),
('B000200', 'S000003864 ', 'Roma Malkist Rasa Abon Gurih 250g', 'J0021', 'M097', 'Kds', 12, 'Pck', 9000, 11500, 0, 0, 0, 10, 36),
('B000201', 'S000004922 ', 'Roma Sari Gandum 290g', 'J0021', 'M097', 'Kds', 12, 'Pck', 8000, 10900, 0, 0, 0, 8, 38),
('B000202', 'S000003851 ', 'Roma Slai O&acute;lai Rasa Strawberry 240g', 'J0021', 'M097', 'Kds', 12, 'Pck', 8000, 10500, 0, 0, 0, 8, 38),
('B000203', 'S000003852 ', 'Roma Slai O&acute;lai Rasa Blueberry 240g', 'J0021', 'M097', 'Kds', 12, 'Pck', 8000, 10500, 0, 0, 0, 8, 38),
('B000204', 'S000006052', 'Khong Guan Assorted Biscuit Red Mini 700g', 'J0021', 'M094', 'Kds', 6, 'Klg', 40000, 50000, 0, 0, 0, 8, 36),
('B000205', 'S000008533 ', 'Khong Guan Malkist Abon Sapi Bag 18g x 10 Pieces', 'J0021', 'M094', 'Kds', 36, 'Pck', 7000, 9900, 0, 0, 0, 10, 36),
('B000206', 'S000008535 ', 'Khong Guan Shaltcheese 200g', 'J0021', 'M094', 'Kds', 36, 'Pck', 6000, 8900, 0, 0, 0, 10, 36),
('B000207', 'S000005662 ', 'Monde Butter Cookies Blue 454g', 'J0021', 'M102', 'Kds', 6, 'Klg', 45000, 49900, 0, 0, 0, 8, 40),
('B000208', 'S000008526 ', 'Monde Chocolate Wafer Tin 600g', 'J0021', 'M102', 'Kds', 6, 'Klg', 38000, 45600, 0, 0, 0, 10, 36),
('B000209', 'S000005657', 'Monde Serena Eggs Roll Standar 600g', 'J0021', 'M102', 'Kds', 6, 'Klg', 70000, 84000, 0, 0, 0, 10, 36),
('B000210', 'S000005885 ', 'Twister Black Tin 300g', 'J0021', 'M100', 'Kds', 12, 'Klg', 23000, 27600, 0, 0, 0, 12, 36),
('B000211', 'S000005884', 'Twister Choco Tin 300g', 'J0021', 'M100', 'Kds', 12, 'Box', 23000, 27600, 0, 0, 0, 12, 40),
('B000212', 'S000014484', 'Garuda Atom Manis 130g', 'J0022', 'M104', 'Kds', 36, 'Pck', 5000, 7900, 0, 0, 0, 12, 48),
('B000213', 'S000014481', 'Garuda Atom Gurih 200g', 'J0022', 'M104', 'Kds', 36, 'Pck', 12000, 14900, 0, 0, 0, 10, 40),
('B000214', 'S000014483', 'Garuda Atom Pedas 100g', 'J0022', 'M104', 'Kds', 36, 'Pck', 5000, 7900, 0, 0, 0, 12, 36),
('B000215', 'S000004959 ', 'Garuda Kacang Kulit 900g', 'J0021', 'M104', 'Kds', 24, 'Pck', 50000, 59900, 0, 0, 0, 10, 40),
('B000216', 'S000004962 ', 'Garuda Kacang Telur 250g', 'J0022', 'M104', 'Kds', 36, 'Pck', 11500, 14500, 0, 0, 0, 12, 40),
('B000217', 'S000014490 ', 'Garuda Rosta Kacang Oven Rs.Bawang 100g', 'J0022', 'M104', 'Kds', 36, 'Pck', 6000, 8500, 0, 0, 0, 10, 40),
('B000218', 'S000002272', 'Chitato Beef Barbequ', 'J0023', 'M108', 'Kds', 36, 'Pck', 19500, 24500, 0, 0, 0, 10, 36),
('B000219', 'S000016420 ', 'Chitato Spicy Chiche', 'J0023', 'M108', 'Kds', 36, 'Pck', 8000, 12000, 0, 0, 0, 10, 36),
('B000220', 'S000016735 ', 'Qtela Original 185g ', 'J0023', 'M109', 'Kds', 36, 'Pck', 9500, 13500, 0, 0, 0, 10, 36),
('B000221', 'S000002285', 'Qtela Balado 185g ', 'J0023', 'M109', 'Kds', 36, 'Pck', 9500, 13500, 0, 0, 0, 10, 36),
('B000222', 'S000002286', ' Qtela Grilled Cheese', 'J0023', 'M109', 'Kds', 36, 'Pck', 9500, 13500, 0, 0, 0, 10, 36),
('B000223', 'S000002278', 'Lay&acute;s Nori Sea ', 'J0023', 'M110', 'Kds', 36, 'Pck', 8000, 12100, 0, 0, 0, 10, 36),
('B000224', 'S000002279', ' Lay´s Salmon T', 'J0023', 'M110', 'Kds', 36, 'Pck', 8000, 12100, 0, 0, 0, 10, 36),
('B000225', 'S000016242 ', 'Happy Tos Realcorn Chips Hijau 160g', 'J0023', 'M111', 'Kds', 36, 'Pck', 6500, 10500, 0, 0, 0, 10, 36),
('B000226', 'S000018275 ', 'Espresso Kopi Susu Bag 50Pc', 'J0029', 'M117', 'Kds', 36, 'Pck', 4000, 7500, 0, 0, 0, 10, 36),
('B000227', 'S000016402 ', 'Kopiko Cappucino Zak 150g', 'J0029', 'M118', 'Kds', 36, 'Pck', 5500, 9000, 0, 0, 0, 10, 36),
('B000228', 'S000003862 ', 'KIS Candy Mint Cherry 125g', 'J0029', 'M119', 'Kds', 36, 'Pck', 4500, 8000, 0, 0, 0, 10, 36),
('B000229', 'S000003863 ', 'KIS Candy Mint Grape 125g', 'J0029', 'M119', 'Kds', 36, 'Pck', 4500, 8000, 0, 0, 0, 10, 36),
('B000230', 'S000001983 ', 'Koko Krunch Duo Cereal 330g', 'J0017', 'M120', 'Kds', 20, 'Box', 34000, 38900, 0, 0, 0, 8, 40),
('B000231', 'S000000920 ', 'Nestle Koko Krunch Cereal 330g ', 'J0017', 'M120', 'Kds', 20, 'Box', 34000, 38900, 0, 0, 0, 8, 40),
('B000232', 'S000004924 ', 'Energen Chocolate Bag 30g x 20 Sachet', 'J0017', 'M121', 'Kds', 24, 'Bag', 26000, 30900, 0, 0, 0, 12, 48),
('B000233', 'S000004925', 'Energen Kacang Hijau Bag 30g x 20 Sachet', 'J0017', 'M121', 'Kds', 24, 'Bag', 26000, 30900, 0, 0, 0, 12, 48),
('B000234', 'S000015742 ', 'Anlene Gold Chocolate 900gr', 'J0030', 'M122', 'Kds', 20, 'Box', 130000, 156000, 0, 0, 0, 10, 40),
('B000235', 'S000015740', 'Anlene Gold Plan 900gr', 'J0030', 'M122', 'Kds', 20, 'Box', 130000, 156000, 0, 0, 0, 10, 40),
('B000236', 'S000004969 ', 'Anlene Actifit Plain 600g', 'J0030', 'M122', 'Kds', 20, 'Box', 75000, 90000, 0, 0, 0, 10, 40),
('B000237', 'S000004971 ', 'Anlene Activit Coklat 600g', 'J0030', 'M122', 'Kds', 20, 'Box', 75000, 95000, 0, 0, 0, 10, 40),
('B000238', 'S000010593 ', 'Frisian Flag Bubuk Full Cream 400g', 'J0030', 'M125', 'Kds', 20, 'Box', 35000, 45000, 0, 0, 0, 10, 40),
('B000239', 'S000010598 ', 'Frisian Flag Bubuk Instant Choco 400g', 'J0030', 'M125', 'Kds', 20, 'Box', 31000, 41000, 0, 0, 0, 10, 40),
('B000240', 'S000010587 ', 'Frisian Flag 123 Coklat 400g', 'J0030', 'M125', 'Kds', 20, 'Box', 38000, 48000, 0, 0, 0, 10, 40),
('B000241', 'S000010464 ', 'Frisian Flag 123 Vanila 400g', 'J0030', 'M125', 'Kds', 20, 'Box', 38000, 48000, 0, 0, 0, 8, 40),
('B000242', 'S000010466 ', 'Indomilk Bubuk Instant Box 400g', 'J0030', 'M127', 'Kds', 20, 'Box', 32000, 42000, 0, 0, 0, 10, 40),
('B000243', 'S000010469 ', 'Indomilk Bubuk Coklat Box 400g', 'J0030', 'M127', 'Kds', 20, 'Box', 29000, 38900, 0, 0, 0, 10, 40),
('B000244', 'S000010465 ', 'Indomilk Bubuk Full Cream Instant Plain 400g', 'J0030', 'M127', 'Kds', 20, 'Box', 33000, 42900, 0, 0, 0, 10, 40),
('B000245', 'S000010537', 'Dancow Strawberry Actigo Box 300g', 'J0030', 'M124', 'Kds', 20, 'Box', 42700, 52700, 0, 0, 0, 10, 40),
('B000246', 'S000000729 ', 'Dancow Chocolate Actigo BIB 800g', 'J0030', 'M124', 'Kds', 20, 'Box', 71000, 85200, 0, 0, 0, 10, 40),
('B000247', 'S000000732 ', 'Dancow Chocolate Enriched 400g', 'J0030', 'M124', 'Kds', 20, 'Box', 37000, 44400, 0, 0, 0, 10, 40),
('B000248', 'S000000714 ', 'Dancow Full Cream 400g', 'J0030', 'M124', 'Kds', 20, 'Box', 41000, 49200, 0, 0, 0, 10, 40),
('B000249', 'S000004981 ', 'Boneeto Milk Powder Chocolate 700g', 'J0030', 'M123', 'Kds', 20, 'Box', 73000, 87600, 0, 0, 0, 8, 40),
('B000250', 'S000003557 ', 'Frisian Flag Susu Kental Manis Chocolate Can 385g', 'J0032', 'M125', 'Kds', 24, 'Klg', 7500, 10500, 0, 0, 0, 12, 48),
('B000251', 'S000003556 ', 'Frisian Flag Susu Kental Manis Gold Can 385g', 'J0032', 'M125', 'Kds', 24, 'Klg', 12000, 14900, 0, 0, 0, 12, 48),
('B000252', 'S000002492 ', 'Indomilk Susu Kental Manis Coklat 375g', 'J0032', 'M127', 'Kds', 24, 'Klg', 7500, 10500, 0, 0, 0, 10, 48),
('B000253', 'S000002491', 'Indomilk Sweetened Condesed Milk 375g', 'J0032', 'M127', 'Kds', 12, 'Klg', 8000, 11200, 0, 0, 0, 10, 36),
('B000254', 'S000014327 ', 'Frisian Flag SKM Gold 42g x 120 Sachet', 'J0032', 'M125', 'Kds', 120, 'Kds', 180000, 216000, 0, 0, 0, 4, 10),
('B000255', 'S000011488 ', 'Frisian Flag Susu Kental Manis Chocolate 40g x 120 Pcs', 'J0032', 'M125', 'Kds', 120, 'Kds', 135000, 162000, 0, 0, 0, 4, 10),
('B000256', 'S000011487 ', 'Frisian Flag Susu Kental Manis Putih 40g x 120 Pcs', 'J0032', 'M125', 'Kds', 120, 'Kds', 132000, 158400, 0, 0, 0, 4, 10),
('B000257', 'S000002493', 'Indomilk Susu Cap Enaak White 375g', 'J0032', 'M127', 'Kds', 24, 'Klg', 6500, 9500, 0, 0, 0, 12, 48),
('B000258', 'S000002494 ', 'Indomilk Susu Cap Enaak Coklat 375g', 'J0032', 'M127', 'Kds', 24, 'Klg', 6500, 9500, 0, 0, 0, 12, 48),
('B000259', 'S000002996 ', 'Ultra Milk Chocolate 1000ml', 'J0031', 'M129', 'Kds', 36, 'Box', 13000, 16500, 0, 0, 0, 10, 50),
('B000260', 'S000002999 ', 'Ultra Milk Full Cream Plain 1000ml', 'J0031', 'M129', 'Kds', 36, 'Box', 13000, 16500, 0, 0, 0, 10, 50),
('B000261', 'S000003578', 'Frisian Flag Dairy Milk Chocolate 1000ml', 'J0031', 'M125', 'Kds', 36, 'Box', 13000, 16500, 0, 0, 0, 10, 45),
('B000262', 'S000003577 ', 'Frisian Flag Dairy Milk Full Cream 1000ml', 'J0031', 'M125', 'Kds', 36, 'Box', 13000, 16500, 0, 0, 0, 10, 45),
('B000263', 'S000032295 ', 'ABC Kacang Hijau Juice 250ml', 'J0042', 'M001', 'Kds', 24, 'Box', 2500, 5500, 0, 0, 0, 12, 48),
('B000264', 'S000002314 ', 'ABC Sari Asam Jawa 250ml', 'J0042', 'M001', 'Kds', 24, 'Box', 3000, 5900, 0, 0, 0, 12, 48),
('B000265', 'S000010755 ', ' Buavita Orange Mandarin 1L', 'J0041', 'M130', 'Kds', 24, 'Box', 23000, 27900, 0, 0, 0, 10, 48),
('B000266', 'S000002311 ', 'ABC Juice Slim Guava 250ml', 'J0041', 'M001', 'Kds', 24, 'Box', 4000, 6900, 0, 0, 0, 10, 48),
('B000267', 'S000010485', 'Nutrisari Jeruk Manis Refill 750g', 'J0041', 'M131', 'Kds', 24, 'Box', 44000, 52800, 0, 0, 0, 10, 48),
('B000268', 'S000003660', 'Buavita Mango Juice 1000ml', 'J0041', 'M130', 'Kds', 24, 'Box', 22000, 26400, 0, 0, 0, 12, 48),
('B000269', 'S000003659 ', 'Buavita Guava Juice 1000ml', 'J0041', 'M130', 'Kds', 24, 'Box', 22000, 26400, 0, 0, 0, 12, 48),
('B000270', 'S000010748 ', 'Buavita Grape 1L', 'J0041', 'M130', 'Kds', 24, 'Box', 23000, 27600, 0, 0, 0, 12, 48),
('B000271', 'S000010484 ', 'Nutrisari Jeruk Nipis Refill 500g', 'J0041', 'M131', 'Kds', 24, 'Box', 33000, 39600, 0, 0, 0, 8, 48),
('B000272', 'S000002313 ', 'ABC Juice Slim Orange 250ml', 'J0041', 'M001', 'Kds', 24, 'Box', 4000, 6900, 0, 0, 0, 10, 48),
('B000273', 'S000006062 ', 'Nutrisari Jeruk Manis Pitcher 350g', 'J0041', 'M131', 'Kds', 24, 'Btl', 36000, 43200, 0, 0, 0, 8, 48),
('B000274', 'S000011390 ', 'Sunkist Apple 1L', 'J0041', 'M132', 'Kds', 24, 'Box', 17000, 21900, 0, 0, 0, 10, 48),
('B000275', 'S000011391 ', 'Sunkist Orange 1L', 'J0041', 'M132', 'Kds', 24, 'Box', 15000, 19900, 0, 0, 0, 10, 48);

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE IF NOT EXISTS `hak_akses` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_user` char(4) NOT NULL,
  `mu_data_user` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_supplier` enum('No','Yes') NOT NULL,
  `mu_data_merek` enum('No','Yes') NOT NULL,
  `mu_data_pelanggan` enum('No','Yes') NOT NULL,
  `mu_data_kategori` enum('No','Yes') NOT NULL,
  `mu_data_kategorisub` enum('No','Yes') NOT NULL,
  `mu_data_jenis` enum('No','Yes') NOT NULL,
  `mu_data_barang` enum('No','Yes') NOT NULL,
  `mu_pencarian` enum('No','Yes') NOT NULL,
  `mu_barcode` enum('No','Yes') NOT NULL,
  `mu_trans_pembelian` enum('No','Yes') NOT NULL,
  `mu_trans_returbeli` enum('No','Yes') NOT NULL,
  `mu_trans_penjualan` enum('No','Yes') NOT NULL,
  `mu_laporan` enum('No','Yes') NOT NULL,
  `mu_login` enum('No','Yes') NOT NULL,
  `mu_logout` enum('No','Yes') NOT NULL,
  `mlap_user` enum('No','Yes') NOT NULL,
  `mlap_supplier` enum('No','Yes') NOT NULL,
  `mlap_pelanggan` enum('No','Yes') NOT NULL,
  `mlap_merek` enum('No','Yes') NOT NULL,
  `mlap_kategori` enum('No','Yes') NOT NULL,
  `mlap_kategorisub` enum('No','Yes') NOT NULL,
  `mlap_jenis` enum('No','Yes') NOT NULL,
  `mlap_barang_kategori` enum('No','Yes') NOT NULL,
  `mlap_barang_kategorisub` enum('No','Yes') NOT NULL,
  `mlap_barang_merek` enum('No','Yes') NOT NULL,
  `mlap_pembelian_periode` enum('No','Yes') NOT NULL,
  `mlap_pembelian_bulan` enum('No','Yes') NOT NULL,
  `mlap_pembelian_supplier` enum('No','Yes') NOT NULL,
  `mlap_pembelian_barang_periode` enum('No','Yes') NOT NULL,
  `mlap_pembelian_barang_bulan` enum('No','Yes') NOT NULL,
  `mlap_pembelian_rekap_periode` enum('No','Yes') NOT NULL,
  `mlap_pembelian_rekap_bulan` enum('No','Yes') NOT NULL,
  `mlap_returbeli_periode` enum('No','Yes') NOT NULL,
  `mlap_returbeli_bulan` enum('No','Yes') NOT NULL,
  `mlap_returbeli_barang_periode` enum('No','Yes') NOT NULL,
  `mlap_returbeli_barang_bulan` enum('No','Yes') NOT NULL,
  `mlap_returbeli_rekap_periode` enum('No','Yes') NOT NULL,
  `mlap_returbeli_rekap_bulan` enum('No','Yes') NOT NULL,
  `mlap_penjualan_periode` enum('No','Yes') NOT NULL,
  `mlap_penjualan_bulan` enum('No','Yes') NOT NULL,
  `mlap_penjualan_barang_periode` enum('No','Yes') NOT NULL,
  `mlap_penjualan_barang_bulan` enum('No','Yes') NOT NULL,
  `mlap_penjualan_rekap_periode` enum('No','Yes') NOT NULL,
  `mlap_penjualan_rekap_bulan` enum('No','Yes') NOT NULL,
  `mlap_penjualan_terlaris` enum('No','Yes') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `kd_user`, `mu_data_user`, `mu_data_supplier`, `mu_data_merek`, `mu_data_pelanggan`, `mu_data_kategori`, `mu_data_kategorisub`, `mu_data_jenis`, `mu_data_barang`, `mu_pencarian`, `mu_barcode`, `mu_trans_pembelian`, `mu_trans_returbeli`, `mu_trans_penjualan`, `mu_laporan`, `mu_login`, `mu_logout`, `mlap_user`, `mlap_supplier`, `mlap_pelanggan`, `mlap_merek`, `mlap_kategori`, `mlap_kategorisub`, `mlap_jenis`, `mlap_barang_kategori`, `mlap_barang_kategorisub`, `mlap_barang_merek`, `mlap_pembelian_periode`, `mlap_pembelian_bulan`, `mlap_pembelian_supplier`, `mlap_pembelian_barang_periode`, `mlap_pembelian_barang_bulan`, `mlap_pembelian_rekap_periode`, `mlap_pembelian_rekap_bulan`, `mlap_returbeli_periode`, `mlap_returbeli_bulan`, `mlap_returbeli_barang_periode`, `mlap_returbeli_barang_bulan`, `mlap_returbeli_rekap_periode`, `mlap_returbeli_rekap_bulan`, `mlap_penjualan_periode`, `mlap_penjualan_bulan`, `mlap_penjualan_barang_periode`, `mlap_penjualan_barang_bulan`, `mlap_penjualan_rekap_periode`, `mlap_penjualan_rekap_bulan`, `mlap_penjualan_terlaris`) VALUES
(1, 'U01', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(2, 'U02', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(3, 'U03', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(4, 'U04', 'No', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(5, 'U05', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE IF NOT EXISTS `jenis` (
  `kd_jenis` char(5) NOT NULL,
  `nm_jenis` varchar(100) NOT NULL,
  `kd_kategorisub` char(5) NOT NULL,
  PRIMARY KEY (`kd_jenis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`kd_jenis`, `nm_jenis`, `kd_kategorisub`) VALUES
('J0001', 'Minyak', 'KS001'),
('J0002', 'Mentega', 'KS001'),
('J0003', 'Garam & Gula', 'KS001'),
('J0004', 'Bumbu', 'KS001'),
('J0005', 'Saus ', 'KS001'),
('J0006', 'Dressing ', 'KS001'),
('J0007', 'Tepung ', 'KS001'),
('J0008', 'Tepung Adonan', 'KS001'),
('J0009', 'Beras ', 'KS001'),
('J0010', 'Makanan Kering', 'KS001'),
('J0011', 'Sup Instan ', 'KS001'),
('J0012', 'Daging ', 'KS001'),
('J0013', 'Makanan Laut ', 'KS002'),
('J0014', 'Sayur & Buah', 'KS002'),
('J0015', 'Mie', 'KS003'),
('J0016', 'Pasta & Spageti', 'KS003'),
('J0017', 'Sereal ', 'KS005'),
('J0018', 'Selai & Olesan', 'KS005'),
('J0019', 'Madu', 'KS005'),
('J0020', 'Popcorn', 'KS004'),
('J0021', 'Biskuit & Kraker ', 'KS004'),
('J0022', 'Kacang ', 'KS004'),
('J0023', 'Keripik ', 'KS004'),
('J0024', 'Snack Bar ', 'KS004'),
('J0025', 'Agar-agar', 'KS004'),
('J0026', 'Kue', 'KS004'),
('J0027', 'Permen Karet', 'KS006'),
('J0028', 'Marshmallow ', 'KS006'),
('J0029', 'Permen Padat ', 'KS006'),
('J0030', 'Susu Bubuk', 'KS007'),
('J0031', 'Siap Minum', 'KS007'),
('J0032', 'Susu Kental Manis ', 'KS007'),
('J0033', 'Kopi', 'KS009'),
('J0034', 'Teh', 'KS009'),
('J0035', 'Coklat ', 'KS009'),
('J0036', 'Siap Minum', 'KS009'),
('J0037', 'Minuman Energi ', 'KS010'),
('J0038', 'Sirup', 'KS010'),
('J0039', 'Cola & Soda', 'KS010'),
('J0040', 'Air Mineral & Bersoda', 'KS010'),
('J0041', 'Buah', 'KS008'),
('J0042', 'Sayur', 'KS008'),
('J0043', 'Shampo', 'KS011'),
('J0044', 'Perawatan', 'KS011'),
('J0045', 'Pewarna Rambut ', 'KS011'),
('J0046', 'Penata Rambut', 'KS011'),
('J0047', 'Sikat Rambut ', 'KS011'),
('J0048', 'Pasta Gigi', 'KS012'),
('J0049', 'Cairan Kumur ', 'KS012'),
('J0050', 'Sikat Gigi ', 'KS012'),
('J0051', 'Busa Pembersih Wajah', 'KS013'),
('J0052', 'Pembersih', 'KS013'),
('J0053', 'Pemutih & Pelembab', 'KS013'),
('J0054', 'Perawatan', 'KS013'),
('J0055', 'Mata', 'KS014'),
('J0056', 'Bibir', 'KS014'),
('J0057', 'Perawatan Wajah', 'KS014'),
('J0058', 'Perawatan Kuku', 'KS014'),
('J0059', 'Pembersih Tubuh', 'KS015'),
('J0060', 'Sabun Tangan & Pelembab ', 'KS015'),
('J0061', 'Deodoran ', 'KS015'),
('J0062', 'Parfum', 'KS015'),
('J0063', 'Pencukur & Penghilang Bulu', 'KS015'),
('J0064', 'Krim Anti Serangga', 'KS015'),
('J0065', 'Bedak Talc', 'KS015'),
('J0066', 'Pakaian Dalam', 'KS015'),
('J0067', 'Tisu Wajah', 'KS016'),
('J0068', 'Tisu Toilet & Dapur ', 'KS016'),
('J0069', 'Kapas & Kertas Minyak ', 'KS016'),
('J0070', 'Tisu Basah', 'KS016'),
('J0071', 'Pembalut ', 'KS017'),
('J0072', 'Pantyliners ', 'KS017'),
('J0073', 'Pembersih Kewanitaan', 'KS017'),
('J0074', 'Minyak', 'KS018'),
('J0075', 'Tubuh', 'KS018'),
('J0076', 'Bibir', 'KS018'),
('J0077', 'Aksesoris ', 'KS018'),
('J0078', 'Omega 3 &Kesehatan ', 'KS019'),
('J0079', 'Kulit', 'KS019'),
('J0080', 'Vitamin', 'KS019'),
('J0081', 'Menstruasi', 'KS019'),
('J0082', 'Minuman Kesehatan', 'KS019'),
('J0083', 'Healthfood', 'KS019'),
('J0084', 'Hormon KB', 'KS019'),
('J0085', 'Sakit & Demam', 'KS022'),
('J0086', 'Batuk & Flu', 'KS022'),
('J0087', 'Sakit Perut', 'KS022'),
('J0088', 'Analgesic ', 'KS022'),
('J0089', 'Antacid', 'KS022'),
('J0090', 'Diare&Laxative', 'KS022'),
('J0091', 'Ear&Ear', 'KS022'),
('J0092', 'Glucose&Blood Pressure', 'KS022'),
('J0093', 'Perlengkapan Kesehatan', 'KS022'),
('J0094', 'Theumatic', 'KS022'),
('J0095', 'Antibiotic', 'KS022'),
('J0096', 'Dermatologis', 'KS022'),
('J0097', 'Kidney', 'KS022'),
('J0098', 'Kondom', 'KS021'),
('J0099', 'Alat Tes Kehamilan', 'KS021'),
('J0100', 'Plester & Obat Luka', 'KS020'),
('J0101', 'Aromaterapi', 'KS020'),
('J0102', 'Inhaler', 'KS020'),
('J0103', 'Krim & Balsem Otot', 'KS020'),
('J0104', 'Popok Dewasa', 'KS020'),
('J0105', 'Antiseptic', 'KS020'),
('J0106', 'Susu Formula', 'KS023'),
('J0107', 'Makanan Bayi', 'KS023'),
('J0108', 'Popok', 'KS024'),
('J0109', 'Tisu Basah', 'KS024'),
('J0110', 'Kapas', 'KS024'),
('J0111', 'Rambut', 'KS025'),
('J0112', 'Kebersihan Gigi & Mulut', 'KS025'),
('J0113', 'Perawatan Tubuh ', 'KS025'),
('J0114', 'Botol', 'KS026'),
('J0115', 'Peralatan Dot Bayi', 'KS026'),
('J0116', 'Perangkat Alat Makan', 'KS026'),
('J0117', 'Alat Pompa Asi', 'KS027'),
('J0118', 'Perangkat Hadiah', 'KS028'),
('J0119', 'Deterjen', 'KS030'),
('J0120', 'Pelembut ', 'KS030'),
('J0121', 'Insektisida', 'KS031'),
('J0122', 'Pengharum Ruangan', 'KS031'),
('J0123', 'Perawatan Sepatu', 'KS031'),
('J0124', 'Binatu', 'KS031'),
('J0125', 'Sabun Cuci Piring', 'KS031'),
('J0126', 'Lantai', 'KS031'),
('J0127', 'Dapur & Jendela', 'KS031'),
('J0128', 'Kamar Mandi & Toilet', 'KS031'),
('J0129', 'Furniture & Produk Kulit', 'KS031'),
('J0130', 'Penggosok, Sarung Tangan, & Kain Lap', 'KS031'),
('J0131', 'Sapu & Alat Pel', 'KS031'),
('J0132', 'Perkakas & Perangkat Masak', 'KS032'),
('J0133', 'Peralatan Meja Makan', 'KS032'),
('J0134', 'Plastik &Pembungkus', 'KS032'),
('J0135', 'Peralatan Minum & Gelas', 'KS032'),
('J0136', 'Peralatan Dapur', 'KS032'),
('J0137', 'Makanan Hewan', 'KS036'),
('J0138', 'Kotak Makanan', 'KS033'),
('J0139', 'Termos & Botol', 'KS033'),
('J0140', 'Laci', 'KS033'),
('J0141', 'Gantungan Baju', 'KS033'),
('J0142', 'Baterai', 'KS035'),
('J0143', 'Senter', 'KS035'),
('J0144', 'Lampu Bohlam', 'KS034'),
('J0145', 'Perkakas Dapur', 'KS034'),
('J0146', 'Setrika & Steamer', 'KS034'),
('J0147', 'Perawatan Rambut', 'KS034'),
('J0148', 'Perawatan Pribadi', 'KS034'),
('J0149', 'Perlengkapan Rumah', 'KS034'),
('J0150', 'Alat Elektronik', 'KS034'),
('J0151', 'Kamera', 'KS034'),
('J0152', 'Air Filter', 'KS034'),
('J0153', 'Aksesoris', 'KS034'),
('J0154', 'Perawatan Otomotif', 'KS037'),
('J0155', 'Pengharum Mobil', 'KS037'),
('J0156', 'Kertas', 'KS038'),
('J0157', 'Alat Tulis', 'KS038'),
('J0158', 'Peralatan Meja Kantor ', 'KS038'),
('J0159', 'Arsip & Map', 'KS038'),
('J0160', 'Sport Shoes', 'KS046'),
('J0161', 'Sports Wear', 'KS047'),
('J0162', 'Sports Shoes ', 'KS048'),
('J0163', 'Equipment', 'KS049'),
('J0164', 'Bags', 'KS049'),
('J0165', 'Socks', 'KS049'),
('J0166', 'Accesories', 'KS049'),
('J0167', 'Earring', 'KS050'),
('J0168', 'Bracelet', 'KS050'),
('J0169', 'Necklace', 'KS050'),
('J0170', 'Camera Bags', 'KS051'),
('J0171', 'Laptop Bags', 'KS051'),
('J0172', 'Carry all Bags', 'KS051');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K001', 'Makanan'),
('K002', 'Minuman'),
('K003', 'Perawatan Pribadi'),
('K004', 'Perawatan Kesehatan'),
('K005', 'Kebutuhan Bayi'),
('K006', 'Rumah & Dapur'),
('K007', 'Fashion & Sport');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sub`
--

CREATE TABLE IF NOT EXISTS `kategori_sub` (
  `kd_kategorisub` char(5) NOT NULL,
  `nm_kategorisub` varchar(100) NOT NULL,
  `kd_kategori` char(4) NOT NULL,
  PRIMARY KEY (`kd_kategorisub`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_sub`
--

INSERT INTO `kategori_sub` (`kd_kategorisub`, `nm_kategorisub`, `kd_kategori`) VALUES
('KS001', 'Bahan Masakan Kue', 'K001'),
('KS002', 'Makanan Kaleng', 'K001'),
('KS003', 'Mie', 'K001'),
('KS004', 'Kudapan', 'K001'),
('KS005', 'Sarapan', 'K001'),
('KS006', 'Permen', 'K001'),
('KS007', 'Susu', 'K002'),
('KS008', 'Jus', 'K002'),
('KS009', 'Kopi & Teh', 'K002'),
('KS010', 'Minuman Ringan', 'K002'),
('KS011', 'Rambut ', 'K003'),
('KS012', 'Perawatan Gigi & Mulut', 'K003'),
('KS013', 'Perawatan Wajah', 'K003'),
('KS014', 'Kosmetik', 'K003'),
('KS015', 'Perawatan Tubuh', 'K003'),
('KS016', 'Tisu & Kapas', 'K003'),
('KS017', 'Kebutuhan Wanita', 'K003'),
('KS018', 'Aromaterapi', 'K003'),
('KS019', 'Suplemen', 'K004'),
('KS020', 'Obat Luar ', 'K004'),
('KS021', 'Kontrasepsi', 'K004'),
('KS022', 'Obat-Obatan ', 'K004'),
('KS023', 'Makanan ', 'K005'),
('KS024', 'Perpopokan', 'K005'),
('KS025', 'Perawatan Tubuh ', 'K005'),
('KS026', 'Alat Makan ', 'K005'),
('KS027', 'Kebutuhan Ibu ', 'K005'),
('KS028', 'Perangkat Hadiah ', 'K005'),
('KS029', 'Accessories', 'K005'),
('KS030', 'Binatu ', 'K005'),
('KS031', 'Peralatan Rumah Tangga ', 'K006'),
('KS032', 'Dapur & Meja Makan ', 'K006'),
('KS033', 'Alat Penyimpanan ', 'K006'),
('KS034', 'Perlengkapan', 'K006'),
('KS035', 'Kebutuhan Rumah Tangga ', 'K006'),
('KS036', 'Peliharaan', 'K006'),
('KS037', 'Otomotif', 'K006'),
('KS038', 'Alat Tulis Kantor', 'K006'),
('KS039', 'Sepatu Pria ', 'K007'),
('KS040', 'Sepatu Wanita ', 'K007'),
('KS041', 'Pakaian Pria ', 'K007'),
('KS042', 'Pakaian Wanita ', 'K007'),
('KS043', 'Olahraga ', 'K007'),
('KS044', 'Accessories', 'K007'),
('KS045', 'Bags', 'K007'),
('KS046', 'Womens Footwear ', 'K007'),
('KS047', 'Mens Clothing ', 'K007'),
('KS048', 'Mens Footwear', 'K007'),
('KS049', 'Sport', 'K007'),
('KS050', 'Accessories', 'K007'),
('KS051', 'Bags', 'K007');

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE IF NOT EXISTS `merek` (
  `kd_merek` char(4) NOT NULL,
  `nm_merek` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_merek`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`kd_merek`, `nm_merek`) VALUES
('M001', 'ABC '),
('M002', 'Bertolli'),
('M003', 'Bimoli'),
('M004', 'Blue Elephant '),
('M005', 'Clovis '),
('M006', 'Dougo'),
('M007', 'Filippo'),
('M008', 'Filippo Berio'),
('M009', 'Filma '),
('M010', 'Forvita'),
('M011', 'Fraiswell '),
('M012', 'Green Tosca'),
('M013', 'Heinz '),
('M014', 'Kunci Mas '),
('M015', 'Mama Suka '),
('M016', 'Mazola'),
('M017', 'Rafael Salgado'),
('M018', 'S&W'),
('M019', 'Sania'),
('M020', 'Sovia'),
('M021', 'Tropical'),
('M022', 'Tropicana Slim'),
('M023', 'Blue Band '),
('M024', 'Filma'),
('M025', 'Forvita'),
('M026', 'Bogasari'),
('M027', 'Hercules'),
('M028', 'Honig '),
('M029', 'Kruawangthip '),
('M030', 'Mama Suka'),
('M031', 'Ratu'),
('M032', 'Sajiku'),
('M033', 'Daesang '),
('M034', 'Elephant'),
('M035', 'Sunmaid'),
('M036', 'Bango '),
('M037', 'Agnesi'),
('M038', 'American Garden'),
('M039', 'Barilla '),
('M040', 'Bulldog'),
('M041', 'Casa Fiesta'),
('M042', 'Del Monte '),
('M043', 'Dua Belibis '),
('M044', 'Jamie Oliver'),
('M045', 'Kara'),
('M046', 'KCT'),
('M047', 'Kikkoman'),
('M048', 'Koepoe-Koepoe'),
('M049', 'La Fonte '),
('M050', 'Lee Kum Kee '),
('M051', 'Louisiana'),
('M052', 'LSH'),
('M053', 'Mae Ploy '),
('M054', 'Mae Pranom '),
('M055', 'Maggi '),
('M056', 'Magic Time '),
('M057', 'Nihon Shokken'),
('M058', 'Pronas'),
('M059', 'Royal Gold'),
('M060', 'S&B'),
('M061', 'Sing Tai Hing'),
('M062', 'Tabasco'),
('M063', 'Taste Me'),
('M064', 'Saori'),
('M065', 'MD Organic '),
('M066', ' Hotel '),
('M067', 'Si Pulen '),
('M068', 'Gulaku '),
('M069', 'Diabetasol '),
('M070', 'Sajiku '),
('M071', 'Royco'),
('M072', 'Ajinomoto'),
('M073', 'Indofood'),
('M074', 'Masako'),
('M075', 'Aroy-D '),
('M076', 'Bonduelle'),
('M077', 'Cirio'),
('M078', 'Dole'),
('M079', 'Erawan'),
('M080', 'KAF'),
('M081', 'Lily Flower'),
('M082', 'Maling '),
('M083', 'Narcissus '),
('M084', 'Hakubaku'),
('M085', 'Hatakenaka '),
('M086', 'Indomie '),
('M087', 'Javara '),
('M088', 'Lungkow'),
('M089', 'Mama'),
('M090', 'Migelas'),
('M091', 'Pop Mie '),
('M092', 'Sedaap '),
('M093', 'Holland'),
('M094', 'Khong Guan'),
('M095', 'Oreo '),
('M096', 'Ritz '),
('M097', 'Roma'),
('M098', 'Selamat'),
('M099', 'Tango '),
('M100', 'Twister '),
('M101', 'Astor '),
('M102', 'Monde '),
('M103', 'Butterfly'),
('M104', 'Garuda'),
('M105', 'Kangaroo '),
('M106', 'Kayaking '),
('M107', 'Sunkist '),
('M108', 'Chitato '),
('M109', 'Qtela'),
('M110', 'Lays'),
('M111', 'Happy Tos'),
('M112', 'Al-Karamah'),
('M113', 'Beng Beng '),
('M114', 'Fitbar'),
('M115', 'Quaker Oat'),
('M116', 'Kraft '),
('M117', 'Espresso'),
('M118', 'Kopiko'),
('M119', 'KIS'),
('M120', 'Nestle'),
('M121', 'Energen'),
('M122', 'Anlene'),
('M123', 'Boneeto'),
('M124', 'Dancow '),
('M125', 'Frisian Flag '),
('M126', 'HiLo'),
('M127', 'Indomilk'),
('M128', 'MILO'),
('M129', 'Ultra'),
('M130', 'Buavita '),
('M131', 'Nutrisari '),
('M132', 'Sunkist');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `kd_pelanggan` char(4) NOT NULL,
  `nm_pelanggan` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_pelanggan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`kd_pelanggan`, `nm_pelanggan`, `alamat`, `no_telepon`) VALUES
('P001', 'UMUM', 'Alamat Umum', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
  `no_pembelian` char(8) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`no_pembelian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_pembelian`, `tgl_pembelian`, `kd_supplier`, `keterangan`, `kd_user`) VALUES
('BL000001', '2015-07-05', 'S001', 'Belanja Stok', 'U01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_bayar`
--

CREATE TABLE IF NOT EXISTS `pembelian_bayar` (
  `no_belibayar` char(5) NOT NULL,
  `no_pembelian` char(8) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_kasir` char(4) NOT NULL,
  PRIMARY KEY (`no_belibayar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE IF NOT EXISTS `pembelian_item` (
  `no_pembelian` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_item`
--

INSERT INTO `pembelian_item` (`no_pembelian`, `kd_barang`, `harga_beli`, `jumlah`) VALUES
('BL000001', 'B000081', 9500, 36),
('BL000001', 'B000067', 8500, 24),
('BL000001', 'B000066', 80000, 24),
('BL000001', 'B000030', 52000, 24),
('BL000001', 'B000029', 28000, 24),
('BL000001', 'B000012', 9000, 24),
('BL000001', 'B000011', 60000, 12),
('BL000001', 'B000004', 24000, 24),
('BL000001', 'B000003', 11000, 24),
('BL000001', 'B000002', 23000, 24),
('BL000001', 'B000001', 25000, 24),
('BL000001', 'B000082', 9500, 36),
('BL000001', 'B000074', 4000, 36),
('BL000001', 'B000075', 20000, 20),
('BL000001', 'B000060', 37000, 24),
('BL000001', 'B000061', 4500, 36),
('BL000001', 'B000062', 8000, 36),
('BL000001', 'B000063', 8000, 36),
('BL000001', 'B000132', 50200, 15),
('BL000001', 'B000133', 105000, 15);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `no_penjualan` char(8) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`no_penjualan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE IF NOT EXISTS `penjualan_item` (
  `no_penjualan` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `diskon` int(4) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pilih_satuan`
--

CREATE TABLE IF NOT EXISTS `pilih_satuan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(20) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pilih_satuan`
--

INSERT INTO `pilih_satuan` (`id`, `satuan`, `keterangan`) VALUES
(1, 'Kds', 'Kardus'),
(2, 'Box', 'Box/ Kotak'),
(3, 'Btl', 'Botol'),
(4, 'Jerigen ', '-'),
(5, 'Pch', 'Pouch '),
(6, 'Sct', 'Sachet '),
(7, 'Pcs', 'Pieces'),
(8, 'Pck', 'Pack'),
(9, 'Pc', 'Piece'),
(10, 'Klg', 'Kaleng'),
(11, 'Tpk', '-'),
(12, 'Str', '-'),
(13, 'Bag', '-'),
(14, 'Pot', '-'),
(15, 'Tub', 'Tube'),
(16, 'Sak', '-'),
(17, 'Pet', '-');

-- --------------------------------------------------------

--
-- Table structure for table `returbeli`
--

CREATE TABLE IF NOT EXISTS `returbeli` (
  `no_returbeli` char(8) NOT NULL,
  `tgl_returbeli` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`no_returbeli`),
  KEY `kd_supplier` (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returbeli_item`
--

CREATE TABLE IF NOT EXISTS `returbeli_item` (
  `no_returbeli` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  KEY `no_pembelian` (`no_returbeli`,`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `no_telepon`) VALUES
('S001', 'DISTRIBUTOR PUSAT 1', 'Jl. Tanjung Karang Barat, 123', '027400010101'),
('S002', 'DISTRIBUTOR PUSAT 2', 'Jl. Pagar Alam, 123, Bandar Lampung', '02741191919');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pembelian`
--

CREATE TABLE IF NOT EXISTS `tmp_pembelian` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE IF NOT EXISTS `tmp_penjualan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kd_barang` char(7) NOT NULL,
  `harga` int(12) NOT NULL,
  `diskon` int(4) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_returbeli`
--

CREATE TABLE IF NOT EXISTS `tmp_returbeli` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `kd_user` char(3) NOT NULL,
  `nm_user` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kd_user`, `nm_user`, `no_telepon`, `username`, `password`, `level`) VALUES
('U01', 'Septi Suhesti', '0211111111111', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('U02', 'Fitria Prasetiawati', '2323232', 'kasir', 'c7911af3adbd12a035b289556d96470a', 'Kasir'),
('U03', 'Indah Indriyanna', '081911111111', 'indah', 'f3385c508ce54d577fd205a1b2ecdfb7', 'Kasir'),
('U04', 'Septiani', '0815245678', 'septiani', 'bec5c2ec524559a2d4cb71e203e298a9', 'Kasir'),
('U05', 'Juanto', '0815245678', 'juanto', '5ccdc826623213fc71fe40dd3503545a', 'Kasir');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
