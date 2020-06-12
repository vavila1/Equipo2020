<?php

	//Conexion con Base de Datos
	function conectar_bd() {
		//$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
		$conexion_bd = mysqli_connect("localhost","ciasagr2_adminciasa","20Gciasa20","ciasagr2_almacenciasa");

		$conexion_bd->set_charset("utf8");

		//verificar si la base de datos se conecto
		if( $conexion_bd == NULL){
			die("No se pudo conectar con la base de datos");
		}
		return $conexion_bd;
	}

	//Cerrar conexion de Base de Datos
	//@param $conexion: Conexion que se cerrara
	function desconectar_bd($conexion_bd){
		mysqli_close($conexion_bd);
	}


	//Consulta de consultar Productos en Almacen
	function consultar_productos($id=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th></tr></thead>";

		/*$consulta = 'SELECT pr.descripcion as pr_descripcion, m.nombre as m_nombre, pr.cantidad as pr_cantidad, pr.precio as pr_precio, tp.nombre as tp_nombre, e.nombre as e_nombre FROM producto as pr, productotiene as pt, marca as m, tipoproducto as tp, estatus as e WHERE pr.id_producto = pt.id_producto AND m.id_marca = pt.id_marca AND tp.id_tipo = pt.id_tipo AND e.id_estatus = pt.id_estatus'; */

		$consulta = 'SELECT
		    p.id AS p_id,
		    p.nombre AS p_nombre
		FROM
		    producto AS p
		WHERE
		    
		';

		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar
		if ($id != "") {
			$consulta .= " p.id=".$id;
		}


		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta

			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "</tr>" ;
		    $resultado .= "<tr>";
		    $resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    $resultado .= "<td><div class=\"col s6\"><svg id=\"barcode\"></svg></div></td>";
		    
		    $resultado .= "</tr>" ;
		    $resultado .= '<script src="scripts/JsBarcode.all.min.js"></script>';
		    $resultado .= '<script type="text/javascript">JsBarcode("#barcode", "'.$row['p_id'].'", {
	          format: "codabar",
	          lineColor: "#000",
	          width: 2,
	          height: 40,
	          displayValue: true
	      });
	    </script>';
	}
		
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}


?>