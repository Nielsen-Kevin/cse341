CREATE SCHEMA team04; 

CREATE TABLE team04.user (
 name VARCHAR(26) NOT NULL, 
 userID SERIAL NOT NULL PRIMARY KEY,
 password VARCHAR(26) NOT NULL
 );

CREATE TABLE team04.speaker (
 speakerID SERIAL NOT NULL PRIMARY KEY,
 name VARCHAR(26) NOT NULL
 );

CREATE TABLE team04.conference (
 conferenceID SERIAL NOT NULL PRIMARY KEY,
 year SMALLINT NOT NULL,
 isSpring BOOLEAN NOT NULL,
 isMorning BOOLEAN NOT NULL,
 isSaturday BOOLEAN NOT NULL,
 isWomen BOOLEAN NOT NULL,
 isMen BOOLEAN NOT NULL
);

CREATE TABLE team04.notes (
  noteID SERIAL NOT NULL PRIMARY KEY,
  userID INT NOT NULL REFERENCES team04.user(userID),
  speakerID INT NOT NULL REFERENCES team04.speaker(speakerID),
  conferenceID INT NOT NULL REFERENCES team04.conference(conferenceID),
  content TEXT NOT NULL
);