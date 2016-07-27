DROP DATABASE IF EXISTS vovoSite;
CREATE DATABASE vovoSite;

USE vovoSite;

CREATE TABLE USER (
email VARCHAR(60) NOT NULL,
name VARCHAR(200) NOT NULL,
sex ENUM ('WOMAN', 'MAN') NOT NULL,
password VARCHAR(500) NOT NULL,
birthdate DATE NOT NULL,
type ENUM('ADMINISTRATOR', 'STUDENT') NOT NULL DEFAULT 'STUDENT',
CONSTRAINT user_pk PRIMARY KEY(email)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE QUESTION (
identifier INT  NOT NULL AUTO_INCREMENT,
a VARCHAR(200) NOT NULL,
d VARCHAR(200) NOT NULL,
e VARCHAR(200) NOT NULL,
c VARCHAR(200) NOT NULL,
b VARCHAR(200) NOT NULL,
correct ENUM('A','B','C','D','E') NOT NULL,
enunciation VARCHAR(200) NOT NULL,
image VARCHAR(100) NULL,
email VARCHAR(60) NOT NULL,
CONSTRAINT question_pk PRIMARY KEY (identifier),
CONSTRAINT question_user_fk FOREIGN KEY(email) REFERENCES USER (email) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE CATEGORY (
identifier INT  NOT NULL AUTO_INCREMENT,
name VARCHAR(50) NOT NULL,
email VARCHAR(60) NOT NULL,
CONSTRAINT category_pk PRIMARY KEY (identifier),
CONSTRAINT category_user_fk FOREIGN KEY(email) REFERENCES USER (email) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE belongs (
identifier INT NOT NULL,
belongs_identifier INT NOT NULL,
CONSTRAINT belongs_uk UNIQUE(identifier, belongs_identifier),
CONSTRAINT category_belongs_fk FOREIGN KEY(identifier) REFERENCES CATEGORY (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT,
CONSTRAINT belongs_to_the_category_fk FOREIGN KEY(belongs_identifier) REFERENCES CATEGORY (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE VIDEO (
identifier INT  NOT NULL AUTO_INCREMENT,
link VARCHAR(200) NOT NULL,
position INT NOT NULL,
category_identifier INT NOT NULL,
CONSTRAINT video_pk PRIMARY KEY (identifier),
CONSTRAINT video_category_fk FOREIGN KEY(category_identifier) REFERENCES CATEGORY (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE has (
video_identifier INT NOT NULL,
question_identifier INT NOT NULL,
CONSTRAINT has_uk UNIQUE(video_identifier, question_identifier),
CONSTRAINT video_has_fk FOREIGN KEY(video_identifier) REFERENCES VIDEO (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT,
CONSTRAINT has_question_fk FOREIGN KEY(question_identifier) REFERENCES QUESTION (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE view (
identifier INT NOT NULL,
email VARCHAR(60) NOT NULL,
CONSTRAINT view_video_fk FOREIGN KEY(identifier) REFERENCES VIDEO (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT,
CONSTRAINT user_view_fk FOREIGN KEY(email) REFERENCES USER (email) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE upload (
email VARCHAR(60) NOT NULL,
identifier INT NOT NULL,
CONSTRAINT user_upload_fk FOREIGN KEY(email) REFERENCES USER (email) ON UPDATE RESTRICT ON DELETE RESTRICT,
CONSTRAINT upload_video FOREIGN KEY(identifier) REFERENCES VIDEO (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE answer (
isCorrect BOOLEAN NOT NULL,
identifier INT NOT NULL,
email VARCHAR(60) NOT NULL,
CONSTRAINT answer_uk UNIQUE(identifier, email),
CONSTRAINT answer_question_fk FOREIGN KEY(identifier) REFERENCES QUESTION (identifier) ON UPDATE RESTRICT ON DELETE RESTRICT,
CONSTRAINT user_answer_fk FOREIGN KEY(email) REFERENCES USER (email) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB CHARSET=utf8;


