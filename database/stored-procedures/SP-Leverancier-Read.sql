-- ==========================================
-- Stored Procedure: Read Leverancier
-- Description: Retrieves all active leveranciers with their contact information
-- ==========================================

DELIMITER $$

DROP PROCEDURE IF EXISTS spReadLeverancier$$

CREATE PROCEDURE spReadLeverancier()
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
        c.Straat,
        c.Huisnummer,
        c.Toevoeging,
        c.Postcode,
        c.Woonplaats,
        c.Email,
        c.Mobiel
    FROM 
        Leverancier l
    LEFT JOIN 
        ContactPerLeverancier cpl ON l.Id = cpl.LeverancierId
    LEFT JOIN 
        Contact c ON cpl.ContactId = c.Id
    WHERE 
        l.IsActive = 1
    ORDER BY 
        l.Naam ASC;
END$$

DELIMITER ;
