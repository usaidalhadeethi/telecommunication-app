-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15 مايو 2024 الساعة 22:25
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usaid`
--

DELIMITER $$
--
-- الإجراءات
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAssistantSalaryAndRewards` ()   BEGIN
    SELECT 
        a.assistant_fullName,
        s.base_salary,
        r.reward_amount,
        YEAR(r.reward_month) AS reward_year,
        MONTH(r.reward_month) AS reward_month
    FROM 
        assistant a
        JOIN salary s ON a.assistant_id = s.assistant_id
        JOIN reward r ON a.assistant_id = r.assistant_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCallDetailsByAssistantID` (IN `assistantID` INT)   BEGIN
    SELECT 
        tc.call_id,
        tc.call_date,
        tc.call_subject,
        tc.call_startTime,
        tc.call_finishTime,
        TIMESTAMPDIFF(MINUTE, tc.call_startTime, tc.call_finishTime) AS call_duration_minutes,
        a.assistant_fullName
    FROM 
        tbl_call tc
        JOIN assistant a ON tc.assistant_id = a.assistant_id
        JOIN customer c ON tc.customer_id = c.customer_id
    WHERE 
        tc.assistant_id = assistantID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetResponseDetails` ()   BEGIN
    SELECT 
        a.assistant_id,
        a.assistant_fullName,
        r.response_content,
        r.response_date
        
    FROM 
        response r
        JOIN assistant a ON r.assistant_id = a.assistant_id
        JOIN team_leader tl ON r.leader_id = tl.leader_id
    WHERE 
        a.team_ID = tl.team_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTeamInfo` ()   BEGIN
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
-- بنية الجدول `assistant`
--

CREATE TABLE `assistant` (
  `assistant_id` int(11) NOT NULL,
  `team_ID` int(11) NOT NULL,
  `assistant_fullName` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `assistant`
--

INSERT INTO `assistant` (`assistant_id`, `team_ID`, `assistant_fullName`, `email`, `password`) VALUES
(6, 1, 'asem muhab', 'fatih00@gmail.com', '12345678'),
(11, 1, 'usaid', 'usaid@gmail.com', 'usaid');

-- --------------------------------------------------------

--
-- Stand-in structure for view `call_details_view`
-- (See below for the actual view)
--
CREATE TABLE `call_details_view` (
`customer_fullName` varchar(50)
,`call_subject` varchar(50)
,`call_date` date
,`call_startTime` time
,`call_finishTime` time
,`call_status` varchar(50)
);

-- --------------------------------------------------------

--
-- بنية الجدول `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_fullName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_fullName`) VALUES
(1, 'mudir mali'),
(2, 'mudir mali'),
(3, 'ahmet usaid');

-- --------------------------------------------------------

--
-- بنية الجدول `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(11) NOT NULL,
  `manager_fullName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `objection`
--

CREATE TABLE `objection` (
  `objection_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `objection_month` date NOT NULL,
  `objection_reason` varchar(50) NOT NULL,
  `objection_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `objection`
--

INSERT INTO `objection` (`objection_id`, `assistant_id`, `objection_month`, `objection_reason`, `objection_status`) VALUES
(8, 11, '2024-06-11', '06 2', 'accept');

-- --------------------------------------------------------

--
-- Stand-in structure for view `objections_list_view`
-- (See below for the actual view)
--
CREATE TABLE `objections_list_view` (
`assistant_id` int(11)
,`assistant_fullName` varchar(30)
,`objection_id` int(11)
,`objection_reason` varchar(50)
,`objection_month` date
,`objection_status` varchar(50)
);

-- --------------------------------------------------------

--
-- بنية الجدول `response`
--

CREATE TABLE `response` (
  `response_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `response_content` varchar(50) NOT NULL,
  `response_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `response_action` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `response`
--

INSERT INTO `response` (`response_id`, `assistant_id`, `leader_id`, `response_content`, `response_date`, `response_action`) VALUES
(7, 11, 55, 'yes ', '2024-05-15 20:09:29', 'accept');

-- --------------------------------------------------------

--
-- بنية الجدول `reward`
--

CREATE TABLE `reward` (
  `reward_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `reward_month` date NOT NULL,
  `reward_amount` int(11) NOT NULL DEFAULT 0,
  `reward_comment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `reward`
--

INSERT INTO `reward` (`reward_id`, `assistant_id`, `reward_month`, `reward_amount`, `reward_comment`) VALUES
(5, 11, '2024-05-09', 5000, 'No incentive earned'),
(18, 11, '2024-06-11', 6000, 'good job');

-- --------------------------------------------------------

--
-- بنية الجدول `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `base_salary` int(11) NOT NULL DEFAULT 5000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tbl_call`
--

CREATE TABLE `tbl_call` (
  `call_id` int(11) NOT NULL,
  `call_status` varchar(50) NOT NULL,
  `call_startTime` time DEFAULT NULL,
  `call_finishTime` time DEFAULT NULL,
  `call_subject` varchar(50) NOT NULL,
  `call_date` date NOT NULL,
  `assistant_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `tbl_call`
--

INSERT INTO `tbl_call` (`call_id`, `call_status`, `call_startTime`, `call_finishTime`, `call_subject`, `call_date`, `assistant_id`, `customer_id`, `customer_name`) VALUES
(37, 'Completed', '00:03:00', '23:06:00', 'Fault', '2024-05-15', 11, 3, 'Usaid');

--
-- القوادح `tbl_call`
--
DELIMITER $$
CREATE TRIGGER `calculate_incentives_after_insert` AFTER INSERT ON `tbl_call` FOR EACH ROW BEGIN
    DECLARE daily_call_count INT;
    DECLARE daily_short_call_count INT;
    DECLARE monthly_base_incentive DECIMAL(10, 2);
    DECLARE daily_incentive DECIMAL(10, 2);

    -- Calculate daily call count and daily short call count
    SELECT COUNT(*), SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, NEW.call_startTime, NEW.call_finishTime) < 5 THEN 1 ELSE 0 END)
    INTO daily_call_count, daily_short_call_count
    FROM tbl_call
    WHERE assistant_id = NEW.assistant_id
    AND DATE(call_startTime) = DATE(NEW.call_startTime);

    -- Check if assistant received fewer than 100 calls per day
    IF daily_call_count < 100 THEN
        SET daily_incentive = 0;
    ELSE
        -- Calculate daily incentive based on call count and call duration
        IF daily_call_count <= 200 THEN
            SET daily_incentive = daily_short_call_count * 1.25;
        ELSE
            SET daily_incentive = daily_short_call_count * 2;
        END IF;
    END IF;

    -- Calculate monthly base incentive
    SET monthly_base_incentive = 5000;

    -- Insert or update reward for the assistant for the month
    INSERT INTO reward (assistant_id, reward_month, reward_amount, reward_comment)
    VALUES (NEW.assistant_id, MONTH(NEW.call_startTime),
            monthly_base_incentive + daily_incentive,
            CASE 
                WHEN daily_call_count < 100 THEN 'No incentive earned'
                ELSE CONCAT('Base incentive + ', daily_short_call_count, ' calls lasting less than 5 minutes')
            END)
    ON DUPLICATE KEY UPDATE
    reward_amount = monthly_base_incentive + daily_incentive,
    reward_comment = CASE 
                        WHEN daily_call_count < 100 THEN 'No incentive earned'
                        ELSE CONCAT('Base incentive + ', daily_short_call_count, ' calls lasting less than 5 minutes')
                    END;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- بنية الجدول `team`
--

CREATE TABLE `team` (
  `team_ID` int(11) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `team`
--

INSERT INTO `team` (`team_ID`, `team_name`, `creation_date`) VALUES
(1, 'veriTabani', '2024-05-09');

-- --------------------------------------------------------

--
-- بنية الجدول `team_leader`
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
-- إرجاع أو استيراد بيانات الجدول `team_leader`
--

INSERT INTO `team_leader` (`leader_id`, `team_ID`, `leader_firstName`, `leader_lastName`, `email`, `password`) VALUES
(1, 1, 'fatih', 'yucalar', 'fatih00@gmail.com', '12345678'),
(55, 1, 'leader', 'lastname', 'leader@leader.com', '12345678');

-- --------------------------------------------------------

--
-- Structure for view `call_details_view`
--
DROP TABLE IF EXISTS `call_details_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `call_details_view`  AS SELECT `c`.`customer_fullName` AS `customer_fullName`, `tc`.`call_subject` AS `call_subject`, `tc`.`call_date` AS `call_date`, `tc`.`call_startTime` AS `call_startTime`, `tc`.`call_finishTime` AS `call_finishTime`, `tc`.`call_status` AS `call_status` FROM ((`tbl_call` `tc` join `assistant` `a` on(`tc`.`assistant_id` = `a`.`assistant_id`)) join `customer` `c` on(`tc`.`customer_id` = `c`.`customer_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `objections_list_view`
--
DROP TABLE IF EXISTS `objections_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `objections_list_view`  AS SELECT `a`.`assistant_id` AS `assistant_id`, `a`.`assistant_fullName` AS `assistant_fullName`, `o`.`objection_id` AS `objection_id`, `o`.`objection_reason` AS `objection_reason`, `o`.`objection_month` AS `objection_month`, `o`.`objection_status` AS `objection_status` FROM ((`assistant` `a` join `team_leader` `tl` on(`a`.`team_ID` = `tl`.`team_ID`)) join `objection` `o` on(`a`.`assistant_id` = `o`.`assistant_id`)) WHERE `a`.`team_ID` = `tl`.`team_ID` ;

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
  ADD KEY `fk_asstant_id_in_objection` (`assistant_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`response_id`);

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
  ADD KEY `fk_CustomerID_tblCall` (`customer_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_ID`);

--
-- Indexes for table `team_leader`
--
ALTER TABLE `team_leader`
  ADD PRIMARY KEY (`leader_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `assistant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `objection`
--
ALTER TABLE `objection`
  MODIFY `objection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_call`
--
ALTER TABLE `tbl_call`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_leader`
--
ALTER TABLE `team_leader`
  MODIFY `leader_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `assistant`
--
ALTER TABLE `assistant`
  ADD CONSTRAINT `fk_team_ID_assistant` FOREIGN KEY (`team_ID`) REFERENCES `team` (`team_ID`);

--
-- قيود الجداول `objection`
--
ALTER TABLE `objection`
  ADD CONSTRAINT `fk_asstant_id_in_objection` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- قيود الجداول `reward`
--
ALTER TABLE `reward`
  ADD CONSTRAINT `fk_assistant_id_in_reward` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- قيود الجداول `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `fk_assistant_id_in_salary` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- قيود الجداول `tbl_call`
--
ALTER TABLE `tbl_call`
  ADD CONSTRAINT `fk_CustomerID_tblCall` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_assitantID_tblCall` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`);

--
-- قيود الجداول `team_leader`
--
ALTER TABLE `team_leader`
  ADD CONSTRAINT `fk_team_ID_team_leader` FOREIGN KEY (`team_ID`) REFERENCES `team` (`team_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
