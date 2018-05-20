-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2018 at 02:05 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir_sangata`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
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
  `harga_member` double NOT NULL,
  `diskon` int(4) NOT NULL,
  `stok` int(4) NOT NULL,
  `stok_opname` int(4) NOT NULL,
  `stok_minimal` int(4) NOT NULL,
  `stok_maksimal` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(4) NOT NULL,
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
  `mu_trans_returjual` enum('No','Yes') NOT NULL,
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
  `mu_header` enum('No','Yes') NOT NULL,
  `mlap_stok_barang` enum('No','Yes','','') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `kd_jenis` char(5) NOT NULL,
  `nm_jenis` varchar(100) NOT NULL,
  `kd_kategori` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `kd_merek` char(4) NOT NULL,
  `nm_merek` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kd_pelanggan` char(4) NOT NULL,
  `no_anggota` varchar(20) NOT NULL,
  `nm_pelanggan` varchar(100) NOT NULL,
  `unit_kerja` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_pembelian` char(8) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `dp` int(11) NOT NULL,
  `kd_user` char(3) NOT NULL,
  `tgl_tempo` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_bayar`
--

CREATE TABLE `pembelian_bayar` (
  `no_belibayar` int(11) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_kasir` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE `pembelian_item` (
  `no_pembelian` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `diskon` varchar(10) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_penjualan` char(8) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_bayar`
--

CREATE TABLE `penjualan_bayar` (
  `no_jualbayar` int(11) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `uang_bayar` int(11) NOT NULL,
  `kd_kasir` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE `penjualan_item` (
  `no_penjualan` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `sn` varchar(32) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `diskon` int(4) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pilih_satuan`
--

CREATE TABLE `pilih_satuan` (
  `id` int(4) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returbeli`
--

CREATE TABLE `returbeli` (
  `no_returbeli` char(8) NOT NULL,
  `tgl_returbeli` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returbeli_item`
--

CREATE TABLE `returbeli_item` (
  `no_returbeli` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returjual`
--

CREATE TABLE `returjual` (
  `no_returjual` char(8) NOT NULL,
  `tgl_returjual` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returjual_item`
--

CREATE TABLE `returjual_item` (
  `no_returjual` char(8) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_header`
--

CREATE TABLE `tb_header` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(12) NOT NULL,
  `thumbnail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_login`
--

CREATE TABLE `tmp_login` (
  `id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pembelian`
--

CREATE TABLE `tmp_pembelian` (
  `id` int(3) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga` int(12) NOT NULL,
  `diskon` varchar(10) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE `tmp_penjualan` (
  `id` int(10) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `sn` varchar(32) NOT NULL,
  `harga` int(12) NOT NULL,
  `diskon` int(4) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_returbeli`
--

CREATE TABLE `tmp_returbeli` (
  `id` int(3) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_returjual`
--

CREATE TABLE `tmp_returjual` (
  `id` int(11) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kd_user` char(3) NOT NULL,
  `nm_user` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`kd_merek`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kd_pelanggan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_pembelian`);

--
-- Indexes for table `pembelian_bayar`
--
ALTER TABLE `pembelian_bayar`
  ADD PRIMARY KEY (`no_belibayar`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_penjualan`);

--
-- Indexes for table `penjualan_bayar`
--
ALTER TABLE `penjualan_bayar`
  ADD PRIMARY KEY (`no_jualbayar`);

--
-- Indexes for table `pilih_satuan`
--
ALTER TABLE `pilih_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returbeli`
--
ALTER TABLE `returbeli`
  ADD PRIMARY KEY (`no_returbeli`),
  ADD KEY `kd_supplier` (`kd_supplier`);

--
-- Indexes for table `returbeli_item`
--
ALTER TABLE `returbeli_item`
  ADD KEY `no_pembelian` (`no_returbeli`,`kd_barang`);

--
-- Indexes for table `returjual`
--
ALTER TABLE `returjual`
  ADD PRIMARY KEY (`no_returjual`);

--
-- Indexes for table `returjual_item`
--
ALTER TABLE `returjual_item`
  ADD PRIMARY KEY (`no_returjual`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `tb_header`
--
ALTER TABLE `tb_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_login`
--
ALTER TABLE `tmp_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_returbeli`
--
ALTER TABLE `tmp_returbeli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_returjual`
--
ALTER TABLE `tmp_returjual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kd_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `pembelian_bayar`
--
ALTER TABLE `pembelian_bayar`
  MODIFY `no_belibayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penjualan_bayar`
--
ALTER TABLE `penjualan_bayar`
  MODIFY `no_jualbayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pilih_satuan`
--
ALTER TABLE `pilih_satuan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tb_header`
--
ALTER TABLE `tb_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tmp_login`
--
ALTER TABLE `tmp_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;
--
-- AUTO_INCREMENT for table `tmp_returbeli`
--
ALTER TABLE `tmp_returbeli`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tmp_returjual`
--
ALTER TABLE `tmp_returjual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
