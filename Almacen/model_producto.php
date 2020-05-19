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

		   $consulta = 'SELECT p.Id_Estatus as p_Estatus, p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, m.id AS m_id, t.id AS tp_id, t.nombre AS tp_nombre, p.cantidad AS p_cantidad, p.precio AS p_precio FROM producto AS p, marca AS m, tipo_producto AS t, empleado, almacen WHERE m.id = p.id_marca AND t.id = p.id_tipo AND almacen.id = empleado.Id_Almacen AND p.Id_Almacen = almacen.id AND p.Id_Estatus != 5 AND p.Id_Almacen = '.$almacen.'';
		
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
		    	if ($row['tp_nombre'] == "Consumible") {
		    		//Seccion de Entrada de Material
		           $resultado.='<a href="agregar_entrada.php?id='.$row['p_id'].'&producto='.$row['p_nombre'].'"';
		           $resultado.="".'"'.">";
		           $resultado.=" ". botonEntrada();
		           $resultado.="</a>";
		    	} else if ($row['tp_nombre'] == "Herramienta" && $row['p_Estatus'] == 1) {
		    	//Seccion de Borrar Boton
				   $resultado.='<a href="controlador_calibracion_herramienta.php?id='.$row['p_id'].'&estatus='.$row['p_Estatus'].'"';
		           $resultado.="onclick=".'"'."return confirm('¿Quieres registar la finalización de la calibración para la Herramienta:  ".$row['p_nombre']." ?')".'"'.">";
		           $resultado.=" ". botonEntradaCalibracion();
		           $resultado.="</a>";
		    	} else if ($row['tp_nombre'] == "Herramienta") {
		    	//Seccion de Borrar Boton
				   $resultado.='<a href="controlador_calibracion_herramienta.php?id='.$row['p_id'].'&estatus='.$row['p_Estatus'].'"';
		           $resultado.="onclick=".'"'."return confirm('¿Quieres registar calibración para la Herramienta:  ".$row['p_nombre']." ?')".'"'.">";
		           $resultado.=" ". botonCalibracion();
		           $resultado.="</a>";
		    	} 
       		}
		    
		    if ($_SESSION["Editar"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="editarProducto.php?id='.$row['p_id'].'&nombre='.$row['p_nombre'].'&tipo='.$row['tp_id'].'&marca='.$row['m_id'].'&precio='.$row['p_precio'].'&estatus='.$row['p_Estatus'].'"';
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
	
	function consultar_select($id, $columna_descripcion, $tabla){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = '<select name ="'.$tabla.'" id ="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';

      	$consulta = "SELECT $id, $columna_descripcion FROM $tabla WHERE $id != 5" ;
      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= '</select><label>'.$tabla.'</label></div>';

		return $resultado;

	}


	function consultar_editar_select($id, $columna_descripcion, $tabla, $seleccion=0){
		$conexion_bd = conectar_bd();  
      
	    $resultado = '<div class="input-field"><select name="'.$tabla.'" id="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';
	            
	    $consulta = "SELECT $id, $columna_descripcion FROM $tabla";
	    $resultados = $conexion_bd->query($consulta);
	    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
	        $resultado .= '<option value="'.$row["$id"].'" ';
	        if($seleccion == $row["$id"]) {
	            $resultado .= 'selected';
	        }
	        $resultado .= '>'.$row["$columna_descripcion"].'</option>';
	    }
	        
	    desconectar_bd($conexion_bd);
	    $resultado .=  '</select><label>'.$tabla.'...</label></div>';
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


	function editar_producto($Nombre, $Precio, $Id_marca, $Id_tipo,$Id_estatus,$Id_producto){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//var_dump($nombre);

		//Prepaprar la consulta
		$dml = 'UPDATE producto SET nombre = (?), precio = (?), id_marca = (?), id_tipo = (?), Id_Estatus = (?) WHERE id = (?)';
		
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ssssss", $Nombre, $Precio, $Id_marca, $Id_tipo,$Id_estatus,$Id_producto)) {
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


	function editar_producto_estatus($id_historial,$id_estatus){  //update e_p
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE `e_p` SET `Id_Estado_producto` = (?) WHERE `e_p`.`id` = (?) ';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $id_estatus,$id_historial)) {
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
		$dml = 'INSERT INTO `e_p`(`Id_Producto`, `Id_Estado_producto`) VALUES ((?),5)';
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


	function registar_calibracion($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `producto` WHERE `producto`.`id` = (?)';
		$dml = 'UPDATE `producto` SET `Id_Estatus` = 1 WHERE `id` = (?)';
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

function registar_calibracion_historial($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `producto` WHERE `producto`.`id` = (?)';
		$dml = 'INSERT INTO `e_p`(`Id_Producto`, `Id_Estado_producto`) VALUES ((?),1)';
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



	function registar_termino_calibracion($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `producto` WHERE `producto`.`id` = (?)';
		$dml = 'UPDATE `producto` SET `Id_Estatus` = 6 WHERE `id` = (?)';
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

function registar_termino_calibracion_historial($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//UPDATE `e_p` SET `Id_Estado_producto` = 6 WHERE `Id_Producto` = (?)
		$dml = 'INSERT INTO `e_p`(`Id_Producto`, `Id_Estado_producto`) VALUES ((?),6)';
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


	function editar_producto_precio($precio,$id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `precio` = (?) WHERE `producto`.`id` = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}
		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $precio,$id)) {
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

	function editar_producto_nombre($nombre,$id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `nombre` = (?) WHERE `producto`.`id` = (?);';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}
		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $nombre, $id)) {
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

	function editar_producto_tipo($id_tipo,$id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `id_tipo` = (?) WHERE `producto`.`id` = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}
		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $id_tipo,$id)) {
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

	function editar_producto_marca($id_marca,$id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `id_marca` = (?) WHERE `producto`.`id` = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}
		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $id_marca,$id)) {
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

	function editar_producto_idestatus($id_estatus,$id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		//Prepaprar la consulta
		$dml = 'UPDATE `producto` SET `Id_Estatus` = (?) WHERE `producto`.`id` = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}
		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $id_estatus,$id)) {
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


  function botonCalibracion(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Registar Calibración">
    <i class="material-icons right">build</i>
  </button>';
    return $resultado;
  }


  function botonEntradaCalibracion(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Entrada de herramienta en calibración">
    <i class="material-icons right">build</i>
  </button>';
    return $resultado;
  }

  function busquedaEscrita($descripcion,$nomform){
    $resultado = '<div class="input-field"><input placeholder="Escribir '.$descripcion.'" type="text" class="validate" name="'.$nomform.'"><label for="">'.$descripcion.' del Producto</label></div>';
    return $resultado;
  }
  
  function registrarEntrada($id,$cantidad){
  	$conexion_bd=conectar_bd();
  	$consulta = 'Select P.cantidad as P_cantidad From producto as P Where P.id='.$id;
  	$resultados = mysqli_query($conexion_bd, $consulta);
  	if(mysqli_num_rows($resultados)>0){
    while($row = mysqli_fetch_assoc($resultados)){
    	$resultado = $row['P_cantidad'];
    }
  }
  mysqli_free_result($resultados);
  $resultado = $resultado+$cantidad;
  $consulta='Update producto Set cantidad=(?) Where id=(?)';
  if ( !($statement = $conexion_bd->prepare($consulta)) ) {
    }
    if (!$statement->bind_param("ii", $resultado,$id)) {
    }
    if (!$statement->execute()) {

  }
  desconectar_bd($conexion_bd);
  }

?>