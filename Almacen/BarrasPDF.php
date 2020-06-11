<?php
		require_once("model_cbarra.php");
		$id = $_GET["id"];
	    echo "<section><div class=\"container\"<div class=\"row\"><div class=\"col s6\"><div class=\"container\"><h1 class=\"center\">Inventario de Productos</h1><br><br>";
	    	
	   echo consultar_productos($id);
?>