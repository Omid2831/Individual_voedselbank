DROP PROCEDURE IF EXISTS sp_getAllVoorraad;

DELIMITER $$

CREATE PROCEDURE sp_getAllVoorraad()
BEGIN
    SELECT 
        p.Naam AS ProductNaam,
        c.Naam AS Categorie,
        COUNT(ppl.Id) AS Aantal,
        DATE_FORMAT(p.Houdbaarheidsdatum, '%d-%m-%Y') AS Houdbaarheidsdatum,
        l.Naam AS Magazijn
    FROM product AS p
    LEFT JOIN Categorie AS c ON p.CategorieId = c.Id
    LEFT JOIN ProductPerLeverancier AS ppl ON p.Id = ppl.ProductId
    LEFT JOIN Leverancier AS l ON ppl.LeverancierId = l.Id
    GROUP BY p.Id, p.Naam, c.Naam, p.Houdbaarheidsdatum, l.Naam
    ORDER BY p.Houdbaarheidsdatum DESC, Aantal DESC;
END $$

DELIMITER ;
