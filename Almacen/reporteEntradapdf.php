<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_reportes.php");

    include("partials/_header.html");
    include("partials/reporteEntradasSalidas.html");
    include("partials/_footer.html");

?>