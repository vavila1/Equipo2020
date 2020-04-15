<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_almacen.php");

    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_registraralmacen.html");
    include("partials/_formregistrarAlmacen.html");
    include("partials/despliegue_registrarAlmacen.php");
    include("partials/_almacenes2.html");
    include("partials/_footer.html");


?>