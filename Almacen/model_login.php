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

  function verificarCuenta($usuario,$password){
    $conexion_bd = conectar_bd();
    
    $consulta = 'Select C.Id_Cuenta as C_id, C.Usuario as C_usuario, C.Password as C_password From cuenta as C';
    $consulta.= ' Where C.usuario="'.$usuario.'"';
    $consulta.=' AND C.password="'.$password.'"';
    

    $resultados = mysqli_query($conexion_bd, $consulta);
    
    $resultado="";
    $resultado2="";

  if(mysqli_num_rows($resultados)>0){
    while($row = mysqli_fetch_assoc($resultados)){
      $resultado =  $row['C_usuario'];
      $resultado2 = $row['C_password'];
    }
  }
  $resultado3="false";

  if($resultado=="" && $resultado2==""){
    $resultado3 = "false";
  }else if(($usuario==$resultado) && ($password=$resultado2)){
    $resultado3 = "true";
  }

mysqli_free_result($resultados);
desconectar_bd($conexion_bd);
return $resultado3;

  }


    function autenticarRol($username, $password){
    $con = conectar_bd();
   
    $query = " SELECT p.nombre as per, e.Nombre as nom, e.id_Almacen as alm
               FROM cuenta as c , cuenta_rol as cr, rol as r, rol_privilegio as rp, privilegio as p, empleado as e
               WHERE e.Id_Empleado = c.Id_Empleado
               AND c.Id_Cuenta = cr.Id_Cuenta
               AND cr.Id_Rol = r.Id_Rol
               AND rp.Id_Rol = r.Id_Rol
               AND rp.Id_Privilegio = p.Id_Privilegio
               AND usuario='$username' 
               AND password='$password'";
      
   $result = mysqli_query($con, $query);
   
   while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
       if($row['per'] == 'Ver'){
               $_SESSION['Ver'] = 1;
       }
       if($row['per'] == 'Editar'){
           $_SESSION['Editar'] = 1;
       }
       if($row['per'] == 'Registrar'){
           $_SESSION['Registar'] = 1;
       }
       if($row['per'] == 'Eliminar'){
           $_SESSION['Eliminar'] = 1;
       }
       if($row['per'] == 'Consultar'){
           $_SESSION['Consultar'] = 1;
       }
       $_SESSION['usuario'] = $row['nom'];
       $_SESSION['almacen'] = $row['alm'];
    }
   mysqli_close($con);
}


 //Cerrar conexion de Base de Datos
    //@param $conexion: Conexion que se cerrara
    function desconectar_bd($conexion_bd){
        mysqli_close($conexion_bd);
    }




?>


