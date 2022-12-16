-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Sep 2021 pada 17.02
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_wo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` varchar(10) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `id_user`, `nama_admin`, `no_tlp`, `alamat`) VALUES
('ADM000001', 'USR000002', 'rizki', '021021888999', 'alamat rizki'),
('ADM000002', 'USR000005', 'admin tes', '021021888999', 'alamat admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_departemen`
--

CREATE TABLE `tb_departemen` (
  `id_departemen` varchar(10) NOT NULL,
  `nama_departemen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_departemen`
--

INSERT INTO `tb_departemen` (`id_departemen`, `nama_departemen`) VALUES
('DP000001', 'R & D'),
('DP000002', 'PPIC'),
('DP000003', 'MTC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtpengajuan`
--

CREATE TABLE `tb_dtpengajuan` (
  `id_dtpengajuan` int(11) NOT NULL,
  `id_pengajuan` varchar(10) NOT NULL,
  `id_inventaris` varchar(10) NOT NULL,
  `id_teknisi` varchar(10) DEFAULT NULL,
  `approved_manager` varchar(10) DEFAULT NULL,
  `tgl_approve_manager` date DEFAULT NULL,
  `approved_mtn` varchar(10) DEFAULT NULL,
  `tgl_approve_mtn` date DEFAULT NULL,
  `masalah` varchar(200) NOT NULL,
  `penanganan` varchar(200) DEFAULT NULL,
  `progres` varchar(10) DEFAULT NULL,
  `keterangan_tkn` varchar(200) DEFAULT NULL,
  `status_detail` varchar(20) DEFAULT NULL,
  `tgl_perbaikan` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_dtpengajuan`
--

INSERT INTO `tb_dtpengajuan` (`id_dtpengajuan`, `id_pengajuan`, `id_inventaris`, `id_teknisi`, `approved_manager`, `tgl_approve_manager`, `approved_mtn`, `tgl_approve_mtn`, `masalah`, `penanganan`, `progres`, `keterangan_tkn`, `status_detail`, `tgl_perbaikan`, `tgl_selesai`, `gambar`) VALUES
(8, 'KPG000001', 'INV000001', 'USR000008', 'USR000007', '2021-09-13', 'USR000012', '2021-09-13', 'perbaikan mesin A', 'perbaikan mesin a', '60', 'perbaikan mesin A', 'PROSES TEKNISI', '2021-09-13', NULL, 'KPG000001_foto_1.png'),
(9, 'KPG000002', 'INV000002', NULL, NULL, NULL, NULL, NULL, 'perbaikan mesin B', NULL, NULL, NULL, NULL, NULL, NULL, 'KPG000002_foto_1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtpermintaan`
--

CREATE TABLE `tb_dtpermintaan` (
  `id_dtpermintaan` int(11) NOT NULL,
  `id_permintaan` varchar(10) NOT NULL,
  `id_teknisi` varchar(10) DEFAULT NULL,
  `id_inventaris` varchar(10) NOT NULL,
  `approved_manager` varchar(10) DEFAULT '',
  `tgl_app_manager` date DEFAULT NULL,
  `approved_mtn` varchar(10) DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `tgl_approved_mtn` date DEFAULT NULL,
  `tujuan` varchar(200) NOT NULL,
  `keterangan_tkn` varchar(100) DEFAULT NULL,
  `keterangan_mtn` varchar(100) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `progres` varchar(10) DEFAULT NULL,
  `status_detail` varchar(30) DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_dtpermintaan`
--

INSERT INTO `tb_dtpermintaan` (`id_dtpermintaan`, `id_permintaan`, `id_teknisi`, `id_inventaris`, `approved_manager`, `tgl_app_manager`, `approved_mtn`, `keterangan`, `tgl_approved_mtn`, `tujuan`, `keterangan_tkn`, `keterangan_mtn`, `gambar`, `progres`, `status_detail`, `tgl_selesai`) VALUES
(31, 'KPR000002', 'USR000008', 'INV000001', 'USR000007', '2021-09-13', 'USR000012', 'pasang mesin A', '2021-09-13', 'pasang mesin A', 'proses A', 'pasang mesin a', 'KPR000002_foto_1.jpg', '30', 'PROSES TEKNISI', NULL),
(32, 'KPR000002', 'USR000008', 'INV000002', 'USR000007', '2021-09-13', 'USR000012', 'pasang mesin B', '2021-09-13', 'pasang mesin B', 'selesai', 'pasang mesin b', 'KPR000002_foto_2.jpg', '100', 'SELESAI', '2021-09-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_inventaris`
--

CREATE TABLE `tb_inventaris` (
  `id_inventaris` varchar(10) NOT NULL,
  `create_by` varchar(10) NOT NULL,
  `id_departemen` varchar(10) NOT NULL,
  `nama_inventaris` varchar(50) NOT NULL,
  `tgl_operasi` date NOT NULL,
  `tgl_beli` date NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_inventaris`
--

INSERT INTO `tb_inventaris` (`id_inventaris`, `create_by`, `id_departemen`, `nama_inventaris`, `tgl_operasi`, `tgl_beli`, `keterangan`) VALUES
('INV000001', '1', 'DP000001', 'mesin A', '2021-09-13', '2021-09-13', 'mesin A e'),
('INV000002', '1', 'DP000001', 'mesin B', '2021-09-13', '2021-09-13', 'mesin B'),
('INV000003', '1', 'DP000002', 'alat A', '2021-09-13', '2021-09-13', 'alat A'),
('INV000004', '1', 'DP000002', 'alat B', '2021-09-13', '2021-09-13', 'alat B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `id_karyawan` varchar(10) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_departemen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`id_karyawan`, `id_user`, `nama_karyawan`, `no_tlp`, `alamat`, `email`, `id_departemen`) VALUES
('KRY000001', 'USR000006', 'admin rd', '081317555430', 'alamat admin r&D', 'vinosisfo13@yahoo.com', 'DP000001'),
('KRY000002', 'USR000007', 'manager rd', '081317555430', 'manager rd', 'vinosisfo13@yahoo.com', 'DP000001'),
('KRY000003', 'USR000008', 'teknisi rd', '081317555430', 'teknisi rd', 'vinosisfo13@yahoo.com', 'DP000001'),
('KRY000004', 'USR000009', 'admin ppic', '081317555430', 'admin ppic', 'vinosisfo13@yahoo.com', 'DP000002'),
('KRY000005', 'USR000010', 'manager ppic', '081317555430', 'manager ppic', 'vinosisfo13@yahoo.com', 'DP000002'),
('KRY000006', 'USR000011', 'teknisi ppic', '081317555430', 'teknisi ppic', 'vinosisfo13@yahoo.com', 'DP000002'),
('KRY000007', 'USR000012', 'manager mtc rd', '081317555430', 'manager mtc rd', 'vinosisfo13@yahoo.com', 'DP000001'),
('KRY000008', 'USR000013', 'manager mtc ppic', '081317555430', 'manager mtc ppic', 'vinosisfo13@yahoo.com', 'DP000002'),
('KRY000009', 'USR000016', 'ADMIN', '081317555430', 'ADMIN MTC ', 'vinosisfo13@yahoo.com', 'DP000003');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengajuan`
--

CREATE TABLE `tb_pengajuan` (
  `id_pengajuan` varchar(10) NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `di_ajukan` varchar(10) DEFAULT NULL,
  `status_pengajuan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pengajuan`
--

INSERT INTO `tb_pengajuan` (`id_pengajuan`, `tgl_pengajuan`, `di_ajukan`, `status_pengajuan`) VALUES
('KPG000001', '2021-09-13', '1', 'PROSES TEKNISI'),
('KPG000002', '2021-09-13', '1', 'BARU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_permintaan`
--

CREATE TABLE `tb_permintaan` (
  `id_permintaan` varchar(10) NOT NULL,
  `tgl_permintaan` date DEFAULT NULL,
  `di_ajukan` varchar(10) DEFAULT NULL,
  `status_permintaan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_permintaan`
--

INSERT INTO `tb_permintaan` (`id_permintaan`, `tgl_permintaan`, `di_ajukan`, `status_permintaan`) VALUES
('KPR000002', '2021-09-13', '1', 'PROSES TEKNISI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_teknisi`
--

CREATE TABLE `tb_teknisi` (
  `id_teknisi` varchar(10) NOT NULL,
  `nama_teknisi` varchar(50) NOT NULL,
  `no_tlpn` varchar(13) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_departemen` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_teknisi`
--

INSERT INTO `tb_teknisi` (`id_teknisi`, `nama_teknisi`, `no_tlpn`, `id_user`, `id_departemen`, `email`) VALUES
('TKN000001', 'teknisi rd', '081317555430', 'USR000014', 'DP000001', 'vinosisfo13@yahoo.com'),
('TKN000002', 'teknisi ppic', '081317555430', 'USR000015', 'DP000002', 'vinosisfo13@yahoo.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `level`, `status`) VALUES
('USR000002', 'test', '3b712de48137572f3849aabd5666a4e3', 'ADMIN', 'Aktif'),
('USR000004', 'test teknisi', 'ac57e6c2487c446046752e5681cc9289', 'TEKNISI', 'AKTIF'),
('USR000005', 'mekanik teknisi', '95fc22f57b072e796e26c87614ff50b8', 'TEKNISI', 'AKTIF'),
('USR000006', 'admin rd', '1b86b438ceea2a82baa0e1523b255e01', 'ADMIN DEPT', 'AKTIF'),
('USR000007', 'manager rd', '3bf69d7af0a1c7101a3018a0078e8466', 'MANAGER DEPT', 'AKTIF'),
('USR000008', 'teknisi rd', '4b6a367e4eb3e3a1bf042dc1b71764e7', 'TEKNISI', 'AKTIF'),
('USR000009', 'admin ppic', 'c01a333835f1f5693a3542e4719f25a6', 'ADMIN DEPT', 'AKTIF'),
('USR000010', 'manager ppic', '76642a100f3676a507ddb00c6ee1486a', 'MANAGER DEPT', 'AKTIF'),
('USR000011', 'teknisi ppic', '6718c5f8fdd2d1ee7303496b46900b5b', 'TEKNISI', 'AKTIF'),
('USR000012', 'manager mtc rd', 'd70751f116b1c18f7faadf9d626f158d', 'MANAGER MTN', 'AKTIF'),
('USR000013', 'manager mtc ppic', '9ae1c0c9a02e22ae4f0426cbe83b53db', 'MANAGER MTN', 'AKTIF'),
('USR000014', 'teknisi rd', 'b634f25f3a5c31d63b44d73bb30d82cc', 'TEKNISI', 'AKTIF'),
('USR000015', 'teknisi ppic', 'a9f4196b654f420558a6d3ed2a54af2d', 'TEKNISI', 'AKTIF'),
('USR000016', 'ADMIN', '9aa22fdeec2b64e00f99b4752f071e6f', 'ADMIN', 'AKTIF');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_departemen`
--
ALTER TABLE `tb_departemen`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indeks untuk tabel `tb_dtpengajuan`
--
ALTER TABLE `tb_dtpengajuan`
  ADD PRIMARY KEY (`id_dtpengajuan`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indeks untuk tabel `tb_dtpermintaan`
--
ALTER TABLE `tb_dtpermintaan`
  ADD PRIMARY KEY (`id_dtpermintaan`);

--
-- Indeks untuk tabel `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  ADD PRIMARY KEY (`id_inventaris`);

--
-- Indeks untuk tabel `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `tb_pengajuan`
--
ALTER TABLE `tb_pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `tb_permintaan`
--
ALTER TABLE `tb_permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `tb_teknisi`
--
ALTER TABLE `tb_teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_dtpengajuan`
--
ALTER TABLE `tb_dtpengajuan`
  MODIFY `id_dtpengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_dtpermintaan`
--
ALTER TABLE `tb_dtpermintaan`
  MODIFY `id_dtpermintaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
