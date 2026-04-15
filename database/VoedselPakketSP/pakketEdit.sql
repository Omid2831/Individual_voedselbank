USE Voedselbank_2;

DROP PROCEDURE IF EXISTS spGetPakketVoorEdit;
DELIMITER $$

CREATE PROCEDURE spGetPakketVoorEdit(
    IN p_PakketId INT
)
BEGIN
    -- We halen direct de data op. De logica voor de blokkade 
    -- en de meldingen regelen we in de Controller en de Blade.
    SELECT 
        VP.Id AS PakketId,
        VP.GezinId,
        VP.Status,
        G.Naam AS Gezinsnaam -- Optioneel: de naam van het gezin erbij
    FROM Voedselpakket VP
    INNER JOIN Gezin G ON VP.GezinId = G.Id
    WHERE VP.Id = p_PakketId;
END $$

DELIMITER ;