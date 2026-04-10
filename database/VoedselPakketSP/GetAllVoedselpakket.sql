USE Voedselbank_2;

DROP PROCEDURE IF EXISTS spGetGezinOverzicht;
DELIMITER $$

CREATE PROCEDURE spGetGezinOverzicht(
    IN p_EetwensId INT
)
BEGIN
    IF p_EetwensId IS NOT NULL THEN
        -- Filter is actief: Toon alleen gezinnen met de specifieke eetwens
        SELECT 
            G.Naam AS Gezinsnaam,
            G.Omschrijving,
            G.AantalVolwassenen,
            G.AantalKinderen,
            G.AantalBabys,
            TRIM(CONCAT(P.Voornaam, ' ', IFNULL(P.Tussenvoegsel, ''), ' ', P.Achternaam)) AS Vertegenwoordiger,
            G.Id AS GezinId
        FROM Gezin G
        LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
        INNER JOIN EetwensPerGezin EPG ON G.Id = EPG.GezinId
        WHERE G.IsActive = 1 
          AND EPG.EetwensId = p_EetwensId
        GROUP BY G.Id
        ORDER BY G.Naam ASC;
    ELSE
        -- Geen filter: Toon ALLE actieve gezinnen
        SELECT 
            G.Naam AS Gezinsnaam,
            G.Omschrijving,
            G.AantalVolwassenen,
            G.AantalKinderen,
            G.AantalBabys,
            TRIM(CONCAT(P.Voornaam, ' ', IFNULL(P.Tussenvoegsel, ''), ' ', P.Achternaam)) AS Vertegenwoordiger,
            G.Id AS GezinId
        FROM Gezin G
        LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
        WHERE G.IsActive = 1
        ORDER BY G.Naam ASC;
    END IF;
END $$

DELIMITER ;