DROP PROCEDURE IF EXISTS sp_updateProductVoorraadDetails;

DELIMITER $$

CREATE PROCEDURE sp_updateProductVoorraadDetails(
    IN p_ProductId MEDIUMINT UNSIGNED,
    IN p_Locatie VARCHAR(35),
    IN p_Uitleveringsdatum DATE,
    IN p_NieuwAantal MEDIUMINT UNSIGNED
)
BEGIN
    DECLARE v_MagazijnId MEDIUMINT UNSIGNED;

    SELECT ppm.MagazijnId
    INTO v_MagazijnId
    FROM ProductPerMagazijn AS ppm
    WHERE ppm.ProductId = p_ProductId
    LIMIT 1;

    IF v_MagazijnId IS NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Geen magazijnkoppeling gevonden voor dit product';
    END IF;

    UPDATE ProductPerMagazijn
    SET Locatie = p_Locatie,
        DatumGewijzigd = NOW(6)
    WHERE ProductId = p_ProductId;

    UPDATE Magazijn
    SET Aantal = p_NieuwAantal,
        Uitleveringsdatum = p_Uitleveringsdatum,
        DatumGewijzigd = NOW(6)
    WHERE Id = v_MagazijnId;
END $$

DELIMITER ;
