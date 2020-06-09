<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_proyecto.php");

    $proyecto_id = htmlspecialchars($_GET["id"]);
    $nombre_proyecto = htmlspecialchars($_GET["nombreProyecto"]);

if ($_SESSION["EditarProyecto"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarProyecto.html");
    include("partials/_footer.html");
}
?>