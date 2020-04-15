
create table Privilegio (
    Id_Privilegio int(10) NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR(20),
    PRIMARY KEY (Id_Privilegio)
);


create table Puesto (
    Id_Puesto int(10) NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR (20),
    PRIMARY KEY (Id_Puesto)
);

create table Rol (
    Id_Rol int(10) NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR(20),
    PRIMARY KEY (Id_Rol)
);

create table  Empleado (
    Id_Empleado int(10) NOT NULL AUTO_INCREMENT,
    Id_Puesto int(10),
    Correo VARCHAR(50),
    Nombre VARCHAR (20),
    PRIMARY KEY (Id_Empleado)
);

create table Cuenta (
    Id_Cuenta int(10) NOT NULL AUTO_INCREMENT,
    Id_Empleado int(10),
    Usuario VARCHAR(20),
    Contraseña VARCHAR(20),
    PRIMARY KEY (Id_Cuenta),
    FOREIGN KEY (Id_Empleado) references Empleado (Id_Empleado)
);


create table Cuenta_Rol (
  Id_Cuenta int(10),
  Id_Rol int(10),
  PRIMARY KEY (Id_Cuenta,Id_Rol),
  FOREIGN KEY (Id_Rol) REFERENCES Rol (Id_Rol),
  FOREIGN KEY (Id_Cuenta) REFERENCES Cuenta (Id_Cuenta)
);

create table Rol_Privilegio(
  Id_Rol int(10),
  Id_Privilegio int(10),
  PRIMARY KEY (Id_Rol,Id_Privilegio),
  FOREIGN KEY (Id_Rol) REFERENCES Rol (Id_Rol),
  FOREIGN KEY (Id_Privilegio) REFERENCES Privilegio (Id_Privilegio)
);


create table Transaccion (
    Id_Transaccion int (10) NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR (20),
    PRIMARY KEY (Id_Transaccion)
);

create table estado(
    id int(10) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR (20),
    PRIMARY KEY (id)
);

create table  almacen (
    id int(10) NOT NULL AUTO_INCREMENT,
    id_estado int(10),
    nombre VARCHAR(20),
    PRIMARY KEY (id),
    FOREIGN KEY (id_estado) REFERENCES estado(id)
);

create table EstatusProyecto (
    Id_EstatusProyecto int(10) NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR(20),
    PRIMARY KEY (Id_EstatusProyecto)
);

create table Proyecto(
    Id_Proyecto int(10) NOT NULL,
    Id_EstatusProyecto int(10),
    Nombre VARCHAR (10),
    Fecha_Inicio TIMESTAMP,
    Fecha_Fin DATETIME,
    PRIMARY KEY (Id_Proyecto),
    FOREIGN KEY (Id_EstatusProyecto) references EstatusProyecto (Id_EstatusProyecto)
);

create table estatus_producto (
    id int(10) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(20),
    PRIMARY KEY (id)
);

create table marca(
  id int(10) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20),
   PRIMARY KEY (id)
);

create table  tipo_producto(
  id int(10) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20),
   PRIMARY KEY (id)
);

create table producto (
    id int(10) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50),
    cantidad int(10),
    precio int(10),
    id_marca int(10),
    id_estatus int(10),
    id_tipo int(10),
    PRIMARY KEY (id),
    FOREIGN KEY (id_marca) references marca (id),
    FOREIGN KEY (id_estatus) references estatus_producto (id),
    FOREIGN KEY (id_tipo) references tipo_producto (id)
);

create table Producto_Proyecto (
    Id_Producto int(10),
    Id_Proyecto int(10),
    Cantidad_Asignada int(10),
    Fecha_Asignacion TIMESTAMP,
    PRIMARY KEY (Id_Producto, Id_Proyecto),
    FOREIGN KEY (Id_Proyecto) references Proyecto (Id_Proyecto),
    FOREIGN KEY (Id_Producto) references producto (id)
);

create table Entregan(
   Id_Transaccion int(10),
   Id_Producto int(10),
   Id_Almacen int(10),
   Id_Empleado int(10),
   Fecha TIMESTAMP,
   PRIMARY KEY (Id_Transaccion,Id_Producto,Id_Almacen,Id_Empleado),
   FOREIGN KEY (Id_Transaccion) references Transaccion (Id_Transaccion),
   FOREIGN KEY (Id_Producto) references producto (id),
   FOREIGN KEY (Id_Almacen) references almacen (id),
   FOREIGN KEY (Id_Empleado) references Empleado (id_Empleado)
  );
