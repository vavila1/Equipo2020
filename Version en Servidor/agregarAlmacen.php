<?php
	//Inicio o recuperdo la sesión
    session_start();

if ($_SESSION["AgregarAlmacen"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_agregarAlmacen.html");
    include("partials/_footer.html");
} else{
        header("location:logout.php");
    }
?>