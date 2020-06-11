<?php
	//Inicio o recuperdo la sesión
    session_start();

    $id = htmlspecialchars($_GET["id"]);
    $_SESSION["id_almacen"] = $id;

    require_once("model_almacen.php");

    if ($_SESSION["EditarAlmacen"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarAlmacen.html");
    include("partials/_formEditarAlmacen.html");
    include("partials/_almacenes2.html");
    include("partials/_footer.html");
}
?>