/**
 * Database creation script
 * Author: Tom Abao
 * Date Created: May 16, 2016
 * Description: This script currently utilizes sqlite commands
 * http://php.net/manual/en/language.operators.execution.php
 */


CREATE TABLE IF NOT EXISTS `notes` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`title` VARCHAR NOT NULL,
	`details` VARCHAR,
	`status` INTEGER NOT NULL,
	`dateMade` VARCHAR NOT NULL,
	`dateDue` VARCHAR,
	`category` VARCHAR
);

-- INSERT INTO `notes` (`title`,`status`,`dateMade`) VALUES ("Hello world",1,date('now'));