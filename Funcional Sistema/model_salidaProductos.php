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
	function consultar_productos($almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Marca</th><th>Tipo de Producto</th><th>Unidades</th><th>Estatus</th><th>Cantidad</th><th>Agregar a proyecto</th></tr></thead>";


		   $consulta = 'SELECT p.id as p_id,  ep.nombre AS ep_nombre ,p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, t.nombre AS tp_nombre, p.cantidad AS p_cantidad FROM producto AS p, marca AS m, tipo_producto AS t, empleado, almacen, estatus_producto as ep WHERE m.id = p.id_marca AND t.id = p.id_tipo AND ep.id = p.Id_Estatus AND almacen.id = empleado.Id_Almacen AND p.Id_Almacen = almacen.id AND p.Id_Estatus = 6 AND p.Id_Almacen = '.$almacen.'';
		


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

		    $resultado .= '<form action = "salidaProductosConfirmacion.php?id='.$proyecto.'&idProducto='.$row['p_id'].'" method = "POST">';
		    $resultado .= "<td> <input class= 'col s4' name = 'cantidad' type = 'text'></td>";
		
		    $resultado .= "<td>";

		

		    //$resultado.= '<a href="salidaProductosConfirmacion.php?id='.$proyecto.'&idProduto='.$row['p_id'].'">';
            $resultado.=" ". botonSalidas();
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

	 function botonSalidas(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" title="Salida de Producto" > AGREGAR</button>';
    return $resultado;
  }

  function registrarSalidaHerramientas($cantidad){

 

  			$conexion_bd = conectar_bd();
		// prepara la consulta

  	    $proyecto = $_GET["id"];
  	    $producto = $_GET["idProducto"];
  
  	    $usuario = 2;
		
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
 
     desconectar_bd($conexion_bd);		

  }

?>