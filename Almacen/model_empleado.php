<?php

	//Conexion con Base de Datos
	function conectar_bd() {
		//$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
		$conexion_bd = mysqli_connect("localhost","ciasagr2_adminciasa","20Gciasa20","ciasagr2_almacenciasa");

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

		$consulta = ' SELECT  c.Password as c_pswrd, e.Id_Empleado as e_id, e.Nombre as e_nombre, e.Correo as e_correo, a.nombre as a_nombre, c.Usuario as c_usuario, p.Nombre as p_nombre, r.Nombre as r_nombre
					  FROM empleado as e, cuenta as c, cuenta_rol as cr, puesto as p, almacen as a, rol as r
					  WHERE e.Id_Empleado = c.Id_Empleado AND e.Id_Puesto = p.Id_Puesto AND e.Id_Almacen = a.id AND c.Id_Cuenta = cr.Id_Cuenta AND r.Id_Rol = cr.Id_Rol';

		$resultado = "<table class=\"highlight\"><thead><tr><th>Nombre</th><th>Correo</th><th>Almacen</th><th>Usuario</th><th>Puesto</th><th>Rol</th><th>Acciones</th></tr></thead><tbody>";
		
		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<tr>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td>".$row['e_correo']."</td>";
		    $resultado .= "<td>".$row['a_nombre']."</td>";
		    $resultado .= "<td>".$row['c_usuario']."</td>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td>".$row['r_nombre']."</td>";


		    $resultado .= "<td>";
      $resultado.='<a href="editar.php?id='.$row['e_id'].'">';
      $resultado.= botonEditar();
      $resultado.="</a>"." ";
       $resultado.='<a href="editarContrasena.php?id='.$row['e_id'].'&ps='.$row['c_pswrd'].'"class="btn waves-effect waves-light btn-small" id="editar">';
       $resultado.='<i class="material-icons right">lock</i>';
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


	function consultar_select_empleado($idEstado, $columna_descripcion,$tabla){
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

		$resultado .= '</select><label>'.$tabla.'</label>';

		return $resultado;

	}


  function botonBorrar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar" title="Eliminar Cuenta">
    <i class="material-icons right">delete</i>
  </button>'; 	
    return $resultado;
  }

    function botonContra(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Eliminar Cuenta">
    <i class="material-icons right">lock</i>
  </button>'; 	
    return $resultado;
  }

  function botonEditar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Cuenta">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }



	function insertar_empleado($nombre,$correo,$usuario,$contra,$puesto,$almacen,$rol){

		$conexion_bd = conectar_bd();
		// prepara la consulta
		
		$dlmInsertarProyecto = 'call crearCuenta(?,?,?,?,?,?,?)' ;

		if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
			 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		}

     //Unir los parámetros de la función con los parámetros de la consulta   
     //El primer argumento de bind_param es el formato de cada parámetro
     if (!$statement->bind_param("iissssi", $puesto, $almacen, $correo, $nombre, $usuario, $contra, $rol)) {
         die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
     }
       
     //Executar la consulta
     if (!$statement->execute()) {
       die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
     }
 
     desconectar_bd($conexion_bd);		


	}



	  function editar_contra($nueva, $id_empleado){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE cuenta as c SET c.Password = (?) WHERE c.Id_Empleado = (?)';

		//var_dump($dml);

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("si", $nueva, $id_empleado)) {
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