create database CRM_1;
use CRM_1;

create table Users(
iduser int primary key auto_increment not null,
email varchar(50),
contraseña blob,
nombre varchar(50),
apellido varchar(50)
);

DELIMITER $$
create procedure registro_usuario(in email_form varchar(50),in contraseña_form varchar(50),in nombre_form varchar(50),in apellido_form varchar(50))
begin
insert into Users(email,contraseña,nombre,apellido) values(email_form,AES_ENCRYPT(contraseña_form,'integradora'),nombre_form,apellido_form);
end
$$
DELIMITER $$
DROP procedure login_usuario;
$$

DELIMITER $$
call registro_usuario('test','test','test','test');
$$

DELIMITER $$
create procedure login_usuario(in email_login varchar(50))
begin
 select cast(AES_DECRYPT(contraseña,'integradora') as char) as 'contraseña' from users where email = email_login ;
end
$$

select cast(AES_DECRYPT(contraseña,'integradora') as char) from users;
select contraseña from users;
insert into users(contraseña) values( AES_ENCRYPT('1234','integradora'));


DELIMITER $$
create procedure verificar_usuario(in pass_login varchar(50),in correo_login varchar(50))
begin

end
$$

create table Direccion(
idDireccion int primary key,
calle varchar(50),
CP varchar(50),
NumExterior varchar(50)
);

create table Cliente(
idCliente int primary key,
empresa varchar(50),
CdMatriz varchar(50),
presupuesto decimal(10,2),
estatus varchar(50),
fkidDireccion int,
foreign key (fkidDireccion) references Direccion(idDireccion)
);

create table Especiales(
idEspecial int primary key,
TipoEspecial varchar(50),
cantidad int,
FechaInicio date,
FechaLimite date
);

create table DetOrdenes(
idDetOrden int primary key,
cantidad int,
FechaInicio date,
FechaLimite date,
estatus varchar(50)
);

create table Ordenes(
idOrden int primary key,
fkidDetOrdenes int,
FechaInicio date,
FechaFinal date,
fkidCliente int,
fkidEspecial int,
foreign key (fkidDetOrdenes) references DetOrdenes(idDetOrden),
foreign key (fkidCliente) references Cliente(idCliente),
foreign key (fkidEspecial) references Especiales(idEspecial)
);

create table Usuarios(
idUsuario int primary key,
Nombre_Usuario varchar(50),
correo_Usuario varchar(100),
contraseña_usuario varchar(200),

);

insert into Direccion values ('1','Portal Del Sol','27442','3314');
insert into Cliente values ('1','Chevrolet','Detroit',10000,'Activo','1');
insert into Especiales values ('1','Body Part','50','01-10-2024','05-10-2024');
insert into DetOrdenes values('1','300','12-10-2024','17-10-2024','Activo');
insert into Ordenes(idOrden,FechaInicio,FechaFinal) values ('1','12-10-2024','17-10-2024');
insert into Usuarios values ('1','Jaime Enrique','licenciadojaime@outlook.com','contraseña');

create view V_Direccion as
 select * from Direccion;
create view V_Cliente as 
 select *  from Cliente;
create view V_Especiales as 
 select * from Especiales;
create view  V_Detordenes as 
 select * from DetOrdenes;
create view V_Ordenes as 
 select * from Ordenes;
create view V_Usuarios as 
 select * from Usuarios;

delimiter $$
create procedure  sp_cambiarestado(in estado varchar(50),in id int)
begin 
update Cliente set estatus =estado where idCliente=id;
end
$$

delimiter $$
create procedure  sp_cambiarestadoOrden(in estado varchar(50),in id int)
begin 
update DetOrdenes set estatus =estado where idDetOrdenid;
end
$$
select * from Cliente

delimiter $$
call sp_cambiarestado('Inactivo','1');
$$

