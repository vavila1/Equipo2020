<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_EstadoProducto.php");
    
  if ($_SESSION["EditarEP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarEstado.html");
    include("partials/_footer.html");
} else{
        header("location:logout.php");
    }
?>