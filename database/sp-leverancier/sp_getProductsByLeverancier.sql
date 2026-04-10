-- ==========================================
-- Stored Procedure: Get Products by Leverancier
-- Description: Retrieves all products for a specific leverancier
-- ==========================================

DROP PROCEDURE IF EXISTS sp_getProductsByLeverancier;

CREATE PROCEDURE sp_getProductsByLeverancier(IN p_LeverancierId INT UNSIGNED)
BEGIN
    SELECT 
        p.Id,
        p.Naam,
        p.SoortAllergie,
        p.Barcode,
        p.Houdbaarheidsdatum,
        p.Omschrijving,
        ppl.DatumAangeleverd,
        ppl.DatumEerstVolgendeLevering,
        ppl.Id AS ProductPerLeverancierId
    FROM 
        Product p
    INNER JOIN 
        ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    WHERE 
        ppl.LeverancierId = p_LeverancierId
        AND p.isactief = 1
        AND ppl.IsActive = 1
    ORDER BY 
        p.Naam ASC;
END;
