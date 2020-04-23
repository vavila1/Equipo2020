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
	function consultar_EstadoProducto($nombre="",$id=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$consulta = 'SELECT t.id as t_id, t.nombre as t_nombre FROM estatus_Producto as t';

		$resultado = "<table><thead><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr></thead><tbody>";
		
		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['t_id']."</td>";
		    $resultado .= "<td>".$row['t_nombre']."</td>";
		    $resultado .= "<td>";
		    $resultado .= "<a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">edit</i></a>";
		    $resultado .= borrarBoton();
		    $resultado .= '</a>' ;
		    $resultado .= "</td>" ;
		    $resultado .= "</tr>" ;
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

function borrarBoton(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar">
    <i class="material-icons right">delete</i>
  </button>';
    return $resultado;
  }

?>