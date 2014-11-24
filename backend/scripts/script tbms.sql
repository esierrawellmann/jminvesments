create database tmbs;
use tmbs;
create table role (
id_role int auto_increment,
nombre varchar(512) not null,
primary key(id_role)
) engine = InnoDB; 

create table caja_chica(
id_caja int auto_increment,
cantidad decimal(10,2) not null,
primary key(id_caja)
)engine=InnoDB; 


insert into caja_chica(cantidad) values (0);

create table permiso (
id_permiso int auto_increment,
nombre varchar(512) not null,
primary key(id_permiso)
) engine = InnoDB; 

insert into permiso(nombre) values ('Caja');
insert into permiso(nombre) values ('Roles');
insert into permiso(nombre) values ('Permisos');
insert into permiso(nombre) values ('Usuarios');
insert into permiso(nombre) values ('TipoProducto');
insert into permiso(nombre) values ('Producto');
insert into permiso(nombre) values ('Mobiliario');
insert into permiso(nombre) values ('CajaChica');
insert into permiso(nombre) values ('Vale');
insert into permiso(nombre) values ('Calendario');
insert into permiso(nombre) values ('Gastos');
insert into permiso(nombre) values ('Ventas');
insert into permiso(nombre) values ('CatalogoVentas');
insert into permiso(nombre) values ('Compras');
insert into permiso(nombre) values ('CatalogoCompras');
insert into permiso(nombre) values ('RolePermiso');
insert into permiso(nombre) values ('Agenda');
insert into permiso(nombre) values ('Perfil');
insert into permiso(nombre) values ('UsuarioMobiliario');
insert into permiso(nombre) values ('UsuarioVales');
insert into permiso(nombre) values ('UsuarioGastos');
insert into permiso(nombre) values ('UsuarioVentas');
insert into permiso(nombre) values ('UsuarioCompras');
insert into permiso(nombre) values ('ValesEstado');
insert into permiso (nombre) values ('UsuarioCitas');

create table role_permiso(
id_role_permiso int auto_increment,
id_role int not null,
id_permiso int not null, 
primary key(id_role_permiso),
foreign key(id_role) references role(id_role),
foreign key(id_permiso) references permiso(id_permiso)
) engine= InnoDB; 

create table usuario(
id_usuario int auto_increment,
id_role int not null,
nombre varchar(512) not null,
primary key(id_usuario),
foreign key(id_role) references role(id_role)
) engine=InnoDB;

create table mobiliario(
id_mobiliario int auto_increment,
id_usuario int not null,
nombre varchar(512),
cantidad int not null,
primary key (id_mobiliario),
foreign key(id_usuario) references usuario(id_usuario)
)engine=InnoDB;

create table tipo_producto(
id_tipo_producto int auto_increment,
nombre varchar(512) not null,
primary key(id_tipo_producto)
) engine=InnoDB; 

insert into tipo_producto(nombre) values ('Producto');
insert into tipo_producto(nombre) values ('Servicio');

create table producto(
id_producto int auto_increment,
id_tipo_producto int not null,
nombre varchar(512),
precio_compra decimal not null,
precio_venta decimal not null,
cantidad int not null,
primary key(id_producto),
foreign key(id_tipo_producto) references tipo_producto(id_tipo_producto)
) engine= InnoDB; 

create table venta(
id_venta int auto_increment,
id_usuario int not null,
nit varchar(124) not null,
nombre varchar(512) not null,
fecha date not null,
tarjeta decimal(10,2) default 0,
efectivo decimal(10,2) default 0,
primary key(id_venta),
foreign key(id_usuario) references usuario(id_usuario)
) engine=InnoDB;


create table detalle_venta(
id_detalle_venta int auto_increment,
id_venta int not null,
id_producto int not null,
cantidad int not null,
precio decimal not null,
primary key(id_detalle_venta),
foreign key(id_venta) references venta(id_venta) ON DELETE CASCADE,
foreign key(id_producto) references producto(id_producto)
) engine=InnoDB;

create table compra(
id_compra int auto_increment,
id_usuario int not null,
fecha date not null,
primary key(id_compra),
foreign key(id_usuario) references usuario(id_usuario)
) engine=InnoDB; 

create table detalle_compra(
id_detalle_compra int auto_increment,
id_compra int not null,
id_producto int not null,
cantidad int not null,
precio decimal not null,
primary key(id_detalle_compra),
foreign key(id_compra) references compra(id_compra) ON DELETE CASCADE,
foreign key(id_producto) references producto(id_producto)
) engine=InnoDB;

create table gasto(
id_gasto int auto_increment,
id_usuario int not null,
asunto varchar(512) not null,
comentario varchar(1024) not null,
fecha date not null,
monto decimal(10,2),
primary key(id_gasto),
foreign key(id_usuario) references usuario(id_usuario)
) engine=InnoDB;

create table vale(
id_vale int auto_increment,
id_usuario int not null,
motivo varchar(512) not null,
monto decimal not null,
estado varchar(50) not null,
fecha date not null,
primary key(id_vale),
foreign key(id_usuario) references usuario(id_usuario)
) engine=InnoDB; 

create table agenda(
id_agenda int auto_increment,
id_usuario int not null,
comentario varchar(512) not null,
fecha_inicio datetime not null,
fecha_fin datetime not null,
primary key(id_agenda),
foreign key(id_usuario) references usuario(id_usuario)
)engine=innoDb;


DROP PROCEDURE IF EXISTS ins_users;
DELIMITER $$
CREATE PROCEDURE ins_users(IN cliente VARCHAR(16),IN usuario VARCHAR(16),IN pass VARCHAR(16))
BEGIN
INSERT INTO mysql.user (HOST,USER,PASSWORD,select_priv,Insert_priv,Update_priv,Delete_priv, EXECUTE_priv,MAX_USER_CONNECTIONS,ssl_cipher, x509_issuer, x509_subject)
VALUES ( cliente, usuario, PASSWORD(pass), 'Y', 'Y', 'Y', 'Y', 'Y',1, '', '', '');
FLUSH PRIVILEGES;
END$$

DROP PROCEDURE IF EXISTS eli_users$$
CREATE PROCEDURE eli_users(IN cliente VARCHAR(16),IN usuario VARCHAR(16))
BEGIN
DELETE FROM mysql.user WHERE mysql.user.User=usuario AND mysql.user.Host=cliente;
FLUSH PRIVILEGES;
END$$

DROP PROCEDURE IF EXISTS update_users$$
CREATE PROCEDURE update_users(IN cliente VARCHAR(16),IN usuario VARCHAR(16),IN pass varchar(16),in oldusuario VARCHAR(16))
BEGIN
update mysql.user set mysql.user.User=usuario, mysql.user.Password=PASSWORD(pass) where mysql.user.User=oldusuario AND mysql.user.Host=cliente;
FLUSH PRIVILEGES;
END$$

CREATE TRIGGER insert_detalle after insert
 ON detalle_venta
 FOR EACH ROW
 BEGIN
 declare cant int; 
 set cant = (select cantidad from producto where id_producto=NEW.id_producto AND producto.id_tipo_producto=1);

 update producto set cantidad = (cant - NEW.cantidad) where id_producto=NEW.id_producto AND producto.id_tipo_producto=1;

END$$

CREATE TRIGGER update_detalle after update
 ON detalle_venta
 FOR EACH ROW
 BEGIN
 declare cant int; 
 declare nueva_cant int;
 set cant = (select cantidad from producto where id_producto=NEW.id_producto AND producto.id_tipo_producto=1);
 set nueva_cant = cant + OLD.cantidad;

 update producto set cantidad = (nueva_cant - NEW.cantidad) where id_producto=NEW.id_producto AND producto.id_tipo_producto=1;

END$$

CREATE TRIGGER delete_detalle after delete
 ON detalle_venta
 FOR EACH ROW
 BEGIN
 declare cant int; 
 declare nueva_cant int;
 set cant = (select cantidad from producto where id_producto=OLD.id_producto AND producto.id_tipo_producto=1);
 set nueva_cant = cant + OLD.cantidad;

 update producto set cantidad = nueva_cant where id_producto=OLD.id_producto AND producto.id_tipo_producto=1;

END$$

CREATE TRIGGER insert_compra after insert
 ON detalle_compra
 FOR EACH ROW
 BEGIN
 declare cant int; 
 set cant = (select cantidad from producto where id_producto=NEW.id_producto AND producto.id_tipo_producto=1);

 update producto set cantidad = (cant + NEW.cantidad) where id_producto=NEW.id_producto AND producto.id_tipo_producto=1;

END$$

CREATE TRIGGER update_compra after update
 ON detalle_compra
 FOR EACH ROW
 BEGIN
 declare cant int; 
 declare nueva_cant int;
 set cant = (select cantidad from producto where id_producto=NEW.id_producto AND producto.id_tipo_producto=1);
 set nueva_cant = cant - OLD.cantidad;

 update producto set cantidad = (nueva_cant + NEW.cantidad) where id_producto=NEW.id_producto AND producto.id_tipo_producto=1;

END$$

CREATE TRIGGER delete_compra after delete
 ON detalle_compra
 FOR EACH ROW
 BEGIN
 declare cant int; 
 declare nueva_cant int;
 set cant = (select cantidad from producto where id_producto=OLD.id_producto AND producto.id_tipo_producto=1);
 set nueva_cant = cant - OLD.cantidad;

 update producto set cantidad = nueva_cant where id_producto=OLD.id_producto AND producto.id_tipo_producto=1;

END$$
DELIMITER ;









