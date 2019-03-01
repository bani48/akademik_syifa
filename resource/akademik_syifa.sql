/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50626
Source Host           : 127.0.0.1:3306
Source Database       : akademik_syifa

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2019-02-25 06:19:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dokumen
-- ----------------------------
DROP TABLE IF EXISTS `dokumen`;
CREATE TABLE `dokumen` (
  `id_dokumen` char(5) DEFAULT NULL,
  `nama_dokumen` varchar(100) DEFAULT NULL,
  `tanggal_upload` date DEFAULT NULL,
  `create_user` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dokumen
-- ----------------------------
INSERT INTO `dokumen` VALUES ('DK001', 'Instrument observasi telaah kurikulum.docx', '2018-11-05', '1');
INSERT INTO `dokumen` VALUES ('DK002', 'Pedoman Praktik Industri PTE 2016-2017.doc', '2018-11-30', '4');
INSERT INTO `dokumen` VALUES ('DK003', 'PANDUAN SEMINAR PROPOSAL PTE 2017_lengkap.pdf', '2018-12-13', '1');

-- ----------------------------
-- Table structure for dosen
-- ----------------------------
DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id_dosen` char(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` char(21) NOT NULL DEFAULT '',
  `jabatan_fungsional` varchar(100) DEFAULT NULL,
  `stat` int(11) DEFAULT '0',
  `jabatan_struktural` varchar(100) DEFAULT NULL,
  `bidang_keahlian` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_dosen`,`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of dosen
-- ----------------------------
INSERT INTO `dosen` VALUES ('D0001', 'Didik Aribowo, S.T., M.T', '19820215200812100', 'Lektor', '0', null, null, null);
INSERT INTO `dosen` VALUES ('D0002', 'Endi Permata, S.T., M.T', '19780614200501100', 'Lektor', '0', 'Ketua Jurusan', 'Teknik Elektro', 'endipermata@untirta.ac.id');
INSERT INTO `dosen` VALUES ('D0003', 'Mohammad Fatkhurrokhman, M.Pd', '0005048904', 'Asisten Ahli', '1', null, null, null);
INSERT INTO `dosen` VALUES ('D0004', 'Mustofa Abi Hamid, M.Pd.T', '19910312201803100', 'Asisten Ahli', '1', null, null, null);
INSERT INTO `dosen` VALUES ('D0005', 'Ratna Ekawati, M.Pd', '0005038606', 'Asisten Ahli', '1', null, null, null);
INSERT INTO `dosen` VALUES ('D0006', 'Desmira, S.T., M.T', '0428058201', 'Asisten Ahli', '1', null, null, null);
INSERT INTO `dosen` VALUES ('D0007', 'Ilham Akbar Darmawan, M.Pd.', '201808032162', 'Tenaga Pendidik', '1', null, null, null);
INSERT INTO `dosen` VALUES ('D0008', 'Dr. Irwanto, MT.,MM., M.Pd., MA', '201808032163', 'Tenaga Pendidik', '0', null, null, null);

-- ----------------------------
-- Table structure for jadwal_seminar
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_seminar`;
CREATE TABLE `jadwal_seminar` (
  `id_jadwal` char(5) NOT NULL,
  `id_pi` char(5) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `ruangan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jadwal_seminar
-- ----------------------------

-- ----------------------------
-- Table structure for jadwal_seminar_proposal
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_seminar_proposal`;
CREATE TABLE `jadwal_seminar_proposal` (
  `id_jadwal` char(5) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jadwal_seminar_proposal
-- ----------------------------

-- ----------------------------
-- Table structure for jurnal_harian
-- ----------------------------
DROP TABLE IF EXISTS `jurnal_harian`;
CREATE TABLE `jurnal_harian` (
  `id_jurnal_harian` char(5) NOT NULL,
  `id_perusahaan` char(5) NOT NULL,
  `id_mahasiswa` varchar(100) DEFAULT NULL,
  `kegiatan` varchar(100) DEFAULT NULL,
  `waktu` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_jurnal_harian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jurnal_harian
-- ----------------------------
INSERT INTO `jurnal_harian` VALUES ('J0001', 'P0001', '2283142088', 'boiler d', '2019-01-23', 'membuat laporan');
INSERT INTO `jurnal_harian` VALUES ('J0002', 'P0001', '2283142088', 'pemeliharaan', '2019-01-09', 'belajar');
INSERT INTO `jurnal_harian` VALUES ('J0003', 'P0001', '2283180013', 'boiler d', '2019-01-17', 'semua ok');

-- ----------------------------
-- Table structure for karya_ilmiah_dosen
-- ----------------------------
DROP TABLE IF EXISTS `karya_ilmiah_dosen`;
CREATE TABLE `karya_ilmiah_dosen` (
  `id_karya` int(5) NOT NULL AUTO_INCREMENT,
  `id_dosen` char(50) NOT NULL,
  `judul` varchar(150) NOT NULL DEFAULT '',
  `tanggal_publikasi` date DEFAULT NULL,
  `publikasi` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id_karya`,`id_dosen`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of karya_ilmiah_dosen
-- ----------------------------
INSERT INTO `karya_ilmiah_dosen` VALUES ('2', 'D0001', 'judul nya banyak', '2019-02-02', 'uuasdfasd');
INSERT INTO `karya_ilmiah_dosen` VALUES ('3', 'D0001', 'judul ketiga', '2019-02-02', 'publikasdfsad');
INSERT INTO `karya_ilmiah_dosen` VALUES ('4', 'D0002', 'asdf', '2019-02-20', 'ubbbb');

-- ----------------------------
-- Table structure for lampiran_pi
-- ----------------------------
DROP TABLE IF EXISTS `lampiran_pi`;
CREATE TABLE `lampiran_pi` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `transkip` varchar(100) DEFAULT NULL,
  `krs` varchar(100) DEFAULT NULL,
  `proposal_pi` varchar(100) DEFAULT NULL,
  `khs1` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(50) DEFAULT NULL,
  `nim` char(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `khs2` varchar(100) DEFAULT NULL,
  `khs3` varchar(100) DEFAULT NULL,
  `khs4` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`,`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of lampiran_pi
-- ----------------------------
INSERT INTO `lampiran_pi` VALUES ('12', 'Ganjil20172018.xlsx', 'Genap20172018.xlsx', 'monev genap 2016-2017.xlsx', 'monev ganjil 2014-2015.xlsx', '2019-01-05 06:10:00', '2283142456', '2283142456', '1', 'monev ganjil 2014-2015.xlsx', 'Ganjil20172018.xlsx', 'Ganjil 20152016.xlsx');
INSERT INTO `lampiran_pi` VALUES ('13', 'Ganjil 20152016.xlsx', 'Genap20152016.xlsx', 'Ganjil20172018.xlsx', 'monev ganjil 2014-2015.xlsx', '2019-01-05 06:15:00', '2283142069', '2283142069', '1', 'monev genap 2016-2017.xlsx', 'monev genap 2016-2017.xlsx', 'monev ganjil 2016-2017.xlsx');
INSERT INTO `lampiran_pi` VALUES ('14', 'activity.png', 'activity2.png', 'kerupuk.png', 'activity4.png', '2019-01-16 15:14:00', 'admin', '2283142069', '1', 'Package1.png', 'Package1.png', 'rancangan.png');
INSERT INTO `lampiran_pi` VALUES ('15', 'activity.png', 'activity5.png', 'activity2.png', 'activity7.png', '2019-01-17 14:53:00', '2283180013', '2283180013', '1', 'Package1.png', 'activity4.png', 'activity3.png');
INSERT INTO `lampiran_pi` VALUES ('19', 'Package1.png', 'RPL_1221161016_Bani_Husni.docx', 'activity4.png', 'activity5.png', '2019-01-17 15:19:00', '2283180013', '2283180013', '1', 'activity3.png', 'user.png', 'activity7.png');
INSERT INTO `lampiran_pi` VALUES ('26', 'CAMAT SERANG.txt', 'activity1.png', 'sumber jurnal SKIRPSI.docx', 'normalisasi.docx', '2019-01-31 15:52:00', '2283180009', '2283180009', '1', 'sequence_mvc2.png', 'use_case_rancangan.png', 'Algoritma.docx');
INSERT INTO `lampiran_pi` VALUES ('28', 'CAMAT SERANG.txt', 'activity1.png', 'sumber jurnal SKIRPSI.docx', 'normalisasi.docx', '2019-01-31 15:52:00', '2283180009', '2283180009', '0', 'sequence_mvc2.png', 'use_case_rancangan.png', 'Algoritma.docx');

-- ----------------------------
-- Table structure for lampiran_seminar
-- ----------------------------
DROP TABLE IF EXISTS `lampiran_seminar`;
CREATE TABLE `lampiran_seminar` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `pendaftaran_seminar` varchar(100) DEFAULT NULL,
  `bukti_serah_terima` varchar(100) DEFAULT NULL,
  `kartu_bimbingan` varchar(100) DEFAULT NULL,
  `laporan_pengajuan` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(50) DEFAULT NULL,
  `id_proposal` char(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_proposal`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lampiran_seminar
-- ----------------------------
INSERT INTO `lampiran_seminar` VALUES ('5', 'rangkuman jurnal.docx', 'tugas 21 11 2018.docx', 'JADWAL KEGIATAN DIKLAT paskibra.docx', '1. Namida no Se.doc', '2018-12-27 14:11:00', '2283142069', 'PP003', '1');
INSERT INTO `lampiran_seminar` VALUES ('7', 'admin.php', 'agenda_surat_keluar.php', 'cetak_disposisi.php', 'cetak_disposisi.php', '2019-01-05 04:35:00', 'admin', 'PP001', '1');
INSERT INTO `lampiran_seminar` VALUES ('8', 'tugas 21 11 2018.docx', 'surat rt.docx', 'LEMBAR PERNYATAAN PERSETUJUAN pi.docx', 'surat rt.docx', '2019-01-05 05:41:00', '2283142456', 'PP002', '1');
INSERT INTO `lampiran_seminar` VALUES ('9', 'admin.php', 'agenda_surat_masuk.php', 'cetak_disposisi.php', 'dosen.php', '2019-01-10 14:36:00', 'admin', 'PP001', '1');
INSERT INTO `lampiran_seminar` VALUES ('10', 'activity3.png', 'activity4.png', 'Package1.png', 'activity.png', '2019-01-16 15:20:00', 'admin', '', '0');
INSERT INTO `lampiran_seminar` VALUES ('11', 'KPI Hari Januari  2019 (9).xlsx', 'KPI Hari Januari  2019 (8).xlsx', 'KPI Monitoring Rovvi Januari 2019 (8).xlsx', 'UNIT CDD DI POOL BCS 3 JANUARI 2019.xlsx', '2019-01-17 13:15:00', '', '7', '0');
INSERT INTO `lampiran_seminar` VALUES ('12', 'activity5.png', 'activity.png', 'Package1.png', 'activity3.png', '2019-01-17 13:50:00', '2283180013', 'PP006', '1');
INSERT INTO `lampiran_seminar` VALUES ('13', 'custom.min.css', 'custom.css', 'calendar.html', 'index.php', '2019-01-29 15:00:00', 'admin', 'PP001', '0');

-- ----------------------------
-- Table structure for lampiran_seminar_hasil
-- ----------------------------
DROP TABLE IF EXISTS `lampiran_seminar_hasil`;
CREATE TABLE `lampiran_seminar_hasil` (
  `id_ph` int(5) NOT NULL AUTO_INCREMENT,
  `pendaftaran_seminar` varchar(100) DEFAULT NULL,
  `bukti_serah_terima` varchar(100) DEFAULT NULL,
  `kartu_bimbingan` varchar(100) DEFAULT NULL,
  `lembar_pernyataan` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(50) DEFAULT NULL,
  `id_proposal` char(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `surat_pernyataan` varchar(255) DEFAULT NULL,
  `krs` varchar(255) DEFAULT NULL,
  `transkip_nilai` varchar(255) DEFAULT NULL,
  `form_ba` varchar(255) DEFAULT NULL,
  `form_nilai` varchar(255) DEFAULT NULL,
  `naskah_proposal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ph`,`id_proposal`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lampiran_seminar_hasil
-- ----------------------------
INSERT INTO `lampiran_seminar_hasil` VALUES ('1', 'agenda_surat_masuk.php', 'dokumen.php', 'edit_disposisi.php', 'edit_jadwal.php', '2019-01-10 14:39:00', 'admin', 'PP002', '1', null, null, null, null, null, null);
INSERT INTO `lampiran_seminar_hasil` VALUES ('2', 'edit_disposisi.php', 'hapus_jadwal.php', 'setuju_upload_lampiran.php', 'tambah_klasifikasi.php', '2019-01-10 14:55:00', 'admin', 'PP005', '1', null, null, null, null, null, null);
INSERT INTO `lampiran_seminar_hasil` VALUES ('3', 'activity5.png', 'activity.png', 'activity7.png', 'activity2.png', '2019-01-17 14:00:00', '2283180013', 'PP006', '1', null, null, null, null, null, null);
INSERT INTO `lampiran_seminar_hasil` VALUES ('4', 'Algoritma.docx', 'activity2.png', 'sequence_mvc.png', 'sumber jurnal SKIRPSI.docx', '2019-02-05 13:17:00', 'admin', 'PP003', '1', null, null, null, null, null, null);
INSERT INTO `lampiran_seminar_hasil` VALUES ('6', 'doc.pdf', 'doc_3.pdf', 'doc_9.pdf', 'dokument.pdf', '2019-02-07 16:13:00', 'admin', 'PP006', '0', 'doc_6.pdf', 'doc_8.pdf', 'doc_6.pdf', 'doc_2.pdf', 'tes_report.pdf', 'report_data_joymanual.pdf');

-- ----------------------------
-- Table structure for mahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id_mahasiswa` char(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` char(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id_mahasiswa`,`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mahasiswa
-- ----------------------------
INSERT INTO `mahasiswa` VALUES ('M0006', 'ARIP PURWANTO', '2283141888', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0007', 'VAKA GUSTIONO', '2283142011', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0008', 'DANIEL PT SIREGAR', '2283142018', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0009', 'ANGGA DWI MAULANA', '2283142069', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0010', 'BAYU SOFIAN JUNIAR', '2283142088', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0011', 'SENO INDRIYANTO', '2283142125', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0012', 'MUHAMMAD RIFALDI', '2283142137', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0013', 'SUDIRMAN', '2283142160', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0014', 'IQBAL SULAEMAN', '2283142172', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0015', 'MAMAN HIDAYATURROHMAN', '2283142250', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0016', 'DWIYANSYAH INDRAWAN', '2283142304', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0017', 'DJEJEN NAHROWI', '2283142356', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0018', 'SITI AFRIDAH', '2283142366', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0019', 'VRISKA RACHMANDITA', '2283142369', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0020', 'LELY YULIAWATI', '2283142437', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0021', 'FERA PUSPITA SARI', '2283142443', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0022', 'HINDRA PRANDANA', '2283142452', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0023', 'SYIFA AFRIANTI', '2283142456', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0024', 'RETNO NINGRUM', '2283142461', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0025', 'SITI NURHIDAYAH', '2283142467', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0026', 'MAHARANI DITAMY', '2283142478', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0027', 'ANDIKA WISNU PRASETIAWAN', '2283142502', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0028', 'NOVI NOVIYANTI', '2283142509', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0029', 'ALVIEDAR PRASETYO', '2283142514', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0030', 'PRASTIKA NINDI ANA', '2283142532', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0031', 'WIDI DWIYANTO', '2283142564', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0032', 'TARKUL HAMMI', '2283142596', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0033', 'INDIRA ELSA APRISTIA', '2283142605', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0034', 'MICHAEL MARKUS', '2283142644', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0035', 'TITO SETYAWAN', '2283142647', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0036', 'ANNA SAFITRI', '2283142681', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0037', 'DERI KUSUMA', '2283142684', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0038', 'DEASY FAJRIANI PUTRI', '2283142695', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0039', 'IQBAL HABIBI', '2283142700', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0040', 'FAHRIZAL TUJUNG KRESNAD', '2283142723', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0041', 'MAS AGUNG MAULANA', '2283142749', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0042', 'GILANG PERDANA', '2283142751', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0043', 'MUHAMMAD BADRUZZAMAN', '2283142907', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0044', 'SIFA LARASWATI', '2283143223', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0045', 'SITI MUTIA ANDINI', '2283143240', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0046', 'MUNIYATURROHAT', '2283150002', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0047', 'MAULANA ALI USMAN', '2283150003', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0048', 'MUHAMAD NURUL', '2283150004', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0049', 'DANAN AHLAN FAUZAN', '2283150005', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0050', 'KUKUH SEPTIYANTO', '2283150006', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0051', 'ILHAM NOVIAN PRATAMA', '2283150007', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0052', 'ADE PRASETYO', '2283150008', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0053', 'BUDI SANTOSA', '2283150009', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0054', 'REZA PRATAMA', '2283150010', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0055', 'JOHAN WHISNU ADJI', '2283150011', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0056', 'ANITA KURNIAWATI HARTINA', '2283150012', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0057', 'BAGUS DODY PRASETYO', '2283150013', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0058', 'WILDAN ARIEF FIRMANSYAH', '2283150016', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0059', 'DADEN AWALUDIN', '2283150017', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0060', 'NANA SUPRIYANA', '2283150018', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0061', 'CHRIST RAYNOLD HUTABARAT', '2283150019', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0062', 'SEKAR VIVI RAHAYU', '2283150021', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0063', 'IRVAN AKRAM', '2283150022', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0064', 'FIRZA FADLULLAH ASMAN', '2283150023', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0065', 'HARIYANTO', '2283150024', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0066', 'SARAH DIBA FAJRIANTI', '2283150025', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0067', 'RIAN PRATAMA', '2283150026', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0068', 'DWI SUPRIHATIN', '2283150027', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0069', 'RINI ANGGRAINI', '2283150028', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0070', 'MUHAMMAD AMIR BAIHAQI', '2283150029', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0071', 'TRY ARDILA VIRGIANI', '2283160001', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0072', 'DIKY SETIAWAN', '2283160002', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0073', 'SAEFUL ISLAM', '2283160003', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0074', 'APRIAWAN MUPARIDY', '2283160004', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0075', 'BACHTIAR PRATAMA', '2283160005', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0076', 'MUHAMMAD GYMNASTIAR FARHAN', '2283160006', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0077', 'ANGGITA RANI ASHARI', '2283160007', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0078', 'AGUS SALIM', '2283160008', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0079', 'YOHANES ALDI PRAPASKAH', '2283160009', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0080', 'RENDI FERDIANYSAH IGEFAR', '2283160010', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0081', 'HAJIJI', '2283160012', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0082', 'OKKY SUDIRMAN', '2283160013', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0083', 'ROSADI', '2283160014', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0084', 'FIKRY FAUZI', '2283160015', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0085', 'RYAN ILHAM PERMANA', '2283160016', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0086', 'MUHAMAD AVICENA HIBAN BANAL HAQ', '2283160017', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0087', 'ILLHAM RIDHOPERMANA', '2283160018', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0088', 'SISKA RIZKI ABILAILA', '2283160019', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0089', 'ENDANG SUHARTANTI', '2283160020', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0090', 'NIDA FATTAHUN NISA', '2283160022', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0091', 'DANI APRIANA', '2283160023', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0092', 'BAYU AJI KUNCORO', '2283160024', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0093', 'TRIDO HARDANI PUTRA', '2283160025', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0094', 'NADIYAH KHOIRUNNISA', '2283160026', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0095', 'WIDHI DWI NUGROHO', '2283160027', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0096', 'Dimas Aditama', '2283170001', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0097', 'Muhammad Khairul Imam', '2283170002', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0098', 'Intan Lestari', '2283170004', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0099', 'Asti Putri Iswari', '2283170005', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0100', 'Fikri Firmansyah', '2283170006', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0101', 'Sintiani Perdani', '2283170008', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0102', 'Reza Prasetya Putra', '2283170009', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0103', 'Rudi Hardiansyah', '2283170010', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0104', 'Dhea Riana Putri', '2283170011', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0105', 'Fitria Wahyu Ningsih', '2283170012', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0106', 'Doni Oktaviana', '2283170013', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0107', 'Triani Wahyuningsih', '2283170014', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0108', 'Faisal Hidayat', '2283170015', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0109', 'Syafrizal Arif Rahman', '2283170016', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0110', 'Eka Revadiaz', '2283170017', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0111', 'Yolandha Saviraningsih', '2283170018', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0112', 'Destia Umihanni Anggraeni', '2283170019', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0113', 'Juliarni Clarisa Dewi Rajagukguk', '2283170020', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0114', 'Syahrir', '2283170021', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0115', 'Anand Fikri', '2283170022', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0116', 'Rizal Amri', '2283170023', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0117', 'Asih Setio Wati', '2283170024', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0118', 'Arman Syaefulloh', '2283170025', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0119', 'Jihad Rahmat', '2283170026', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0120', 'Roga Dinar Prabustya', '2283170027', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0121', 'Dannisa Deza Azkia', '2283170028', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0122', 'Mokh. Sidqi Fahmi', '2283170029', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0123', 'Devi Pertiwi', '2283170030', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0124', 'Leogi', '2283170031', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0125', 'Mochamad Asep Soedarma', '2283170032', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0126', 'Mohammad Septiyan Dika', '2283170033', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0127', 'Hanif Urfa Sakinah', '2283180001', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0128', 'Syamsu Ridho', '2283180002', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0129', 'Ahmad Denny Listiyawan', '2283180003', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0130', 'Muhammad Rizki Aris Hakim', '2283180004', null, null, '0');
INSERT INTO `mahasiswa` VALUES ('M0131', 'Hana Prima Zakiyya', '2283180005', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0132', 'Amar Jatnika', '2283180006', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0133', 'Koko Yusuf Ardiansyah', '2283180007', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0134', 'Nidaur Rahmah', '2283180008', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0135', 'Zico Juniar Adi Prasetia', '2283180009', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0136', 'Nahda Khoirunnisa', '2283180010', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0137', 'Lilis Noviawati', '2283180011', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0138', 'Dahliya Sulastri', '2283180012', null, null, '1');
INSERT INTO `mahasiswa` VALUES ('M0139', 'Moh. Adji Firdaus', '2283180013', 'adji@fidaus', '98080980', '1');

-- ----------------------------
-- Table structure for pengajuan_hasil_seminar_skripsi
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_hasil_seminar_skripsi`;
CREATE TABLE `pengajuan_hasil_seminar_skripsi` (
  `id_ph` char(5) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `id_pembimbing1` varchar(50) DEFAULT NULL,
  `id_pembimbing2` varchar(50) DEFAULT NULL,
  `judul_proposal` varchar(100) DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  PRIMARY KEY (`id_ph`,`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pengajuan_hasil_seminar_skripsi
-- ----------------------------
INSERT INTO `pengajuan_hasil_seminar_skripsi` VALUES ('PS001', '2283142456', '08568988899', 'D0001', 'D0007', '44tes', '0');
INSERT INTO `pengajuan_hasil_seminar_skripsi` VALUES ('PS002', '2283142088', '34343', 'D0001', 'D0004', 'aa', '0');
INSERT INTO `pengajuan_hasil_seminar_skripsi` VALUES ('PS003', '2283142088', '08568988899', 'D0001', 'D0003', 'eeresa', '0');
INSERT INTO `pengajuan_hasil_seminar_skripsi` VALUES ('PS004', '2283142069', '7777777777', 'D0001', 'D0004', 'anu tes', '0');

-- ----------------------------
-- Table structure for pengajuan_proposal_skripsi
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_proposal_skripsi`;
CREATE TABLE `pengajuan_proposal_skripsi` (
  `id` char(5) NOT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `id_pembimbing1` varchar(50) DEFAULT NULL,
  `id_pembimbing2` varchar(50) DEFAULT NULL,
  `judul_1` varchar(100) DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  `judul_2` varchar(255) DEFAULT NULL,
  `judul_3` varchar(255) DEFAULT NULL,
  `pilih_judul` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pengajuan_proposal_skripsi
-- ----------------------------
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP001', '2283141888', 'D0001', 'D0003', 'aaa', '1', 'ZZZZ', 'SSSS', 'ZZZZ');
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP002', '2283142456', 'D0001', 'D0005', 'PENGEMBANGAN MEDIA PEMBELAJARAN', '1', 'PENGEMBANGAN SISTEM INFORMASI', 'PERBANDINGAN MODEL PEMBELAJARAN', 'PENGEMBANGAN SISTEM INFORMASI');
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP003', '2283142069', 'D0002', 'D0003', 'i want you', '1', 'i need you', 'i love you', 'i need you');
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP004', '2283142437', 'D0001', 'D0004', 'hgfgjgdf', '1', 'hghgkhftf', 'ghjgfyt', 'hghgkhftf');
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP005', '2283142088', 'D0002', 'D0007', 'kjh;u', '1', 'kj;l', 'kjkgyf', 'kjkgyf');
INSERT INTO `pengajuan_proposal_skripsi` VALUES ('PP006', '2283180013', 'D0001', 'D0003', 'hshshhs', '1', 'ajajj', 'slsls', 'slsls');

-- ----------------------------
-- Table structure for pengajuan_seminar_skripsi
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_seminar_skripsi`;
CREATE TABLE `pengajuan_seminar_skripsi` (
  `id` char(5) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `id_pembimbing1` varchar(50) DEFAULT NULL,
  `id_pembimbing2` varchar(50) DEFAULT NULL,
  `judul_proposal` varchar(100) DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`,`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pengajuan_seminar_skripsi
-- ----------------------------
INSERT INTO `pengajuan_seminar_skripsi` VALUES ('PS001', '2283142456', '7335383993', 'D0001', 'D0005', 'pengembangan sistem informasi c', '0');
INSERT INTO `pengajuan_seminar_skripsi` VALUES ('PS002', '2283142069', '679876544', 'D0002', 'D0003', 'pemeliharaan\r\n', '0');
INSERT INTO `pengajuan_seminar_skripsi` VALUES ('PS003', '2283180013', '088988779879', 'D0001', 'D0003', 'judul', '0');

-- ----------------------------
-- Table structure for perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan` (
  `id_perusahaan` char(5) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_perusahaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perusahaan
-- ----------------------------
INSERT INTO `perusahaan` VALUES ('P0001', 'PT INDAH KIAT PULP & PAPER', 'Jl. Raya Serang Km. 76, Kragilan, Serang, Banten Indonesia 42184', '(+62 254) 28', 'cs_iks@app.co.id', 'www.ikserang.com');
INSERT INTO `perusahaan` VALUES ('P0002', 'PT Archroma Indonesia Cilegon', 'Jl Kp Tegal Malang No.69, Warnasari, Citangkil, Kota Cilegon, Banten 42443', null, null, 'www.archroma.com');
INSERT INTO `perusahaan` VALUES ('P0003', 'PT Mayora Indah Tbk. Jatake Tangerang', 'Jl. Telesonic, Jatake, Pasir Jaya, Jatiuwung, Kota Tangerang, Banten 15135', '(021) 565 53', 'hrd.recruitment@mayora.co.id  ', 'www.mayoraindah.co.id');
INSERT INTO `perusahaan` VALUES ('P0004', 'PLTU Suralaya', 'Jl. Raya Merak, Suralaya, Pulomerak, Cligeon, Banten 42439', '(62-254) 570', null, 'www.indonesiapower.co.id');
INSERT INTO `perusahaan` VALUES ('P0005', 'PT Krakatau Daya Listrik', 'Jl. Amerika I, Kawasan Industri Krakatau Cilegon 43443 - Banten - Indonesia', '+62 (254) 31', 'info@kdl.co.id', 'www.kdl.co.id');
INSERT INTO `perusahaan` VALUES ('P0006', 'PT PLN Persero (Area Banten Utara, Kota bekasi, Ci', 'Jl. Pangeran Diponegoro No.2, Kotabaru, Kec. Serang, Kota Serang, Banten 42112', '(0254) 20071', 'pln123@pln.co.id', 'www.pln.co.id');
INSERT INTO `perusahaan` VALUES ('P0007', 'PT. Indonesia Power (UJP Banten 3 Lontar, Suralaya', 'Gedung Ex. Pengembangan Usaha Komplek PLTU Suralaya PO. Box. 15 Cilegon, Merak Banten', '(62-254) 570', null, 'www.indonesiapower.co.id');
INSERT INTO `perusahaan` VALUES ('P0008', 'PT Latinusa Tbk', 'Jalan Australia I Kav. E1 Kawasan Industri KIEC Cilegon, Banten 42443', '(62-254) 392', 'info@latinusa.co.id / sekper@latinusa.co.id', 'www.latinusa.co.id');
INSERT INTO `perusahaan` VALUES ('P0009', 'PT Elnusa Tbk', 'Graha Elnusa, 16th Floor Jl. TB Simatupang Kav. 1 B Jakarta 12560 Indonesia', '62-21 7883 0', 'corporate[at]elnusa.co.id', 'www.elnusa.co.id');
INSERT INTO `perusahaan` VALUES ('P0010', 'PT Angkasa Pura II ', 'PT Angkasa Pura II (Persero) Soekarno-Hatta International Airport', '138', 'contact.center@angkasapura2.co.id', 'www.angkasapura2.co.id');
INSERT INTO `perusahaan` VALUES ('P0011', 'RSUD Dr. Ajidarmo Rangkasbitung', 'Jl. Iko Jatmiko No. 1 Rangkasbitung Lebak – Banten', '(0252) 52835', null, 'rsud-adjidarmo.id');
INSERT INTO `perusahaan` VALUES ('P0012', 'PT Angels Products Sugar Refinery', 'Jl. Raya Bojonegara KM. 7 Desa Bojonegara Kabupaten Serang, Banten 42454', '0254 - 57506', 'info@ap.co.id', 'www.ap.co.id');
INSERT INTO `perusahaan` VALUES ('P0013', 'PT Waskita Beton Precast Palembang', 'Jl. Soekarno Hatta No 98, Talang Klp., Ilir Bar. I, Kota Palembang, Sumatera Selatan 30153', '(0711) 56115', 'info@waskitaprecast.co.id', 'web.waskitaprecast.co.id');
INSERT INTO `perusahaan` VALUES ('P0014', 'PT Prawita Karya', 'Komp. Ruko Graha Mas Pemuda Blok AC 17-18 Jl.Pemuda, Rawamangun Jakarta Timur 13220, Indonesia', '6221-471-529', 'sales@prawitakarya.com, info@prawitakarya.com', 'www.prawitakarya.com');
INSERT INTO `perusahaan` VALUES ('P0015', 'PT Grand Pintalan Textile Industries', 'Jln Raya Serang Km 71, Desa Kibin Cikande. Serang ', '(0254) 40125', null, 'www.argomanunggalgroup.com');
INSERT INTO `perusahaan` VALUES ('P0016', 'PT Trinseo Materials Indonesia', ' KM 117,5, Jl. Raya Merak, Gerem, Grogol, Cilegon City, Banten 42438', null, null, 'www.trinseo.com');
INSERT INTO `perusahaan` VALUES ('P0017', 'PT Charoen Pokphand Indonesia Tbk', 'Jl. Ancol VIII/1 Jakarta 14430 Indonesia', '021-6919999', 'investor.relations@cp.co.id', 'www.cp.co.id');
INSERT INTO `perusahaan` VALUES ('P0018', 'PT LOTTE Chemical Titan Nusantara', 'Jl. Raya Merak Km. 116, Desa Rawa Arum, Pulomerak, Gerem, Cilegon, Kota Cilegon, Banten 42436', '+62 254 5713', null, 'www.lottechem.co.id');
INSERT INTO `perusahaan` VALUES ('P0019', 'PT Telkom (Kandatel Rangkasbitung, Banten, Jakarta', 'Jl. Multatuli No.4 Rangkasbitung kabupaten lebak, 42314', '(0252) 20344', null, 'www.telkom.co.id');
INSERT INTO `perusahaan` VALUES ('P0020', 'PT Surya Citra Televisi (SCTV) ', 'SCTV Tower - Senayan City, Jl. Asia Afrika Lot 19, Jakarta 10270 ', '62-21-2793 5', null, 'www.sctv.co.id');
INSERT INTO `perusahaan` VALUES ('P0021', 'PT Sulfindo Adiusaha', 'Desa Mangunreja, Kecamatan Pulo Ampel Kabupaten Serang, Banten', '62-254-57500', null, 'www.sulfindo.com');
INSERT INTO `perusahaan` VALUES ('P0022', 'PT NTT Indonesia', 'Wisma 46 - Kota BNI 5th Floor Jl. Jend. Sudirman Kav. 1 Jakarta Pusat 10220, Indonesia', '62-21-572-77', null, 'www.id.ntt.com');
INSERT INTO `perusahaan` VALUES ('P0023', 'Unit Penyelenggara Bandar Udara (UPBU) Radin Inten', 'Tromol Pos No. 1 TANJUNG  KARANG Airport 35022', '( 0721 ) 769', null, 'www.radinintenairport.id');
INSERT INTO `perusahaan` VALUES ('P0024', 'PT Cilegon Fabricators', 'Jl. Puloampel, Argawana, Puloampel, Serang, Banten 42454', '(0254) 57500', 'ptcf@cilegonfab.co.id', 'www.cilegonfab.co.id');
INSERT INTO `perusahaan` VALUES ('P0025', 'PT Trafoindo Prima Perkasa', 'Jalan Hayam Wuruk 4 No. FX Jakarta Pusat 10120 – Indonesia', ' +62 21 3850', 'trafo@trafoindonesia.com', ' www.trafoindonesia.com');
INSERT INTO `perusahaan` VALUES ('P0026', 'PT Chandra Asri Petrochemical Tbk', 'Jl. Raya Anyer Km.123 Ciwandan, Cilegon, Banten 42447, Indonesia', '(62-254) 601', null, 'www.chandra-asri.com');
INSERT INTO `perusahaan` VALUES ('P0027', 'PT I.T.U Airconco cikupa tangerang', 'Jl Raya Serang KM 12 Cikupa Tangera, Kota  tangerang banten', '+62 21 59607', 'service@ituaircon.co.id', 'www.ituaircon.web.indotrading.com');

-- ----------------------------
-- Table structure for praktek_industri
-- ----------------------------
DROP TABLE IF EXISTS `praktek_industri`;
CREATE TABLE `praktek_industri` (
  `id_pi` char(5) NOT NULL,
  `nim` char(10) DEFAULT NULL,
  `nip` char(17) DEFAULT NULL,
  `judul_laporan` varchar(50) DEFAULT NULL,
  `tgl_pengajuan_pi` date DEFAULT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_perusahaan` char(5) DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  PRIMARY KEY (`id_pi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of praktek_industri
-- ----------------------------
INSERT INTO `praktek_industri` VALUES ('PI001', '2283142456', 'D0001', 'tes judul', '2019-01-05', '2019-01-10', 'P0001', '1');
INSERT INTO `praktek_industri` VALUES ('PI002', '2283142069', '-Pilih-', 'treyw', '2019-01-01', '2019-01-05', 'P0001', '1');
INSERT INTO `praktek_industri` VALUES ('PI003', '2283180013', 'D0002', 'judul editan', '2019-01-18', '2019-01-17', 'P0001', '1');

-- ----------------------------
-- Table structure for ruangan
-- ----------------------------
DROP TABLE IF EXISTS `ruangan`;
CREATE TABLE `ruangan` (
  `id_ruangan` char(5) NOT NULL,
  `nama_ruangan` varchar(30) NOT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ruangan
-- ----------------------------
INSERT INTO `ruangan` VALUES ('R0001', 'A01');
INSERT INTO `ruangan` VALUES ('R0002', 'A02');

-- ----------------------------
-- Table structure for seminar_praktek_industri
-- ----------------------------
DROP TABLE IF EXISTS `seminar_praktek_industri`;
CREATE TABLE `seminar_praktek_industri` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_pi` char(10) DEFAULT NULL,
  `nim` char(17) DEFAULT NULL,
  `laporan_pi` varchar(100) DEFAULT NULL,
  `jurnal_pi` varchar(100) DEFAULT NULL,
  `kartu_bimbingan` varchar(100) DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of seminar_praktek_industri
-- ----------------------------
INSERT INTO `seminar_praktek_industri` VALUES ('4', '', null, 'cat motor.txt', 'Pass_SAP_ABAP.txt', 'Untitled.png', '0');
INSERT INTO `seminar_praktek_industri` VALUES ('6', 'PI003', null, 'format pengetikan.png', 'RPL_1221161016_Bani_Husni.docx', 'vgroup.xml', '0');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '1');
INSERT INTO `tbl_user` VALUES ('15', '111113', 'f6be2ff0d88a9434a04a79c0e1a28066', 'Zafa', '111113', '4');
INSERT INTO `tbl_user` VALUES ('16', '2224343565', '1ef0b70af062e8f21ca5d5e7ab28cec0', 'doni', '2224343565', '4');
INSERT INTO `tbl_user` VALUES ('17', '2283142456', '610453e0ea66ce6b92ea7119b2b11ef7', 'syifa afrianti', '2283142456', '4');
INSERT INTO `tbl_user` VALUES ('21', '201808032162', 'addd54bdfdb0e8e5aa6324eacdc95504', 'Ilham', '201808032162', '1');
INSERT INTO `tbl_user` VALUES ('22', '0428058201', '65850c96a687a6b6f742e86dbe79e92e', 'Desmira. MT', '0428058201', '3');
INSERT INTO `tbl_user` VALUES ('23', '0005038606', '9daf89f927915f629f2f39ff56cccbe1', 'Ratna Eka Wati. Mpd', '0005038606', '3');
INSERT INTO `tbl_user` VALUES ('24', '2283142456', '610453e0ea66ce6b92ea7119b2b11ef7', 'SYIFA AFRIANTI', '2283142456', '4');
INSERT INTO `tbl_user` VALUES ('25', '2283180010', '1029790cd7a8c3eeaaded04f77e9f2a1', 'Nahda Khoirunnisa', '2283180010', '4');
INSERT INTO `tbl_user` VALUES ('26', '2283142069', 'e5e58fd787c91871a5b5395c1c7dedbe', 'ANGGA DWI MAULANA', '2283142069', '4');
INSERT INTO `tbl_user` VALUES ('27', '2283180013', '8a0be64c7db17267301c2cbcfed1baf1', 'Moh. Adji Firdaus', '2283180013', '4');
INSERT INTO `tbl_user` VALUES ('28', '2283180012', '018a0010f94c39a0293e2c5bfcaf678e', 'Dahliya Sulastri', '2283180012', '4');
INSERT INTO `tbl_user` VALUES ('29', '2283180011', 'd2366bf0cbd8bf18b32a784b9b3e08b3', 'Lilis Noviawati', '2283180011', '4');
INSERT INTO `tbl_user` VALUES ('30', '2283180009', 'e94451c32515b363e750d1be1f92f0a0', 'Zico Juniar Adi Prasetia', '2283180009', '4');
INSERT INTO `tbl_user` VALUES ('31', '2283180008', 'fa079bdaca89dfa35769b88efc0186b8', 'Nidaur Rahmah', '2283180008', '4');
INSERT INTO `tbl_user` VALUES ('32', '2283180007', 'a1eb0b09966e789a551eb71b09c92c64', 'Koko Yusuf Ardiansyah', '2283180007', '4');
INSERT INTO `tbl_user` VALUES ('33', '2283180006', '74abfe797e957bdb62a959bca5748c0a', 'Amar Jatnika', '2283180006', '4');
INSERT INTO `tbl_user` VALUES ('34', '2283180005', '38ce467ed9a03215e566495e9d1b6022', 'Hana Prima Zakiyya', '2283180005', '4');
INSERT INTO `tbl_user` VALUES ('35', '2283142437', '7583db0e15f76ba2b684377d978cb9d5', 'LELY YULIAWATI', '2283142437', '4');
INSERT INTO `tbl_user` VALUES ('36', '0005048904', 'a582b0712c210f4543017e1140308d1d', 'Mohammad Fatkhurrokhman, M.Pd', '0005048904', '1');
INSERT INTO `tbl_user` VALUES ('37', '19910312201803100', '99194aff9628c267a328dd540c2ab023', 'Mustofa Abi Hamid, M.Pd.T', '19910312201803100', '3');
INSERT INTO `tbl_user` VALUES ('38', '2283142088', '2f2ff5ca6d83ee37033c5552c9b1905b', 'BAYU SOFIAN JUNIAR', '2283142088', '4');
