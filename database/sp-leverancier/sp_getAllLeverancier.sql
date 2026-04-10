-- ==========================================
-- Stored Procedure: Get All Leverancier
-- Description: Retrieves all leveranciers with their contact information
-- ==========================================

DROP PROCEDURE IF EXISTS sp_getAllLeverancier;

CREATE PROCEDURE sp_getAllLeverancier()
BEGIN
    SELECT 
        l.Id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.LeverancierType,
        l.IsActive,
        l.Opmerking,
        l.DatumAangemaakt,
        l.DatumGewijzigd,
        c.Email,
        c.Mobiel,
        c.Straat,
        c.Huisnummer,
        c.Toevoeging,
        c.Postcode,
        c.Woonplaats
    FROM 
        Leverancier l
    LEFT JOIN 
        ContactPerLeverancier cpl ON l.Id = cpl.LeverancierId AND cpl.IsActive = 1
    LEFT JOIN 
        Contact c ON cpl.ContactId = c.Id AND c.IsActive = 1
    WHERE 
        l.IsActive = 1
    ORDER BY 
        l.Naam ASC;
END;
