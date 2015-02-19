DROP DATABASE IF EXISTS DB_MonsterPark ;
CREATE DATABASE DB_MonsterPark ;
USE DB_MonsterPark ;

DROP TABLE IF EXISTS Monster ;
CREATE TABLE Monster (
	IdMonster INT(10)  AUTO_INCREMENT NOT NULL,
	Name VARCHAR(20),
	Gender ENUM('F', 'M'),
	Age INT(5),
	Weight INT(5),
	DangerScale ENUM('INOFFENSIVE', 'AGGRESSIVE', 'DANGEROUS', 'MORTAL'),
	HealthState INT(10),
	HungerState INT(10),
	CleanScale INT(10),
	Regime ENUM('HERBIVORE', 'FRUITARIAN', 'PESCETARIAN', 'OMNIVOROUS', 'CARNIVORE'),
	enclosure_idenclosure INT(10),
	IdMaturity INT(10),
	player_idjoueur INT(10),
	PRIMARY KEY (IdMonster)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS SubSpecie ;
CREATE TABLE SubSpecie (
 	IdSubSpecie INT(10)  AUTO_INCREMENT NOT NULL,
	LibSubSpecie VARCHAR(20),
	LibHabitat VARCHAR(20),
	IdSpecie INT(10),
	PRIMARY KEY (IdSubSpecie)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Spiece ;
CREATE TABLE Spiece (
	IdSpecie INT(10)  AUTO_INCREMENT NOT NULL,
	LibSpecie VARCHAR(20),
	PRIMARY KEY (IdSpecie)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Element ;
CREATE TABLE Element (	
	IdElement INT(10)  AUTO_INCREMENT NOT NULL,
	LibElement VARCHAR(20),
	PRIMARY KEY (IdElement)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Enclosure ;
CREATE TABLE Enclosure (
	IdEnclosure INT(10)  AUTO_INCREMENT NOT NULL,
	TypeEnclos ENUM('BASIC', 'AVIARY', 'AQUARIUM'),
	CapacityMonster INT(10),
	Price INT(10),
	Climate ENUM('FOREST', 'VOLCANIC', 'ARID', 'TROPICAL', 'CAVERNOUS', 'MOUNTAINOUS', 'ARCTIc', 'ISLAND', 'OCEANIC'),
	IdSubSpecie INT(10),
	parc_idparc INT(10),
	PRIMARY KEY (IdEnclosure)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Player ;
CREATE TABLE Player (
	IdJoueur INT(10)  AUTO_INCREMENT NOT NULL,
	FirstName VARCHAR(20),
	LastName VARCHAR(20),
	GenderE ENUM('F', 'M'),
	BirthDate DATE,
	PhoneNumber VARCHAR(10),
	Description LONGTEXT,
	WebSite VARCHAR(200),
	ItemCapacity INT(10),
	Money INT(10),
	PRIMARY KEY (IdJoueur)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Item ;
CREATE TABLE Item (
	IdItem INT(10)  AUTO_INCREMENT NOT NULL,
	TypeItem ENUM('ENTRETIEN', 'FOOD', 'WEAPON', 'ARMOR'),
	LibItem VARCHAR(20),
	PrixItem INT(10),
	FamilyItem ENUM('CONSUMABLE', 'EQUIPMENT'),
	player_idjoueur INT(10) NOT NULL,
	IdQuest INT(10) NOT NULL,
	PRIMARY KEY (IdItem)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Account ;
CREATE TABLE Account (
	IdAccount INT(10)  AUTO_INCREMENT NOT NULL,
	Pseudo VARCHAR(20),
	Email VARCHAR(50),
	Password VARCHAR(20),
	IP VARCHAR(15),
	dateInscription DATETIME,
	PRIMARY KEY (IdAccount)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Transaction ;
CREATE TABLE Transaction (
	IdTransaction INT(10)  AUTO_INCREMENT NOT NULL,
	Amount INT(10),
	TransactionDate DATETIME,
	IdJoueur INT(10) NOT NULL,
	PRIMARY KEY (IdTransaction)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS News ;
CREATE TABLE News (
	IdNews INT(10)  AUTO_INCREMENT NOT NULL,
	Title VARCHAR(20),
	Picture VARCHAR(20),
	Content VARCHAR(200),
	IdNewspaper INT(10) NOT NULL,
	PRIMARY KEY (IdNews)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Quest ;
CREATE TABLE Quest (
	IdQuest INT(10)  AUTO_INCREMENT NOT NULL,
	Fee FLOAT(10),
	DateDeb DATE,
	Duration INT(5),
	IsCompleted BOOL,
	PRIMARY KEY (IdQuest)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Parc ;
CREATE TABLE Parc (IdParc INT(10)  AUTO_INCREMENT NOT NULL,
CapacityEnclosure INT(10),
player_idjoueur INT(10),
PRIMARY KEY (IdParc)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Maturity ;
CREATE TABLE Maturity (
	IdMaturity INT(10)  AUTO_INCREMENT NOT NULL,
	LevelMaturity INT(5),
	LibMaturity VARCHAR(20),
	TimeRequire INT(10),
	PRIMARY KEY (IdMaturity)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Newspapers ;
CREATE TABLE Newspapers (
	IdNewspaper INT(10)  AUTO_INCREMENT NOT NULL,
	Publication DATE,
	PRIMARY KEY (IdNewspaper)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS IsSubSpecies ;
CREATE TABLE IsSubSpecies (
	IdSubSpecie INT(10)  AUTO_INCREMENT NOT NULL,
	IdMonster INT(10) NOT NULL,
	PRIMARY KEY (IdSubSpecie, IdMonster)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS HaveElement ;
CREATE TABLE HaveElement (
	IdElement INT(10)  AUTO_INCREMENT NOT NULL,
	IdMonster INT(10) NOT NULL,
	PRIMARY KEY (IdElement, IdMonster)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS TakeCare ;
CREATE TABLE TakeCare (
	IdEnclosure INT(10)  AUTO_INCREMENT NOT NULL,
	IdJoueur INT(10) NOT NULL,
	PRIMARY KEY (IdEnclosure, IdJoueur)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Play ;
CREATE TABLE Play (
	IdJoueur INT(10)  AUTO_INCREMENT NOT NULL,
	IdAccount INT(10) NOT NULL,
	dateConnexion DATETIME,
	PRIMARY KEY (IdJoueur, IdAccount)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Particip ;
CREATE TABLE Particip (
	IdQuest INT(10)  AUTO_INCREMENT NOT NULL,
	IdJoueur INT(10) NOT NULL,
	ParticipCost INT(10),
	PRIMARY KEY (IdQuest, IdJoueur)
) ENGINE=InnoDB;

ALTER TABLE Monster ADD CONSTRAINT FK_Monster_enclosure_idenclosure FOREIGN KEY (enclosure_idenclosure) REFERENCES Enclosure (IdEnclosure);
ALTER TABLE Monster ADD CONSTRAINT FK_Monster_IdMaturity FOREIGN KEY (IdMaturity) REFERENCES Maturity (IdMaturity);
ALTER TABLE Monster ADD CONSTRAINT FK_Monster_player_idjoueur FOREIGN KEY (player_idjoueur) REFERENCES Player (IdJoueur);
ALTER TABLE SubSpecie ADD CONSTRAINT FK_SubSpecie_IdSpecie FOREIGN KEY (IdSpecie) REFERENCES Spiece (IdSpecie);
ALTER TABLE Enclosure ADD CONSTRAINT FK_Enclosure_IdSubSpecie FOREIGN KEY (IdSubSpecie) REFERENCES SubSpecie (IdSubSpecie);
ALTER TABLE Enclosure ADD CONSTRAINT FK_Enclosure_parc_idparc FOREIGN KEY (parc_idparc) REFERENCES Parc (IdParc);
ALTER TABLE Item ADD CONSTRAINT FK_Item_player_idjoueur FOREIGN KEY (player_idjoueur) REFERENCES Player (IdJoueur);
ALTER TABLE Item ADD CONSTRAINT FK_Item_IdQuest FOREIGN KEY (IdQuest) REFERENCES Quest (IdQuest);
ALTER TABLE Transaction ADD CONSTRAINT FK_Transaction_IdJoueur FOREIGN KEY (IdJoueur) REFERENCES Player (IdJoueur);
ALTER TABLE News ADD CONSTRAINT FK_News_IdNewspaper FOREIGN KEY (IdNewspaper) REFERENCES Newspapers (IdNewspaper);
ALTER TABLE Parc ADD CONSTRAINT FK_Parc_player_idjoueur FOREIGN KEY (player_idjoueur) REFERENCES Player (IdJoueur);
ALTER TABLE IsSubSpecies ADD CONSTRAINT FK_IsSubSpecies_IdSubSpecie FOREIGN KEY (IdSubSpecie) REFERENCES SubSpecie (IdSubSpecie);
ALTER TABLE IsSubSpecies ADD CONSTRAINT FK_IsSubSpecies_IdMonster FOREIGN KEY (IdMonster) REFERENCES Monster (IdMonster);
ALTER TABLE HaveElement ADD CONSTRAINT FK_HaveElement_IdElement FOREIGN KEY (IdElement) REFERENCES Element (IdElement);
ALTER TABLE HaveElement ADD CONSTRAINT FK_HaveElement_IdMonster FOREIGN KEY (IdMonster) REFERENCES Monster (IdMonster);
ALTER TABLE TakeCare ADD CONSTRAINT FK_TakeCare_IdEnclosure FOREIGN KEY (IdEnclosure) REFERENCES Enclosure (IdEnclosure);
ALTER TABLE TakeCare ADD CONSTRAINT FK_TakeCare_IdJoueur FOREIGN KEY (IdJoueur) REFERENCES Player (IdJoueur);
ALTER TABLE Play ADD CONSTRAINT FK_Play_IdJoueur FOREIGN KEY (IdJoueur) REFERENCES Player (IdJoueur);
ALTER TABLE Play ADD CONSTRAINT FK_Play_IdAccount FOREIGN KEY (IdAccount) REFERENCES Account (IdAccount);
ALTER TABLE Particip ADD CONSTRAINT FK_Particip_IdQuest FOREIGN KEY (IdQuest) REFERENCES Quest (IdQuest);
ALTER TABLE Particip ADD CONSTRAINT FK_Particip_IdJoueur FOREIGN KEY (IdJoueur) REFERENCES Player (IdJoueur);