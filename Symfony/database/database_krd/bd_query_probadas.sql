-- FORMTO FECHA: YYYY-MM-DD

-- Consulta de disponibilidad con JOIN (es más rápido)
select id_reserva_ocupa,usr.id_usuario, fecha_ini, fecha_fin 
from usuario as usr join reserva_ocupa as rsv on usr.id_usuario = rsv.id_usuario;

-- Consulta de disponibilidad con producto cartesiano
select id_reserva_ocupa,usr.id_usuario, fecha_ini, fecha_fin 
from usuario as usr, reserva_ocupa as rsv
where usr.id_usuario = rsv.id_usuario;

-- Contar habitaciones ocupadas en un intervalo de fecha dado.
select count(*)
from usuario as usr join reserva_ocupa as rsv on usr.id_usuario = rsv.id_usuario
where (fecha_ini between '2013-08-15' and '2013-08-30' or 
 fecha_fin between '2013-08-15' and '2013-08-30')   and rsv.categoria_habitacion = 'B' 
and rsv.tipo_habitacion = 2 and ( estatus_reserva = 'activa' or estatus_reserva = 'ocupada' );

select *from reserva_ocupa
where '2013-02-13' between fecha_ini  and fecha_fin and '2013-02-14' between fecha_ini 
and fecha_fin;

select * from reserva_ocupa;
   
    delete from reserva_ocupa
    where id_reserva_ocupa = 56;

-- Habitaciones agrupadas por categoría y tipo
select categoria, tipo, count(*)
from habitacion
group by categoria,tipo;

select * from habitacion;
    
    delete from habitacion 
    where id_habitacion > 0;

select id_habitacion as id
from habitacion
where categoria = 'B' and tipo = 2
limit 1;

select * from usuario;

    delete from usuario
    where id_usuario <> '';

select * from consumible_almacen;
    
    
select * from rol;

select * from consumible;

    delete from consumible
    where id_consumible > 0;
    
select * from llamadas_tlfs
order by id_reserva_ocupa;


insert into t1(dato) values ('aaa');
select last_insert_id() as id;


-- Consulta para facturar
    -- precio 
select precio, id_consumible_almacen, nombre, marca
from consumible_almacen as ca
where ca.id_consumible_almacen in 
   ( 
    select ids_consumible_almacen
    from consumible
    where id_reserva_ocupa = 1  
    )
order by id_consumible_almacen;
    -- cantidad 
select cantidad, ids_consumible_almacen 
from consumible
where id_reserva_ocupa = 1
order by ids_consumible_almacen;


select timediff('12:22:01','11:20:00') as time ;

select minute('01:02:01');
select hour ('01:02:01');

-- PRECIO de llamadas
    -- internacional
select precio
from consumible_almacen
where nombre = 'llamada_internacional';

-- Diferencia de fechas
select datediff(fecha_fin,fecha_ini) as dias, fecha_ini, fecha_fin
from reserva_ocupa
where id_reserva_ocupa  = 1
;

select * from factura;
    
    delete from factura
    where id_factura  > 0;

select * from items_factura;
 

-- llamadas
select hora_ini, hora_fin, tipo
from llamadas_tlfs
where id_reserva_ocupa = 1;

-- número de dias para contabilizar las penalizaciones
select datediff('2013-08-02',current_date());


select * from ci_sessions;

select * from usuario;

delete from ci_sessions;

select * from reserva_ocupa where id_usuario = 'baltazar666';

CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);
