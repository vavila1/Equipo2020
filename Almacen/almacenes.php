<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_almacen.php");

if ($_SESSION["VerAlmacen"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_almacenes.html");
    include("partials/_formAlmacen.html");
    include("partials/_despliegueAlmacen.php");
    include("partials/_almacenes2.html");
    include("partials/_footer.html");
}
?>