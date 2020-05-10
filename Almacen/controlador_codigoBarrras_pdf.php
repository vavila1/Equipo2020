<?php
session_start();
	//Traemos libreria de model
    require_once("model_cbarra.php");
    $id = $_GET["id"];
	    include("partials/_generarCodigo.html");
?>