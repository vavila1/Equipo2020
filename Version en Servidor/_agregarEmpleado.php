<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_empleado.php");
 if ($_SESSION["AgregarUsuario"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_form_Empleado.html");
    include("partials/_footer.html");
} else{
        header("location:logout.php");
    }
?>