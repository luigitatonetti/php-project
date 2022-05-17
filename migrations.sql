-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Mag 05, 2022 alle 17:53
-- Versione del server: 5.1.73
-- Versione PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `progettos2i`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Ordini`
--

CREATE TABLE IF NOT EXISTS `Ordini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Data` date NOT NULL,
  `PaeseDestinazione` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `Ordini`
--

INSERT INTO `Ordini` (`id`, `Data`, `PaeseDestinazione`) VALUES
(1, '2021-05-04', 'italia'),
(2, '2021-01-04', 'italia'),
(7, '2022-05-09', 'spagna'),
(6, '2022-05-05', 'italia');

-- --------------------------------------------------------

--
-- Struttura della tabella `OrdiniRighe`
--

CREATE TABLE IF NOT EXISTS `OrdiniRighe` (
  `idOrdine` int(11) NOT NULL,
  `idProdotto` int(11) NOT NULL,
  `Quantita` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `OrdiniRighe`
--

INSERT INTO `OrdiniRighe` (`idOrdine`, `idProdotto`, `Quantita`) VALUES
(1, 1, 5),
(1, 4, 3),
(2, 3, 10),
(2, 5, 2),
(2, 2, 5),
(1, 2, 7),
(6, 1, 5),
(6, 4, 2),
(7, 1, 7),
(7, 4, 1),
(7, 2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `Prodotti`
--

CREATE TABLE IF NOT EXISTS `Prodotti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `CO2` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `Prodotti`
--

INSERT INTO `Prodotti` (`id`, `Nome`, `CO2`) VALUES
(1, 'Vitello Sintetico', 10.5),
(2, 'Pollo Sintetico', 2.3),
(3, 'Maiale Sintetico', 1.1),
(4, 'Bistecca', 5.6),
(5, 'Hamburgher', 2.1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
