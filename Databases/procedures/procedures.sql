DELIMITER //

CREATE PROCEDURE GetUserBookLimit(IN user_id VARCHAR(20))
BEGIN
    DECLARE user_role VARCHAR(20);
    DECLARE user_loan DECIMAL(10,2);
    DECLARE user_estado VARCHAR(20);
    DECLARE max_libros INT;

    SELECT TIPO_USUARIO, Deuda INTO user_role, user_loan
    FROM USUARIO
    WHERE ID_USUARIO = user_id;

    SET max_libros = CASE
            WHEN user_role = 'ESTUDIANTE' THEN 5
            WHEN user_role = 'MAESTRO' THEN 15
            WHEN user_role = 'ADMIN' THEN 50
            ELSE 3
        END;

     IF user_loan > 0.0 THEN 
            SET user_estado = 'SUSPENDIDO';
            SET max_libros = 0;
        ELSE
            SET user_estado = 'ACTIVO';
        END IF;
    SELECT 
            user_id AS id_usuario,
            user_role AS rol,
            user_loan AS deuda,
            user_estado AS estado,
            max_libros AS max_libros;


END //
DELIMITER