<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

if ($_SESSION["EditarProducto"]) {
    $_SESSION["id_producto"] = $_GET["id"];

    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_form_editar_producto.html");
    include("partials/_footer.html");
}
?>