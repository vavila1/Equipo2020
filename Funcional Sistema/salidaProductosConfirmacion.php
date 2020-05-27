<?php
    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_salidaProductos.php");
    $cantidad = $_POST["cantidad"];

    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());

    registrarSalidaHerramientas($cantidad);


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_salidaProductos.html");

    include("partials/_footer.html");

?>