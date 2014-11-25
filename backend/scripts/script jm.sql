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

password varchar(45) not null,

primary key(id_usuario),

foreign key(id_role) references role(id_role)

) engine=InnoDB;



insert into role(nombre) values ("Administrador");

insert into usuario(id_role,nombre,password) values (1,"admin","123"); 



create table agenda(

id_agenda int auto_increment,

id_usuario int not null,

comentario varchar(512) not null,

fecha_inicio datetime not null,

fecha_fin datetime not null,

primary key(id_agenda),

foreign key(id_usuario) references usuario(id_usuario)

)engine=innoDb;



create table propiedad(

id_propiedad int auto_increment,

tipo varchar(200) not null,

negocio varchar(124) not null,

zona varchar(5) not null,

estado varchar(124) not null,

nombre_proyecto varchar(512) not null,

nombre_propietario varchar(512) not null,

dormitorios varchar(512) not null,

precio_renta decimal(20,2) null,

precio_venta decimal(20,2) null,

amueblado varchar(8) not null,

directa_compartida varchar(124) not null,

ambiente varchar(2048) not null,

area varchar(254) not null,

direccion varchar(1024) null,

departamento varchar(512) null,

municipio varchar(512) null, 

parqueos varchar(512) null,

primary key(id_propiedad)

) engine=InnoDB;



create table detalle_propiedad(

id_detalle_propiedad int auto_increment,

id_propiedad int not null,

direccion varchar(1024) not null, 

nombre varchar(512) not null,

primary key (id_detalle_propiedad),

foreign key (id_propiedad) references propiedad(id_propiedad)

) engine=InnoDB;





insert into role(nombre) values ("Administrador");

insert into usuario(id_role,nombre) values (1,"usuario"); 