<?php
    session_start();

    require_once("model_producto.php");

     if ($_SESSION["VerMarcas"]) { 
        include("partials/_header.html");
        include("partials/_nav.html");
        include("partials/_configuracion.html");
        include("partials/_footer.html");
    } else {
    	header("location:logout.php");
    }

?>