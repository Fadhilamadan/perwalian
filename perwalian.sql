-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2016 at 04:37 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perwalian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(9) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('123', '202cb962ac59075b964b07152d234b70'),
('admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `kode_kelas` int(11) NOT NULL,
  `kode_mk` varchar(8) NOT NULL,
  `kode_periode` int(11) NOT NULL,
  `nama_kelas` varchar(8) NOT NULL,
  `kapasitas` smallint(6) NOT NULL,
  `hapuskah` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kode_kelas`, `kode_mk`, `kode_periode`, `nama_kelas`, `kapasitas`, `hapuskah`) VALUES
(5, '1600A002', 2, 'KP A', 8, 0),
(6, '1600A002', 2, 'KP B', 9, 0),
(7, '1604A031', 2, 'KP A', 9, 0),
(8, '1604A031', 2, 'KP B', 8, 0),
(10, '1604A043', 2, 'KP A', 9, 0),
(11, '1604A043', 2, 'KP B', 8, 0),
(12, '1604A042', 2, 'KP A', 7, 0),
(13, '1604A042', 2, 'KP B', 10, 0),
(14, '1604A044', 2, 'KP A', 8, 0),
(15, '1604A044', 2, 'KP B', 9, 0),
(16, '1604A051', 2, 'KP A', 8, 0),
(17, '1604A051', 2, 'KP B', 9, 0),
(18, '1600A002', 1, 'KP A', 10, 0),
(19, '1604A031', 1, 'KP A', 10, 0),
(20, '1604A042', 1, 'KP A', 10, 0),
(21, '1604A043', 1, 'KP A', 10, 0),
(22, '1604A044', 1, 'KP A', 10, 0),
(23, '1604A051', 1, 'KP A', 10, 0),
(24, '1600A002', 3, 'KP A', 10, 0),
(25, '1604A031', 3, 'KP A', 10, 0),
(26, '1604A042', 3, 'KP A', 10, 0),
(27, '1604A043', 3, 'KP A', 10, 0),
(28, '1604A044', 3, 'KP A', 10, 0),
(29, '1604A051', 3, 'KP A', 10, 0),
(30, '1604A052', 1, 'KP A', 10, 0),
(31, '1604A052', 2, 'KP A', 8, 0),
(32, '1604A052', 3, 'KP A', 10, 0),
(33, '1604A052', 2, 'KP B', 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nrp` varchar(9) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `jatah_sks` int(11) NOT NULL,
  `foto_profil` varchar(100) NOT NULL,
  `hapuskah` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nrp`, `nama`, `password`, `jatah_sks`, `foto_profil`, `hapuskah`) VALUES
('160414039', 'Putu Aditya', '25d55ad283aa400af464c76d713c07ad', 24, 'aeb97d93fd.jpg', 0),
('160414053', 'Faishal Hendaryawan', '25d55ad283aa400af464c76d713c07ad', 24, 'dae636e67e.jpg', 0),
('160414063', 'Fadhil Amadan', '25d55ad283aa400af464c76d713c07ad', 24, 'e4222012d9.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_kelas`
--

CREATE TABLE `mahasiswa_kelas` (
  `nrp` varchar(9) NOT NULL,
  `kode_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa_kelas`
--

INSERT INTO `mahasiswa_kelas` (`nrp`, `kode_kelas`) VALUES
('160414039', 6),
('160414039', 7),
('160414039', 11),
('160414039', 12),
('160414039', 14),
('160414039', 16),
('160414039', 31),
('160414053', 5),
('160414053', 8),
('160414053', 11),
('160414053', 12),
('160414053', 14),
('160414053', 17),
('160414053', 33),
('160414063', 5),
('160414063', 8),
('160414063', 10),
('160414063', 12),
('160414063', 15),
('160414063', 16);

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_mk` varchar(8) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jumlah_sks` smallint(6) NOT NULL,
  `deskripsi` text NOT NULL,
  `hapuskah` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode_mk`, `nama`, `jumlah_sks`, `deskripsi`, `hapuskah`) VALUES
('1600A002', 'Bahasa Inggris', 2, 'Bahasa Inggris', 0),
('1604A031', 'Struktur Data', 4, 'Struktur Data', 0),
('1604A042', 'Interaksi Manusia Komputer', 3, 'Interaksi Manusia Komputer', 0),
('1604A043', 'Pemrograman Web', 3, 'Pemrograman Web', 0),
('1604A044', 'Manajemen Sains', 3, 'Manajemen Sains', 0),
('1604A051', 'Pemrograman Terdistribusi', 4, 'Pemrograman Terdistribusi', 0),
('1604A052', 'Security and Assurance', 3, 'Information Security and Assurance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `kode_periode` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `hapuskah` tinyint(1) NOT NULL,
  `tanggal_buka` date NOT NULL,
  `tanggal_akhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`kode_periode`, `nama`, `status`, `hapuskah`, `tanggal_buka`, `tanggal_akhir`) VALUES
(1, 'GANJIL 2015/2016', 0, 0, '2015-08-15', '2015-12-24'),
(2, 'GENAP 2015/2016', 1, 0, '2016-02-15', '2016-06-24'),
(3, 'GANJIL 2016/2017', 0, 0, '2016-08-15', '2016-12-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kode_kelas`),
  ADD KEY `kode_periode` (`kode_periode`),
  ADD KEY `kode_mk` (`kode_mk`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nrp`);

--
-- Indexes for table `mahasiswa_kelas`
--
ALTER TABLE `mahasiswa_kelas`
  ADD PRIMARY KEY (`nrp`,`kode_kelas`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_mk`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`kode_periode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kode_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `kode_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
