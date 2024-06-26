-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 12:22 AM
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
-- Database: `telecommunication_app`
--

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `AddAssistant` (IN `p_team_ID` INT, IN `p_assistant_fullName` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(70))   BEGIN
    INSERT INTO assistant (team_ID, assistant_fullName, email, password)
    VALUES (p_team_ID, p_assistant_fullName, p_email, p_password);
END$$

CREATE PROCEDURE `GetAcceptedObjections` ()   BEGIN
    SELECT 
        a.assistant_fullName,
        o.objection_id,
        o.objection_reason,
        o.objection_month,
        o.objection_status,
        r.response_content,
        r.response_date
    FROM 
        objection o
    JOIN 
        assistant a ON o.assistant_id = a.assistant_id
    JOIN 
        response r ON o.objection_id = r.objection_id
    WHERE 
        o.objection_status = 'accepted';
END$$

CREATE PROCEDURE `GetObjectionsByStatus` (IN `p_status` VARCHAR(50))   BEGIN
    SELECT 
        o.objection_id,
        o.objection_reason,
        o.objection_month,
        o.objection_status,
        a.assistant_id,
        a.assistant_fullName
    FROM 
        objection o
    JOIN 
        assistant a ON o.assistant_id = a.assistant_id
    WHERE 
        o.objection_status = p_status;
END$$

CREATE PROCEDURE `GetTeamInfo` ()   BEGIN
    SELECT 
        t.team_ID,
        t.team_name,
        tl.leader_id,
        CONCAT(tl.leader_firstName, ' ', tl.leader_lastName) AS leader_fullName,
        a.assistant_id,
        a.assistant_fullName
    FROM 
        team t
        JOIN team_leader tl ON t.team_ID = tl.team_ID
        JOIN assistant a ON t.team_ID = a.team_ID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assistant`
--

CREATE TABLE `assistant` (
  `assistant_id` int(11) NOT NULL,
  `team_ID` int(11) NOT NULL,
  `assistant_fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assistant`
--

INSERT INTO `assistant` (`assistant_id`, `team_ID`, `assistant_fullName`, `email`, `password`) VALUES
(1, 1, 'Assistant A1', 'AssistantA1@gmail.com', '1'),
(2, 1, 'Assistant A2', 'AssistantA2@gmail.com', '1'),
(3, 2, 'Assistant B1', 'AssistantB1@gmail.com', '1'),
(4, 2, 'Assistant B2', 'AssistantB2@gmail.com', '1');

-- --------------------------------------------------------

--
-- Stand-in structure for view `assistant_rewards_view`
-- (See below for the actual view)
--
CREATE TABLE `assistant_rewards_view` (
`assistant_id` int(11)
,`assistant_fullName` varchar(100)
,`reward_id` int(11)
,`reward_month` int(11)
,`reward_amount` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_fullName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_fullName`) VALUES
(1, 'customer1 a1'),
(2, 'customer2 a1'),
(3, 'customer3 a1'),
(4, 'customer4 a2'),
(5, 'customer5 a2'),
(10, 'c b2'),
(11, 'c2 b2'),
(13, 'c a1 new'),
(14, 'new2'),
(123, 'yosuf');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(11) NOT NULL,
  `manager_fullName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `objection`
--

CREATE TABLE `objection` (
  `objection_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `team_ID` int(11) NOT NULL,
  `objection_month` int(11) NOT NULL,
  `objection_reason` varchar(50) NOT NULL,
  `objection_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objection`
--

INSERT INTO `objection` (`objection_id`, `assistant_id`, `team_ID`, `objection_month`, `objection_reason`, `objection_status`) VALUES
(59, 1, 1, 5, 'a1 m5', 'reject'),
(60, 2, 1, 6, 'as2 m6', 'accept'),
(61, 2, 1, 6, 'as2 m6', 'accept'),
(62, 4, 2, 7, 'b2 m7', 'reject'),
(63, 1, 1, 7, 'a1 m7 new', 'reject'),
(64, 1, 1, 7, 'a1', 'accept');

-- --------------------------------------------------------

--
-- Stand-in structure for view `objections_list_view`
-- (See below for the actual view)
--
CREATE TABLE `objections_list_view` (
`assistant_id` int(11)
,`assistant_fullName` varchar(100)
,`objection_id` int(11)
,`objection_reason` varchar(50)
,`objection_month` int(11)
,`objection_status` varchar(50)
,`team_ID` int(11)
,`leader_id` int(11)
,`leader_fullName` varchar(61)
);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `response_id` int(11) NOT NULL,
  `objection_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `response_content` varchar(50) NOT NULL,
  `response_action` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`response_id`, `objection_id`, `assistant_id`, `leader_id`, `response_content`, `response_action`) VALUES
(38, 59, 1, 1, 'as1 m5 reject', 'reject'),
(39, 60, 2, 1, 'as1 m6 accepted', 'accept'),
(40, 61, 2, 1, 'as2 m6 ac', 'accept'),
(41, 62, 4, 2, 'be m7 r', 'reject'),
(42, 63, 1, 1, 'm7 r', 'reject'),
(43, 64, 1, 1, 'jnwef', 'accept'),
(44, 64, 1, 1, 'jnwef', 'accept');

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE `reward` (
  `reward_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `reward_month` int(11) NOT NULL,
  `reward_year` int(11) NOT NULL,
  `reward_amount` int(11) NOT NULL DEFAULT 0,
  `reward_comment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward`
--

INSERT INTO `reward` (`reward_id`, `assistant_id`, `reward_month`, `reward_year`, `reward_amount`, `reward_comment`) VALUES
(92, 1, 5, 2024, 5000, 'Monthly incentive 5 year 2024'),
(93, 1, 6, 2024, 5000, 'Monthly incentive 6 year 2024'),
(94, 2, 5, 2024, 5000, 'Monthly incentive 5 year 2024'),
(95, 2, 6, 2024, 5000, 'Monthly incentive 6 year 2024'),
(96, 4, 5, 2024, 5000, 'Monthly incentive 5 year 2024'),
(97, 4, 7, 2024, 5000, 'Monthly incentive 7 year 2024'),
(98, 1, 7, 2024, 5000, 'Monthly incentive 7 year 2024');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `base_salary` int(11) NOT NULL DEFAULT 5000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_call`
--

CREATE TABLE `tbl_call` (
  `call_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `call_status` varchar(50) NOT NULL,
  `call_startTime` time DEFAULT NULL,
  `call_finishTime` time DEFAULT NULL,
  `call_subject` varchar(50) NOT NULL,
  `call_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_call`
--

INSERT INTO `tbl_call` (`call_id`, `assistant_id`, `customer_id`, `call_status`, `call_startTime`, `call_finishTime`, `call_subject`, `call_date`) VALUES
(193, 1, 1, 'Completed', '16:13:00', '16:15:00', 'Fault', '2024-05-19'),
(194, 1, 2, 'Completed', '14:02:00', '14:03:00', 'Fault', '2024-05-21'),
(195, 1, 3, 'Completed', '02:02:00', '14:04:00', 'Fault', '2024-06-12'),
(196, 2, 4, 'Problem could not solved', '00:30:00', '00:32:00', 'Fault', '2024-05-15'),
(197, 2, 5, 'Completed', '00:31:00', '00:33:00', 'Fault', '2024-06-12'),
(198, 4, 10, 'Completed', '00:35:00', '00:37:00', 'Fault', '2024-05-22'),
(199, 4, 11, 'Completed', '00:37:00', '00:40:00', 'Fault', '2024-07-17'),
(200, 1, 13, 'Completed', '01:00:00', '01:01:00', 'Fault', '2024-07-24'),
(201, 1, 14, 'Problem could not solved', '01:06:00', '01:06:00', 'Fault', '2024-05-21'),
(202, 1, 123, 'Completed', '21:03:00', '12:03:00', 'Fault', '2024-05-21');

--
-- Triggers `tbl_call`
--
DELIMITER $$
CREATE TRIGGER `calculate_monthly_incentive` AFTER INSERT ON `tbl_call` FOR EACH ROW BEGIN
    DECLARE assistant_call_count INT DEFAULT 0;
    DECLARE assistant_short_call_count INT DEFAULT 0;
    DECLARE monthly_base_incentive DECIMAL(10,2) DEFAULT 5000;
    DECLARE daily_incentive DECIMAL(10,2) DEFAULT 0;
    DECLARE monthly_incentive DECIMAL(10,2) DEFAULT 0;
    DECLARE existing_record_count INT DEFAULT 0;
    DECLARE calc_month INT;
    DECLARE calc_year INT;
    DECLARE assistant_exists INT DEFAULT 0;

    SET calc_month = MONTH(NEW.call_date);
    SET calc_year = YEAR(NEW.call_date);

    -- Check if there is already a record for this assistant in this month
    SELECT COUNT(*) INTO assistant_exists
    FROM reward
    WHERE assistant_id = NEW.assistant_id
    AND reward_month = calc_month
    AND reward_year = calc_year;

    -- If the assistant has not been inserted yet for this month, insert a record
    IF assistant_exists = 0 THEN
        INSERT INTO reward (assistant_id, reward_month, reward_year, reward_amount, reward_comment)
        VALUES (NEW.assistant_id, calc_month, calc_year, 5000, 'No incentive earned');
    END IF;

    -- Calculate daily call count and daily short call count
    SELECT COUNT(*), SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, call_startTime, call_finishTime) < 5 THEN 1 ELSE 0 END)
    INTO assistant_call_count, assistant_short_call_count
    FROM tbl_call
    WHERE assistant_id = NEW.assistant_id
    AND YEAR(call_date) = calc_year
    AND MONTH(call_date) = calc_month;

    -- Calculate daily incentive based on the rules
    IF assistant_call_count < 100 THEN
        SET daily_incentive = 0;
    ELSEIF assistant_call_count <= 200 THEN
        SET daily_incentive = assistant_short_call_count * 1.25;
    ELSE
        SET daily_incentive = assistant_short_call_count * 2;
    END IF;

    -- Update daily incentive for the assistant for the day
    UPDATE reward
    SET reward_amount = reward_amount + daily_incentive ,
        reward_comment = CASE
                            WHEN assistant_call_count < 100 THEN 'No incentive earned'
                            ELSE CONCAT('Base incentive + ', assistant_short_call_count, ' calls lasting less than 5 minutes')
                        END
    WHERE assistant_id = NEW.assistant_id
    AND reward_month = calc_month
    AND reward_year = calc_year;

    -- Calculate and update monthly incentive for the assistant
    SELECT COALESCE(SUM(reward_amount), 0)
    INTO monthly_incentive
    FROM reward
    WHERE assistant_id = NEW.assistant_id
    AND reward_month = calc_month
    AND reward_year = calc_year;

    UPDATE reward
    SET reward_amount = monthly_incentive,
        reward_comment = CONCAT('Monthly incentive ', calc_month, ' year ', calc_year)
    WHERE assistant_id = NEW.assistant_id
    AND reward_month = calc_month
    AND reward_year = calc_year;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_ID` int(11) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_ID`, `team_name`, `creation_date`) VALUES
(1, 'Team A', '2024-05-09'),
(2, 'Team B', '2024-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `team_leader`
--

CREATE TABLE `team_leader` (
  `leader_id` int(11) NOT NULL,
  `team_ID` int(11) DEFAULT NULL,
  `leader_firstName` varchar(30) NOT NULL,
  `leader_lastName` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_leader`
--

INSERT INTO `team_leader` (`leader_id`, `team_ID`, `leader_firstName`, `leader_lastName`, `email`, `password`) VALUES
(1, 1, 'Leader', 'A', 'LeaderA@gmail.com', '1'),
(2, 2, 'Leader', 'B', 'LeaderB@gmail.com', '1');

-- --------------------------------------------------------

--
-- Structure for view `assistant_rewards_view`
--
DROP TABLE IF EXISTS `assistant_rewards_view`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `assistant_rewards_view`  AS SELECT `a`.`assistant_id` AS `assistant_id`, `a`.`assistant_fullName` AS `assistant_fullName`, `r`.`reward_id` AS `reward_id`, `r`.`reward_month` AS `reward_month`, `r`.`reward_amount` AS `reward_amount` FROM (`assistant` `a` join `reward` `r` on(`a`.`assistant_id` = `r`.`assistant_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `objections_list_view`
--
DROP TABLE IF EXISTS `objections_list_view`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `objections_list_view`  AS SELECT `a`.`assistant_id` AS `assistant_id`, `a`.`assistant_fullName` AS `assistant_fullName`, `o`.`objection_id` AS `objection_id`, `o`.`objection_reason` AS `objection_reason`, `o`.`objection_month` AS `objection_month`, `o`.`objection_status` AS `objection_status`, `tl`.`team_ID` AS `team_ID`, `tl`.`leader_id` AS `leader_id`, concat(`tl`.`leader_firstName`,' ',`tl`.`leader_lastName`) AS `leader_fullName` FROM ((`assistant` `a` join `objection` `o` on(`a`.`assistant_id` = `o`.`assistant_id`)) join `team_leader` `tl` on(`a`.`team_ID` = `tl`.`team_ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`assistant_id`),
  ADD KEY `fk_team_ID_assistant` (`team_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `objection`
--
ALTER TABLE `objection`
  ADD PRIMARY KEY (`objection_id`),
  ADD KEY `fk_asstant_id_in_objection` (`assistant_id`),
  ADD KEY `fk_teamID_objection` (`team_ID`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `fk_res_objection_id` (`objection_id`);

--
-- Indexes for table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`reward_id`),
  ADD KEY `fk_assistant_id_in_reward` (`assistant_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `fk_assistant_id_in_salary` (`assistant_id`);

--
-- Indexes for table `tbl_call`
--
ALTER TABLE `tbl_call`
  ADD PRIMARY KEY (`call_id`),
  ADD KEY `fk_assitantID_tblCall` (`assistant_id`),
  ADD KEY `fk_customer_id_call` (`customer_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_ID`);

--
-- Indexes for table `team_leader`
--
ALTER TABLE `team_leader`
  ADD PRIMARY KEY (`leader_id`),
  ADD KEY `fk_team_ID_team_leader` (`team_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `assistant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9069248;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `objection`
--
ALTER TABLE `objection`
  MODIFY `objection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_call`
--
ALTER TABLE `tbl_call`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_leader`
--
ALTER TABLE `team_leader`
  MODIFY `leader_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistant`
--
ALTER TABLE `assistant`
  ADD CONSTRAINT `fk_team_ID_assistant` FOREIGN KEY (`team_ID`) REFERENCES `team` (`team_ID`);

--
-- Constraints for table `objection`
--
ALTER TABLE `objection`
  ADD CONSTRAINT `fk_asstant_id_in_objection` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`),
  ADD CONSTRAINT `fk_teamID_objection` FOREIGN KEY (`team_ID`) REFERENCES `team` (`team_ID`);

--
-- Constraints for table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `fk_res_objection_id` FOREIGN KEY (`objection_id`) REFERENCES `objection` (`objection_id`);

--
-- Constraints for table `reward`
--
ALTER TABLE `reward`
  ADD CONSTRAINT `fk_assistant_id_in_reward` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `fk_assistant_id_in_salary` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- Constraints for table `tbl_call`
--
ALTER TABLE `tbl_call`
  ADD CONSTRAINT `fk_assitantID_tblCall` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`),
  ADD CONSTRAINT `fk_customer_id_call` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `team_leader`
--
ALTER TABLE `team_leader`
  ADD CONSTRAINT `fk_team_ID_team_leader` FOREIGN KEY (`team_ID`) REFERENCES `team` (`team_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
