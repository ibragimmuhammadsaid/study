-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2024 at 01:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `StudentDebts`
--

CREATE TABLE `StudentDebts` (
  `DebtID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `StudentDebt` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `StudentDebts`
--

INSERT INTO `StudentDebts` (`DebtID`, `StudentID`, `StudentDebt`) VALUES
(1, 220222, 13500000.00),
(2, 220682, 2000000.00),
(3, 220982, 30000000.00),
(4, 220813, 29000000.00),
(5, 230587, 3000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `Surname` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `Year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`Surname`, `firstName`, `ID`, `Year`) VALUES
('Mirjalilov', 'Mirazam', 220145, 3),
('Istamov', 'Emil', 220211, 3),
('Sultanmuratov', 'Mahmud', 220222, 3),
('Rakhimjonov', 'Abdulloh', 220333, 3),
('Mirazimov', 'Mirvakhid', 220336, 3),
('Abduhakimov', 'Shaxbozbek', 220403, 3),
('Rakhmanov', 'Jasur', 220415, 3),
('Asanova', 'Karina', 220588, 3),
('Erkinov', 'Alisher', 220655, 3),
('Nazarova', 'Saodat', 220682, 3),
('Akhmedov', 'Azim', 220698, 3),
('Musaxanov', 'Abror', 220763, 3),
('Safarov', 'Shaxzod', 220768, 3),
('Yuldashev', 'Muhammadali', 220813, 3),
('Khabibullina', 'Alsu', 220866, 3),
('Abdulmanapov', 'Akmal', 220877, 3),
('Inagamov', 'Usmon', 220982, 3),
('Savkimov', 'Azizbek', 221224, 3),
('Mirazimov', 'Mirkamol', 221703, 3),
('Sharipova', 'Madina', 221921, 3),
('Rasulova', 'Khonzoda', 230152, 2),
('Anvarov', 'Saidbek', 230502, 2),
('Mirakhmadi', 'Zukhra', 230523, 2),
('Mirakhmadi', 'Kamola', 230524, 2),
('Mamurova', 'Sevara', 230558, 2),
('XXX', 'Hamas', 230587, 2),
('Abbasova', 'Naval', 230677, 2),
('Bahadirova', 'Sanam', 230678, 2),
('Gayratova', 'Farzona', 230828, 2),
('Jamoliddinov', 'Hudayor', 230874, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `StudentDebts`
--
ALTER TABLE `StudentDebts`
  ADD PRIMARY KEY (`DebtID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `StudentDebts`
--
ALTER TABLE `StudentDebts`
  MODIFY `DebtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `StudentDebts`
--
ALTER TABLE `StudentDebts`
  ADD CONSTRAINT `StudentDebts_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `Students` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
