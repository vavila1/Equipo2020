<?php

	//Conexion con Base de Datos
	function conectar_bd() {
		$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
		//$conexion_bd = mysqli_connect("localhost","ciasagr2_adminciasa","20Gciasa20","ciasagr2_almacenciasa");
		
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
function consultar_transacciones($fecha_inicio,$fecha_fin,$proyecto,$almacen,$transaccion){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>ID Producto</th><th>Producto</th><th>Empleado Responsable</th><th>Tipo de transaccion</th><th>Supervisor</th><th>Cantidad</th><th>Precio unitario</th><th>Total</th><th>Fecha</th><th>Proyecto</th></tr></thead>";

		$consulta = 'SELECT e.supervisor as e_supervisor, p.Id_Almacen as p_Id_Almacen, p.precio as p_precio, e.cantidad as e_cantidad, p.id as p_id, t.Nombre as t_nombre, p.nombre as p_nombre, emp.Nombre as emp_nombre, e.fecha as e_fecha,e.proyecto as e_proyecto, SUM(p.precio * e.cantidad) as total
						FROM entregan as e, producto as p, empleado as emp, transaccion as t, almacen as alm 
						WHERE e.Id_Transaccion = t.Id_Transaccion AND e.Id_Producto = p.id AND e.Id_Empleado = emp.Id_Empleado AND p.Id_Almacen=alm.id'; 
		if($fecha_inicio!="" && $fecha_fin!=""){
			$consulta.=' AND e.fecha Between "'.$fecha_inicio.'" AND "'.$fecha_fin.'"';
		}
		if($proyecto!=""){
			$consulta.=' AND e.proyecto='.$proyecto;
		}
		if($almacen!=""){
					$consulta.=' AND p.Id_Almacen='.$almacen;
		}
		if($transaccion){
					$consulta.=' AND e.Id_Transaccion='.$transaccion;
		}
		if($fecha_inicio!="" && $fecha_fin!=""){
		$consulta.=' GROUP BY e.id Order BY e.fecha Asc';	
		}
		if($fecha_inicio=="" && $fecha_fin==""){
			$consulta.=' GROUP BY e.id	
						Order BY e.fecha Desc';
		}
		
		
		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_id']."</td>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    
		    $resultado .= "<td>".$row['emp_nombre']."</td>";
		    $resultado .= "<td>".$row['t_nombre']."</td>";
		    $resultado .= "<td>".$row['e_supervisor']."</td>";
		    $resultado .= "<td>".$row['e_cantidad']."</td>";
		    $resultado .= "<td>$".$row['p_precio']."</td>";
		    $resultado .= "<td> $ ".$row['total']."</td>";
		    $resultado .= "<td>".$row['e_fecha']."</td>";
		    if($row['t_nombre']!='Entrada'){
		    $resultado .= "<td> R ".$row['e_proyecto']."</td>";
		}else{
			$resultado .= "<td>".$row['e_proyecto']."</td>";
		}
		    
			
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</table>";

		return $resultado;
	}

		function consultar_stock_por_almacen($almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();
		
		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Marca</th><th>Tipo de Producto</th><th>Unidades</th><th>Precio</th><th>Estatus</th></tr></thead>";

		   $consulta = 'SELECT ep.nombre as ep_nombre, almacen.nombre as a_nom, p.Id_Estatus as p_Estatus, p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, m.id AS m_id, t.id AS tp_id, t.nombre AS tp_nombre, p.cantidad AS p_cantidad, p.precio AS p_precio FROM producto AS p, marca AS m, tipo_producto AS t, almacen, estatus_producto as ep WHERE m.id = p.id_marca AND t.id = p.id_tipo AND p.Id_Almacen = almacen.id AND p.cantidad > 0  AND p.Id_Estatus != 5 AND ep.id = p.Id_Estatus ';

		if ($almacen != "") {
			$consulta .= "AND p.Id_Almacen=".$almacen;
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
		    $resultado .= "<td>$".$row['ep_nombre']."</td>";
		}

		
		


		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</table>";

		sacar_total($almacen);
		return $resultado;
	}

		function sacar_total($almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

			$resultado = "<table class=\"highlight\"><thead><tr><th>TOTAL</th></thead>";

		   $consulta = 'SELECT
    SUM(p.precio * p.cantidad) AS total
FROM
    producto AS p,
    marca AS m,
    tipo_producto AS t,
    almacen,
    estatus_producto AS ep
WHERE
    m.id = p.id_marca AND t.id = p.id_tipo AND p.Id_Almacen = almacen.id AND p.Id_Estatus != 5 AND ep.id = p.Id_Estatus';

		if ($almacen != "") {
			$consulta .= " AND p.Id_Almacen=".$almacen;
		}

		/*if ($estatus != "") {
			$consulta .= " AND e.id=".$estatus;
		}*/



		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td><span style='font-weight:bold'>$ ".$row['total']." MXM</span></td>";
		  
		}

		



		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</table><br><br><br>";

		echo $resultado;
	}


		function consultar_calibracion($almacen){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>ID Producto</th><th>Nombre Producto</th><th>Ultima calibracion</th></tr></thead>";


		$consulta = 'SELECT p.id as p_id, p.nombre as p_nombre, e_p.fecha as fecha FROM producto as p, e_p, estatus_producto WHERE p.id = e_p.Id_Producto AND e_p.Id_Estado_producto = estatus_producto.id AND e_p.Id_Estado_producto = 1 ';

		if ($almacen != "") {
			$consulta .= "AND p.Id_Almacen=".$almacen;
		}

		/*if ($estatus != "") {
			$consulta .= " AND e.id=".$estatus;
		}*/

		$consulta .= " ORDER BY e_p.fecha DESC";
		
		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
			$resultado .= "<td>".$row['p_id']."</td>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td>".$row['fecha']."</td>";
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</table>";

		return $resultado;
	}


	//Crear un select con los datos de una consulta
	
	function crear_select($id, $columna_descripcion, $tabla){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = '<select name ="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';

      	$consulta = "SELECT $id, $columna_descripcion FROM $tabla";
      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= '</select><label>'.$tabla.'</label></div>';

		return $resultado;

	}

	function salidaMaterial($id_proyecto){
 		//Primero conectarse a la bd
 		$conexion_bd = conectar_bd();

 		$resultado = "<hr><table class=\"highlight\"><thead><tr><th>ID</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Tipo Producto</th><th>Cantidad Solicitada</th>/tr></thead>";


 		$consulta = 'SELECT
 						p.id as p_id,
 					    pp.Id_Proyecto as pp_id,
 					    p.nombre as p_nombre,
 					    m.nombre as p_marca,
 					    p.modelo as p_modelo,
 					    tp.nombre as tp_nombre,
 					    pp.Cantidad_Asignada as pp_cantidad,
 					    pp.Fecha_Asignacion as pp_fecha
 					  
 					FROM
 					    producto AS p,
 					    tipo_producto AS tp,
 					    producto_proyecto AS pp,
 					    marca as m
 					WHERE
 					    p.id_marca = m.id AND p.id = pp.Id_Producto AND tp.id = p.id_tipo  AND pp.Id_Proyecto = '.$id_proyecto.'';

 		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

 		$resultados = $conexion_bd->query($consulta);  
 		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
 			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
 			$resultado .= "<tr>";
 			$resultado .= "<td>".$row['p_id']."</td>";
 		    $resultado .= "<td>".$row['p_nombre']."</td>";
 		    $resultado .= "<td>".$row['p_marca']."</td>";
 		    $resultado .= "<td>".$row['p_modelo']."</td>";
 		    $resultado .= "<td>".$row['tp_nombre']."</td>";
 		    $resultado .= "<td>".$row['pp_cantidad']."</td>";
 		    
 		    $resultado .= "<td>".$row['e_nombre']."</td>";
 		    $resultado .= "</tr>" ;
 		}
 		mysqli_free_result($resultados); //Liberar la memoria

 		// desconectarse al termino de la consulta
 		desconectar_bd($conexion_bd);

 		$resultado .= "</table><hr>";

 		unset($_SESSION['id']);

 		return $resultado;
 	}



 function obtener_reporte($id_proyecto){
 		//Primero conectarse a la bd
 		$conexion_bd = conectar_bd();

 		$resultado = "";

 		$consulta = 'SELECT
 					    pp.Id_Proyecto as pp_id,
 					    p.nombre as p_nombre,
 					    m.nombre as p_marca,
 					    p.modelo as p_modelo,
 					    tp.nombre as tp_nombre,
 					    pp.Cantidad_Asignada as pp_cantidad,
 					    pp.Fecha_Asignacion as pp_fecha,
 					    a.nombre as a_nombre,
 					    e.Nombre as e_nombre
 					FROM
 					    producto AS p,
 					    tipo_producto AS tp,
 					    producto_proyecto AS pp,
 					    almacen AS a,
 					    empleado AS e,
 					    marca as m
 					WHERE
 					    p.id_marca = m.id AND p.id = pp.Id_Producto AND tp.id = p.id_tipo AND a.id = p.Id_Almacen AND e.Id_Almacen = p.Id_Almacen AND pp.Id_Proyecto = '.$id_proyecto.'
 					 LIMIT 1';

 		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

 		$resultados = $conexion_bd->query($consulta);  
 		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
 			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
 		;
 			$resultado .= $row['pp_id'];

 		}
 		mysqli_free_result($resultados); //Liberar la memoria

 		// desconectarse al termino de la consulta
 		desconectar_bd($conexion_bd);

 		return $resultado;
 	}

 	function obtener_almacen($id_proyecto,$opcion=""){
 		//Primero conectarse a la bd
 		$conexion_bd = conectar_bd();

 		$resultado = "";


 		$consulta = 'SELECT
 					    pp.Id_Proyecto as pp_id,
 					    p.nombre as p_nombre,
 					    m.nombre as p_marca,
 					    p.modelo as p_modelo,
 					    tp.nombre as tp_nombre,
 					    pp.Cantidad_Asignada as pp_cantidad,
 					    pp.Fecha_Asignacion as pp_fecha,
 					    a.nombre as a_nombre,
 					    e.Nombre as e_nombre
 					FROM
 					    producto AS p,
 					    tipo_producto AS tp,
 					    producto_proyecto AS pp,
 					    almacen AS a,
 					    empleado AS e,
 					    marca as m
 					WHERE
 					    p.id_marca = m.id AND p.id = pp.Id_Producto AND tp.id = p.id_tipo AND a.id = p.Id_Almacen AND e.Id_Almacen = p.Id_Almacen AND pp.Id_Proyecto = '.$id_proyecto.'
 					 LIMIT 1';

 		//Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

 		$resultados = $conexion_bd->query($consulta);  
 		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
 			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
 			if($opcion != 1){
 				$resultado .= $row['pp_fecha'];
 			}else{
 				$resultado .= $row['a_nombre'];
 			}
 			
 		}
 		mysqli_free_result($resultados); //Liberar la memoria

 		// desconectarse al termino de la consulta
 		desconectar_bd($conexion_bd);


 		return $resultado;
 	}



 	function busquedaEscrita($descripcion,$nomform){
    $resultado = '<br><br><div class="input-field col s3"><input placeholder="Escribir '.$descripcion.'" type="text" class="validate" name="'.$nomform.'"><label for="">Proyecto</label></div>';
    return $resultado;
  }


?>