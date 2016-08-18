-- Lisää CREATE TABLE lauseet tähän tiedostoon

Create Table Kayttaja(
	KID SERIAL PRIMARY KEY,
	nimi varchar(16) NOT NULL,
	ssana varchar(16) NOT NULL
);

Create Table Muistutus(
	MID SERIAL PRIMARY KEY,
	kayttaja INTEGER REFERENCES Kayttaja(KID),
	Kategoria varchar(25),
	Prioriteetti INTEGER DEFAULT 5 CHECK (6 > Prioriteetti AND Prioriteetti > 0),
	Info varchar(35),
	Suoritettu boolean DEFAULT FALSE,
	Muistutus varchar(500)	
);

Create Table Linkki(
	LID SERIAL PRIMARY KEY,
	muistutus INTEGER REFERENCES Muistutus(MID),
	Aihe varchar(50),
	Osoite varchar(100) NOT NULL
);
