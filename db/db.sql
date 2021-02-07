-- Notes
-- Changed category to album
--- REFERENCES my not work with default see album

CREATE SCHEMA project01;

CREATE TYPE level AS ENUM ('1','2','3');

CREATE TABLE project01.user (
	userId SERIAL NOT NULL PRIMARY KEY,
	userName VARCHAR(60) NOT NULL,
	userEmail VARCHAR(60) NOT NULL,
	userPassword VARCHAR(255) NOT NULL,
	userLevel LEVEL NOT NULL DEFAULT '1',
	CONSTRAINT uk_userEmail UNIQUE (userEmail)
);

CREATE TABLE project01.album (
	albumId SERIAL NOT NULL PRIMARY KEY,
	userId INT NOT NULL REFERENCES project01.user(userId),
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

-- For testing

INSERT INTO project01.album (albumId, userId, albumParent, albumTitle, albumDescription, albumPrivate, albumShareKey, albumOrder) VALUES 
(1, 1, 0, 'Main', 'Main', 0, 'cd41294a-afb0-11df-bc9b-00241dd71234', 0),
(2, 1, 1, 'Child 1', 'Child of Main Private', 1, 'cd41294a-afb0-11df-bc9b-00241dd71235', 1),
(3, 1, 1, 'Child 2', 'Child of Main Password', 1, 'cd41294a-afb0-11df-bc9b-00241dd1236', 2), 
(4, 1, 1, 'Child 3', 'Child of Main Public', 0, 'cd41294a-afb0-11df-bc9b-00241dd71237', 3),
(5, 1, 4, 'Child 3.1', 'Child of Child', 0, 'cd41294a-afb0-11df-bc9b-00241dd7138', 1);

INSERT INTO project01.image (albumId, imageTitle, imageCaption, imageName, imagePrivate, imageShareKey, imageOrder) VALUES 
(2, 'Image A', 'Caption', 'image1.jpg', 0, '', 0),
(2, 'Image B', 'Caption', 'image2.jpg', 1, '', 0),
(3, 'Image 1', 'Caption', 'image3.jpg', 0, '', 0),
(3, 'Image 2', 'Caption', 'image4.jpg', 1, '', 0),
(4, 'Image B', 'Caption', 'image5.jpg', 0, '', 0),
(4, 'Image B', 'Caption', 'image6.jpg', 1, '', 0),
(5, 'Image 1', 'this is 2', 'image7.jpg', 0, '', 2),
(5, 'Image 2', 'this is 1', 'image8.jpg', 1, '', 1);