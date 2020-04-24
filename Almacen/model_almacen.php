<?php 
  //función para conectarnos a la BD
  function conectar_bd() {
      $conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
      if ($conexion_bd == NULL) {
          die("No se pudo conectar con la base de datos");
      }
      return $conexion_bd;
  }

  //función para desconectarse de una bd
  //@param $conexion: Conexión de la bd que se va a cerrar
  function desconectar_bd($conexion_bd) {
      mysqli_close($conexion_bd);
  }

  function getFruits($id,$nombre,$estado){
    $conexion_bd = conectar_bd();
      $resultado = "<table><thead><tr><th>ID</th><th>Nombre</th><th>Estado</th></tr></thead>";
    
    $consulta = 'Select A.id as A_id, A.nombre as A_nombre, E.nombre as E_nombre From almacen as A, estado as E Where A.id_estado = E.id';


    /* Para evitar los 16 ifs resultantes de las combinaciones entre cada variable, se simplificó de tal forma que se creó una variable y esta variable va a contener todas las condiciones de la consulta. Si no hay una anterior, se pondra como inicial de una consulta. Si hay una anterior, se agregara con un AND.
    */
    if($id!=""){
      $consulta .= " AND A.id=".$id;
    }
    if($nombre!=""){
      $consulta .= " AND A.nombre='".$nombre."'";
    }
    if($estado!=""){
      $consulta.= " AND E.id='".$estado."'";
    }
    
    $consulta.= " Group by A.id";
    

    $resultados = mysqli_query($conexion_bd, $consulta);
    $mensaje = "Hola";

    


  if(mysqli_num_rows($resultados)>0){
    while($row = mysqli_fetch_assoc($resultados)){
      $resultado.="<tr>";
      $resultado.="<td>" . $row['A_id'] . "</td>";
      $resultado.="<td>" . $row['A_nombre'] . "</td>";
      $resultado.="<td>" . $row['E_nombre'] . "</td>";
      $resultado.="<td>";
      $resultado.='<a href="editar.php?id='.$row['A_id'].'">';
      $resultado.= botonEditar();
      $resultado.="</a>"." ";
      $resultado.='<a href="borrar.php?id='.$row['A_id'].'"';
      $resultado.="onclick=".'"'."return confirm('¿Estás seguro que deseas borrar ".$row['A_nombre']."?')".'"'.">";
      $resultado.=" ". botonBorrar();
      $resultado.="</a></td>";
      $resultado.="</tr>";
    }
  }




mysqli_free_result($resultados);
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

  function selectFruits($id, $columna, $tabla){
    $conexion_bd = conectar_bd();
    $resultado = '<div class="input-field"><select name="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';
    $consulta = "SELECT $id, $columna FROM $tabla";
    $resultados = mysqli_query($conexion_bd,$consulta);
    if(mysqli_num_rows($resultados)>0){
  while($row = mysqli_fetch_assoc($resultados)){
    $resultado .= '<option value="'.$row["$id"].'">'.$row["$columna"].'</option>';
  }
}
    desconectar_bd($conexion_bd);
     $resultado .=  '</select><label>'.$columna." ".$tabla.'...</label></div>';
    return $resultado;
  }


  function busquedaEscrita($descripcion,$nomform){
    $resultado = '<div class="input-field"><input placeholder="Escribir '.$descripcion.'" type="text" class="validate" name="'.$nomform.'"><label for="">'.$descripcion.' del Almacen</label></div>';
    return $resultado;
  }

  function borrarAlmacen($id){

     $conexion_bd = conectar_bd();
    $consulta = 'Delete From almacen Where id=(?)';


    /*Con el siguiente codigo se puede encontrar el error en caso de existir.*/

    if ( !($statement = $conexion_bd->prepare($consulta)) ) {
    }
    if (!$statement->bind_param("i", $id)) {
    }
    if (!$statement->execute()) {

  }

    desconectar_bd($conexion_bd);

  }

function editarAlmacen($id,$estado){

     $conexion_bd = conectar_bd();
    $consulta = 'Update almacen Set id_estado=(?) WHERE id=(?)';


    /*Con el siguiente codigo se puede encontrar el error en caso de existir.*/

    if ( !($statement = $conexion_bd->prepare($consulta)) ) {
    }
    if (!$statement->bind_param("ii", $estado,$id)) {
    }
    if (!$statement->execute()) {

  }

    desconectar_bd($conexion_bd);

  }




  function insertarPaciente($nombre,$estado){
    $conexion_bd = conectar_bd();
    $consulta = 'Insert Into almacen (nombre, id_estado) Values (?,?) ';


    /*Con el siguiente codigo se puede encontrar el error en caso de existir.*/

    if ( !($statement = $conexion_bd->prepare($consulta)) ) {
    }
    if (!$statement->bind_param("ss", $nombre, $estado)) {
    }
    if (!$statement->execute()) {

  }

    desconectar_bd($conexion_bd);
  }




?>