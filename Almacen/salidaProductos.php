<?php
    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_salidaProductos.php");

    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());

    if ($_SESSION["SalidaProyecto"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_salidaProductos.html");
    include("partials/_footer.html");
    } else{
    header("location:logout.php");
}

?>