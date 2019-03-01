/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50626
Source Host           : 127.0.0.1:3306
Source Database       : akademik_syifa

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2019-02-07 22:15:22
*/

SET FOREIGN_KEY_CHECKS=0;

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
