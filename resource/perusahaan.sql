/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50626
Source Host           : 127.0.0.1:3306
Source Database       : akademik_syifa

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2019-02-13 20:35:05
*/

SET FOREIGN_KEY_CHECKS=0;

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
