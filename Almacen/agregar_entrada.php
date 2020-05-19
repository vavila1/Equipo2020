<?php
    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");
    include("controlador_agregar_entrada.php");
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_form_agregar_entrada.html");
    include("partials/_footer.html");
?>