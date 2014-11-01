create database jm; 
use jm; 

create table role (
id_role int auto_increment,
nombre varchar(512) not null,
primary key(id_role)
) engine = InnoDB; 

create table usuario(
id_usuario int auto_increment,
id_role int not null,
nombre varchar(512) not null,
primary key(id_usuario),
foreign key(id_role) references role(id_role)
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

create table tipo(
id_tipo int auto_increment,
nombre varchar(512) not null,
primary key(id_tipo)
) engine=InnoDB;

create table propiedad(
id_propiedad int auto_increment,
id_tipo int not null,
negocio varchar(124) not null,
zona varchar(5) not null,
estado varchar(124) not null,
nombre_proyecto varchar(512) not null,
nombre_propietario varchar(512) not null,
dormitorios varchar(512) not null,
precio_renta decimal(20,2) null,
precio_venta decimal(20,2) null,
amueblado varchar(1) not null,
directa_compartida varchar(1) not null,
direccion varchar(1024) null,
departamento varchar(512) null,
municipio varchar(512) null, 
primary key(id_propiedad),
foreign key(id_tipo) references tipo(id_tipo)
) engine=InnoDB;

create table detalle_propiedad(
id_detalle_propiedad int auto_increment,
id_propiedad int not null,
direccion varchar(1024) not null, 
primary key (id_detalle_propiedad),
foreign key (id_propiedad) references propiedad(id_propiedad)
) engine=InnoDB;

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
DELIMITER ;