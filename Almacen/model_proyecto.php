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

		$consulta = 'SELECT p.id_Proyecto as p_idProyecto, p.nombre as p_desc, p.fecha_inicio as p_fecha, e.nombre as e_nombre FROM proyecto as p, estatusProyecto as e WHERE p.id_estatusproyecto = e.id_estatusProyecto AND p.id_estatusproyecto != 5';

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
		    $resultado .= "<td>";
		   
		     if ($_SESSION["Registar"]) {
		    //Seccion de Entrada de Material
           $resultado.='<a href="salidaProductos.php?id='.$row['p_idProyecto'].'"';
           $resultado.="".'"'.">";
           $resultado.=" ". botonSalidas();
           $resultado.="</a>";
       }
		    
		    if ($_SESSION["Editar"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="controlador_editar_producto.php?id='.$row['p_idProyecto'].'"';
           $resultado.="".'"'.">";
           $resultado.=" ". botonEditar();
           $resultado.="</a>";
           }

           if ($_SESSION["Eliminar"]) {
           	//Seccion de Borrar Boton
		   $resultado.='<a href="controlador_eliminar_proyecto.php?id='.$row['p_idProyecto'].'"';
           $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar el proyecto:  ".$row['p_desc']." ?')".'"'.">";
           $resultado.=" ". botonBorrar();
           $resultado.="</a>";
           }


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

      	$consulta = "SELECT $idEstado, $columna_descripcion FROM $tabla WHERE $idEstado != 5";
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


		function eliminar_proyecto($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `proyecto` WHERE `proyecto`.`Id_Proyecto` = (?)';
		$dml = 'UPDATE `proyecto` SET `Id_EstatusProyecto` = 5 WHERE `Id_Proyecto` = (?)';
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

  function botonSalidas(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Salida de Producto">
    <i class="material-icons right">exit_to_app</i>
  </button>';
    return $resultado;
  }

?>