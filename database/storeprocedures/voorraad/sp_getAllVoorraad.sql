DROP PROCEDURE IF EXISTS sp_getAllVoorraad;

DELIMITER $$

CREATE PROCEDURE sp_getAllVoorraad()
BEGIN
    SELECT 
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        p.Houdbaarheidsdatum,
        m.Ontvangstdatum,
        c.Naam AS Categorie,
        m.VerpakkingsEenheid AS Eenheid,
        m.Aantal,
        m.Uitleveringsdatum,
        DATE_FORMAT(p.Houdbaarheidsdatum, '%d-%m-%Y') AS HoudbaarheidsdatumFormatted,
        DATE_FORMAT(m.Ontvangstdatum, '%d-%m-%Y') AS OntvangstdatumFormatted,
        DATE_FORMAT(m.Uitleveringsdatum, '%d-%m-%Y') AS UitleveringsdatumFormatted,
        ppm.Locatie AS Magazijn
    FROM product AS p
    LEFT JOIN Categorie AS c ON p.CategorieId = c.Id
    LEFT JOIN ProductPerMagazijn AS ppm ON p.Id = ppm.ProductId
    LEFT JOIN Magazijn AS m ON ppm.MagazijnId = m.Id
    ORDER BY p.Houdbaarheidsdatum DESC;
END $$

DELIMITER ;
