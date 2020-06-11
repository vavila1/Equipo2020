<?php

	//Inicio o recuperdo la sesión
    session_start();

    include("partials/_header.html");
    require_once("model_login.php");

    if (isset($_POST["usuario"])) {
        $_POST["usuario"] = htmlspecialchars($_POST["usuario"]);
    }
    if (isset($_POST["password"])) {
        $_POST["password"]= htmlspecialchars($_POST["password"]);
    }


    // verificar si hay sesión activa
    if(isset($_SESSION["usuario"])) {

    	//codigo si ya estaba con sesion activa
        include("partials/_nav.html");
    	include("partials/_mainSection.html");
    	

    // Se crea la sesión si no hay sesión activa
    }else if(isset($_POST["usuario"]) && isset($_POST["password"])){
        $resultado=verificarCuenta($_POST["usuario"],$_POST["password"]);
        if($resultado=="true"){
        autenticarRol($_POST["usuario"],$_POST["password"]);
        include("partials/_nav.html");
        include("partials/_mainSection.html");
        }else if($resultado=="false"){
            $error = "Usuario y/o password incorrectos";
            include("login.php");
        }    
    }else{
    include("login.php");
}

    include("partials/_footer.html");

?>


