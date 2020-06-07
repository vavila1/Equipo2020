<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_empleado.php");

    //var_dump($_GET["id"]);
    $idEmpleado =  htmlspecialchars($_GET["idEmp"]);
    $idCuenta = htmlspecialchars($_GET["idCuenta"]);

    if (isset($idEmpleado) && isset($idCuenta)) {
        eliminar_cuenta($idEmpleado, $idCuenta);
        $_SESSION["delete"] = "Se ha eliminado la cuenta con exito";
    }

    header("location:cuentas.php");


?>