DELIMITER //

DROP PROCEDURE IF EXISTS Sp_GetAllAllergieen //

CREATE PROCEDURE Sp_GetAllAllergieen(
    IN p_AllergieNaam VARCHAR(100)
)
BEGIN
    SELECT 
        Gezin.Id AS GezinId,
        Gezin.Naam AS GezinNaam,
        Gezin.Omschrijving,
        Gezin.AantalVolwassenen,
        Gezin.AantalKinderen,
        Gezin.AantalBabys,
        TRIM(CONCAT(Persoon.Voornaam, ' ', IFNULL(CONCAT(Persoon.Tussenvoegsel, ' '), ''), Persoon.Achternaam)) AS VertegenwoordigerNaam
    FROM Gezin

    INNER JOIN Persoon ON Persoon.GezinId = Gezin.Id AND Persoon.IsVertegenwoordiger = 1
    WHERE EXISTS (

        SELECT 1
        FROM Persoon P2
        INNER JOIN AllergiePerPersoon ON AllergiePerPersoon.PersoonId = P2.Id
        INNER JOIN Allergie ON Allergie.Id = AllergiePerPersoon.AllergieId
        WHERE P2.GezinId = Gezin.Id
        AND (p_AllergieNaam IS NULL OR p_AllergieNaam = '' OR Allergie.Naam = p_AllergieNaam)
    )
    ORDER BY Gezin.Naam ASC;
END //

DELIMITER ;