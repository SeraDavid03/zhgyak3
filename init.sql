DROP SCHEMA IF EXISTS init;
CREATE SCHEMA init DEFAULT character SET
utf8 COLLATE utf8_unicode_ci;
USE init;

CREATE TABLE varos (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nev VARCHAR(255),
	lakossag FLOAT,
    atlaghomerseklet FLOAT
);

CREATE TABLE homerseklet (
	id INT PRIMARY KEY AUTO_INCREMENT,
    datum DATE,
    homerseklet FLOAT,
    varosid INT,
    CONSTRAINT FK_varos_homerseklet FOREIGN KEY (varosid)
    REFERENCES varos(id)
);

INSERT INTO varos(nev, lakossag, atlaghomerseklet) VALUES ('London', '8.9', '9.50');
INSERT INTO varos(nev, lakossag, atlaghomerseklet) VALUES ('Párizs', '2.1', '0.00');
INSERT INTO varos(nev, lakossag, atlaghomerseklet) VALUES ('Budapest', '1.7', '6.00');

INSERT INTO homerseklet (datum, homerseklet, varosid) VALUES ('2024-11-18', '10', '1');
INSERT INTO homerseklet (datum, homerseklet, varosid) VALUES ('2024-11-20', '9', '1');
INSERT INTO homerseklet (datum, homerseklet, varosid) VALUES ('2024-11-18', '5', '3');
INSERT INTO homerseklet (datum, homerseklet, varosid) VALUES ('2024-11-19', '7', '3');
INSERT INTO homerseklet (datum, homerseklet, varosid) VALUES ('2024-11-20', '6', '3');

SELECT * FROM varos;