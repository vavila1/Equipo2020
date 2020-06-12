<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_EstadoProducto.php");


    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());

if ($_SESSION["VerEP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_estadoProducto.html");
    include("partials/_footer.html");
} else{
        header("location:logout.php");
    }
?>