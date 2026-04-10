DELIMITER //

DROP PROCEDURE IF EXISTS Sp_GetPersoonAllergieForEdit //

CREATE PROCEDURE Sp_GetPersoonAllergieForEdit(
    IN p_PersoonId INT
)
BEGIN
    SELECT 
        APP.Id AS AllergiePerPersoonId,
        P.Id AS PersoonId,
        TRIM(CONCAT(P.Voornaam, ' ', IFNULL(CONCAT(P.Tussenvoegsel, ' '), ''), P.Achternaam)) AS VolledigeNaam,
        A.Id AS HuidigeAllergieId,
        A.Naam AS HuidigeAllergieNaam,
        A.AnafylactischRisico
    FROM Persoon P
    LEFT JOIN AllergiePerPersoon APP ON APP.PersoonId = P.Id
    LEFT JOIN Allergie A ON A.Id = APP.AllergieId
    WHERE P.Id = p_PersoonId
    LIMIT 1;
END //

DELIMITER ;
