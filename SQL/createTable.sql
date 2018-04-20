CREATE TABLE `Admin`(
    `id_admin` VARCHAR(16),
    `hashed_pass` CHAR(16) NOT NULL,
     PRIMARY KEY(`id_admin`)
); CREATE TABLE `Board`(
    `id_board` VARCHAR(5),
    `name` VARCHAR(20) NOT NULL,
    `max_thread` INT NOT NULL,
    `id_admin` VARCHAR(16) NOT NULL REFERENCES `Admin`(`id_admin`),
    PRIMARY KEY(`id_board`)
); CREATE TABLE Thread(
    id_thread INT UNSIGNED AUTO_INCREMENT,
    id_board VARCHAR(5) NOT NULL REFERENCES Board(id_board),
    max_post INT DEFAULT 500 NOT NULL,
    creation_date DATETIME NOT NULL,
    subject VARCHAR(50) NOT NULL,
	sticky BOOLEAN DEFAULT FALSE,
	num_of_report INT UNSIGNED DEFAULT 0,
	is_archieved BOOLEAN DEFAULT FALSE,
	last_bump DATETIME NOT NULL,
	PRIMARY KEY (id_thread)
); CREATE TABLE Poster(
    id_poster CHAR(8),
    id_thread INT NOT NULL REFERENCES Thread(id_thread),
    session_id VARCHAR(26) NOT NULL,
	PRIMARY KEY(id_poster, id_thread)
); CREATE TABLE Post(
    id_post INT UNSIGNED AUTO_INCREMENT,
    id_thread INT NOT NULL REFERENCES Thread(id_thread),
	id_poster CHAR(8) REFERENCEs Poster(id_poster),
	reply_no INT NOT NULL,
	poster_name VARCHAR(16) DEFAULT "Anon",
	trip_code VARCHAR(16) DEFAULT NULL,
    comment VARCHAR(500) NOT NULL,
    image CHAR(16), 
	num_of_report INT UNSIGNED DEFAULT 0,
	PRIMARY KEY (id_post)
);