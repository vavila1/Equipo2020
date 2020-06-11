<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_tipoProducto.php");

    $proyecto_id = htmlspecialchars($_GET["id"]);
    $nombre_proyecto = htmlspecialchars($_GET["nombre"]);

if ($_SESSION["EditarTP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarTipoProducto.html");
    include("partials/_footer.html");
}
?>