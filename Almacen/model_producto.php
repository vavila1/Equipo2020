<?php

	//Conexion con Base de Datos
	function conectar_bd() {
		$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");

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


	function obtenerHistorial($id){
    $conexion_bd=conectar_bd();
    $consulta='call ObtenerHistorial('.$id.');';
    $resultado="";
    $resultados=mysqli_query($conexion_bd,$consulta);
    if(mysqli_num_rows($resultados)>0){
      while($row=mysqli_fetch_assoc($resultados)){
        $resultado.=$row["E_nombre"];
        $resultado.=" (".$row["H_fecha"].")";
        $resultado.="<br>";
      }
    }
    mysqli_free_result($resultados);
    desconectar_bd($conexion_bd);
    return $resultado;
  }


	//Consulta de consultar Productos en Almacen
	function consultar_productos($marca="",$tipo="",/*$estatus="",*/$almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Marca</th><th>Tipo de Producto</th><th>Unidades</th><th>Precio</th><th>Estatus</th><th>Acciones</th></tr></thead>";

		   $consulta = 'SELECT p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, t.nombre AS tp_nombre, p.cantidad AS p_cantidad, p.precio AS p_precio FROM producto AS p, marca AS m, tipo_producto AS t, empleado, almacen WHERE m.id = p.id_marca AND t.id = p.id_tipo AND almacen.id = empleado.Id_Almacen AND p.Id_Almacen = almacen.id AND p.Id_Estatus != 5 AND p.Id_Almacen = '.$almacen.'';
		
		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar
		if ($marca != "") {
			$consulta .= " AND m.id=".$marca;
		}

		if ($tipo != "") {
			$consulta .= " AND t.id=".$tipo;
		}

		/*if ($estatus != "") {
			$consulta .= " AND e.id=".$estatus;
		}*/


		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td>".$row['m_nombre']."</td>";
		    $resultado .= "<td>".$row['tp_nombre']."</td>";
		    $resultado .= "<td>".$row['p_cantidad']."</td>";
		    $resultado .= "<td>$".$row['p_precio']."</td>";
		    $resultado .= "<td>".obtenerHistorial($row['p_id'])."</td>";
		    $resultado .= "<td>";

		    if ($_SESSION["Registar"]) {
		    //Seccion de Entrada de Material
           $resultado.='<a href="#?id='.$row['p_id'].'"';
          $resultado.="".'"'.">";
           $resultado.=" ". botonEntrada();
           $resultado.="</a>";
       }
		    
		    if ($_SESSION["Editar"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="controlador_editar_producto.php?id='.$row['p_id'].'"';
           $resultado.="".'"'.">";
           $resultado.=" ". botonEditar();
           $resultado.="</a>";
           }

           //Seccion de Codigo de Barras Boton
            $resultado.='<a href="barcode.php?id='.$row['p_id'].'"';
           $resultado.="".'"'.">";
           $resultado.=" ". botonBarra();
           $resultado.="</a>";

           if ($_SESSION["Eliminar"]) {
           	//Seccion de Borrar Boton
		   $resultado.='<a href="controlador_eliminar_producto.php?id='.$row['p_id'].'"';
           $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar el producto:  ".$row['p_nombre']." ?')".'"'.">";
           $resultado.=" ". botonBorrar();
           $resultado.="</a>";
           }

           $resultado.= "</td>";

		   /* $resultado .= '<a href="controlador_eliminar_producto.php?id='.$row['p_id'].' class="waves-effect waves-light btn-small red lighten-2"><i class="material-icons">delete</i></a>';*/

		    
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}


	//Crear un select con los datos de una consulta
	
	function consultar_select($id, $columna_descripcion, $tabla, $Seleccion=0){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = '<select name ="'.$tabla.'" id ="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';

      	$consulta = "SELECT $id, $columna_descripcion FROM $tabla WHERE $id != 5 " ;
      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= '</select><label>'.$tabla.'</label></div>';

		return $resultado;

	}



	function consultar_ultimo_id(){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

      	$consulta = 'SELECT
	   						 id as p_id
					 FROM
	  						 `producto`
				     ORDER BY
	    					  id DESC
					 Limit 1' ;

      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado = $row["p_id"];
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		return $resultado;

	}

	function consultar_ultimo_estado($id_producto){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

      	$consulta = 'SELECT
	   						 id as p_id
					 FROM
	  						 `e_p`
	  				 WHERE Id_Producto = '.$id_producto.'';

		$consulta .='ORDER BY
	    					  id DESC
					 Limit 1';



      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado = $row["p_id"];
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		return $resultado;

	}

	//var_dump(consultar_ultimo_estado(1));


	// Funcion para insertar un registro de un producto en el almacen
	//Paso1: Preparar consulta
	//Paso2 Union de parametros
	//Paso3 Ejecutar la consulta
	function insertar_producto($nombre, $cantidad, $precio, $id_marca, $id_almacen, $id_tipo,$id_estatus){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//var_dump($nombre);

		//Prepaprar la consulta
		$dml = 'INSERT INTO producto (nombre, cantidad, precio, id_marca, id_almacen, id_tipo, Id_Estatus) VALUES (?,?,?,?,?,?,?) ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("sssssss", $nombre, $cantidad, $precio, $id_marca, $id_almacen, $id_tipo,$id_estatus)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}

	function insertar_producto_estatus($id_producto, $id_estatus){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		$dml = 'INSERT INTO e_p (Id_Producto, Id_Estado_producto) VALUES (?,?) ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $id_producto, $id_estatus)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}

/*UPDATE
    `producto`
SET
    `id_estatus` = 6 
WHERE
    `id` = 11*/


	function eliminar_producto($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `producto` WHERE `producto`.`id` = (?)';
		$dml = 'UPDATE `producto` SET `Id_Estatus` = 5 WHERE `id` = (?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}

function eliminar_producto_historial($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `producto` WHERE `producto`.`id` = (?)';
		$dml = 'UPDATE `e_p` SET `Id_Estado_producto` = 5 WHERE `Id_Producto` = (?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}



	function eliminar_producto_proyecto($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		$dml = 'DELETE FROM `producto_proyecto` WHERE `producto_proyecto`.`id_producto` = (?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}

	function editar_producto_estatus($id, $id_estatus){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `id_estatus` = id_estatus WHERE `producto`.`id` = id ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $id_estatus)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}


	function editar_producto_cantidad($id, $cantidad){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `cantidad` = cantidad WHERE `producto`.`id` = id ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $cantidad)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}


	function editar_producto_precio($id, $precio){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `precio` = precio WHERE `producto`.`id` = id ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("s", $precio)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		// Ejecutar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
			}

		//Desconectarse de la base de datos
			  desconectar_bd($conexion_bd);
			  return 1;
 
	}



function botonBorrar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar" title = "Eliminar Producto">
    <i class="material-icons right">delete</i>
  </button>';
    return $resultado;
  }

  function botonEditar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Producto">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }

  function botonBarra(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Codigo de Barras">
    <i class="material-icons right">receipt</i>
  </button>';
    return $resultado;
  }

  function botonEntrada(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Recibir Entrada">
    <i class="material-icons right">add_box</i>
  </button>';
    return $resultado;
  }

?>