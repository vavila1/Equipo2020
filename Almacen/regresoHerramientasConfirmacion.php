<?php
    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_retornoHerramientas.php");

    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());

    registrarRetornoHerramientas();


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_retornoHerramientas.html");

    include("partials/_footer.html");

?>