<?php
    //Inicio o recuperdo la sesión
    session_start();
    $id = htmlspecialchars($_GET['id']);
    $_SESSION['ID_ADD'] = $id; 
    //Traemos libreria de model
    	require_once("model_producto.php");
if ($_SESSION["RecibirProducto"]) {
    	include("partials/_header.html");
    	include("partials/_nav.html");
    	include("partials/_form_agregar_entrada.html");
    	include("partials/_footer.html");
}
?>