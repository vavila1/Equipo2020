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


	
	function consultar_estadoProducto($id="",$nombre=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$consulta = 'SELECT e.id as e_id, e.nombre as e_nombre FROM estatus_producto as e';

		$resultado = "<table class=\"highlight\"><thead><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr></thead><tbody>";
		
		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['e_id']."</td>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td>";


		   if ($_SESSION["Editar"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="editarEstadoProducto.php?id='.$row['e_id'].'&nombre='.$row['e_nombre'].'"class="btn waves-effect waves-light btn-small" id="editar">';
		$resultado.='<i class="material-icons right">edit</i>';
		$resultado.="</a>"." ";
           }


		     if ($_SESSION["Eliminar"]) {
           	//Seccion de Borrar Boton
		   $resultado.='<a href="controlador_eliminar_estadoProducto.php?id='.$row['e_id'].'" class="btn waves-effect waves-light btn-small" id="borrar"';
		   $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar el estado de producto:  ".$row['e_nombre']." ?')".'"'.">";
		   $resultado.='<i class="material-icons right">delete</i>';
           $resultado.="</a>";
           }




		    $resultado .= "</td>" ;
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados);

		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

	function agregar_estadoProducto($nombre=""){

		$conexion_bd = conectar_bd();

		$consulta = 'INSERT INTO `estatus_producto` (`nombre`) VALUES ((?))';

		if ( !($statement = $conexion_bd->prepare($consulta)) ) {
    	}
    	if (!$statement->bind_param("s", $nombre)) {
    	}
    	if (!$statement->execute()) {
  		}
	
	mysqli_free_result($resultados);

    desconectar_bd($conexion_bd);


	}

function botonBorrar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar" title = "Eliminar Estado">
    <i class="material-icons right">delete</i>
  </button>';
    return $resultado;
  }

  function botonEditar($id){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Almacen">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }


  	function editar_estado_nombre($id, $nombre){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE estatus_producto SET Nombre = (?) WHERE id = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("si", $nombre,$id)) {
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


				function eliminar_estado($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `proyecto` WHERE `proyecto`.`Id_Proyecto` = (?)';
		$dml = 'DELETE FROM estatus_producto WHERE id = (?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("i", $id)) {
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


?>
