<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_proyecto.php");

if ($_SESSION["AgregarProyecto"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_agregarProyecto.html");
    include("partials/_footer.html");
}
?>