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
	function consultar_productos($almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Marca</th><th>Tipo de Producto</th><th>Unidades</th><th>Estatus</th><th>Cantidad</th><th>Agregar a proyecto</th></tr></thead>";


		   $consulta = 'SELECT t.nombre as t_nombre, p.cantidad as p_cantidad, p.id as p_id,  ep.nombre AS ep_nombre ,p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, t.nombre AS tp_nombre, p.cantidad AS p_cantidad FROM producto AS p, marca AS m, tipo_producto AS t, almacen, estatus_producto as ep WHERE m.id = p.id_marca AND t.id = p.id_tipo AND ep.id = p.Id_Estatus AND p.Id_Almacen = almacen.id AND p.Id_Estatus = 6 AND p.id_tipo != 6 AND p.id_tipo != 4 AND p.Id_Almacen = '.$almacen.'';
		


		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td>".$row['m_nombre']."</td>";
		    $resultado .= "<td>".$row['tp_nombre']."</td>";
		    $resultado .= "<td>".$row['p_cantidad']."</td>";
		    $resultado .= "<td>".$row['ep_nombre']."</td>";

		    $proyecto = $_GET["id"];
		    $cantidad_actual = $row['p_cantidad'];
		    $tipo = $row['t_nombre'];

		    if ($_SESSION["SalidaProyecto"]) {
		    $resultado .= '<form action = "salidaProductosConfirmacion.php?id='.$proyecto.'&idProducto='.$row['p_id'].'&cantidadActual='. $cantidad_actual.'&tipo='.$tipo.'" method = "POST">';
		    $resultado .= "<td> <input class= 'col s4' name = 'cantidad' type = 'text'></td>";
		    
		    $resultado .= "<td>";

		
		    
		    //$resultado.= '<a href="salidaProductosConfirmacion.php?id='.$proyecto.'&idProduto='.$row['p_id'].'">';
            $resultado.=" ". botonSalidas();
           // $resultado.="</a>";
            $resultado .= "</form>";
		    $resultado .= "</td>";
		    }
   			
		

		    
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

	 function botonSalidas(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" title="Salida de Producto" > AGREGAR</button>';
    return $resultado;
  }

  function registrarSalidaHerramientas($cantidad, $cantidad_actual, $tipo){

 

  			$conexion_bd = conectar_bd();
		// prepara la consulta

  	    $proyecto = $_GET["id"];
  	    $producto = $_GET["idProducto"];
  	    $usuario = $_SESSION["IDempleado"];


  	     if ($cantidad == NULL){
 	    	 $_SESSION["mensaje"] = "Debe introducir una cantidad a entregar";
 	    	 return 0;
  	    }

  	    if($cantidad <= 0){
 			$_SESSION["mensaje"] = "La cantidad debe ser mayor a cero";
 	    	 return 0;
  	    }
  	     if ($cantidad_actual - $cantidad < 0) {
			 $_SESSION["mensaje"] = "La cantidad a entregar es mayor a la disponible";
 	    	 return 0;
  	    }

  	   	if ( $tipo == "Consumible"){


  	   			if( $cantidad_actual - $cantidad == 0){
  	   					$id_estado = 2;
  	   			} else {
  	   					$id_estado = 6;
  	   			}

	  	   		$dlmInsertarProyecto = 'call registrarSalidaConsumibles(?,?,?,?,?);' ;

				if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
					 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				}

		     //Unir los parámetros de la función con los parámetros de la consulta   
		     //El primer argumento de bind_param es el formato de cada parámetro
		     if (!$statement->bind_param("iiiii", $producto,$proyecto, $usuario, $cantidad, $id_estado)) {
		         die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		     }
		       
		     //Executar la consulta
		     if (!$statement->execute()) {
		       die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		     }
		      $_SESSION["mensaje"] = "Se ha asignado el producto al proyecto con éxito";

  	   	} else if ( $tipo == "Herramienta"){

	  	   		$dlmInsertarProyecto = 'call registrarSalidaHerramienta(?,?,?,?);' ;

				if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
					 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				}

		     //Unir los parámetros de la función con los parámetros de la consulta   
		     //El primer argumento de bind_param es el formato de cada parámetro
		     if (!$statement->bind_param("iiii", $producto,$proyecto, $usuario, $cantidad)) {
		         die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		     }
		       
		     //Executar la consulta
		     if (!$statement->execute()) {
		       die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		     }
		      $_SESSION["mensaje"] = "Se ha asignado el producto al proyecto con éxito";

  	   	}



		
		

 
     desconectar_bd($conexion_bd);		

  }

?>