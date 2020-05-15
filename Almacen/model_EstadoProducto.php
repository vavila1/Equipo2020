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


	//Consulta de consultar Empleados
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
		   	$resultado .='<a href="editarEstado.php?id='.$row['e_id'].'"';
           	$resultado .="".'"'.">";
           	$resultado .=" ". botonEditar();
           	$resultado .="</a>";
		    $resultado .='<a href="controlador_eliminar_estado.php?id='.$row['e_id'].'"';
           	$resultado .="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar el estado:  ".$row['e_nombre']." ?')".'"'.">";
           	$resultado .=" ". botonBorrar();
           	$resultado .="</a>";
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

  function botonEditar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Producto">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }

?>
