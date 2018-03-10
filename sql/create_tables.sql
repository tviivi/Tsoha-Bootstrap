-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY,
  nimi varchar(20) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Askare(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES kayttaja(id),
  nimi varchar(20) NOT NULL,
  tarkeys_aste INTEGER NOT NULL,
  luokka varchar(20) NOT NULL,
  suoritus varchar(20) NOT NULL
);

CREATE TABLE Luokka(
  id SERIAL PRIMARY KEY,
  nimi varchar (20) NOT NULL,
  askare varchar(20) NOT NULL
);

CREATE TABLE Viitetaulu(
  FOREIGN KEY(Askare) REFERENCES Askare(id),
  FOREIGN KEY(Luokka) REFERENCES Luokka(id)
);