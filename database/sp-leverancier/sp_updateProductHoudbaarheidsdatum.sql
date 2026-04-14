-- ==========================================
-- Stored Procedure: Update Product Houdbaarheidsdatum
-- Description: Updates the expiry date of a product with validation
-- Returns: 1 if successful, 0 if validation fails
-- ==========================================

DROP PROCEDURE IF EXISTS sp_updateProductHoudbaarheidsdatum;

CREATE PROCEDURE sp_updateProductHoudbaarheidsdatum(
    IN p_ProductId INT UNSIGNED,
    IN p_NieuweHoudbaarheidsdatum DATE,
    OUT p_Result INT,
    OUT p_Message VARCHAR(255)
)
BEGIN
    DECLARE v_OudeHoudbaarheidsdatum DATE;
    DECLARE v_DagenVerschil INT;
    
    -- Get current expiry date
    SELECT Houdbaarheidsdatum INTO v_OudeHoudbaarheidsdatum
    FROM Product
    WHERE Id = p_ProductId;
    
    -- Check if new date is in the past
    IF p_NieuweHoudbaarheidsdatum < CURDATE() THEN
        SET p_Result = 0;
        SET p_Message = 'De houdbaarheidsdatum mag niet in het verleden liggen';
    ELSE
        -- Calculate difference in days
        SET v_DagenVerschil = DATEDIFF(p_NieuweHoudbaarheidsdatum, v_OudeHoudbaarheidsdatum);
        
        -- Validate: maximum 7 days extension (positive difference only)
        IF v_DagenVerschil > 7 THEN
            SET p_Result = 0;
            SET p_Message = 'De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd';
        ELSEIF v_DagenVerschil < 0 THEN
            SET p_Result = 0;
            SET p_Message = 'De houdbaarheidsdatum mag niet worden verkort';
        ELSE
            -- Update the product
            UPDATE Product
            SET Houdbaarheidsdatum = p_NieuweHoudbaarheidsdatum,
                DatumGewijzigd = NOW(6)
            WHERE Id = p_ProductId;
            
            SET p_Result = 1;
            SET p_Message = 'De houdbaarheidsdatum is gewijzigd';
        END IF;
    END IF;
END;
