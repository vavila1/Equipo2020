<?php
		session_start();
		$a = $id;
	    echo "<section><div class=\"container\"<div class=\"row\"><div class=\"col s12\"><div class=\"container\"><h1 class=\"center\">Inventario de Productos</h1><br><br>";

	   echo consultar_productos($id);

	   include ('partials/_generarCodigo.html');
	   include ('partials/_footer.html');

?>


