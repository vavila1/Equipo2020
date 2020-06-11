<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_reportes.php");

if ($_SESSION["VerReporte"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_focus_productos.html");
    include("partials/_reportes.html");
    include("partials/_footer.html");
} else{
	header("location:logout.php");
}
?>