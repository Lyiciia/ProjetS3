DROP TABLE if exists joueur;
DROP TABLE if exists club;

CREATE TABLE club(
    idClub INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomClub VARCHAR(255),
    villeClub VARCHAR(255)
)ENGINE=InnoDB;

CREATE TABLE joueur
(
    idJoueur INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomJoueur VARCHAR(255),
    prenomJoueur VARCHAR(255),
    tailleJoueur NUMERIC(4,2),
    dateNaissJoueur DATE,
    idClub INT, 
    FOREIGN KEY (idClub) REFERENCES club(idClub)
)ENGINE=InnoDB;

INSERT INTO club (idClub, nomClub, villeClub) VALUES (NULL, 'Paris SG', 'Paris');
INSERT INTO club (idClub, nomClub, villeClub) VALUES (NULL, 'Chelsea', 'Londres');
INSERT INTO club (idClub, nomClub, villeClub) VALUES (NULL, 'FC Barcelona', 'Barcelone');

INSERT INTO joueur VALUES (NULL, 'Hazard', 'Eden', 1.73, '1991-01-07', 2);
INSERT INTO joueur VALUES (NULL, 'Messi', 'Lionel', 1.70, '1987-06-24', 3);
INSERT INTO joueur VALUES (NULL, 'Matuidi', 'Blaise', 1.78, '1987-04-09', 1);
INSERT INTO joueur VALUES (NULL, 'Fabregas', 'Cesc', 1.75, '1987-05-04', 2);
INSERT INTO joueur VALUES (NULL, 'Courtois', 'Thibaut', 1.99, '1992-05-11', 3);
INSERT INTO joueur VALUES (NULL, 'Pique', 'Gerard', 1.94, '1987-02-02', 1);
INSERT INTO joueur VALUES (NULL, 'Terry', 'John', 1.87, '1980-12-07', 2);
INSERT INTO joueur VALUES (NULL, 'Ibrahimovic', 'Zlatan', 1.95, '1981-10-03', 1);
INSERT INTO joueur VALUES (NULL, 'Cahill', 'Gary', 1.93, '1985-12-19', 2);
INSERT INTO joueur VALUES (NULL, 'Rakitic', 'Ivan', 1.84, '1988-04-10', 3);
INSERT INTO joueur VALUES (NULL, 'Digne', 'Lucas', 1.78, '1993-01-20', 1);
INSERT INTO joueur VALUES (NULL, 'Suarez', 'Luis', 1.82, '1987-01-24', 3);
