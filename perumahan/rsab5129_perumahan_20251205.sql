/*
 Navicat Premium Data Transfer

 Source Server         : HOSTING_ABUHANIFAH
 Source Server Type    : MySQL
 Source Server Version : 101114
 Source Host           : srv172.niagahoster.com:3306
 Source Schema         : rsab5129_perumahan

 Target Server Type    : MySQL
 Target Server Version : 101114
 File Encoding         : 65001

 Date: 05/12/2025 14:53:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `usernm` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jk` int(1) NULL DEFAULT NULL COMMENT '1 laki 2 perem',
  `pass` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `notelp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_gambar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `level` int(1) NULL DEFAULT 0 COMMENT '0 belum ada jabatan',
  `lokid` int(4) NULL DEFAULT NULL,
  `sts_app` int(1) NULL DEFAULT NULL,
  `upd_usr` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `upd_date` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, '555555', 'satgas', 'Petugas Lapangan', 'satgas@gmail.com', 2, '$2y$10$rEysEEiBXUCwiKHPt4brW.SWteXxII2941jW6n7egk7AdLGH/evaW', '', '2222', NULL, 2, 1, 1, '11', '20220615');
INSERT INTO `tbl_user` VALUES (2, '23232', 'admin', 'admin', 'admin@gmail.com', 2, '$2y$10$Qm0SznIcBEIj5Qgk83HF8u6fHJpHOfaqF.Yq3D1LQyoCp1kENwkzG', '1111', '4556', NULL, 1, 1, 1, '11', '20220615');
INSERT INTO `tbl_user` VALUES (3, '23232', 'owner', 'owner', 'owner@gmail.com', 2, '$2y$10$Qm0SznIcBEIj5Qgk83HF8u6fHJpHOfaqF.Yq3D1LQyoCp1kENwkzG', '1111', '4556', NULL, 3, 1, 1, '11', '20220615');

-- ----------------------------
-- Table structure for tm_harga_rumah
-- ----------------------------
DROP TABLE IF EXISTS `tm_harga_rumah`;
CREATE TABLE `tm_harga_rumah`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_perum` int(8) NULL DEFAULT NULL,
  `nama_perum` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_rumah` int(8) NULL DEFAULT NULL COMMENT 'id rumah',
  `norumah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_jns` int(8) NULL DEFAULT NULL COMMENT 'jenis harga yang terdapat di rumah tersesbut',
  `nama_harga` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal` decimal(15, 0) NULL DEFAULT NULL,
  `terbayar` decimal(15, 0) NULL DEFAULT 0,
  `last_upd` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` timestamp(0) NULL DEFAULT current_timestamp(),
  `update_at` timestamp(0) NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tm_jns_harga
-- ----------------------------
DROP TABLE IF EXISTS `tm_jns_harga`;
CREATE TABLE `tm_jns_harga`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tm_jns_harga
-- ----------------------------
INSERT INTO `tm_jns_harga` VALUES (1, 'BOKING ');
INSERT INTO `tm_jns_harga` VALUES (2, 'PELUNASAN');

-- ----------------------------
-- Table structure for tm_kategori_pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `tm_kategori_pengeluaran`;
CREATE TABLE `tm_kategori_pengeluaran`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `kateg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tm_perumahan
-- ----------------------------
DROP TABLE IF EXISTS `tm_perumahan`;
CREATE TABLE `tm_perumahan`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'nama perumahan',
  `desk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'keterangan, bisa berupa alamat, atau apapun tentang perumahan ini ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tm_perumahan
-- ----------------------------
INSERT INTO `tm_perumahan` VALUES (1, 'GREEN BINTANG BENTIRING 2', 'JL. PADAT KARYA RT/RW 007/002 KEL, BENTIRING KEC. MUARA BANGKAHULU KOTA BENGKULU');
INSERT INTO `tm_perumahan` VALUES (2, 'GRAND BINTANG BETUNGAN', 'JL TEKURUNG 4, KEL. BETUNGAN, KEC. SELEBAR KOTA BENGKULU');
INSERT INTO `tm_perumahan` VALUES (3, 'TARRA  PITAKNUTUS', 'Jln.  kol. Alamsyah gunung selan- Argamakmur KaB. Bengkulu Utara Pro. Bengkulu');
INSERT INTO `tm_perumahan` VALUES (4, 'CITA MARGA RESIDENCE', 'Alamat sukau Margo Kecamatan amen Kabupaten lebong');

-- ----------------------------
-- Table structure for tm_rumah
-- ----------------------------
DROP TABLE IF EXISTS `tm_rumah`;
CREATE TABLE `tm_rumah`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_perumahan` int(8) NOT NULL COMMENT 'id perumahan ',
  `norumah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_jual` decimal(15, 0) NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `mtd_jual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'cara jual: cash, kpr, kredit ke developer, cash bertahap',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_rumah`(`id_perumahan`, `norumah`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 180 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tm_rumah
-- ----------------------------
INSERT INTO `tm_rumah` VALUES (1, 1, 'A1', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (2, 1, 'A2', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (3, 1, 'A3', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (4, 1, 'A4', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (5, 1, 'A5', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (6, 1, 'A6', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (7, 1, 'A7', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (8, 1, 'A8', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (9, 1, 'A9', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (10, 1, 'A10', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (11, 1, 'B1', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (12, 1, 'B2', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (13, 1, 'B3', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (14, 1, 'B4', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (15, 2, 'A1', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (16, 1, 'B5', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (17, 1, 'B6', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (18, 1, 'B7', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (19, 1, 'B8', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (20, 1, 'B9', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (21, 2, 'A2', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (22, 2, 'A3', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (23, 2, 'A4', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (24, 1, 'C1', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (25, 2, 'A5', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (26, 1, 'C2', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (27, 1, 'C3', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (28, 2, 'A6', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (29, 1, 'C4', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (30, 2, 'A7', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (31, 1, 'C5', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (32, 1, 'C6', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (33, 2, 'A8', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (34, 2, 'A9', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (35, 2, 'A10', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (36, 1, 'C7', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (37, 2, 'A11', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (38, 1, 'C8', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (39, 2, 'A12', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (40, 1, 'C9', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (41, 1, 'C10', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (42, 2, 'A13', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (43, 2, 'A14', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (44, 1, 'C11', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (45, 2, 'A15', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (46, 1, 'C12', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (47, 1, 'C13', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (48, 2, 'B1', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (49, 1, 'C14', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (50, 1, 'C15', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (51, 2, 'B2', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (52, 1, 'C16', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (53, 2, 'B3', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (54, 1, 'C17', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (55, 2, 'B4', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (56, 1, 'C18', 166000000, '-RUMAH TYPE 36\r\n- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (57, 2, 'B5', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (58, 2, 'B6', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (59, 2, 'B7', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (60, 2, 'B8', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (61, 2, 'B9', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (62, 2, 'B10', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (63, 2, 'B11', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (64, 2, 'B12', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (65, 2, 'B13', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (66, 2, 'B14', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (67, 2, 'B15', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (68, 2, 'B16', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (69, 2, 'B17', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (70, 2, 'B18', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (71, 2, 'B19', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (72, 2, 'B20', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (73, 2, 'B21', 162000000, '- 2 KAMAR TIDUR\r\n- 1 KAMAR MANDI\r\n- 1 RUANG TAMU\r\n- CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (74, 1, 'D1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (75, 1, 'D2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (76, 1, 'D3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (77, 1, 'D4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (78, 1, 'D5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (79, 1, 'D6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (80, 1, 'D7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (81, 1, 'D8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (82, 1, 'D9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (83, 1, 'D10', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (84, 1, 'D11', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (85, 1, 'D12', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (86, 1, 'D13', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (87, 1, 'D14', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (88, 1, 'D15', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (89, 1, 'D16', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (90, 1, 'D17', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (91, 1, 'D18', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (92, 1, 'E1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (93, 1, 'E2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (94, 1, 'E3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (95, 1, 'E4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (96, 1, 'E5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (97, 1, 'E6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (98, 1, 'E7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (99, 1, 'E8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (100, 1, 'E9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (101, 1, 'E10', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (102, 1, 'E11', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (103, 1, 'E12', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (104, 1, 'E13', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (105, 1, 'E14', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (106, 1, 'E15', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (107, 1, 'E16', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (108, 1, 'E17', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (109, 1, 'E18', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (110, 1, 'E19', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (111, 1, 'E20', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (112, 1, 'E21', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (113, 1, 'E22', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (114, 1, 'E23', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (115, 1, 'E24', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (116, 1, 'F1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (117, 1, 'F2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (118, 1, 'F3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (119, 1, 'F4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (120, 1, 'F5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (121, 1, 'F6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (122, 1, 'F7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (123, 1, 'F8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (124, 1, 'F9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (125, 1, 'F10', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (126, 1, 'F11', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (127, 1, 'F12', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (128, 1, 'F13', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (129, 1, 'F14', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (130, 1, 'F15', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (131, 1, 'F16', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (132, 1, 'F17', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (133, 1, 'F18', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (134, 1, 'F19', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (135, 1, 'F20', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (136, 1, 'F21', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (137, 1, 'G1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (138, 1, 'G2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (139, 1, 'G3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (140, 1, 'G4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (141, 1, 'G5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (142, 1, 'G6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (143, 1, 'G7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (144, 1, 'G8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (145, 1, 'G9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (146, 1, 'G10', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (147, 1, 'G11', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (148, 1, 'G12', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (149, 1, 'G13', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (150, 1, 'G14', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (151, 1, 'H1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (152, 1, 'H2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (153, 1, 'H3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (154, 1, 'H4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (155, 1, 'H5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (156, 1, 'H6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (157, 1, 'H7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (158, 1, 'H8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (159, 1, 'H9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (160, 1, 'H10', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (161, 1, 'H11', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (162, 1, 'I1', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (163, 1, 'I2', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (164, 1, 'I3', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (165, 1, 'I4', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (166, 1, 'I5', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (167, 1, 'I6', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (168, 1, 'I7', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (169, 1, 'I8', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (170, 1, 'I9', 166000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (171, 2, 'B22', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (172, 2, 'B23', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (173, 2, 'B24', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (175, 2, 'B26', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (176, 2, 'B27', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (177, 2, 'B28', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (178, 2, 'B29', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);
INSERT INTO `tm_rumah` VALUES (179, 2, 'B25', 162000000, '-RUMAH TYPE 36\r\n - 2 KAMAR TIDUR\r\n - 1 KAMAR MANDI \r\n- 1 RUANG TAMU\r\n - CARPORT', NULL);

-- ----------------------------
-- Table structure for tm_rumah_20251124
-- ----------------------------
DROP TABLE IF EXISTS `tm_rumah_20251124`;
CREATE TABLE `tm_rumah_20251124`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_perumahan` int(8) NOT NULL COMMENT 'id perumahan ',
  `norumah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_jual` decimal(15, 0) NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `mtd_jual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'cara jual: cash, kpr, kredit ke developer, cash bertahap',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_rumah`(`id_perumahan`, `norumah`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for trx_penj_rumah
-- ----------------------------
DROP TABLE IF EXISTS `trx_penj_rumah`;
CREATE TABLE `trx_penj_rumah`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perum` int(8) NULL DEFAULT NULL,
  `nama_perum` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_rumah` int(8) NULL DEFAULT NULL,
  `norumah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_cust` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_ktp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `notelp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'yyyymmdd',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp(0) NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of trx_penj_rumah
-- ----------------------------
INSERT INTO `trx_penj_rumah` VALUES (1, 1, 'GREEN BINTANG BENTIRING 2', 1, 'A1', 'HARI KURNIAWAN', '-', '083167798994', 'jln. pasar kaget, kel. bentiring kota bengkulu', '20251202', 'RUMAH SUDAH READY', '2025-12-02 12:18:17', '2025-12-02 12:18:17');
INSERT INTO `trx_penj_rumah` VALUES (2, 1, 'GREEN BINTANG BENTIRING 2', 2, 'A2', 'REZA ELISA', '-', '085270598801', 'jln. padat karya rt/rw 007/002 kel. bentiring, kec. muara bangkahulu kota bengkulu', '20251202', 'RUMAH SUDAH READY', '2025-12-02 12:19:42', '2025-12-02 12:19:42');
INSERT INTO `trx_penj_rumah` VALUES (3, 1, 'GREEN BINTANG BENTIRING 2', 3, 'A3', 'SISKA', '-', '082373435200', 'jln. padat karya rt/rw 007/002 kel. bentiring, kec. muara bangkahulu kota bengkulu', '20251202', 'RUMAH SUDAH READY', '2025-12-02 12:21:45', '2025-12-02 12:21:45');
INSERT INTO `trx_penj_rumah` VALUES (4, 1, 'GREEN BINTANG BENTIRING 2', 4, 'A4', 'ENO', '-', '082179489742', 'jln. padat karya rt/rw 007/002 kel. bentiring, kec. muara bangkahulu kota bengkulu', '20251202', 'RUMAH SUDAH READY', '2025-12-02 12:22:25', '2025-12-02 12:22:25');

-- ----------------------------
-- Table structure for trx_penj_rumah_harga
-- ----------------------------
DROP TABLE IF EXISTS `trx_penj_rumah_harga`;
CREATE TABLE `trx_penj_rumah_harga`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_penj_rumah` int(8) NULL DEFAULT NULL COMMENT 'dari id tabel transaksi ',
  `id_jns` int(8) NULL DEFAULT NULL COMMENT 'jenis harga yang terdapat di rumah tersesbut',
  `nama_harga` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal` decimal(15, 0) NULL DEFAULT NULL,
  `terbayar` decimal(15, 0) NULL DEFAULT 0,
  `last_upd` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` timestamp(0) NULL DEFAULT current_timestamp(),
  `update_at` timestamp(0) NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of trx_penj_rumah_harga
-- ----------------------------
INSERT INTO `trx_penj_rumah_harga` VALUES (1, 1, 1, 'BOKING ', 1000000, 0, NULL, '2025-12-02 12:23:09', '2025-12-02 12:23:09');
INSERT INTO `trx_penj_rumah_harga` VALUES (2, 1, 2, 'PELUNASAN', 17000000, 0, NULL, '2025-12-02 12:24:09', '2025-12-02 12:24:09');

-- ----------------------------
-- Table structure for trx_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `trx_transaksi`;
CREATE TABLE `trx_transaksi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_transaksi` enum('masuk','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'keluar',
  `id_perum` int(8) NULL DEFAULT NULL,
  `nama_perum` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `peruntukan` enum('rumah','umum') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'umum',
  `id_rumah` int(8) NULL DEFAULT NULL,
  `norumah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kateg` int(8) NULL DEFAULT NULL,
  `nama_kateg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'yyyymmdd',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nominal` decimal(15, 0) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp(0) NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of trx_transaksi
-- ----------------------------
INSERT INTO `trx_transaksi` VALUES (1, 'masuk', 1, 'GREEN BINTANG BENTIRING 2', 'rumah', 1, 'A1', 1, 'BOKING ', '20251202', 'CASH', 17000000, '2025-12-02 12:24:40', '2025-12-02 12:24:40');

SET FOREIGN_KEY_CHECKS = 1;
