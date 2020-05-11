<?php
	//Inicio o recuperdo la sesión
    session_start();
    //error_reporting(E_ALL ^ E_NOTICE);
    //Traemos libreria de model
    require_once("model_producto.php");

    /*Probamos conexicon con la funcion creada en model.php conectar_bd()
    var_dump(conectar_bd()); */

    /* Verificar si funciona desconectar_bd
    $bd = conectar_bd();
    desconectar_bd($bd); */

    if ($_SESSION["Ver"]) {
        include("partials/_header.html");
        include("partials/_nav.html");
        include("partials/_productos.html");
        include("partials/_footer.html");
    }

?>