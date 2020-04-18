<?php

	//Inicio o recuperdo la sesión
    session_start();


    include("partials/_header.html");
    require_once("model_login.php");


    // verificar si hay sesión activa
    if(isset($_SESSION["usuario"])) {

    	//codigo si ya estaba con sesion activa
    	include("partials/_mainSection.html");
    	include("partials/_nav.html");

    // Se crea la sesión si no hay sesión activa
    } else if (isset($_POST["usuario"]) && isset($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];
        
        autenticar($usuario,$password);
        var_dump($_SESSION);

       /* var_dump($_SESSION["usuario"]);
        var_dump($_SESSION["password"]);
        var_dump(autenticar($_POST["usuario"],$_POST["password"]));*/
        if ($_SESSION['Ver']) {
            include("partials/_mainSection.html");
            include("partials/_nav.html");
        }
        else{
            include("logout.php");
        }
        

     // Redirecciona al Login para crear sesion
    } else {
    	include("login.php");
    }

    include("partials/_footer.html");

?>


