-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (nimi, password) VALUES ('Viivi', 'salasana');
INSERT INTO Kayttaja (nimi, password) VALUES ('Henkilo', 'toinensalasana');
INSERT INTO Askare (nimi, tarkeys_aste, luokka, suoritus) VALUES ('imurointi', 3, 'kotityot', 'done');
INSERT INTO Askare (nimi, tarkeys_aste, luokka, suoritus) VALUES ('läksyt', 1, 'koulujutut', 'done');
INSERT INTO Luokka (nimi, askare) VALUES ('kotityöt', 'tiskaus');
INSERT INTO Kayttaja (nimi, password) VALUES ('testikäyttajä', 'testisalasana');