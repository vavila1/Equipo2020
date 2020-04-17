<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_almacen.php");

    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarAlmacen.html");
    include("partials/_formEditarAlmacen.html");
    include("partials/_despliegueEditarAlmacen.php");
    include("partials/_almacenes2.html");
    include("partials/_footer.html");

?>