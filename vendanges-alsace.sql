-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2014 at 02:04 PM
-- Server version: 5.6.19
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `vendanges_alsace`
--

-- --------------------------------------------------------

--
-- Table structure for table `annonces`
--

CREATE TABLE IF NOT EXISTS `annonces` (
`id` int(11) NOT NULL,
  `vigneron` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `logement` tinyint(1) NOT NULL,
  `repas` tinyint(1) NOT NULL,
  `remuneration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texte` longtext COLLATE utf8_unicode_ci NOT NULL,
  `places` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `annonces`
--

INSERT INTO `annonces` (`id`, `vigneron`, `titre`, `dateDebut`, `dateFin`, `logement`, `repas`, `remuneration`, `texte`, `places`, `active`) VALUES
(1, 15, 'Coupeur', '2014-10-01 00:00:00', '2014-10-18 00:00:00', 0, 0, '10,00€ brut à l''heure', 'yada yada yada', 3, 1),
(2, 15, 'Coupeur', '2014-09-07 00:00:00', '2014-09-17 00:00:00', 0, 0, '10,00€ brut à l''heure', 'yada', 2, 1),
(3, 13, 'Coupeur', '2014-09-01 00:00:00', '2014-09-14 00:00:00', 1, 1, '9,15€ brut à l''heure', 'bla bla bla', 3, 1),
(4, 12, 'Conducteur', '2014-09-13 00:00:00', '2014-09-16 00:00:00', 1, 0, '9,15€ brut à l''heure', 'bla bla', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
`id` int(11) NOT NULL,
  `vendangeur_id` int(11) DEFAULT NULL,
  `annonce_id` int(11) DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `reponse`
--

INSERT INTO `reponse` (`id`, `vendangeur_id`, `annonce_id`, `message`, `sujet`) VALUES
(1, 3, 1, 'this is a test', 'test'),
(2, 3, 4, 'this should be a response to annonce 4 from vendangeur 3', 'another test'),
(3, 4, 2, 'response from vendangeur 4 to annonce 2', 'one more test');

-- --------------------------------------------------------

--
-- Table structure for table `vendangeurs`
--

CREATE TABLE IF NOT EXISTS `vendangeurs` (
`id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vendangeurs`
--

INSERT INTO `vendangeurs` (`id`, `nom`, `prenom`, `adresse`, `code`, `ville`, `pays`, `tel`, `email`, `password`) VALUES
(1, 'Willard', 'John', '23 Rue des Foulons', '67200', 'Strasbourg', 'France', '0699492949', 'jgwil2@gmail.com', '$2y$10$j.dggaumo8KSiZF3iTOA1eMDVtN98Iq3I74uM0X.fjcSke5QRxaQC'),
(3, 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', '6cyzH/P36PXTFEZBVo1btAr8GGax2hGf0SfrGZuLTuj3sCDHt/CFB/Ng5w2d8Ydis4sqDEt2YwjnbXWbPTVAZg=='),
(4, 'test5', 'test5', 'test5', 'test5', 'test5', 'test5', 'test5', 'test5', 'jnnJxrBzJuuE5ckuIUSJFo4WjWknGpNv7cXDkBuquU49aoEFUv4Wwx4OPtOAAPtWg56bhnlpYLu2dBowz05ZAw==');

-- --------------------------------------------------------

--
-- Table structure for table `vignerons`
--

CREATE TABLE IF NOT EXISTS `vignerons` (
`id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `site` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentation` longtext COLLATE utf8_unicode_ci NOT NULL,
  `photoPath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `vignerons`
--

INSERT INTO `vignerons` (`id`, `nom`, `adresse`, `code`, `ville`, `email`, `site`, `presentation`, `photoPath`, `password`) VALUES
(6, 'test2', 'test2', 'test', 'test', 'test2', 'test2', 'teset', 'b085b42be35d879adaf35688f7f2c8d45d6de432.gif', 'ad0234829205b9033196ba818f7a872b'),
(7, 'test', 'test', 'test', 'test', 'test', 'test', 'test', '4f99ed6e29d0a938d948d8df6eaab9856a6b5972.gif', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'),
(8, 'test3', 'test3', 'test3', 'test3', 'test3', 'test3', 'test3', '8e3a4107f3a75d761b823d9581e35ba817dd03dd.gif', 'UJcRLbpI+VhlJSrqTli1S6romZo='),
(10, 'test4', 'test4', 'test4', 'test4', 'test4', 'test4', 'test', 'b4fedf4b1232102a704acf368b36396462874ce5.gif', 'mwX9QnivI2WUDuRHn1KvIfmR7Q1SYxKHO003HQ9QGBAIU+w674V5Sw0z46g5yNpMNZPmcfLd8gXBqgidct8d0A=='),
(11, 'test5', 'test5', 'test5', 'test5', 'test5', 'test5', 'test5', 'fabbd4b9e8051d23769c0ec9f173eb8aeccc72b7.gif', 'jnnJxrBzJuuE5ckuIUSJFo4WjWknGpNv7cXDkBuquU49aoEFUv4Wwx4OPtOAAPtWg56bhnlpYLu2dBowz05ZAw=='),
(12, 'test6', 'test6', 'test6', 'test6', 'test6', 'test6', 'test6', '174be6cb58a8c0cdba269751ee056271ee921091.gif', '2maNYH045up3Qpxu/fe5Amgjidt2NwzyDG8nXPbTndKmHrM65XYUQcj2KGiEOmCmFO2mtSETUhGEtDVKd9RHAA=='),
(13, 'test7', 'test7', 'test7', 'test7', 'test7', 'test7', 'test7', 'd1c8efda54539bc65bbd68612e190497b3c733b5.gif', '5P3FGFe3NIvqwaEwFEcZaHnWXlNWkldaw/9eiVXV8jqGzqpLuAVJW2BVFjT1y6AOf5s0pgpmrSGSYiLwRgWFkQ=='),
(15, 'test8', 'test8', 'test8', 'test8', 'test8', 'test8', 'test8', 'e9829ea6c7beb90a3f90f6e8111c70371003f1cb.gif', 'SWJdXkbXDjaIUQvBfLtaw5s3UWz6n4Sn5/i+tzqEt/g/2FyN/Iua8EibRFQZmlO73C4X+v2kWviteknr4n8YZQ==');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annonces`
--
ALTER TABLE `annonces`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_CB988C6F312238BE` (`vigneron`);

--
-- Indexes for table `reponse`
--
ALTER TABLE `reponse`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_5FB6DEC78E6F3791` (`vendangeur_id`), ADD KEY `IDX_5FB6DEC78805AB2F` (`annonce_id`);

--
-- Indexes for table `vendangeurs`
--
ALTER TABLE `vendangeurs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_34340641E7927C74` (`email`);

--
-- Indexes for table `vignerons`
--
ALTER TABLE `vignerons`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_37E673B8694309E4` (`site`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annonces`
--
ALTER TABLE `annonces`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reponse`
--
ALTER TABLE `reponse`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vendangeurs`
--
ALTER TABLE `vendangeurs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vignerons`
--
ALTER TABLE `vignerons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `annonces`
--
ALTER TABLE `annonces`
ADD CONSTRAINT `FK_CB988C6F312238BE` FOREIGN KEY (`vigneron`) REFERENCES `vignerons` (`id`);

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
ADD CONSTRAINT `FK_5FB6DEC78805AB2F` FOREIGN KEY (`annonce_id`) REFERENCES `annonces` (`id`),
ADD CONSTRAINT `FK_5FB6DEC78E6F3791` FOREIGN KEY (`vendangeur_id`) REFERENCES `vendangeurs` (`id`);