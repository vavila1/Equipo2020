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


	//Consulta de consultar Proyectos en lab14
	function consultar_proyectos($estado = ""){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = "<table class=\"highlight\"><thead><tr><th>ID_Proyecto</th><th>Descripcion</th><th>Fecha de inicio</th><th>Estado</th><th>Acciones</th>";
		 if ($_SESSION["TerminarProyecto"]) {
				$resultado .= "<th>Terminar proyecto</th>";
					}
		$resultado .= "</tr></thead>";

		$consulta = 'SELECT p.Nombre as p_nombre, p.Id_Proyecto as p_idProyecto, p.Fecha_Inicio as p_fecha, e.Nombre as e_nombre, e.Id_EstatusProyecto as e_id FROM proyecto as p, estatusproyecto as e WHERE p.Id_EstatusProyecto = e.Id_EstatusProyecto AND p.Id_EstatusProyecto != 5';

		if($estado != ""){
			$consulta .= " AND e.id_estatusproyecto= ".$estado;
		}

		$resultados = $conexion_bd->query($consulta);  

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			//$resultado .= $row[0]; //Se puede usar el índice de la consulta
			$resultado .= "<tr>";
		    $resultado .= "<td>R ".$row['p_idProyecto']."</td>";
		    $resultado .= "<td>".$row['p_nombre']."</td>";
		    $resultado .= "<td>".$row['p_fecha']."</td>";
		    $resultado .= "<td>".$row['e_nombre']."</td>";
		    $resultado .= "<td>";
		    //Seccion de Entrada de Material
		    if ($row['e_nombre'] != "Terminado"){
	           $resultado.= '<a href="salidaProductos.php?id='.$row['p_idProyecto'].'"';
	           $resultado.="".'"'.">";
	           $resultado.=" ". botonSalidas();
	           $resultado.="</a>";  

	           $resultado.= '<a href="retornoHerramientas.php?id='.$row['p_idProyecto'].'"';
           	   $resultado.="".'"'.">";
               $resultado.=" ". botonRetornos();
               $resultado.="</a>";  
       		} else{
       		   $resultado.= '<a';
	           $resultado.="".'"'.">";
	           $resultado.=" ". botonDesSalidas();
	           $resultado.="</a>";  

	           $resultado.= '<a';
           	   $resultado.="".'"'.">";
               $resultado.=" ". botonDesRetornos();
               $resultado.="</a>"; 
       		}

		   
		    if ($_SESSION["EditarProyecto"]) {
		    //Seccion de Editar Boton
		   $resultado.='<a href="editarProyecto.php?id='.$row['p_idProyecto'].'&nombreProyecto='.$row['p_nombre'].'&estatus='.$row['e_id'].'">';
           $resultado.=" ". botonEditar();
           $resultado.="</a>";
           }

           if ($_SESSION["EliminarProyecto"]) {
           	//Seccion de Borrar Boton
		   $resultado.='<a href="controlador_eliminar_proyecto.php?id='.$row['p_idProyecto'].'"';
           $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar el proyecto:  ".$row['p_nombre']." ?')".'"'.">";
           $resultado.=" ". botonBorrar();
           $resultado.="</a>";
    }
          if ($_SESSION["TerminarProyecto"]) {
		   $resultado .= "<td>";
		   if ($row['e_nombre'] != "Terminado"){
		   		$resultado.='<a href="controlador_terminar_proyecto.php?id='.$row['p_idProyecto'].'"';
           		$resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas marcar como terminado el proyecto: R.".$row['p_idProyecto']." ?')".'"'.">";
          		$resultado.="<button class = 'btn waves-effect waves-light btn-small' title = 'terminar proyecto'>Terminar</button>";
          		$resultado.="</a><br>";
		   }
		}
		   
           $resultado .= "</td>";


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

	function insertar_proyecto($folio,$estatus, $nombrem, $fecha, $supervisor){

		$conexion_bd = conectar_bd();
		// prepara la consulta
		
		$dlmInsertarProyecto = 'INSERT INTO proyecto (Id_Proyecto, Id_EstatusProyecto, Nombre, fecha_Inicio, id_supervisor) VALUES (?,?,?,?,?)' ;

		if( !($statement = $conexion_bd->prepare($dlmInsertarProyecto))){
			 die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		}

     //Unir los parámetros de la función con los parámetros de la consulta   
     //El primer argumento de bind_param es el formato de cada parámetro
     if (!$statement->bind_param("iissi", $folio,$estatus, $nombrem, $fecha, $supervisor)) {
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

		function terminar_proyecto($id){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();

		//Prepaprar la consulta
		//$dml = 'DELETE FROM `proyecto` WHERE `proyecto`.`Id_Proyecto` = (?)';
		$dml = 'UPDATE proyecto SET Fecha_Fin = CURRENT_TIMESTAMP, Id_EstatusProyecto = 1 WHERE Id_Proyecto = (?)';
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
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="borrar" title = "Eliminar Proyecto">
    <i class="material-icons right">delete</i>
  </button>';
    return $resultado;
  }

  function botonEditar(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Editar Proyecto">
    <i class="material-icons right">edit</i>
  </button>';
    return $resultado;
  }


  function botonSalidas(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Salida de Producto">
    <i class="material-icons right">exit_to_app</i>
  </button>';
    return $resultado;
  }

  function botonRetornos(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Retorno de Herramientas">
    <i class="material-icons right">assignment_return</i>
  </button>';
    return $resultado;
  }


  	function botonDesSalidas(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Salida de Producto" disabled>
    <i class="material-icons right">exit_to_app</i>
  </button>';
    return $resultado;
  }

  function botonDesRetornos(){
    $resultado = '<button class="btn waves-effect waves-light btn-small" type="submit" id="editar" title="Retorno de Herramientas" disabled>
    <i class="material-icons right">assignment_return</i>
  </button>';
    return $resultado;
  }




  function editar_proyecto_estatus($id, $id_estatus){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE proyecto SET Id_EstatusProyecto = (?) WHERE Id_Proyecto = (?) ';

		if ( !($statement = $conexion_bd->prepare($dml)) ){
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
			}

		// Unir los parametros de la funcion con los parametros de la consulta
		// El primer argumento de bind_param es el formato de cada parametro
		if (!$statement->bind_param("ii", $id_estatus, $id)) {
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


	function editar_proyecto_nombre($id, $nombre){
		//Primero conectarse a la base de datos
		$conexion_bd = conectar_bd();
		
		//Prepaprar la consulta
		$dml = 'UPDATE proyecto SET Nombre = (?) WHERE Id_Proyecto = (?)';

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
function consultar_editar_select($id, $columna_descripcion, $tabla, $seleccion){
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

function busquedaEscrita($descripcion,$nomform){
    $resultado = '<div class="input-field col s3"><input placeholder="Escribir '.$descripcion.'" type="text" class="validate" name="'.$nomform.'"><label for=""> Proyecto</label></div>';
    return $resultado;
  }

function consultar_supervisor($id, $columna_descripcion, $tabla){
		//Primero conectarse a la bd
		$conexion_bd = conectar_bd();

		$resultado = '<select name ="'.$tabla.'" id ="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';

      	$consulta = "SELECT $id, $columna_descripcion FROM $tabla WHERE Id_Puesto = 2" ;
      	$resultados = $conexion_bd->query($consulta);
      	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
		}
      
      	// desconectarse al termino de la consulta
		desconectar_bd($conexion_bd);

		$resultado .= '</select><label>'.$tabla.'</label></div>';

		return $resultado;

	}

?>