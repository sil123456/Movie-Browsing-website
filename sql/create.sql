CREATE TABLE Movie(
	id INT,
	title VARCHAR(100),
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY (id)
);

CREATE TABLE Actor(
	id INT,
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE,
	dod DATE,
	PRIMARY KEY (id)
);

CREATE TABLE MovieGenre(
	mid INT,
	genre VARCHAR(20)
);

CREATE TABLE MovieActor(
	mid INT,
	aid INT,
	role VARCHAR(50)
);

CREATE TABLE Review(
	name VARCHAR(20),
	time DATETIME,
	mid INT,
	rating INT,
	comment TEXT
);


