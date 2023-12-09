-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time:  3 Dec, 2023 at 03:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nu_events`
--

-- --------------------------------------------------------

-- Table structure for table `admin`

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `psw` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `admin`

INSERT INTO `admin` (`aid`, `name`, `psw`) VALUES
(0, 'admin', 'admin');

-- Table structure for table `registration`

-- --------------------------------------------------------

CREATE TABLE `registration` (
  `reg_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `u_id` INT(11),
  `name` VARCHAR(30),
  `email` VARCHAR(30),
  `phoneNum` VARCHAR(30),
  `type_id` INT(11),
  `event_id` INT(11),
  FOREIGN KEY (`u_id`) REFERENCES `u_info`(`uid`),
  FOREIGN KEY (`type_id`) REFERENCES `event_type`(`type_id`)
);
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `events`
CREATE TABLE `events` (
  `event_id` INT(100) AUTO_INCREMENT PRIMARY KEY,
  `event_title` TEXT,
  `event_price` INT(20),
  `participants` INT(100),
  `img_link` TEXT,
  `type_id` INT(100),
  `event_description` TEXT,
  `event_date` DATE,
  `start_time` TIME,
  `end_time` TIME,
  `event_location` VARCHAR(255),
  `organizer_name` VARCHAR(100),
  `organizer_email` VARCHAR(100),
  `registration_deadline` DATE,
  FOREIGN KEY (`type_id`) REFERENCES `event_type`(`type_id`) ON DELETE CASCADE
);
----------------------------------------------------------

-- Table structure for table `event_type`
CREATE TABLE `event_type` (
  `type_id` INT(100) AUTO_INCREMENT PRIMARY KEY,
  `type_name` VARCHAR(100)
);
----------------------------------------------------------

-- Table structure for table `u_info`

CREATE TABLE `u_info` (
  `uid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pno` varchar(30) NOT NULL,
  `adds` varchar(30) NOT NULL,
  `psw` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Adding a foreign key constraint to the registration table
ALTER TABLE `registration`
ADD CONSTRAINT `fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `events`(`event_id`);

-- Trigger to backup registrations when a deletion is attempted
DELIMITER //
CREATE TRIGGER `backup_registration_trigger` BEFORE DELETE ON `registration`
FOR EACH ROW
BEGIN
    IF OLD.event_id = (SELECT event_id FROM events WHERE event_id = OLD.event_id) THEN
        INSERT INTO `registrations_backup` (`reg_id`, `event_id`, `u_id`, `name`, `email`, `phoneNum`, `type_id`)
        VALUES (OLD.reg_id, OLD.event_id, OLD.u_id, OLD.name, OLD.email, OLD.phoneNum, OLD.type_id);
    END IF;
END;
//
DELIMITER ;

-- Trigger to delete related registrations when an event is deleted
DELIMITER //
CREATE TRIGGER `delete_related_registrations_trigger` BEFORE DELETE ON `events`
FOR EACH ROW
BEGIN
    DELETE FROM `registration` WHERE `event_id` = `OLD.event_id`;
END;
//
DELIMITER ;

-- Trigger to update the participants count when a registration is deleted
DELIMITER //

CREATE TRIGGER decrement_participants_trigger
AFTER DELETE ON registration
FOR EACH ROW
BEGIN
    UPDATE events
    SET participants = participants - 1
    WHERE event_id = OLD.event_id;
END;
//
DELIMITER ;


-- -----------------------------------------------------
CREATE TABLE `registrations_backup` LIKE `registration`;



