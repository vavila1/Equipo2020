<?php
	//Inicio o recuperdo la sesión
    session_start();
    require_once("model_proyecto.php");

    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_focus_productos.html");
    include("partials/_reportes.html");
    include("partials/_footer.html");

?>