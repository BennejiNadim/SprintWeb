-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 21, 2020 at 11:45 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agora1`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choix` varchar(255) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`id`, `choix`, `contenu`) VALUES
(16, 'Contant', 'zzzzz'),
(5, 'Contant', 'nonnn bien'),
(6, 'Satisfait', 'salem'),
(12, 'Satisfait', 'good service');

-- --------------------------------------------------------

--
-- Table structure for table `carte_fidelite`
--

DROP TABLE IF EXISTS `carte_fidelite`;
CREATE TABLE IF NOT EXISTS `carte_fidelite` (
  `Id_CF` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` varchar(20) DEFAULT NULL,
  `nb_point` int(11) DEFAULT NULL,
  `date_debut` varchar(50) DEFAULT NULL,
  `date_fin` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_CF`),
  KEY `Id_user` (`Id_user`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carte_fidelite`
--

INSERT INTO `carte_fidelite` (`Id_CF`, `Id_user`, `nb_point`, `date_debut`, `date_fin`, `type`) VALUES
(145, 'null', 100, '2020/02/26', '2020/05/26', 'Silver'),
(153, 'null', 500, '2020/02/26', '2020/05/26', 'Silver'),
(148, 'null', 500, '2020/02/26', '2020/08/26', 'Gold'),
(149, 'null', 3333, '2020/02/26', '2020/05/26', 'Silver'),
(152, 'null', 1500, '2020/02/26', '2020/05/26', 'Silver'),
(155, 'null', 600, '2020/02/27', '2020/08/27', 'Gold'),
(157, '17', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_catg` int(11) NOT NULL AUTO_INCREMENT,
  `lib_catg` varchar(50) NOT NULL,
  PRIMARY KEY (`id_catg`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_catg`, `lib_catg`) VALUES
(7, 'produit electronic'),
(6, 'produit alimentaire'),
(8, 'produit informatique'),
(9, 'produit sanitaire');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(20) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `total` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=1067 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `id_user`, `date`, `total`) VALUES
(1039, '2', '2020-02-23 12:39:47', 1350000),
(1045, '', '2020-02-23 14:00:31', 2000),
(1046, '', '2020-02-23 14:02:01', 117),
(1047, 'guest', '2020-02-23 14:06:33', 1800),
(1048, 'guest', '2020-02-25 16:19:42', 1440000),
(1049, 'guest', '2020-02-26 21:29:00', 1440000),
(1050, 'guest', '2020-02-26 22:30:23', 101000),
(1051, 'guest', '2020-02-26 22:33:48', 5000),
(1052, 'guest', '2020-02-26 22:34:46', 1500000),
(1053, 'guest', '2020-02-26 22:36:20', 10000),
(1054, 'guest', '2020-02-26 22:36:42', 5000),
(1055, 'guest', '2020-02-27 08:18:04', 4000),
(1056, 'guest', '2020-02-27 08:37:12', 1000),
(1057, 'guest', '2020-02-27 08:37:51', 4000),
(1058, 'guest', '2020-02-27 08:38:44', 800000),
(1059, 'guest', '2020-02-27 08:39:18', 1600000),
(1060, 'guest', '2020-02-27 08:50:32', 2700000),
(1061, 'guest', '2020-02-27 08:52:30', 800000),
(1062, 'guest', '2020-02-27 08:54:10', 1500000),
(1063, 'guest', '2020-02-27 11:11:34', 1000),
(1064, 'guest', '2020-02-27 11:12:53', 1440000),
(1065, 'guest', '2020-02-27 11:51:27', 2790000),
(1066, 'guest', '2020-06-18 12:45:44', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFacturation` date NOT NULL,
  `etatFacture` enum('payed','not_payed') NOT NULL,
  `montant` decimal(20,3) NOT NULL,
  `ClientLogin` varchar(20) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `EmployeLogin` varchar(20) NOT NULL,
  `typeFacture` enum('vente_produit','achat_produit','vente_materiel','achat_materiel','taxe','salaire','in','out') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ClientLogin` (`ClientLogin`),
  KEY `EmployeLogin` (`EmployeLogin`),
  KEY `SupplierId` (`SupplierId`)
) ENGINE=MyISAM AUTO_INCREMENT=1829 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id`, `dateFacturation`, `etatFacture`, `montant`, `ClientLogin`, `SupplierId`, `EmployeLogin`, `typeFacture`) VALUES
(1828, '2020-06-19', 'payed', '0.000', '', 0, '', 'achat_materiel'),
(1827, '2020-06-19', 'payed', '25000000.000', 'null', 0, 'null', 'achat_materiel'),
(1813, '2020-06-19', 'payed', '2300.000', 'null', 0, 'null', 'achat_materiel'),
(1800, '2020-06-19', 'payed', '65000000.000', 'null', 0, 'null', 'achat_materiel'),
(1756, '2020-06-19', 'payed', '200000.000', 'null', 0, 'null', 'achat_materiel'),
(1715, '2020-06-19', 'payed', '230000.000', 'null', 0, 'null', 'achat_materiel'),
(1745, '2020-06-19', 'payed', '18000000.000', 'null', 0, 'null', 'achat_materiel'),
(1704, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'out'),
(1703, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'in'),
(1702, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'salaire'),
(1701, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'taxe'),
(1700, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'achat_materiel'),
(1699, '2020-06-18', 'payed', '1.000', 'wael3', 0, 'wael3', 'vente_materiel'),
(1698, '2020-06-18', 'not_payed', '1.000', 'wael3', 0, 'wael3', 'achat_produit'),
(1788, '2020-06-19', 'payed', '360000.000', 'null', 0, 'null', 'achat_materiel');

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(26, 'TTest', 'ttest', 'test1@admin.com', 'test1@admin.com', 1, 'hv1it0BHz8KZAfKsJ0AkwH3pgsiqDLzEaK3swsGNrMo', 'user{hv1it0BHz8KZAfKsJ0AkwH3pgsiqDLzEaK3swsGNrMo}', '2020-06-19 13:41:35', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(69, 'user123', 'user123', 'user1@gmail.com', 'user1@gmail.com', 1, NULL, 'user1', '2020-06-18 14:07:00', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(72, 'WAEL', 'WAEL', 'QSDQ', 'QSDQ', 1, NULL, 'sdf', NULL, NULL, NULL, 'a:0:{}'),
(79, 'Nuser', 'nuser', 'usernew@esprit.tn', 'usernew@esprit.tn', 1, 'NNk3voyI47OLcdgZ9gCFBPt7EloZokfXevw0MDCIni0', 'user{NNk3voyI47OLcdgZ9gCFBPt7EloZokfXevw0MDCIni0}', '2020-06-19 13:42:09', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}');

-- --------------------------------------------------------

--
-- Table structure for table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `numero` int(11) NOT NULL,
  `Email` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom`, `numero`, `Email`) VALUES
(2, 'delice', 75888999, 'delice@gmail.tn');

-- --------------------------------------------------------

--
-- Table structure for table `historiqueequipements`
--

DROP TABLE IF EXISTS `historiqueequipements`;
CREATE TABLE IF NOT EXISTS `historiqueequipements` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `operation` enum('achat','vente','corbeille','panne','maintenance','disponnible') NOT NULL,
  `equipement` enum('vehicule','materiels') NOT NULL,
  `qte` int(255) NOT NULL,
  `idm` int(255) NOT NULL,
  `idv` int(255) NOT NULL,
  `prix` float NOT NULL,
  `idf` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_m` (`idm`),
  KEY `id_v` (`idv`),
  KEY `id_f` (`idf`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `historiqueequipements`
--

INSERT INTO `historiqueequipements` (`id`, `date`, `operation`, `equipement`, `qte`, `idm`, `idv`, `prix`, `idf`) VALUES
(41, '2020-06-19', 'achat', 'materiels', 20, 12, 0, 2300, 1813),
(44, '2020-06-19', 'panne', 'materiels', 5, 13, 0, 0, 0),
(45, '2020-06-19', 'achat', 'vehicule', 100, 14, 0, 0, 1828),
(42, '2020-06-19', 'achat', 'vehicule', 1, 0, 24, 25000000, 1827),
(43, '2020-06-19', 'panne', 'vehicule', 1, 0, 23, 0, 0),
(39, '2020-06-19', 'achat', 'vehicule', 1, 0, 23, 65000000, 1800);

-- --------------------------------------------------------

--
-- Table structure for table `ligne_commande`
--

DROP TABLE IF EXISTS `ligne_commande`;
CREATE TABLE IF NOT EXISTS `ligne_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) DEFAULT NULL,
  `Id_commande` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `quantite`, `Id_commande`, `id_produit`) VALUES
(68, 2, 1039, 777),
(69, 1, 1040, 19),
(70, 3, 1041, 19),
(71, 3, 1042, 19),
(72, 1, 1043, 999),
(73, 1, 1044, 888),
(74, 1, 1044, 777),
(75, 1, 1045, 999),
(76, 1, 1046, 19),
(77, 1, 1047, 999),
(78, 4, 1048, 888),
(79, 3, 1049, 888),
(80, 5151, 1050, 666),
(81, 15, 1051, 666),
(82, 1, 1052, 777),
(83, 55, 1053, 666),
(84, 15, 1054, 666),
(85, 3, 1055, 999),
(86, 1, 1056, 666),
(87, 10, 1057, 666),
(88, 1, 1058, 888),
(89, 3, 1059, 888),
(90, 3, 1060, 777),
(91, 1, 1061, 888),
(92, 1, 1062, 777),
(93, 1, 1063, 666),
(94, 3, 1064, 888),
(95, 3, 1065, 888),
(96, 1, 1065, 777),
(97, 3, 1066, 666),
(98, 1, NULL, 123456682),
(99, 1, NULL, 123456682),
(100, 1, NULL, 123456682),
(101, 2, NULL, 666);

-- --------------------------------------------------------

--
-- Table structure for table `livraison`
--

DROP TABLE IF EXISTS `livraison`;
CREATE TABLE IF NOT EXISTS `livraison` (
  `Id_livraison` int(11) NOT NULL AUTO_INCREMENT,
  `etat` varchar(50) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `Id_commande` int(11) DEFAULT NULL,
  `trucking` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id_livraison`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `livraison`
--

INSERT INTO `livraison` (`Id_livraison`, `etat`, `total`, `Id_commande`, `trucking`) VALUES
(34, 'en traitement', 210.6, 1042, 'qdaqeVdJBnLS'),
(35, 'en traitement', 2000, 1043, '7tEJ5kVuPNLr'),
(36, 'envoyer', 800000, 1044, 'nepxVvQu8B4m'),
(39, 'en traitement', 1440000, 1049, 'rt4ZYJXqDUEI'),
(40, 'en traitement', 2700000, 1060, 'CgJGf7crO7uG'),
(41, 'en traitement', 800000, 1061, '8msAjTANIzSu'),
(42, 'en traitement', 1440000, 1064, '3gEsHLxyPoPF'),
(43, 'en traitement', 2790000, 1065, 'bHECTLupBMJi');

-- --------------------------------------------------------

--
-- Table structure for table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int(11) NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(50) NOT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom_marque`) VALUES
(2, 'apple'),
(1, 'sony'),
(3, 'warda'),
(4, 'nadhif'),
(8, 'Asus'),
(6, 'LG'),
(7, 'HP');

-- --------------------------------------------------------

--
-- Table structure for table `materiels`
--

DROP TABLE IF EXISTS `materiels`;
CREATE TABLE IF NOT EXISTS `materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `qte` int(255) NOT NULL,
  `etat` enum('disponnible','en_panne','vendu','en_maintenance','corbeille','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materiels`
--

INSERT INTO `materiels` (`id`, `nom`, `qte`, `etat`) VALUES
(13, 'Chariot', 5, 'en_panne'),
(14, 'Diable', 100, 'disponnible');

-- --------------------------------------------------------

--
-- Table structure for table `mouvementproduit`
--

DROP TABLE IF EXISTS `mouvementproduit`;
CREATE TABLE IF NOT EXISTS `mouvementproduit` (
  `id_mouvement_Produit` int(11) NOT NULL AUTO_INCREMENT,
  `id_facture` int(11) NOT NULL,
  `source` enum('supplier','stock','magasin','client') NOT NULL,
  `destination` enum('supplier','stock','magasin','client') NOT NULL,
  `quantite` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_produit` int(11) NOT NULL,
  PRIMARY KEY (`id_mouvement_Produit`),
  KEY `id_produit` (`id_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=9698 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mouvementproduit`
--

INSERT INTO `mouvementproduit` (`id_mouvement_Produit`, `id_facture`, `source`, `destination`, `quantite`, `date`, `id_produit`) VALUES
(12, 12, 'magasin', 'client', 20, '2020-01-29', 10),
(66, 99, 'supplier', 'stock', 60, '2020-01-30', 888),
(6, 7, 'magasin', 'stock', 61, '2020-01-28', 6),
(15, 56, 'magasin', 'supplier', 151, '2020-02-12', 51),
(55, 55, 'magasin', 'stock', 6, '2020-01-29', 12),
(9669, 132, 'magasin', 'client', 55, '2020-01-28', 19),
(9670, 455, 'magasin', 'client', 1, '2020-02-23', 19),
(9671, 456, 'magasin', 'client', 1, '2020-02-23', 999),
(9672, 457, 'magasin', 'client', 4, '2020-02-25', 888),
(9673, 598, 'magasin', 'client', 3, '2020-02-26', 888),
(9674, 0, 'stock', 'magasin', 60, '2020-01-29', 666),
(9675, 599, 'magasin', 'client', 5151, '2020-02-26', 666),
(9676, 600, 'magasin', 'client', 15, '2020-02-26', 666),
(9677, 618, 'magasin', 'client', 1, '2020-02-26', 777),
(9678, 637, 'magasin', 'client', 55, '2020-02-26', 666),
(9679, 657, 'magasin', 'client', 15, '2020-02-26', 666),
(9680, 728, 'magasin', 'client', 3, '2020-02-27', 999),
(9681, 780, 'magasin', 'client', 1, '2020-02-27', 666),
(9682, 808, 'magasin', 'client', 10, '2020-02-27', 666),
(9683, 837, 'magasin', 'client', 1, '2020-02-27', 888),
(9684, 867, 'magasin', 'client', 3, '2020-02-27', 888),
(9685, 868, 'magasin', 'client', 3, '2020-02-27', 777),
(9686, 900, 'magasin', 'client', 1, '2020-02-27', 888),
(9687, 901, 'magasin', 'client', 1, '2020-02-27', 777),
(9688, 1002, 'magasin', 'client', 1, '2020-02-27', 666),
(9689, 1039, 'magasin', 'client', 3, '2020-02-27', 888),
(9690, 0, 'stock', 'magasin', 401, '2020-02-04', 777),
(9691, 1418, 'magasin', 'client', 3, '2020-02-27', 888),
(9692, 1459, 'magasin', 'client', 1, '2020-02-27', 777),
(9693, 1501, 'magasin', 'client', 3, '2020-02-27', 888),
(9694, 1544, 'magasin', 'client', 1, '2020-02-27', 777),
(9695, 2, 'supplier', 'stock', 50, '2020-03-13', 777),
(9696, 2, 'supplier', 'stock', 50, '2020-03-05', 777),
(9697, 69996, 'stock', 'magasin', 50, '2015-01-01', 9789946);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ref_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(50) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `quantite_stock` int(11) NOT NULL,
  `quantite_magasin` int(11) NOT NULL,
  `prix_vente` float NOT NULL,
  `prix_achat` float NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`ref_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=123456689 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`ref_produit`, `nom_produit`, `marque`, `categorie`, `quantite_stock`, `quantite_magasin`, `prix_vente`, `prix_achat`, `image`, `updated`) VALUES
(777, 'iphone', 'apple', 'produit informatique', 199, 695, 2000000, 1200000, '97744-v1-apple-iphone-7-mobile-phone-large-1.jpg', 1),
(888, 'tv', 'sony', 'produit electronic', 500, 494, 800000, 500000, '50051313_536959.png', 1),
(123456682, 'pc hp', 'HP', 'produit informatique', 30, 10, 2000100, 1500000, 'pc-portable-hp-15-da0064nk-i3-7e-gen-4-go-windows-10-gris-sim-orange-offerte-30-go.jpg', 1),
(123456683, 'shampoo head and shoulders', 'head and shoulders', 'produit sanitaire', 150, 70, 3000, 2500, '2ba09fb7-3baf-4cc1-8296-f02a9c598829_1.4a4321622bf3496ba170c39709a932e1.jpg', 1),
(123456688, 'PC gaming Asus', 'HP', 'produit informatique', 30, 20, 2000, 1500, 'UTB8cBLrFGrFXKJk43Ovq6ybnpXaW.jpg_350x350.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedback` varchar(255) NOT NULL,
  `ratings` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `feedback`, `ratings`) VALUES
(11, 'bonne qualité ', 3),
(15, 'bon produit', 3),
(14, 'great product ', 3),
(13, 'pas mal', 1),
(12, 'bonne qualité', 3),
(10, 'nice product', 4);

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

DROP TABLE IF EXISTS `reclamation`;
CREATE TABLE IF NOT EXISTS `reclamation` (
  `id_rec` int(11) NOT NULL AUTO_INCREMENT,
  `nomuser` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_rec`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id_rec`, `nomuser`, `numero`, `date`, `image`) VALUES
(29, 'nadim', 21508830, '2020-02-27', 'Profile164269.jpg'),
(30, 'wael', 23456789, '2020-02-27', 'Profile204359.jpg'),
(31, 'chaima', 24567891, '2020-02-27', 'Profile255812.jpg'),
(35, 'salem', 52316, '2020-02-27', 'Profile136461.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `monton` decimal(20,0) NOT NULL,
  `etatTransaction` enum('payed','not_payed') NOT NULL,
  `description` varchar(100) NOT NULL,
  `idFacture` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idFacture` (`idFacture`)
) ENGINE=MyISAM AUTO_INCREMENT=3379 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `date`, `monton`, `etatTransaction`, `description`, `idFacture`) VALUES
(3378, '2020-06-19', '0', 'payed', '', 1828),
(3377, '2020-06-19', '25000000', 'payed', '', 1827),
(3323, '2020-06-19', '2300', 'payed', '', 1813),
(3270, '2020-06-19', '65000000', 'payed', '', 1800),
(3218, '2020-06-19', '360000', 'payed', '', 1788),
(3113, '2020-06-19', '200000', 'payed', '', 1756),
(3063, '2020-06-19', '18000000', 'payed', '', 1745),
(2966, '2020-06-19', '230000', 'payed', '', 1715),
(2918, '2020-06-19', '1000000', 'payed', '', 1705),
(2913, '2020-06-03', '94534', 'payed', '', 1699),
(2912, '2020-06-09', '95345', 'payed', '', 1700),
(2911, '2020-06-06', '80654', 'payed', '', 1701),
(2910, '2020-06-02', '95342', 'payed', '', 1702),
(2909, '2020-06-12', '83545', 'payed', '', 1703),
(2908, '2020-06-10', '75434', 'payed', '', 1704),
(2907, '2020-05-30', '43545', 'payed', '', 1698),
(2906, '2020-05-31', '35454', 'payed', '', 1698),
(2905, '2020-06-01', '45324', 'payed', '', 1698),
(2904, '2020-06-02', '35425', 'payed', '', 1698),
(2903, '2020-06-03', '63464', 'payed', '', 1698),
(2902, '2020-06-04', '43553', 'payed', '', 1698),
(2901, '2020-06-05', '45345', 'payed', '', 1698),
(2900, '2020-06-06', '34532', 'payed', '', 1698),
(2899, '2020-06-07', '35435', 'payed', '', 1698),
(2898, '2020-06-08', '12354', 'payed', '', 1698),
(2897, '2020-06-09', '45324', 'payed', '', 1698),
(2896, '2020-06-10', '31254', 'payed', '', 1698),
(2895, '2020-06-11', '63453', 'payed', '', 1698),
(2894, '2020-06-12', '45354', 'payed', '', 1698),
(2893, '2020-06-13', '75466', 'payed', '', 1698),
(2892, '2020-06-14', '63545', 'payed', '', 1698),
(2891, '2020-06-15', '85454', 'payed', '', 1698),
(2890, '2020-06-16', '75424', 'payed', '', 1698),
(2889, '2020-06-17', '45453', 'payed', '', 1698),
(2888, '2020-06-18', '25425', 'payed', '', 1698),
(2887, '2020-05-30', '121232', 'payed', '', 1697),
(2886, '2020-05-31', '152421', 'payed', '', 1697),
(2885, '2020-06-01', '142121', 'payed', '', 1697),
(2884, '2020-06-02', '132121', 'payed', '', 1697),
(2883, '2020-06-03', '133333', 'payed', '', 1697),
(2882, '2020-06-04', '154524', 'payed', '', 1697),
(2881, '2020-06-05', '160000', 'payed', '', 1697),
(2880, '2020-06-06', '154545', 'payed', '', 1697),
(2879, '2020-06-07', '121245', 'payed', '', 1697),
(2878, '2020-06-08', '142312', 'payed', '', 1697),
(2877, '2020-06-09', '152545', 'payed', '', 1697),
(2876, '2020-06-10', '120452', 'payed', '', 1697),
(2875, '2020-06-11', '100202', 'payed', '', 1697),
(2874, '2020-06-12', '125456', 'payed', '', 1697),
(2873, '2020-06-13', '121212', 'payed', '', 1697),
(2872, '2020-06-14', '121212', 'payed', '', 1697),
(2871, '2020-06-15', '121231', 'payed', '', 1697),
(2870, '2020-06-16', '121231', 'payed', '', 1697),
(2869, '2020-06-17', '162323', 'payed', '', 1697),
(2868, '2020-06-18', '123123', 'payed', '', 1697);

-- --------------------------------------------------------

--
-- Table structure for table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `utilisation` enum('vehicule_personnel','vehicule_livraison','') NOT NULL,
  `km` int(255) NOT NULL,
  `etat` enum('disponnible','en_panne','vendu','en_maintenance','corbeille','') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicule`
--

INSERT INTO `vehicule` (`id`, `nom`, `matricule`, `couleur`, `utilisation`, `km`, `etat`) VALUES
(23, 'Bmw', '200Tun2100', '0xb31a1aff', 'vehicule_personnel', 0, 'en_panne');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
