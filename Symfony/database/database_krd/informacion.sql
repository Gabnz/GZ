-- --------------------------------------------
-- Inserciones de campos en CONSUMIBLE ALMACEN
-- --------------------------------------------

insert into consumible_almacen(nombre,precio,categoria,cantidad,marca) values
('cerveza',5,'N',1000,'Polar Light') ,
('cerveza',10,'B',500,'Solera') , 
('cerveza',15,'A',300,'Polar Xtreme'),
('vino',10,'N',100,'San Andrés'),
('vino',11,'B',230,'Caminos de San Joaquín'),
('vino',12,'A',250,'Uvas del Cochinal'),
('alcohol',25,'N',100, 'Vokda Glacial'),
('alcohol',35,'B',150,'Santa Teresa'),
('alcohol',75,'A',200,'Droché 80 años - Edición Especial'),

('agua',5,'N',500,'Minalba Pura de Manatial, eso dice la etiqueta'),
('refresco',3,'N',900,'Pepsi-Cola');

-- Precios de servicios del hotel que tambien se encuentran registrados en la misma tabla
insert into consumible_almacen(nombre,precio,categoria) values
('llamada_internacional',5,'N'),
('llamada_nacional',1,'N'),
('cama_niño',10,'N'),
('habitacion_individual',40,'N'),
('habitacion_doble',70,'N'),
('alojamiento',1,'N'),
('alojamiento',1.3,'B'),
('alojamiento',2.0,'A');

-- ---------------------------------
-- HABITACIONES: 120 
-- ---------------------------------
-- De cada categoría son 40, y de cada tipo son 20 . lo que daría un total de 120
insert into habitacion (tipo, categoria) values 
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(1, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(2, 'N') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(1, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(2, 'B') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(1, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ,
(2, 'A') ;


-- -----------------------
-- Insercion  -  USUARIOS 
-- -----------------------
    -- el número de tarjeta es de 16 (VISA ini 4, MASTERCARD 5)
insert into usuario (id_usuario, clave, nombre, apellido, correo, sexo, cedula, fecha_nac,
 num_tarjeta,tipo_cuenta, nacionalidad, rif) values 

('baltazar666','123456','Baltazar','Bueno', 'baltazar@gmail.com','m','1000000','1666-06-06',
'422559658215569','corriente','E','E-1000000-9'),

('rr_gutierrez','123456', 'Ramon', 'Gutierrez','rgutierrez@gmail.com','m','7500800','1970-05-16',
'525482358345589','ahorro','V','V-7500800-3'),

('sandrab86','123456', 'Sandra', 'Baron','sandrab86@hotmail.com', 'f','21255897','1993-06-18',
'425412358389489','corriente','V','V-21255897-6'),

('paola','123456', 'Paola', 'Parra','paolapp@gmail.com','f','20888666','1990-05-22',
'525222358345989','ahorro','V','V-20888666-5');

-- actualizando claves a sha1
update usuario
set clave = sha1('123456')
where id_usuario <> '';
-- la clave de todos los usuario es 123456 pero se almacena encriptada con 'sha1'

-- ROLES
insert into rol(descripcion) values ('admin'), ('estandar');

-- ktrina (usuario ADMIN)
insert into usuario (id_usuario, clave, nombre, apellido, correo, sexo, cedula, fecha_nac,
nacionalidad,rif) values

('ktrina','123456','Ktrina', 'Smith','ktrina@gmail.com','f','20888999','2013-07-24','V',
'V-20888999-6');

-- ------------------------------------------------------
-- ::: RESERVAS ::: (la data ser hara a partir de agosto)
-- ------------------------------------------------------
insert into reserva_ocupa (id_usuario,fecha_ini,fecha_fin,categoria_habitacion,tipo_habitacion)
values
-- de baltazar666 
('baltazar666','2013-08-15','2013-08-30','B','2'),
('baltazar666','2013-08-15','2013-08-30','B','2'),
('baltazar666','2013-08-15','2013-08-30','B','2'),
('baltazar666','2013-08-15','2013-08-30','B','2'),
('baltazar666','2013-08-15','2013-08-30','B','2'),
('baltazar666','2013-08-15','2013-08-30','B','2'),
 
('baltazar666','2013-08-20','2013-08-30','B','2'),
('baltazar666','2013-08-20','2013-08-30','B','2'),
('baltazar666','2013-08-20','2013-08-30','B','2'),
('baltazar666','2013-08-20','2013-08-30','B','2'),
('baltazar666','2013-08-20','2013-08-30','B','2'),
('baltazar666','2013-08-20','2013-08-30','B','2'),

('baltazar666','2013-08-20','2013-08-30','N','1'),
('baltazar666','2013-08-20','2013-08-30','N','1'),
('baltazar666','2013-08-20','2013-08-30','N','1'),

-- de sandrab86
('sandrab86','2013-08-15','2013-08-20','B','2'),
('sandrab86','2013-08-15','2013-08-20','B','2'),
('sandrab86','2013-08-15','2013-08-20','B','2'),
('sandrab86','2013-08-15','2013-08-20','A','1'),
('sandrab86','2013-08-15','2013-08-20','A','2'),

-- de rr_gutierrez
('rr_gutierrez','2013-08-16','2013-08-18','B','2'),
('rr_gutierrez','2013-08-16','2013-08-18','N','2'),
('rr_gutierrez','2013-08-16','2013-08-18','N','2'),
('rr_gutierrez','2013-08-16','2013-08-18','B','1'),
('rr_gutierrez','2013-08-16','2013-08-18','B','1'),
('rr_gutierrez','2013-08-16','2013-08-18','B','1'),

-- de paola 
('paola','2013-08-15','2013-08-20','B','2'),
('paola','2013-08-15','2013-08-20','B','2'),
('paola','2013-08-15','2013-08-20','B','2'),
('paola','2013-08-15','2013-08-20','B','2'),

('paola','2013-08-15','2013-08-20','N','1'),
('paola','2013-08-15','2013-08-20','A','1'),
('paola','2013-08-15','2013-08-20','A','1'),
('paola','2013-08-15','2013-08-21','A','1')
;

-- -----------------------
-- Generación de LLAMADAS: HH:MM:SS, formato 24/
-- -----------------------
insert into llamadas_tlfs (fecha, hora_ini, hora_fin,numero, id_reserva_ocupa,tipo) values
-- de baltazar666 --> reserva 1
('2013-08-16','12:22:01','12:23:00','9532132132168','1','I'),
('2013-08-17','12:40:00','12:50:00','04265842524','1','N'),

-- de sandrab86
('2013-08-18','12:22:01','12:23:00','04264484827','17','N'),
('2013-08-19','12:40:00','13:40:00','04145844721','17','N'),
('2013-08-20','22:40:00','22:50:00','892312132131','17','I'),

-- de rr_gutierrez
('2013-08-16','09:30:00','09:50:22','02418236631','23','N'),
('2013-08-17','09:30:00','09:50:22','04145855539','23','N'),

--  de paola
('2013-08-20','12:30:00','12:40:34','04120388544','34','I')
;



