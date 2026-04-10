DROP PROCEDURE IF EXISTS sp_getAllVoorraad;

DELIMITER $$

CREATE PROCEDURE sp_getAllVoorraad()
BEGIN
    SELECT 
        p.Naam AS ProductNaam,
        c.Naam AS Categorie,
        m.VerpakkingsEenheid AS Eenheid,
        m.Aantal,
        DATE_FORMAT(p.Houdbaarheidsdatum, '%d-%m-%Y') AS Houdbaarheidsdatum,
        ppm.Locatie AS Magazijn
    FROM product AS p
    LEFT JOIN Categorie AS c ON p.CategorieId = c.Id
    LEFT JOIN ProductPerMagazijn AS ppm ON p.Id = ppm.ProductId
    LEFT JOIN Magazijn AS m ON ppm.MagazijnId = m.Id
    ORDER BY p.Houdbaarheidsdatum DESC;
END $$

DELIMITER ;
