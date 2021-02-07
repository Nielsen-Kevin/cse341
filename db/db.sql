-- Notes
-- Changed category to album
--- REFERENCES my not work with default see album

CREATE SCHEMA project01;

CREATE TYPE level AS ENUM ('1','2','3');

CREATE TABLE project01.user (
	user_id SERIAL NOT NULL PRIMARY KEY,
	user_name VARCHAR(60) NOT NULL,
	user_email VARCHAR(60) NOT NULL,
	user_password VARCHAR(255) NOT NULL,
	user_level LEVEL NOT NULL DEFAULT '1',
	CONSTRAINT uk_user_email UNIQUE (user_email)
);

CREATE TABLE project01.album (
	album_id SERIAL NOT NULL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES project01.user(user_id),
	album_parent INT NOT NULL DEFAULT 0,
	album_title VARCHAR(32) NOT NULL,
	album_description TEXT NOT NULL,
	album_private BOOLEAN NOT NULL,
	album_share_key CHAR(38) NOT NULL,
	album_order INT NOT NULL
);

CREATE TABLE project01.image (
	image_id SERIAL NOT NULL PRIMARY KEY,
	album_id INT NOT NULL REFERENCES project01.album(album_id),
	image_title VARCHAR(32) NOT NULL,
	image_caption VARCHAR(120) NOT NULL,
	image_name VARCHAR(150) NOT NULL,
	image_private BOOLEAN NOT NULL,
	image_share_key CHAR(38) NOT NULL,
	image_order INT NOT NULL
);

CREATE TABLE project01.access (
	access_id SERIAL NOT NULL PRIMARY KEY,
	album_id INT NOT NULL REFERENCES project01.album(album_id),
	password VARCHAR(255) NOT NULL
);

DROP TABLE project01.user CASCADE;
DROP TABLE project01.album CASCADE;
DROP TABLE project01.image CASCADE;
DROP TABLE project01.access CASCADE;

-- For testing

INSERT INTO project01.user (user_name, user_email, user_password, user_level) VALUES 
('Admin', 'admin@cit340.net', '$2y$10$JDQxSyXNKXEgrAPyGU65D.uvWKB7Ib51VABXFDnG/6V34G05rY0qS', '3'),
('Kevin', 'test@test.com', '$2y$10$iRbQOnHR0imEankQB2O/G.Shzu3keJZ0dPg9wZnSbouk3h6QUQbtC', '2');

INSERT INTO project01.album (album_id, user_id, album_parent, album_title, album_description, album_private, album_share_key, album_order) VALUES 
(1, 1, 0, 'Main', 'Main has 3 albums. Private ones need a Password.', false, 'cd41294a-afb0-11df-bc9b-00241dd71234', 0),
(2, 1, 1, 'Child 1 Private', 'Child of Main Private', true, 'cd41294a-afb0-11df-bc9b-00241dd71235', 1),
(3, 1, 1, 'Child 2 Password', 'Child of Main Password', true, 'cd41294a-afb0-11df-bc9b-00241dd1236', 2), 
(4, 1, 1, 'Child 3 Public', 'Child of Main Public: Show ability to childs in childs.', false, 'cd41294a-afb0-11df-bc9b-00241dd71237', 3),
(5, 1, 4, 'Child 3.1 Order By', 'Album Child of Child. Images shows ORDER BY working', false, 'cd41294a-afb0-11df-bc9b-00241dd7138', 1);

INSERT INTO project01.image (album_id, image_title, image_caption, image_name, image_private, image_share_key, image_order) VALUES 
(2, 'Image A', 'Image Caption', 'image1.jpg', false, '', 0),
(2, 'Image B', 'Image Caption', 'image2.jpg', false, '', 0),
(3, 'Image 1', 'Image Caption', 'image3.jpg', false, '', 0),
(3, 'Image 2', 'Image Caption', 'image4.jpg', false, '', 0),
(4, 'Image A', 'Image Caption', 'image5.jpg', false, '', 0),
(4, 'Image B', 'Image Caption', 'image6.jpg', true, '', 0),
(5, 'Image 1', 'this is 4a', 'image1.jpg', false, '', 4),
(5, 'Image 2', 'this is 4b', 'image2.jpg', true, '', 4),
(5, 'Image 3', 'this is 4c', 'image3.jpg', false, '', 4),
(5, 'Image 4', 'this is 3', 'image4.jpg', true, '', 3),
(5, 'Image 5', 'this is 2', 'image5.jpg', false, '', 2),
(5, 'Image 6', 'this is 1', 'image6.jpg', true, '', 1);

INSERT INTO project01.access (album_id, password) VALUES 
(3, 'demo'),
(2, 'test');