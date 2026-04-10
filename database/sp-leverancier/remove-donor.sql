-- Remove Donor leverancier (Jan van der Heijden)
-- This will trigger the warning message when selecting "Donor" type

USE laravel;

-- Set IsActive to 0 instead of deleting (soft delete)
UPDATE Leverancier 
SET IsActive = 0 
WHERE Id = 5 AND LeverancierType = 'Donor';

-- Or completely delete if preferred:
-- DELETE FROM Leverancier WHERE Id = 5 AND LeverancierType = 'Donor';
