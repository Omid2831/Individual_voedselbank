DELIMITER //

DROP PROCEDURE IF EXISTS Sp_GetAllergieenDetailsPerGezin //

CREATE PROCEDURE Sp_GetAllergieenDetailsPerGezin(
    IN p_GezinId INT
)
BEGIN
    SELECT 
        G.Id AS GezinId,
        G.Naam AS Gezinsnaam,
        G.Omschrijving,
        G.TotaalAantalPersonen,
        P.Id AS PersoonId,
        TRIM(CONCAT(P.Voornaam, ' ', IFNULL(CONCAT(P.Tussenvoegsel, ' '), ''), P.Achternaam)) AS VolledigeNaam,
        P.TypePersoon,
        IF(P.IsVertegenwoordiger = 1, 'Vertegenwoordiger', 'Gezinslid') AS Gezinsrol,
        IFNULL(GROUP_CONCAT(A.Naam SEPARATOR ', '), 'Geen') AS Allergie
    FROM Gezin G
    INNER JOIN Persoon P ON P.GezinId = G.Id
    LEFT JOIN AllergiePerPersoon APP ON APP.PersoonId = P.Id
    LEFT JOIN Allergie A ON A.Id = APP.AllergieId
    WHERE G.Id = p_GezinId
    GROUP BY G.Id, P.Id, P.Voornaam, P.Tussenvoegsel, P.Achternaam, P.TypePersoon, P.IsVertegenwoordiger
    ORDER BY P.IsVertegenwoordiger DESC, P.Voornaam ASC;
END //

DELIMITER ;
