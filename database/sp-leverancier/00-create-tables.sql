-- 1. Database aanmaken en selecteren
-- DROP DATABASE IF EXISTS Voedselbank_2;
-- CREATE DATABASE Voedselbank_2;
USE Voedselbank_2;

-- 2. Verwijder tabellen in de juiste volgorde (indien ze bestaan)

DROP TABLE IF EXISTS AllergiePerPersoon;
DROP TABLE IF EXISTS Allergie;
DROP TABLE IF EXISTS EetwensPerGezin;  
DROP TABLE IF EXISTS Eetwens;
DROP TABLE IF EXISTS ProductPerVoedselPakket;
DROP TABLE IF EXISTS Voedselpakket;
DROP TABLE IF EXISTS ProductPerMagazijn;
DROP TABLE IF EXISTS ProductPerLeverancier;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS AllergiePerPersoon;
DROP TABLE IF EXISTS Allergie;
DROP TABLE IF EXISTS Persoon;
DROP TABLE IF EXISTS Gezin;
DROP TABLE IF EXISTS ContactPerLeverancier;
DROP TABLE IF EXISTS Contact;
DROP TABLE IF EXISTS Leverancier;

-- 3. Tabel: Leverancier
CREATE TABLE Leverancier (
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Naam                VARCHAR(100) NOT NULL,
    ContactPersoon      VARCHAR(100) NOT NULL,
    LeverancierNummer   VARCHAR(10) NOT NULL,
    LeverancierType     VARCHAR(50) NOT NULL,
    IsActive            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT NOW(6)
) ENGINE=InnoDB;

INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, LeverancierType) VALUES
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf'),
(2, 'Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling'),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid'),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier'),
(5, 'Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor'),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf'),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf'),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid');

-- 4. Tabel: Contact
CREATE TABLE Contact (
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Straat              VARCHAR(100) NOT NULL,
    Huisnummer          INT NOT NULL,
    Toevoeging          VARCHAR(10) NULL,
    Postcode            VARCHAR(10) NOT NULL,
    Woonplaats          VARCHAR(50) NOT NULL,
    Email               VARCHAR(100) NOT NULL,
    Mobiel              VARCHAR(20) NOT NULL,
    IsActive            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT NOW(6)
) ENGINE=InnoDB;

INSERT INTO Contact (Id, Straat, Huisnummer, Toevoeging, Postcode, Woonplaats, Email, Mobiel) VALUES
(1, 'Prinses Irenestraat', 12, 'A', '5271TH', 'Maaskantje', 'j.van.zevenhuizen@gmail.com', '+31 623456123'),
(2, 'Gibraltarstraat', 234, NULL, '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123'),
(7, 'Siegfried Knutsenlaan', 234, NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123'),
(8, 'Theo de Bokstraat', 256, NULL, '5271ZH', 'Maaskantje', 'l.pastoor@gmail.com', '+31 623456123'),
(9, 'Meester van Leerhof', 2, 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123'),
(10, 'Van Wemelenplantsoen', 300, NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123'),
(11, 'Terlingenhof', 20, NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356'),
(12, 'Veldhoen', 31, NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314'),
(13, 'ScheringaDreef', 37, NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314');

-- 5. Tabel: ContactPerLeverancier
CREATE TABLE ContactPerLeverancier (
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    LeverancierId       INT UNSIGNED NOT NULL,
    ContactId           INT UNSIGNED NOT NULL,
    IsActive            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT NOW(6),
    CONSTRAINT FK_CPL_Leverancier FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),
    CONSTRAINT FK_CPL_Contact     FOREIGN KEY (ContactId)     REFERENCES Contact(Id)
) ENGINE=InnoDB;

INSERT INTO ContactPerLeverancier (LeverancierId, ContactId) VALUES
(1, 7), (2, 8), (3, 9), (4, 10), (6, 11), (7, 12), (8, 13);

-- 6. Tabel: Categorie
CREATE TABLE Categorie (
    Id MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
    Naam VARCHAR(10) NOT NULL,
    Omschrijving VARCHAR(255),
    isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NULL DEFAULT NOW(6)
) ENGINE=InnoDB;

INSERT INTO Categorie (Id, Naam, Omschrijving) VALUES
(1, 'AGF', 'Aardappelen groente en fruit'),
(2, 'KV', 'Kaas en vleeswaren'),
(3, 'ZPE', 'Zuivel plantaardig en eieren'),
(4, 'BB', 'Bakkerij en Banket'),
(5, 'FSKT', 'Frisdrank, sap, koffie/thee'),
(6, 'PRW', 'Pasta, rijst en wereldkeuken'),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie'),
(8, 'SKCC', 'Snoep, koek, chips en chocolade'),
(9, 'BVH', 'Baby, verzorging en hygiÃ«ne');

-- 7. Tabel: Product
CREATE TABLE Product (
    Id MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
    CategorieId MEDIUMINT UNSIGNED NOT NULL,
    Naam VARCHAR(25) NOT NULL,
    SoortAllergie VARCHAR(50) NULL,
    Barcode VARCHAR(20) NOT NULL UNIQUE,
    Houdbaarheidsdatum DATE NOT NULL,
    Omschrijving VARCHAR(150) NULL,
    Status VARCHAR(50) NOT NULL,
    isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NULL DEFAULT NOW(6),
    CONSTRAINT FK_Product_Categorie FOREIGN KEY (CategorieId) REFERENCES Categorie(Id),
    CHECK (Status IN ('OpVoorraad', 'NietOpVoorraad', 'NietLeverbaar'))
) ENGINE=InnoDB;

INSERT INTO Product (Id, CategorieId, Naam, SoortAllergie, Barcode, Houdbaarheidsdatum, Omschrijving, Status) VALUES
(1, 1, 'Aardappel', NULL, '8719587321239', '2026-04-15', 'Kruimige aardappel', 'OpVoorraad'),
(2, 1, 'Ui', NULL, '8719437321335', '2026-04-12', 'Gele ui', 'NietOpVoorraad'),
(3, 2, 'Kaas', 'Lactose', '8719487421338', '2026-04-17', 'Jonge Kaas', 'OpVoorraad'),
(4, 2, 'Rosbief', NULL, '8719487421331', '2026-04-16', 'Rundvlees', 'OpVoorraad'),
(5, 3, 'Melk', 'Lactose', '8719487321332', '2026-04-14', 'Halfvolle melk', 'OpVoorraad'),
(6, 3, 'Margarine', NULL, '8719486321336', '2026-04-13', 'Plantaardige boter', 'OpVoorraad'),
(7, 3, 'Ei', 'Eier', '8719487321344', '2026-04-15', 'Scharrel ei', 'OpVoorraad'),
(8, 4, 'Brood', 'Gluten', '8719877211337', '2026-04-11', 'Volkoren brood', 'OpVoorraad'),
(9, 4, 'Gevulde Koek', 'Amandel', '8719833211332', '2026-04-12', 'Banketbakkers kwaliteit', 'OpVoorraad'),
(10, 5, 'Fristi', 'Lactose', '8719871211331', '2026-04-17', 'Frisdrank', 'NietOpVoorraad'),
(11, 5, 'Appelsap', NULL, '8719875211335', '2026-04-16', '100% vruchtensap', 'OpVoorraad'),
(12, 6, 'Pasta', 'Gluten', '8719487321334', '2026-04-14', 'Macaroni', 'NietLeverbaar'),
(13, 6, 'Rijst', NULL, '8719487531335', '2026-04-13', 'Basmati Rijst', 'OpVoorraad'),
(14, 6, 'Knorr Nasi Mix', NULL, '8719487351353', '2026-04-15', 'Nasi kruiden', 'OpVoorraad'),
(15, 7, 'Tomatensoep', NULL, '8719487321337', '2026-04-11', 'Romige tomatensoep', 'OpVoorraad'),
(16, 7, 'Tomatensaus', NULL, '8719487321339', '2026-04-12', 'Pizza saus', 'NietOpVoorraad'),
(17, 7, 'Peterselie', NULL, '8719487321646', '2026-04-14', 'Verse kruidenpot', 'OpVoorraad'),
(18, 7, 'Olie', NULL, '8719873272337', '2026-04-17', 'Olijfolie', 'OpVoorraad'),
(19, 8, 'Mars', NULL, '8719873243434', '2026-04-13', 'Snoep', 'OpVoorraad'),
(20, 8, 'Biscuit', NULL, '8719873111331', '2026-04-15', 'San Francisco biscuit', 'OpVoorraad'),
(21, 8, 'Paprika Chips', NULL, '8719873218398', '2026-04-16', 'Ribbelchips paprika', 'OpVoorraad'),
(22, 8, 'Chocolade reep', 'Cacoa', '8719873215333', '2026-04-17', 'Tony Chocolonely', 'OpVoorraad');

-- 8. Tabel: ProductPerLeverancier
CREATE TABLE ProductPerLeverancier (
    Id                          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    LeverancierId               INT UNSIGNED NOT NULL,
    ProductId                   MEDIUMINT UNSIGNED NOT NULL,
    DatumAangeleverd            DATE NOT NULL,
    DatumEerstVolgendeLevering  DATE NOT NULL,
    IsActive                    BIT NOT NULL DEFAULT 1,
    Opmerking                   VARCHAR(255) NULL,
    DatumAangemaakt             DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd              DATETIME(6) NOT NULL DEFAULT NOW(6),

    CONSTRAINT FK_PPL_Leverancier
        FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),

    CONSTRAINT FK_PPL_Product
        FOREIGN KEY (ProductId) REFERENCES Product(Id)
) ENGINE=InnoDB;

INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumAangeleverd, DatumEerstVolgendeLevering) VALUES
(4, 1, '2026-03-12', '2026-05-15'), (4, 2, '2026-04-02', '2026-05-05'), (2, 3, '2026-03-16', '2026-05-18'),
(1, 4, '2026-04-08', '2026-05-11'), (4, 5, '2026-04-06', '2026-05-10'), (1, 6, '2026-03-12', '2026-05-15'),
(4, 7, '2026-03-20', '2026-05-21'), (4, 8, '2026-04-02', '2026-05-08'), (4, 9, '2026-04-04', '2026-05-09'),
(3, 10, '2026-04-07', '2026-05-11'), (3, 11, '2026-04-01', '2026-05-06'), (3, 12, '2026-03-18', '2026-05-20'),
(3, 13, '2026-03-19', '2026-05-20'), (2, 14, '2026-04-10', '2026-05-12'), (2, 15, '2026-03-13', '2026-05-15'),
(1, 16, '2026-03-18', '2026-05-21'), (1, 17, '2026-03-11', '2026-05-15'), (1, 18, '2026-04-02', '2026-05-06'),
(1, 19, '2026-04-09', '2026-05-12'), (4, 20, '2026-04-03', '2026-05-06'), (2, 21, '2026-04-02', '2026-05-08'),
(1, 22, '2026-03-16', '2026-05-19');

-- 9. Tabel: Gezin
CREATE TABLE Gezin (
    Id INT NOT NULL PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Code VARCHAR(10) NOT NULL,
    Omschrijving VARCHAR(100) NOT NULL,
    AantalVolwassenen INT NOT NULL,
    AantalKinderen INT NOT NULL,
    AantalBabys INT NOT NULL,
    TotaalAantalPersonen INT NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO Gezin (Id, Naam, Code, Omschrijving, AantalVolwassenen, AantalKinderen, AantalBabys, TotaalAantalPersonen) VALUES
(1, 'ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4),
(2, 'BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4),
(3, 'HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2),
(4, 'ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 0, 2, 3),
(5, 'DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2),
(6, 'VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1);

-- 10. Tabel: Persoon
CREATE TABLE Persoon (
    Id INT NOT NULL PRIMARY KEY,
    GezinId INT NULL,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(20) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Geboortedatum DATE NOT NULL,
    TypePersoon VARCHAR(20) NOT NULL,
    IsVertegenwoordiger BIT NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_Persoon_Gezin FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
) ENGINE=InnoDB;

INSERT INTO Persoon (Id, GezinId, Voornaam, Tussenvoegsel, Achternaam, Geboortedatum, TypePersoon, IsVertegenwoordiger) VALUES
(1, NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', 0),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', 1),
(8, 2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', 1),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', 1),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', 1),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', 1),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', 1);

-- 11. Tabel: Voedselpakket
CREATE TABLE Voedselpakket (
    Id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    GezinId INT NOT NULL,
    PakketNummer SMALLINT UNSIGNED NOT NULL,
    DatumSamenstelling DATE NOT NULL DEFAULT (CURRENT_DATE),
    DatumUitgifte DATE NULL,
    Status VARCHAR(50) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6),
    PRIMARY KEY (Id),
    CONSTRAINT FK_Voedselpakket_Gezin FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
) ENGINE=InnoDB;

INSERT INTO Voedselpakket (GezinId, PakketNummer, DatumSamenstelling, DatumUitgifte, Status) VALUES
(1, 1, '2026-03-21', '2026-03-21', 'Uitgereikt'),
(1, 2, '2026-03-19', NULL, 'NietUitgereikt'),
(2, 4, '2026-03-10', '2026-03-14', 'Uitgereikt');

-- 12. Tabel: ProductPerVoedselPakket
CREATE TABLE ProductPerVoedselPakket (
    Id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    VoedselpakketId INT UNSIGNED NOT NULL,
    ProductId MEDIUMINT UNSIGNED NOT NULL,
    AantalProductEenheden INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6),
    PRIMARY KEY (Id),
    CONSTRAINT FK_PPVP_Voedselpakket FOREIGN KEY (VoedselpakketId) REFERENCES Voedselpakket(Id),
    CONSTRAINT FK_PPVP_Product FOREIGN KEY (ProductId) REFERENCES Product(Id)
) ENGINE=InnoDB;

INSERT INTO ProductPerVoedselPakket (VoedselpakketId, ProductId, AantalProductEenheden) VALUES
(1, 7, 1), (1, 8, 2), (2, 12, 1), (3, 3, 1);

CREATE TABLE Eetwens (
    Id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6),
    PRIMARY KEY (Id)
) ENGINE=InnoDB;

INSERT INTO Eetwens (Id, Naam, Omschrijving) VALUES
(1, 'GeenVarken', 'Geen Varkensvlees'),
(2, 'Veganistisch', 'Geen zuivelproducten en vlees'),
(3, 'Vegetarisch', 'Geen vlees'),
(4, 'Omnivoor', 'Geen beperkingen');

-- 4. Tabel: EetwensPerGezin
CREATE TABLE EetwensPerGezin (
    Id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    GezinId INT NOT NULL,
    EetwensId INT UNSIGNED NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6),
    PRIMARY KEY (Id),
    CONSTRAINT FK_EetwensPerGezin_Gezin FOREIGN KEY (GezinId) REFERENCES Gezin(Id),
    CONSTRAINT FK_EetwensPerGezin_Eetwens FOREIGN KEY (EetwensId) REFERENCES Eetwens(Id)
) ENGINE=InnoDB;

INSERT INTO EetwensPerGezin (Id, GezinId, EetwensId) VALUES
(1, 1, 2),
(2, 2, 4),
(3, 3, 4),
(4, 4, 3),
(5, 5, 2);

-- 3. Tabel: Allergie [cite: 1, 2]
CREATE TABLE Allergie (
    Id INT NOT NULL PRIMARY KEY,
    Naam VARCHAR(50) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    AnafylactischRisico VARCHAR(50) NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Data voor Allergie
INSERT INTO Allergie (Id, Naam, Omschrijving, AnafylactischRisico) VALUES
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag'),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog'),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog'),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag'),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag'),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag');


-- 4. Tabel: AllergiePerPersoon [cite: 3, 4]
CREATE TABLE AllergiePerPersoon (
    Id INT NOT NULL PRIMARY KEY,
    PersoonId INT NOT NULL,
    AllergieId INT NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (PersoonId) REFERENCES Persoon(Id),
    FOREIGN KEY (AllergieId) REFERENCES Allergie(Id)
);

-- Data voor AllergiePerPersoon
-- Only includes IDs that exist in your Persoon table (4, 8, 13, 14, 17, 19)
INSERT INTO AllergiePerPersoon (Id, PersoonId, AllergieId, IsActive) VALUES
(1, 4, 1, 1),
(5, 8, 3, 1),
(9, 13, 4, 1),
(10, 14, 1, 1),
(13, 17, 1, 1),
(14, 17, 2, 1),
(16, 19, 4, 1);