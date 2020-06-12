<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_almacen.php");

if ($_SESSION["AgregarAlmacen"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_registraralmacen.html");
    include("partials/_formregistrarAlmacen.html");
    include("partials/_almacenes2.html");
    include("partials/_footer.html");
}else{
	header("location:logout.php");
}
?>