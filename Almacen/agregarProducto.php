<?php
	//Inicio o recuperdo la sesión
    session_start();

if ($_SESSION["AgregarInventario"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_agregarProducto.html");
    include("partials/_footer.html");
}
?>