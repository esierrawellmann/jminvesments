create database tmbs;
use tmbs;
create table role (
id_role int auto_increment,
nombre varchar(512) not null,
primary key(id_role)
) engine = InnoDB; 

create table permiso (
id_permiso int auto_increment,
nombre varchar(512) not null,
primary key(id_permiso)
) engine = InnoDB; 

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

create table tipo_producto(
id_tipo_producto int auto_increment,
nombre varchar(512) not null,
primary key(id_tipo_producto)
) engine=InnoDB; 

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
foreign key(id_venta) references venta(id_venta),
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
foreign key(id_compra) references compra(id_compra),
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


















