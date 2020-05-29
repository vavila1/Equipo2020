<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_empleado.php");

        if (isset($_POST["nueva"])) {
        $nueva = htmlspecialchars($_POST["nueva"]);

        editar_contra($nueva,$_GET['id']);
        $_SESSION["mensaje"] = "Se cambió la contraseña";
        }

         else {
            $_SESSION["warning"] = "Ocurrio un error al hacer el cambio";
        }
    

    header("location:cuentas.php");

?>