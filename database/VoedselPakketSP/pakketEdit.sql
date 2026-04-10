USE Voedselbank_2;

DROP PROCEDURE IF EXISTS spGetPakketVoorEdit;
DELIMITER $$

CREATE PROCEDURE spGetPakketVoorEdit(
    IN p_PakketId INT
)
BEGIN
    SELECT 
        VP.Id AS PakketId,
        VP.Status
    FROM Voedselpakket VP
    INNER JOIN Gezin G ON VP.GezinId = G.Id
    WHERE VP.Id = p_PakketId;
END $$

DELIMITER ;