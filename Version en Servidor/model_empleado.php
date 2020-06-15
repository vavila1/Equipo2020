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


	//Consulta de consultar Empleados
	function consultar_empleado($nombre="",$correo="",$Id_Empleado=""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$consulta = ' SELECT c.Id_Cuenta as c_idC, c.Password as c_pswrd, e.Id_Empleado as e_id, e.Nombre as e_nombre, e.Correo as e_correo, a.nombre as a_nombre, c.Usuario as c_usuario, p.Nombre as p_nombre, r.Nombre as r_nombre, c.Id_Estatusgeneral, p.Id_Puesto as id_puesto, r.Id_Rol as id_rol, a.id as a_id
					  FROM empleado as e, cuenta as c, cuenta_rol as cr, puesto as p, almacen as a, rol as r
					  WHERE e.Id_Empleado = c.Id_Empleado AND c.Id_Estatusgeneral = 1 AND e.Id_Puesto = p.Id_Puesto AND e.Id_Almacen = a.id AND c.Id_Cuenta = cr.Id_Cuenta AND r.Id_Rol = cr.Id_Rol';

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
     	 if ($_SESSION["EditarUsuario"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="editarCuenta.php?idEmp='.$row['e_id'].'&idCuenta='.$row['c_idC'].'&correo='.$row['e_correo'].'&usuario='.$row['c_usuario'].'&nombre='.$row['e_nombre'].'&puesto='.$row['id_puesto'].'&rol='.$row['id_rol'].'&almacen='.$row['id_rol'].'"class="btn waves-effect waves-light btn-small" id="editar">';
           $resultado.='<i class="material-icons right">edit</i>';//. botonEditar();
           $resultado.="</a>"." ";
           }
           	 if ($_SESSION["ContraseñaUsuario"]) {
       $resultado.='<a href="editarContrasena.php?id='.$row['e_id'].'&ps='.$row['c_pswrd'].'&name='.$row['e_nombre'].'"class="btn waves-effect waves-light btn-small" id="editar">';
       $resultado.='<i class="material-icons right">lock</i>';
        $resultado.="</a>"." ";
    }
       if ($_SESSION["EliminarUsuario"]) {
           	//Seccion de Borrar Boton
		   $resultado.='<a href="controlador_eliminar_cuenta.php?idEmp='.$row['e_id'].'&idCuenta='.$row['c_idC'].'"class="btn waves-effect waves-light btn-small" id="borrar"';
           $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar la cuenta de  ".$row['e_nombre']." ?')".'"'.">";
           $resultado.='<i class="material-icons right">delete</i>';//. botonBorrar();
           $resultado.="</a>";
           }
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


	function encriptarPassword($contraseña){
		//$hash = password_hash($contraseña, PASSWORD_DEFAULT, ['cost' => 10]);
		$hash = hash('sha3-224', $contraseña);
		return $hash;
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


		function eliminar_cuenta($idE, $idC){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `proyecto` WHERE `proyecto`.`Id_Proyecto` = (?)';
		$dml = 'UPDATE cuenta as c SET Id_Estatusgeneral = 2, c.Password = "cuentaeliminada" WHERE Id_Empleado = (?) AND Id_Cuenta = (?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ii", $idE, $idC)) {
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

	  function crear_select_editar($id, $columna_descripcion, $tabla, $seleccion=0) {
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


  	function editar_cuenta_nombre($id, $nombre){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE empleado SET Nombre = (?) WHERE Id_Empleado = (?)';

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

  	function editar_cuenta_correo($id, $correo){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE empleado SET Correo = (?) WHERE Id_Empleado = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("si", $correo,$id)) {
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

  	function editar_cuenta_usuario($id, $usuario){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE cuenta SET Usuario = (?) WHERE Id_Cuenta = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("si", $usuario,$id)) {
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

  	function editar_cuenta_puesto($id, $puesto){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE empleado SET Id_puesto = (?) WHERE Id_Empleado = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $puesto,$id)) {
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

  	function editar_cuenta_almacen($id, $almacen){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE empleado SET Id_Almacen = (?) WHERE Id_Empleado = (?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $almacen,$id)) {
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

  	function editar_cuenta_rol($id, $rol){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE cuenta_rol SET Id_Rol = (?) WHERE Id_Cuenta = (?)';



		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ss", $almacen,$id)) {
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


	function busquedaEscrita($descripcion,$nomform){
    $resultado = '<div class="input-field col s3"><input placeholder="Escribir '.$descripcion.'" type="text" class="validate" name="'.$nomform.'"><label for="">Usuario</label></div>';
    return $resultado;
  }
?>