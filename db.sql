DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `semester` INT NOT NULL
);
INSERT INTO `semester`(`semester`) VALUES(1),(2),(3);

DROP TABLE IF EXISTS `program`;
CREATE TABLE `program` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `program` VARCHAR(15),
    `descript` VARCHAR(50)
);
INSERT INTO `program`(`program`,`descript`) 
VALUES ('CILT', 'CERTIFICATE IN LOGISTICS AND TRANSPORT'),
		('DILT', 'DIPLOMA IN LOGISTICS AND TRANSPORT'),
        ('ADILT', 'ADAVANCED DIPLOMA IN LOGISTICS AND TRANSPORT');

DROP TABLE IF EXISTS `academic_year`;
CREATE TABLE `academic_year` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `start` INT NOT NULL, -- references tbl_users ID
    `end` INT NOT NULL, -- 1 for observation, 2 for incident
    `academic_year` VARCHAR(12) GENERATED ALWAYS AS (CONCAT(`start`,' - ',`end`)) STORED
);
INSERT INTO `academic_year`(`start`,`end`) VALUES (2020, 2021);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `acaid` INT NOT NULL,
    `semid` INT NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `todate` DATE NOT NULL,
    `threshold` DECIMAL(6,2) DEFAULT 0.0,
    `tres_type` VARCHAR(10) DEFAULT 'amount',
    `using` INT DEFAULT 1,
    `due_days` INT GENERATED ALWAYS AS (DATEDIFF(`end_date`,`start_date`)) STORED
);

DROP TABLE IF EXISTS `setted`;
CREATE TABLE `setted` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `set_later` INT DEFAULT 1,
    `later_date` DATE
);
INSERT INTO `setted`(`set_later`) VALUES(0);

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pid` INT NOT NULL,
    `fname` VARCHAR(50) NOT NULL,
    `mname` VARCHAR(50),
    `lname` VARCHAR(50) NOT NULL,
    `fullname` VARCHAR(100) GENERATED ALWAYS AS (CONCAT(`fname`, " ", `lname`)) STORED,
    `index` VARCHAR(20) NOT NULL,
    `password` TEXT DEFAULT '0de084f38ace8e3d82597f55cc6ad5d6001568e6',
    `type`  INT DEFAULT 2,
    `sem`  INT DEFAULT 1,
    `done`  INT DEFAULT 0,
    `deleted` INT DEFAULT 0,
    `added_at` DATETIME DEFAULT CURRENT_TIMESTAMP()
);

INSERT INTO `students` (`pid`, `fname`, `lname`, `index`, `password`, `type`)
VALUES(0,'Admin', 'Admin', 'info@admin.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1);

DROP TABLE IF EXISTS `secret_codes`;
CREATE TABLE `secret_codes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sid` INT NOT NULL,
    `set` INT NOT NULL,
    `permit` VARCHAR(15) NOT NULL,
    `qr_code` TEXT NOT NULL,
    `added_at` DATETIME DEFAULT CURRENT_TIMESTAMP()
);

DROP TABLE IF EXISTS `finance`;
CREATE TABLE `finance` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sid` INT NOT NULL,
    `set` INT NOT NULL,
    `balBF` DECIMAL(6,2) DEFAULT 0.0,
    `bill` DECIMAL(6,2) DEFAULT 0.0,
    `paid` DECIMAL(6,2) DEFAULT 0.0,
    `bal` DECIMAL(6,2) GENERATED ALWAYS AS ((`balBF` + `bill`) - `paid`) STORED,
    `added_at` DATETIME DEFAULT CURRENT_TIMESTAMP()
);

