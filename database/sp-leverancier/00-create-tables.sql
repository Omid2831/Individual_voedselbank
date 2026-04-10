-- ==========================================
-- Create Leverancier Tables
-- ==========================================

USE laravel;

-- Drop tables in correct order
DROP TABLE IF EXISTS ProductPerLeverancier;
DROP TABLE IF EXISTS ContactPerLeverancier;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Leverancier;
DROP TABLE IF EXISTS Contact;

-- 1. Contact Table
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Leverancier Table
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. ContactPerLeverancier Table
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Contact Data
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

-- Insert Leverancier Data
INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, LeverancierType) VALUES
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf'),
(2, 'Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling'),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid'),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier'),
(5, 'Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor'),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf'),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf'),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid');

-- Insert ContactPerLeverancier Data
INSERT INTO ContactPerLeverancier (LeverancierId, ContactId) VALUES
(1, 7),
(2, 8),
(3, 9),
(4, 10),
(6, 11),
(7, 12),
(8, 13);
