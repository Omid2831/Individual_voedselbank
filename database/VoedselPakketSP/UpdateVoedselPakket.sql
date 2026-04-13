USE Voedselbank_2;

DROP PROCEDURE IF EXISTS spUpdatePakket;
DELIMITER $$

CREATE PROCEDURE spUpdatePakket(
    IN p_PakketId INT,
    IN p_NieuweStatus VARCHAR(50)
)
BEGIN
    -- We voeren direct de update uit. 
    -- De veiligheidscheck zit al in de Laravel-voorkant.
    UPDATE Voedselpakket 
    SET Status = p_NieuweStatus,
        DatumUitgifte = IF(p_NieuweStatus = 'Uitgereikt', CURRENT_DATE, DatumUitgifte),
        DatumGewijzigd = NOW(6)
    WHERE Id = p_PakketId;
END $$

DELIMITER ;