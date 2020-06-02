<?php

	//Conexion con Base de Datos
	function conectar_bd() {
		//$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
		$conexion_bd = mysqli_connect("localhost","ciasagr2_adminciasa","20Gciasa20","ciasagr2_almacenciasa");

		//verificar si la base de datos se conecto
		if( $conexion_bd == NULL){
			die("No se pudo conectar con la base de datos");
		}
		return $conexion_bd;
	}

/*BEGIN 
	SELECT
    E.nombre AS E_nombre,
    H.fecha AS H_fecha
FROM
    estatus_producto AS E,
    producto AS P,
    e_p AS H
WHERE
    E.id = H.Id_Estado_producto AND P.id = H.Id_Producto AND H.Id_Producto = id
ORDER BY
    H.fecha
DESC
LIMIT 3;
END*/

	//Cerrar conexion de Base de Datos
	//@param $conexion: Conexion que se cerrara
	function desconectar_bd($conexion_bd){
		mysqli_close($conexion_bd);
	}



	//Consulta de consultar Productos en Almacen
	function consultar_herramientas($almacen, $proyecto){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Registrar Retorno</th></tr></thead>";


		$consulta ='SELECT producto.id as p_id, producto.nombre as p_nombre FROM producto, producto_proyecto, proyecto WHERE proyecto.Id_Proyecto = producto_proyecto.Id_Proyecto AND producto.id = producto_proyecto.Id_Producto AND producto.Id_Estatus = 3  AND producto.id_tipo = 1 AND producto_proyecto.Id_Proyecto = '.$proyecto.' AND producto.Id_Almacen = '.$almacen.' GROUP BY producto.id ORDER BY producto_proyecto.Fecha_Asignacion';

		//var_dump($consulta);
		


		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";

		    $proyecto = $_GET["id"];

		    $resultado .= '<form action = "regresoHerramientasConfirmacion.php?id='.$proyecto.'&idProducto='.$row['p_id'].'" method = "POST">';	
		    $resultado .= "<td>";

		

		    //$resultado.= '<a href="salidaProductosConfirmacion.php?id='.$proyecto.'&idProduto='.$row['p_id'].'">';
            $resultado.=" ". botonRegresos();
           // $resultado.="</a>";
            $resultado .= "</form>";
		    $resultado .= "</td>";

   			
		

		    
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

	 function botonRegresos(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" title="Retorno de Producto" >REGRESAR </button>';
    return $resultado;
  }

  function registrarRetornoHerramientas(){

 

  		$conexion_bd = conectar_bd();
		// prepara la consulta

  	    $producto = $_GET["idProducto"];
  		$usuario = $_SESSION["IDempleado"];
		
		$dlmInsertarProyecto = 'call registrarRetornoHerramientas(?,?);' ;

		if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
			 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		}

     //Unir los parámetros de la función con los parámetros de la consulta   
     //El primer argumento de bind_param es el formato de cada parámetro
     if (!$statement->bind_param("ii", $producto, $usuario)) {
         die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
     }
       
     //Executar la consulta
     if (!$statement->execute()) {
       die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
     }
 
     desconectar_bd($conexion_bd);		

  }

?>