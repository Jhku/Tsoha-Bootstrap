-- Lisää CREATE TABLE lauseet tähän tiedostoon

Create Table Kayttaja(
	KID SERIAL PRIMARY KEY,
	nimi varchar(16) NOT NULL,
	ssana varchar(16) NOT NULL
);

Create Table Muistutus(
	MID SERIAL PRIMARY KEY,
	kayttaja INTEGER REFERENCES Kayttaja(KID),
	Kategoria varchar(50),
	Prioriteetti INTEGER,
	Muistutus varchar(200) NOT NULL 	
);

Create Table Linkki(
	LID SERIAL PRIMARY KEY,
	muistutus INTEGER REFERENCES Muistutus(MID),
	Aihe varchar(50),
	Osoite varchar(100)
);
