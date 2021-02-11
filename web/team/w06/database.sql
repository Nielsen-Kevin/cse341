CREATE SCHEMA team06;

CREATE TABLE team06.scriptures (
  id SERIAL NOT NULL PRIMARY KEY,
  book VARCHAR(30) NOT NULL,
  chapter INT NOT NULL,
  verse INT NOT NULL,
  content TEXT
);

INSERT INTO team06.scriptures (book, chapter, verse, content) VALUES 
('John', 1, 5, 'And the light shineth in darkenss; and the darkness comprehended it not.'), 
('Doctrine and Covenants', 88, 49, 'The light shineth in darkness, and the darkness comprehendeth it not; nevertheless, the day shall come when you shall comprehend even God, being quickened in him and by him.'),
('Doctrine and Covenants', 93, 28, 'He that keepeth his commandments receiveth truth and light, until he is glorified in truth and knoweth all things.'),
('Mosiah', 16, 9, 'He is the light and the life of the world; yea, a light that is endless, that can never be darkened; yea, and also a life which is endless, that there can be no more death.');


-- Create a table called topic
-- with two columns: id and name.
CREATE TABLE team06.topic (
  id SERIAL PRIMARY KEY NOT NULL,
  name VARCHAR(30) NOT NULL
);

-- Add 3 topics
INSERT INTO team06.topic (name) VALUES 
('Faith'), ('Sacrifice'), ('Charity');

-- Create another table to link scriptures to topics.
CREATE TABLE team06.scripture_topic (
  scripture_id INT NOT NULL REFERENCES team06.scriptures(id),
  topic_id INT NOT NULL REFERENCES team06.topic(id)
);