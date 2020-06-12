<?php
	//Inicio o recuperdo la sesión
    session_start();

if ($_SESSION["AgregarEP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_agregarEstadoProducto.html");
    include("partials/_footer.html");
} else{
        header("location:logout.php");
    }
?>