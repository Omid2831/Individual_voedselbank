DROP PROCEDURE IF EXISTS sp_getProductDetails;

DELIMITER $$

CREATE PROCEDURE sp_getProductDetails(IN productId INT)
BEGIN
    SELECT 
        p.Id,
        p.Naam AS Productnaam,
        p.Barcode,
        p.Houdbaarheidsdatum as Houdbaarheidsdatum,
        p.Ontvangstdatum as Ontvangstdatum,
        DATE_FORMAT(p.Houdbaarheidsdatum, '%d-%m-%Y') AS HoudbaarheidsdatumFormatted,
        DATE_FORMAT(p.Ontvangstdatum, '%d-%m-%Y') AS OntvangstdatumFormatted,
        c.Naam AS Categorie,
        c.Id AS CategorieId,
        m.Aantal,
        m.VerpakkingsEenheid AS Eenheid,
        m.Uitleveringsdatum as Uitleveringsdatum,
        DATE_FORMAT(m.Uitleveringsdatum, '%d-%m-%Y') AS UitleveringsdatumFormatted,
        mag.Naam AS Magazijn,
        ppm.Locatie AS MagazijnLocatie,
        ppm.Id AS ProductPerMagazijnId
    FROM product AS p
    LEFT JOIN Categorie AS c ON p.CategorieId = c.Id
    LEFT JOIN ProductPerMagazijn AS ppm ON p.Id = ppm.ProductId
    LEFT JOIN Magazijn AS m ON ppm.MagazijnId = m.Id
    LEFT JOIN Magazijn AS mag ON ppm.MagazijnId = mag.Id
    WHERE p.Id = productId;
END $$

DELIMITER ;
