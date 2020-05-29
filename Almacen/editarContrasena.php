<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_empleado.php");

    $id_empleado = htmlspecialchars($_GET["id"]);
    $contra = htmlspecialchars($_GET["ps"]);


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarContra.html");
    include("partials/_footer.html");

?>