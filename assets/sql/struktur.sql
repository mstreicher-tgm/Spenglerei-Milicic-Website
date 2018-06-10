CREATE DATABASE milicic;
USE milicic;

CREATE TABLE standort (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  titel varchar(255) NULL,
  email text NOT NULL,
  addresse text NOT NULL,
  telefon text NOT NULL,
  fax text NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE person (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  titel varchar(255) NULL,
  vorname varchar(255) NOT NULL,
  nachname varchar(255) NOT NULL,
  geburtsdatum varchar(255) NULL,
  email text NOT NULL,
  beschreibung text NOT NULL,
  ausbildung text NULL,
  standort INT unsigned NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(standort) REFERENCES standort(id)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE einstellung (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  firmenname varchar(255) NOT NULL,
  beschreibung text NOT NULL,
  impressum text NOT NULL,
  hinweise text NOT NULL,
  headerfarbe varchar(255) NOT NULL,
  footerfarbe varchar(255) NOT NULL,
  akzentfarbe varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE userdata (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  passwort varchar(255) NOT NULL,
  status boolean NOT NULL,
  eigentümer boolean NOT NULL,
  PRIMARY KEY (id), UNIQUE (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bild (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  quelle text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE farbe (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  hexcode varchar(255) NOT NULL,
  PRIMARY KEY (id), UNIQUE (name), UNIQUE (hexcode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE blog (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  titel varchar(255) NOT NULL,
  inhalt text NOT NULL,
  bild INT unsigned NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(bild) REFERENCES bild(id)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
