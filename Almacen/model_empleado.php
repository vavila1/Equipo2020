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
	function consultar_empleado($nombre="",$correo="",$Id_Empleado=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$consulta = 'SELECT e.Id_Empleado as e_id, e.nombre as e_nombre, e.correo as e_correo FROM Empleado as e';

		$resultado = "<table class=\"highlight\"><thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Acciones</th></tr></thead><tbody>";
		
		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['e_id']."</td>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td>".$row['e_correo']."</td>";
		    $resultado .= "<td>";
      $resultado.='<a href="editar.php?id='.$row['e_id'].'">';
      $resultado.= botonEditar();
      $resultado.="</a>"." ";
      $resultado.='<a href="borrar.php?id='.$row['e_id'].'"';
      $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar ".$row['e_nombre']."?')".'"'.">";
      $resultado.=" ". botonBorrar();
      $resultado.="</a></td>";
      $resultado.="</tr>";
		}
		mysqli_free_result($resultados); //Liberar la memoria

		// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}

  function botonBorrar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar" title="Eliminar Almacen">
    <i class="material-icons right">delete</i>
  </button>';
    return $resultado;
  }

  function botonEditar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Almacen">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }


?>