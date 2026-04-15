DELIMITER //

DROP PROCEDURE IF EXISTS Sp_UpdatePersoonAllergie //

CREATE PROCEDURE Sp_UpdatePersoonAllergie(
    IN p_AllergiePerPersoonId INT,
    IN p_NewAllergieId INT
)
BEGIN
    UPDATE AllergiePerPersoon 
    SET 
        AllergieId = p_NewAllergieId,
        DatumGewijzigd = NOW(6)
    WHERE Id = p_AllergiePerPersoonId;
END //

DELIMITER ;
