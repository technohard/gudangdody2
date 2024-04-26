-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2024 at 01:22 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adjustment`
--

CREATE TABLE `tbl_adjustment` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) NOT NULL,
  `stok` int DEFAULT '0',
  `total_stok` int DEFAULT '0',
  `jumlah` int DEFAULT NULL COMMENT 'qty adjustment',
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_adjustment`
--

INSERT INTO `tbl_adjustment` (`id_transaksi`, `tanggal`, `barang`, `stok`, `total_stok`, `jumlah`, `keterangan`) VALUES
('TA-0000001', '2024-04-15', 'B0001', 1, 6, 5, 'tess');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jenis` int NOT NULL,
  `stok_minimum` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `satuan` int NOT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggale` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama_barang`, `jenis`, `stok_minimum`, `stok`, `satuan`, `foto`, `tanggale`, `keterangan`) VALUES
('B0001', 'tes1', 1, 5, 1, 1, 'b57a1fa1ed4da973bf82082059749ff1525cc925.jpg', '2024-04-15', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_keluar`
--

CREATE TABLE `tbl_barang_keluar` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) NOT NULL,
  `nama_pengirim` varchar(255) DEFAULT NULL,
  `nama_penerima` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `jns_dok` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'jenis dokumen',
  `tgl_dok` date DEFAULT NULL COMMENT 'tanggal dokumen',
  `no_dok` varchar(100) DEFAULT NULL COMMENT 'nomor dokumen',
  `jumlah` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_keluar`
--

INSERT INTO `tbl_barang_keluar` (`id_transaksi`, `tanggal`, `barang`, `nama_pengirim`, `nama_penerima`, `jns_dok`, `tgl_dok`, `no_dok`, `jumlah`) VALUES
('TK-0000001', '2024-04-15', 'B0001', 'tes p2', 'tes p3', 'Freemovement', '2024-04-15', 'dok002', 1);

--
-- Triggers `tbl_barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `hapus_stok_keluar` BEFORE DELETE ON `tbl_barang_keluar` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok+OLD.jumlah
WHERE id_barang=OLD.barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_keluar` AFTER INSERT ON `tbl_barang_keluar` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok-NEW.jumlah
WHERE id_barang=NEW.barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) NOT NULL,
  `nama_pengirim` varchar(255) DEFAULT NULL,
  `jns_dok` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT ' ' COMMENT 'jenis dokumen',
  `tgl_dok` date DEFAULT NULL COMMENT 'tanggal dokumen',
  `no_dok` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'nomor dokumen',
  `jumlah` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`id_transaksi`, `tanggal`, `barang`, `nama_pengirim`, `jns_dok`, `tgl_dok`, `no_dok`, `jumlah`) VALUES
('TM-0000001', '2024-04-15', 'B0001', 'tes p1', 'PPKEK', '2024-04-15', 'dok001', 2);

--
-- Triggers `tbl_barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `hapus_stok_masuk` BEFORE DELETE ON `tbl_barang_masuk` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok-OLD.jumlah
WHERE id_barang=OLD.barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_masuk` AFTER INSERT ON `tbl_barang_masuk` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok+NEW.jumlah
WHERE id_barang=NEW.barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis`
--

CREATE TABLE `tbl_jenis` (
  `id_jenis` int NOT NULL,
  `nama_jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jenis`
--

INSERT INTO `tbl_jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Umum'),
(2, 'Material'),
(3, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saldo`
--

CREATE TABLE `tbl_saldo` (
  `id_transaksi` varchar(50) NOT NULL,
  `periode` varchar(6) DEFAULT NULL,
  `id_barang` varchar(5) DEFAULT NULL,
  `saldo_awal` decimal(20,0) DEFAULT '0',
  `masuk` decimal(20,0) DEFAULT '0',
  `keluar` decimal(20,0) DEFAULT '0',
  `saldo_akhir` decimal(20,0) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `id_satuan` int NOT NULL,
  `nama_satuan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Kg'),
(3, 'Dos');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hak_akses` enum('Administrator','Admin Gudang','Kepala Gudang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`, `hak_akses`) VALUES
(1, 'Admin', 'administrator', '$2y$12$Yi/I5f1jPoQNQnh6lWoVfuz.RtZ3OHcKN6PU.I62P0fYK1tJ7xMRi', 'Administrator'),
(2, 'Admin Gudang', 'admin gudang', '$2y$12$BeRYh13zfPXej97VgcfeNucYJGTElha5sRyIUQm1278D2u2Aqf6DS', 'Admin Gudang'),
(3, 'Kepala Gudang', 'kepala gudang', '$2y$12$odXcPs.RLJJH6Ghv3s42c.5zg5qAOz/S3Adr0lXGNcVSJ6f1hHS6G', 'Kepala Gudang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_adjustment`
--
ALTER TABLE `tbl_adjustment`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_jenis`
--
ALTER TABLE `tbl_jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tbl_saldo`
--
ALTER TABLE `tbl_saldo`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_jenis`
--
ALTER TABLE `tbl_jenis`
  MODIFY `id_jenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `id_satuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
