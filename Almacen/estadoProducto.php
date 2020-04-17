<?php
	//Inicio o recuperdo la sesión
    session_start();


    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_estadoProducto.html");
    include("partials/_footer.html");

?>