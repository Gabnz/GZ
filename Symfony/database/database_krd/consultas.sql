--~ CONSULTAS DE BASE DE DATOS DE HOTEL D'ROCHE


--:: PARA RESERVAR::
--Número de habitaciones de un tipo, no se toma en cuenta el tipo porque
--en el proyecto se puede hacer una excepción de una individual por una doble

-->>>INDIVIDUAL
SELECT count(*)
FROM habitaciones
WHERE categoria = '?';

-- Número de habitaciones reservadas para una fecha dada
SELECT count(*)
FROM reserva_ocupa
WHERE id_usuario = ? AND '?_ini' >= fecha_ini AND '?_ini' <= fecha_ini 
AND '?_fin' >= fecha_fin AND '?_fin' <= fecha_fin
AND categoria_habitacion = '?'  AND tipo = ? AND estatus_reserva = 'activa'
OR estatus_reserva = 'ocupada'; 

-->>>DOBLES
SELECT count(*)
FROM habitaciones
WHERE categoria = '?' AND tipo = '2';

-- Número de habitaciones reservadas para una fecha dada
SELECT count(*)
FROM reserva_ocupa
WHERE '?_ini' >= fecha_ini AND '?_ini' <= fecha_ini 
AND '?_fin' >= fecha_fin AND '?_fin' <= fecha_fin
AND categoria_habitacion = '?'  AND tipo = '2' 
AND estatus_reserva != 'cancelada';

--~ CODIGO habitaciones totales con reservadas_ocupadas
--~ if(total_hab  - total_reserva > 0)
--~ ... Proceder

--:: OCUPAR Habitación  -- previa RESERVA:::







