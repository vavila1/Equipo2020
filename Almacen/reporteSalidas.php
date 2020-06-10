<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_reportes.php");

    $id_proyecto = $_SESSION["id"];
    include("partials/_header.html");
    include("partials/reporteSalidas.html");
    include("partials/_footer.html");

?>