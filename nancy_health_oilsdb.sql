-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 01:28 PM
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
-- Database: `nancy_health_oilsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `base_oils`
--

CREATE TABLE `base_oils` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `base_oils`
--

INSERT INTO `base_oils` (`id`, `name`, `description`, `price`, `image`, `type`, `image_path`) VALUES
(5, 'SESAME OIL', 'SESAME OIL has more than a thousand years of active use as a beauty elixir, antiaging agent, hair strengthening supplement, and headache reliever. Sesame oil is stored for a very long time thanks not only to the high content of vitamin E, but also to the unique natural preservative - Sesamol. In addition, the composition includes vitamin C, beta-sitosterol.', 12.00, 'uploads/SESAME.png', 'base oils', NULL),
(6, 'APRICOT SEED OIL', 'APRICOT SEED OIL is prized for its unique healing properties and its delicate aroma and pleasant texture. The first experience with the use of this oil is attributed to the medicine of Ancient Tibet. In addition to vitamins C, A and B, which are common in base oils, it contains an active form of rare vitamin F, unique tocopherols and salts of magnesium, potassium and zinc.', 22.10, 'uploads/APRICOT.png', 'base oils', NULL),
(7, 'CEDAR OIL', 'CEDAR OIL - Siberian cedar oil is considered the best pine nut oil. It is one of the original Russian plant oils whose unique properties define its special status in aromatherapy. This oil has a wide range of medicinal properties that are much more pronounced than cosmetic ones. It is believed that medically it surpasses and completely replaces any, even the rarest vegetable oil.', 37.20, 'uploads/CEDAR.png', 'base oils', NULL),
(8, 'Hemp Seed Oil', 'Hemp Seed Oil  \r\nOrganic Hemp seed oil has healing powers that have been associated with the plant for centuries. The oil contains more than 75% of unsaturated fatty acids. The most important ones are omega-6-linoleic acid, omega-6- gamma-linoleic acid and omega-3-linoleic acid. The oil contains a big amount of vitamins (A, B1, B2, B3, B6, C, D and E)', 12.00, 'uploads/Hemp.png', 'base oils', NULL),
(9, 'JOJOBA OIL', 'JOJOBA OIL has a thousand-year history of use, it is truly unique in its chemical composition and properties, which are not lost even with long-term storage. With anti-inflammatory properties, it treats cracks, cuts, injuries, irritations and dermatitis, and is also used effectively in anti-cellulite formulas, including to remove stretch marks. Jojoba oil can be used for any type of skin – dry, oily or normal, for problem areas and at any age.', 14.00, 'uploads/JOJOBA.png', 'base oils', NULL),
(10, 'POMEGRANATE SEED OIL', 'POMEGRANATE SEED OIL has unique protective, nourishing and moisturizing properties, which allows you to get rid of very serious problems with dryness and loss of elasticity of the skin. In terms of vitamin E content, pomegranate oil is considered the only competitor of wheat germ oil', 33.00, 'uploads/POMEGRANATE.png', 'base oils', NULL),
(11, 'AMARANTH OIL', 'AMARANTH OIL - Amaranth oil is considered a unique natural remedy that promotes a qualitative increase in cellular respiration. Amaranth oil is considered the only source of squalene among base oils - a unique substance that is as close as possible to natural cellular compounds, but also provides high-quality activation of cellular respiration.', 16.90, 'uploads/AMARANTH.png', 'base oils', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consumables`
--

CREATE TABLE `consumables` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity_ml` int(11) NOT NULL,
  `packets` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin1', 'admin1@gmail.com', 'admin1', 'admin'),
(2, 'user1', 'user@gmail.com', 'user1', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `base_oils`
--
ALTER TABLE `base_oils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumables`
--
ALTER TABLE `consumables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `base_oils`
--
ALTER TABLE `base_oils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `consumables`
--
ALTER TABLE `consumables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
