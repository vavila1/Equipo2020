<?php

	//Inicio o recuperdo la sesión
    session_start();

    include("partials/_header.html");

    // verificar si hay sesión activa
    if(isset($_SESSION["usuario"]) && isset($_SESSION["password"])) {

    	//codigo si ya estaba con sesion activa
    	include("partials/_mainSection.html");
    	include("partials/_nav.html");

    // Se crea la sesión si no hay sesión activa
    } else if (isset($_POST["usuario"]) && isset($_POST["usuario"])) {

    	//Creo la variable de sesión inicio.
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["password"] = $_POST["password"];
        var_dump($_SESSION["usuario"]);
        var_dump($_SESSION["password"]);

        include("partials/_mainSection.html");
        include("partials/_nav.html");

     // Redirecciona al Login para crear sesion
    } else {
    	include("login.php");
    }

    include("partials/_footer.html");

?>
