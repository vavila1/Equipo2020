<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_empleado.php");

    $nombre = htmlspecialchars($_GET["nombre"]);
    $correo = htmlspecialchars($_GET["correo"]);
    $usuario = htmlspecialchars($_GET["usuario"]);
    $idRol = htmlspecialchars($_GET["rol"]);
    $idPuesto = htmlspecialchars($_GET["puesto"]);
    $idAlmacen = htmlspecialchars($_GET["almacen"]);
    $idEmpleado = htmlspecialchars($_GET["idEmp"]);
    $idCuenta = htmlspecialchars($_GET["idCuenta"]);


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarCuenta.html");
    include("partials/_footer.html");

?>