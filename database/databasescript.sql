DROP DATABASE IF EXISTS voorraad;
CREATE DATABASE voorraad;

USE voorraad;

-- =====================
-- DROP TABLES (in FK-safe order)
-- =====================
DROP TABLE IF EXISTS ProductPerMagazijn;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS Categorie;

-- =====================
-- TABLE CREATION
-- =====================
CREATE TABLE Categorie (
    Id MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
    Naam VARCHAR(10) NOT NULL,
    Omschrijving VARCHAR(255),
    isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NULL DEFAULT NOW(6)
);

CREATE TABLE Magazijn (
    Id MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
    Ontvangstdatum DATE NOT NULL,
    Uitleveringsdatum DATE NULL,
    VerpakkingsEenheid VARCHAR(50),
    Aantal MEDIUMINT NOT NULL,
    isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NULL DEFAULT NOW(6)
);

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
    FOREIGN KEY (CategorieId) REFERENCES Categorie(Id),
    CHECK (Status IN ('OpVoorraad', 'NietOpVoorraad', 'NietLeverbaar'))
);

CREATE TABLE ProductPerMagazijn (
    Id MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
    ProductId MEDIUMINT UNSIGNED NOT NULL,
    MagazijnId MEDIUMINT UNSIGNED NOT NULL,
    Locatie VARCHAR(35) NOT NULL,
    isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NULL DEFAULT NOW(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (MagazijnId) REFERENCES Magazijn(Id)
);

-- =======================
-- Categorie Data
-- =======================
INSERT INTO Categorie (Id, Naam, Omschrijving) VALUES
(1, 'AGF', 'Aardappelen groente en fruit'),
(2, 'KV', 'Kaas en vleeswaren'),
(3, 'ZPE', 'Zuivel plantaardig en eieren'),
(4, 'BB', 'Bakkerij en Banket'),
(5, 'FSKT', 'Frisdrank, sap, koffie/thee'),
(6, 'PRW', 'Pasta, rijst en wereldkeuken'),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie'),
(8, 'SKCC', 'Snoep, koek, chips en chocolade'),
(9, 'BVH', 'Baby, verzorging en hygiëne');

-- =======================
-- Magazijn Data
-- =======================
INSERT INTO Magazijn (Id, Ontvangstdatum, Uitleveringsdatum, VerpakkingsEenheid, Aantal) VALUES
(1,  '2026-03-12', NULL, '5 kg', 20),
(2,  '2026-04-02', NULL, '2.5 kg', 40),
(3,  '2026-03-16', NULL, '1 kg', 30),
(4,  '2026-04-08', NULL, '1.5 kg', 25),
(5,  '2026-04-06', NULL, '4 stuks', 75),
(6,  '2026-03-12', NULL, '1 kg/tros', 60),
(7,  '2026-03-20', NULL, '2 kg/tros', 200),
(8,  '2026-04-02', NULL, '200 g', 45),
(9,  '2026-04-04', NULL, '100 g', 60),
(10, '2026-04-07', NULL, '1 liter', 120),
(11, '2026-04-01', NULL, '250 g', 80),
(12, '2026-03-18', NULL, '6 stuks', 120),
(13, '2026-03-19', NULL, '800 g', 220),
(14, '2026-03-10', NULL, '1 stuk', 130),
(15, '2026-03-13', NULL, '150 ml', 72),
(16, '2026-03-18', NULL, '1 l', 12),
(17, '2026-03-11', NULL, '250 g', 300),
(18, '2026-04-02', NULL, '25 zakjes', 280),
(19, '2026-04-09', NULL, '500 g', 330),
(20, '2026-04-03', NULL, '1 kg', 34),
(21, '2026-04-02', NULL, '50 g', 23),
(22, '2026-03-16', NULL, '1 l', 46),
(23, '2026-03-14', NULL, '250 ml', 98),
(24, '2026-04-07', NULL, '1 potje', 56),
(25, '2026-03-17', NULL, '1 l', 210),
(26, '2026-04-05', NULL, '4 stuks', 24),
(27, '2026-04-07', NULL, '300 g', 87),
(28, '2026-04-06', NULL, '200 g', 230),
(29, '2026-04-08', NULL, '80 g', 30);

-- =======================
-- Product Data
-- =======================
INSERT INTO Product (Id, CategorieId, Naam, SoortAllergie, Barcode, Houdbaarheidsdatum, Omschrijving, Status) VALUES
(1, 1, 'Aardappel', NULL, '8719587321239', '2026-05-12', 'Kruimige aardappel', 'OpVoorraad'),
(2, 1, 'Ui', NULL, '8719437321335', '2026-05-02', 'Gele ui', 'NietOpVoorraad'),
(3, 2, 'Kaas', 'Lactose', '8719487421338', '2026-05-19', 'Jonge Kaas', 'OpVoorraad'),
(4, 2, 'Rosbief', NULL, '8719487421331', '2026-05-23', 'Rundvlees', 'OpVoorraad'),
(5, 3, 'Melk', 'Lactose', '8719487321332', '2026-05-23', 'Halfvolle melk', 'OpVoorraad'),
(6, 3, 'Margarine', NULL, '8719486321336', '2026-05-02', 'Plantaardige boter', 'OpVoorraad'),
(7, 3, 'Ei', 'Eier', '8719487321344', '2026-05-07', 'Scharrel ei', 'OpVoorraad'),
(8, 4, 'Brood', 'Gluten', '8719877211337', '2026-05-07', 'Volkoren brood', 'OpVoorraad'),
(9, 4, 'Gevulde Koek', 'Amandel', '8719833211332', '2026-05-04', 'Banketbakkers kwaliteit', 'OpVoorraad'),
(10, 5, 'Fristi', 'Lactose', '8719871211331', '2026-05-28', 'Frisdrank', 'NietOpVoorraad'),
(11, 5, 'Appelsap', NULL, '8719875211335', '2026-05-19', '100% vruchtensap', 'OpVoorraad'),
(12, 6, 'Pasta', 'Gluten', '8719487321334', '2026-05-16', 'Macaroni', 'NietLeverbaar'),
(13, 6, 'Rijst', NULL, '8719487531335', '2026-05-13', 'Basmati Rijst', 'OpVoorraad'),
(14, 6, 'Knorr Nasi Mix', NULL, '8719487351353', '2026-05-13', 'Nasi kruiden', 'OpVoorraad'),
(15, 7, 'Tomatensoep', NULL, '8719487321337', '2026-05-03', 'Romige tomatensoep', 'OpVoorraad'),
(16, 7, 'Tomatensaus', NULL, '8719487321339', '2026-05-03', 'Pizza saus', 'NietOpVoorraad'),
(17, 7, 'Peterselie', NULL, '8719487321646', '2026-05-11', 'Verse kruidenpot', 'OpVoorraad'),
(18, 7, 'Olie', NULL, '8719873272337', '2026-05-27', 'Olijfolie', 'OpVoorraad'),
(19, 8, 'Mars', NULL, '8719873243434', '2026-05-11', 'Snoep', 'OpVoorraad'),
(20, 8, 'Biscuit', NULL, '8719873111331', '2026-05-07', 'San Francisco biscuit', 'OpVoorraad'),
(21, 8, 'Paprika Chips', NULL, '8719873218398', '2026-05-22', 'Ribbelchips paprika', 'OpVoorraad'),
(22, 8, 'Chocolade reep', 'Cacoa', '8719873215333', '2026-05-21', 'Tony Chocolonely', 'OpVoorraad');

-- =======================
-- ProductPerMagazijn Data
-- =======================
INSERT INTO ProductPerMagazijn (Id, ProductId, MagazijnId, Locatie) VALUES
(1,  1,  1,  'Berlicum'),
(2,  2,  2,  'Rosmalen'),
(3,  3,  3,  'Berlicum'),
(4,  4,  4,  'Berlicum'),
(5,  5,  5,  'Rosmalen'),
(6,  6,  6,  'Berlicum'),
(7,  7,  7,  'Rosmalen'),
(8,  8,  8,  'Sint-MichelsGestel'),
(9,  9,  9,  'Sint-MichelsGestel'),
(10, 10, 10, 'Middelrode'),
(11, 11, 11, 'Middelrode'),
(12, 12, 12, 'Middelrode'),
(13, 13, 13, 'Schijndel'),
(14, 14, 14, 'Schijndel'),
(15, 15, 15, 'Gemonde'),
(16, 16, 16, 'Gemonde'),
(17, 17, 17, 'Gemonde'),
(18, 18, 18, 'Gemonde'),
(19, 19, 19, 'Den Bosch'),
(20, 20, 20, 'Den Bosch'),
(21, 21, 21, 'Den Bosch'),
(22, 22, 22, 'Heeswijk Dinther'),
(23, 23, 23, 'Heeswijk Dinther'),
(24, 24, 24, 'Heeswijk Dinther'),
(25, 25, 25, 'Vught'),
(26, 26, 26, 'Vught'),
(27, 21, 27, 'Vught'),
(28, 22, 28, 'Vught'),
(29, 22, 29, 'Vught');

