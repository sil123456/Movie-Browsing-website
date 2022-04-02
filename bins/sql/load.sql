load data local infile './movie.del' into table Movie FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './actor1.del' into table Actor FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './actor2.del' into table Actor FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './actor3.del' into table Actor FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './moviegenre.del' into table MovieGenre FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './movieactor1.del' into table MovieActor FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';
load data local infile './movieactor2.del' into table MovieActor FIELDS TERMINATED BY ','  ENCLOSED BY '"' LINES TERMINATED BY '\n';