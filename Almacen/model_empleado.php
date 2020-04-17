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
	function consultar_empleado($nombre="",$correo="",$id_empleado=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table><thead><tr><th>Nombre</th><th>Correo</th><th>ID</th><th>Acciones</th></tr></thead>";

		$consulta = 'SELECT e.Id_Empleado as e_id, e.nombre as e_nombre, e.correo as e_correo FROM Empleado as e';
		
		$resultados = $conexion_bd->query($consulta);  
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['e_id']."</td>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td>".$row['e_correo']."</td>";
		    $resultado .= "<td>";
		    $resultado .= "<a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">add_box</i></a>";
		    $resultado .= "<a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">edit</i></a>";
		    $resultado .= "<a class=\"waves-effect waves-light btn-small\"><i class=\"material-icons\">receipt</i></a>";
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