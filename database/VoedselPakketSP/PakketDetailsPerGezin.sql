USE Voedselbank_2;

DROP PROCEDURE IF EXISTS spGetPakketDetailsPerGezin;
DELIMITER $$

CREATE PROCEDURE spGetPakketDetailsPerGezin(
    IN p_GezinId INT
)
BEGIN
    SELECT 
        -- Gegevens voor de bovenste tabel
        G.Id AS GezinId,
        G.Naam AS Gezinsnaam,
        G.Omschrijving AS GezinOmschrijving,
        (G.AantalVolwassenen + G.AantalKinderen + G.AantalBabys) AS TotaalPersonen,

        -- Gegevens voor de onderste tabel met DATE_FORMAT
        VP.PakketNummer,
        DATE_FORMAT(VP.DatumSamenstelling, '%d-%m-%Y') AS DatumSamenstelling,
        DATE_FORMAT(VP.DatumUitgifte, '%d-%m-%Y') AS DatumUitgifte,
        VP.Status,
        (SELECT SUM(AantalProductEenheden) 
         FROM ProductPerVoedselPakket 
         WHERE VoedselpakketId = VP.Id) AS AantalProducten,
        VP.Id AS PakketId
    FROM Gezin G
    LEFT JOIN Voedselpakket VP ON G.Id = VP.GezinId
    WHERE G.Id = p_GezinId
    ORDER BY VP.DatumSamenstelling DESC;
END $$

DELIMITER ;