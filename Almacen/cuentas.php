<?php
	//Inicio o recuperdo la sesión
    session_start();

if ($_SESSION["VerUsuario"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_cuentas.html");
    include("partials/_footer.html");
}
?>