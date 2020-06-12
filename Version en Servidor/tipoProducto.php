<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_tipoProducto.php");
    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());

if ($_SESSION["VerTP"]) {
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_tipoProductos.html");
    include("partials/_footer.html");
} else{
    header("location:logout.php");
}
?>