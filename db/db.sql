-- Notes
-- Changed category to album
--- REFERENCES my not work with default see album

CREATE SCHEMA project01;

CREATE TYPE level AS ENUM ('1','2','3');

CREATE TABLE project01.user (
	userID SERIAL NOT NULL PRIMARY KEY,
	userName VARCHAR(60) NOT NULL,
	userEmail VARCHAR(60) NOT NULL,
	userPassword VARCHAR(255) NOT NULL,
	userLevel LEVEL NOT NULL DEFAULT '1',
	CONSTRAINT uk_userEmail UNIQUE (userEmail)
);

CREATE TABLE project01.album (
	albumId SERIAL NOT NULL PRIMARY KEY,
	userID INT NOT NULL REFERENCES project01.user(userID),
	albumParent INT NOT NULL REFERENCES project01.album(albumId) DEFAULT 0,
	albumTitle VARCHAR(32) NOT NULL,
	albumDescription TEXT NOT NULL,
	albumPrivate BOOLEAN NOT NULL,
	albumShareKey CHAR(38) NOT NULL,
	albumOrder INT NOT NULL
);

CREATE TABLE project01.image (
	imageId SERIAL NOT NULL PRIMARY KEY,
	albumId INT NOT NULL REFERENCES project01.album(albumId),
	imageTitle VARCHAR(32) NOT NULL,
	imageCaption VARCHAR(120) NOT NULL,
	imageName VARCHAR(150) NOT NULL,
	imagePrivate BOOLEAN NOT NULL,
	imageShareKey CHAR(38) NOT NULL,
	imageOrder INT NOT NULL
);

CREATE TABLE project01.access (
	accessId SERIAL NOT NULL PRIMARY KEY,
	albumId INT NOT NULL REFERENCES project01.album(albumId),
	password VARCHAR(255) NOT NULL
);