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

	//Cerrar conexion de Base de Datos
	//@param $conexion: Conexion que se cerrara
	function desconectar_bd($conexion_bd){
		mysqli_close($conexion_bd);
	}


	//Consulta de consultar Proyectos en lab14
	function consultar_proyectos($estado = ""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table><thead><tr><th>ID_Proyecto</th><th>Descripcion</th><th>Fecha de inicio</th><th>Terminado</th><th>Acciones</th></tr></thead>";

		$consulta = 'SELECT p.id_Proyecto as p_idProyecto, p.nombre as p_desc, p.fecha_inicio as p_fecha, e.nombre as e_nombre FROM proyecto as p, estatusProyecto as e WHERE p.id_estatusproyecto = e.id_estatusProyecto';

		if($estado != ""){
			$consulta .= " AND e.id_estatusproyecto= ".$estado;
		}

		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['p_idProyecto']."</td>";
		    $resultado .= "<td>".$row['p_desc']."</td>";
		    $resultado .= "<td>".$row['p_fecha']."</td>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td><a class=\"waves-effect waves-light btn-small red lighten-2\"><i class=\"material-icons\">delete</i></a><a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">edit</i></a><a class=\"waves-effect waves-light btn-small\" href=\"registrarIngresoProductos.php\"><i class=\"material-icons\">add_box</i></a><a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">vpn_key</i></a></td>" ;
		    $resultado .= "</tr>";
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

	//Crear un select con los datos de una consulta
	
	function consultar_select_proyectos($idEstado, $columna_descripcion,$tabla){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = '<select name ="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';

      	$consulta = "SELECT $idEstado, $columna_descripcion FROM $tabla";
      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= '<option value="'.$row["$idEstado"].'">'.$row["$columna_descripcion"].'</option>';
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= '</select><label>'.$tabla.'</label></div>';

		return $resultado;

	}

	//funcion para insertar un registro de un nuevo proyecto

	function insertar_proyecto($folio,$estatus, $nombrem,$inicio,$fin){

		$conexion_bd = conectar_bd();
		// prepara la consulta
		
		$dlmInsertarProyecto = 'INSERT INTO proyecto (id_Proyecto, id_estatusproyecto, nombre, fecha_inicio, fecha_fin) VALUES (?,?,?,?,?)' ;

		if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
			 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		}

     //Unir los parámetros de la función con los parámetros de la consulta   
     //El primer argumento de bind_param es el formato de cada parámetro
     if (!$statement->bind_param("iisss", $folio,$estatus, $nombrem,$inicio,$fin)) {
         die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
     }
       
     //Executar la consulta
     if (!$statement->execute()) {
       die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
     }
 
     desconectar_bd($conexion_bd);		


	}

?>