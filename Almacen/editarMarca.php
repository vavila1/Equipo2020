<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_tipoProducto.php");

    $marca_id = htmlspecialchars($_GET["id"]);
    $nombre_marca = htmlspecialchars($_GET["nombre"]);


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarTipoMarca.html");
    include("partials/_footer.html");

?>