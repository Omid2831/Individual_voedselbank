-- Activate Donor leverancier (Jan van der Heijden)
-- This will make the Donor visible again in the overview

USE laravel;

-- Set IsActive to 1 to activate
UPDATE Leverancier 
SET IsActive = 1 
WHERE Id = 5 AND LeverancierType = 'Donor';
