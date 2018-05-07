-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2015 at 04:46 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `penjualandb`
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
