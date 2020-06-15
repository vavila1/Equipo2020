<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_reportes.php");

if ($_SESSION["SalidaProyecto"]) {
    $id_proyecto = $_SESSION["id"];
    include("partials/_headerpdf.html");
    include("partials/reporteSalidas.html");
    include("partials/_footer.html");
}else{
	header("location:logout.php");
}
?>