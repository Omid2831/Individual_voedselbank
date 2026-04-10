DROP PROCEDURE IF EXISTS sp_getAllVoorraad;

DELIMITER $$

CREATE PROCEDURE sp_getAllVoorraad()
BEGIN
    SELECT 
        p.Naam AS ProductNaam,
        c.Naam AS Categorie,
        ppl.DatumAangeleverd AS Aantal, -- Changed to show something, might need adjustment
        p.Houdbaarheidsdatum,
        l.Naam AS Leverancier -- Changed from Magazijn to Leverancier
    FROM product AS p
    LEFT JOIN Categorie AS c ON p.CategorieId = c.Id
    LEFT JOIN ProductPerLeverancier AS ppl ON p.Id = ppl.ProductId
    LEFT JOIN Leverancier AS l ON ppl.LeverancierId = l.Id;
END $$

DELIMITER ;

select * from product;
