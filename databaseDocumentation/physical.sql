DROP DATABASE IF EXISTS vovoSite;
CREATE DATABASE vovoSite;

USE vovoSite;

CREATE TABLE USER (
email VARCHAR(60) PRIMARY KEY,
name VARCHAR(200),
sex ENUM ('WOMAN', 'MAN'),
password VARCHAR(500),
birthdate DATE,
type ENUM('ADMINISTRATOR', 'STUDENT')
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE QUESTION (
a VARCHAR(200),
d VARCHAR(200),
e VARCHAR(200),
c VARCHAR(200),
b VARCHAR(200),
correct ENUM('A','B','C','D','E'),
enunciation VARCHAR(200),
image VARCHAR(100),
identifier INT PRIMARY KEY,
email VARCHAR(60),
FOREIGN KEY(email) REFERENCES USER (email)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE CATEGORY (
name VARCHAR(50),
identifier INT PRIMARY KEY,
email VARCHAR(60),
FOREIGN KEY(email) REFERENCES USER (email)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE belongs (
identifier INT,
possui_identifier INT,
FOREIGN KEY(identifier) REFERENCES CATEGORY (identifier),
FOREIGN KEY(possui_identifier) REFERENCES CATEGORY (identifier)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE VIDEO (
link VARCHAR(200),
identifier INT PRIMARY KEY,
position INT,
category_identifier INT,
FOREIGN KEY(category_identifier) REFERENCES CATEGORY (identifier)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE has (
video_identifier INT,
question_identifier INT,
FOREIGN KEY(video_identifier) REFERENCES VIDEO (identifier),
FOREIGN KEY(question_identifier) REFERENCES QUESTION (identifier)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE view (
identifier INT,
email VARCHAR(60),
FOREIGN KEY(identifier) REFERENCES VIDEO (identifier),
FOREIGN KEY(email) REFERENCES USER (email)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE charge (
email VARCHAR(60),
identifier INT,
FOREIGN KEY(email) REFERENCES USER (email),
FOREIGN KEY(identifier) REFERENCES VIDEO (identifier)
) ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE answer (
isCorrect BOOLEAN,
identifier INT,
email VARCHAR(60),
FOREIGN KEY(identifier) REFERENCES QUESTION (identifier),
FOREIGN KEY(email) REFERENCES USER (email)
) ENGINE = InnoDB CHARSET=utf8;


