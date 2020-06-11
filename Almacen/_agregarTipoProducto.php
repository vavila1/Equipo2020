<?php
	//Inicio o recuperdo la sesión
    session_start();

if ($_SESSION["AgregarTP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_agregarTipoProducto.html");
    include("partials/_footer.html");
}
?>
