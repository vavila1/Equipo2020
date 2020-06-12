<?php

    //Conexion con Base de Datos
    function conectar_bd() {
      //$conexion_bd = mysqli_connect("localhost","root","","almacenciasa");
      $conexion_bd = mysqli_connect("localhost","ciasagr2_adminciasa","20Gciasa20","ciasagr2_almacenciasa");

      $conexion_bd->set_charset("utf8");

        //verificar si la base de datos se conecto
        if( $conexion_bd == NULL){
            die("No se pudo conectar con la base de datos");
        }
        return $conexion_bd;
    }

  function verificarCuenta($usuario,$password){
    $conexion_bd = conectar_bd();
    $hash_pass = encriptarPassword($password);
    $consulta = 'Select C.Id_Cuenta as C_id, C.Usuario as C_usuario, C.Password as C_password From cuenta as C';
    $consulta.= ' Where C.usuario="'.$usuario.'"';
    $consulta.=' AND C.password="'.$hash_pass.'"';
    

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
  }else if(($usuario==$resultado) && ($hash_pass=$resultado2)){
    $resultado3 = "true";
  }

mysqli_free_result($resultados);
desconectar_bd($conexion_bd);
return $resultado3;

  }


    function autenticarRol($username, $password){
    $con = conectar_bd();
    $hash_pass = encriptarPassword($password);
    $query = " SELECT   e.Id_Empleado as e_id, p.nombre as per, e.Nombre as nom, e.id_Almacen as alm, a.nombre as a_nombre
               FROM cuenta as c , cuenta_rol as cr, rol as r, rol_privilegio as rp, privilegio as p, empleado as e, almacen as a
               WHERE e.Id_Empleado = c.Id_Empleado
               AND c.Id_Cuenta = cr.Id_Cuenta
               AND cr.Id_Rol = r.Id_Rol
               AND rp.Id_Rol = r.Id_Rol
               AND rp.Id_Privilegio = p.Id_Privilegio
               AND e.id_Almacen=a.id
               AND usuario='$username' 
               AND password='$hash_pass'";
      
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
       if($row['per'] == 'VerInicio'){
               $_SESSION['VerInicio'] = 1;
       }
       if($row['per'] == 'VerReporte'){
           $_SESSION['VerReporte'] = 1;
       }
       if($row['per'] == 'ConsultarReporte'){
           $_SESSION['ConsultarReporte'] = 1;
       }
       if($row['per'] == 'DescargarReporte'){
           $_SESSION['DescargarReporte'] = 1;
       }
       if($row['per'] == 'VerProyecto'){
           $_SESSION['VerProyecto'] = 1;
       }
       if($row['per'] == 'ConsultarProyecto'){
               $_SESSION['ConsultarProyecto'] = 1;
       }
       if($row['per'] == 'AgregarProyecto'){
           $_SESSION['AgregarProyecto'] = 1;
       }
       if($row['per'] == 'SalidaProyecto'){
           $_SESSION['SalidaProyecto'] = 1;
       }
       if($row['per'] == 'EntradaProyecto'){
           $_SESSION['EntradaProyecto'] = 1;
       }
       if($row['per'] == 'EditarProyecto'){
           $_SESSION['EditarProyecto'] = 1;
       }
       if($row['per'] == 'EliminarProyecto'){
               $_SESSION['EliminarProyecto'] = 1;
       }
       if($row['per'] == 'VerInventario'){
           $_SESSION['VerInventario'] = 1;
       }
       if($row['per'] == 'ConsultarInventario'){
           $_SESSION['ConsultarInventario'] = 1;
       }
       if($row['per'] == 'AgregarInventario'){
           $_SESSION['AgregarInventario'] = 1;
       }
       if($row['per'] == 'CalibrarProducto'){
           $_SESSION['CalibrarProducto'] = 1;
       }
       if($row['per'] == 'RecibirProducto'){
               $_SESSION['RecibirProducto'] = 1;
       }
       if($row['per'] == 'EditarProducto'){
           $_SESSION['EditarProducto'] = 1;
       }
       if($row['per'] == 'ImprimirCB'){
           $_SESSION['ImprimirCB'] = 1;
       }
       if($row['per'] == 'EliminarProducto'){
           $_SESSION['EliminarProducto'] = 1;
       }
       if($row['per'] == 'VerAlmacen'){
           $_SESSION['VerAlmacen'] = 1;
       }
       if($row['per'] == 'ConsultarAlmacen'){
               $_SESSION['ConsultarAlmacen'] = 1;
       }
       if($row['per'] == 'AgregarAlmacen'){
           $_SESSION['AgregarAlmacen'] = 1;
       }
       if($row['per'] == 'EditarAlmacen'){
           $_SESSION['EditarAlmacen'] = 1;
       }
       if($row['per'] == 'EliminarAlmacen'){
           $_SESSION['EliminarAlmacen'] = 1;
       }
       if($row['per'] == 'VerMarcas'){
           $_SESSION['VerMarcas'] = 1;
       }
       if($row['per'] == 'ConsultarMarcas'){
               $_SESSION['ConsultarMarcas'] = 1;
       }
       if($row['per'] == 'AgregarMarcas'){
           $_SESSION['AgregarMarcas'] = 1;
       }
       if($row['per'] == 'EditarMarcas'){
           $_SESSION['EditarMarcas'] = 1;
       }
       if($row['per'] == 'EliminarMarcas'){
           $_SESSION['EliminarMarcas'] = 1;
       }
       if($row['per'] == 'VerTP'){
           $_SESSION['VerTP'] = 1;
       }
       if($row['per'] == 'ConsultarTP'){
               $_SESSION['ConsultarTP'] = 1;
       }
       if($row['per'] == 'AgregarTP'){
           $_SESSION['AgregarTP'] = 1;
       }
       if($row['per'] == 'EditarTP'){
           $_SESSION['EditarTP'] = 1;
       }
       if($row['per'] == 'EliminarTP'){
           $_SESSION['EliminarTP'] = 1;
       }
       if($row['per'] == 'VerEP'){
           $_SESSION['VerEP'] = 1;
       }
       if($row['per'] == 'ConsultarEP'){
               $_SESSION['ConsultarEP'] = 1;
       }
       if($row['per'] == 'AgregarEP'){
           $_SESSION['AgregarEP'] = 1;
       }
       if($row['per'] == 'EditarEP'){
           $_SESSION['EditarEP'] = 1;
       }
       if($row['per'] == 'EliminarEP'){
           $_SESSION['EliminarEP'] = 1;
       }
       if($row['per'] == 'VerUsuario'){
           $_SESSION['VerUsuario'] = 1;
       }
       if($row['per'] == 'ConsultarUsuario'){
               $_SESSION['ConsultarUsuario'] = 1;
       }
       if($row['per'] == 'AgregarUsuario'){
           $_SESSION['AgregarUsuario'] = 1;
       }
       if($row['per'] == 'EditarUsuario'){
           $_SESSION['EditarUsuario'] = 1;
       }
       if($row['per'] == 'EliminarUsuario'){
           $_SESSION['EliminarUsuario'] = 1;
       }
       if($row['per'] == 'ContraseñaUsuario'){
           $_SESSION['ContraseñaUsuario'] = 1;
       }
       if($row['per'] == 'TerminarProyecto'){
           $_SESSION['TerminarProyecto'] = 1;
       }
       $_SESSION['usuario'] = $row['nom'];
       $_SESSION['almacen'] = $row['alm'];
       $_SESSION["IDempleado"] = $row['e_id'];
       $_SESSION["nomalm"]=$row['a_nombre'];
    }
   mysqli_close($con);
}


 //Cerrar conexion de Base de Datos
    //@param $conexion: Conexion que se cerrara
    function desconectar_bd($conexion_bd){
        mysqli_close($conexion_bd);
    }

    //Consulta de consultar Productos en Almacen
  function consultar_transacciones(){
    //Primero conectarse a la bd
    $conexion_bd = conectar_bd();

    $resultado = "<table class=\"highlight\"><thead><tr><th>Producto</th><th>Tipo de transaccion</th><th>Empleado Responsable</th><th>Cantidad</th><th>Fecha</th><th>Proyecto</th></tr></thead>";


    $consulta = 'SELECT e.cantidad as e_cantidad, p.id as p_id, t.Nombre as t_nombre, p.nombre as p_nombre, emp.Nombre as emp_nombre, e.fecha as e_fecha,e.proyecto as e_proyecto
            FROM entregan as e, producto as p, empleado as emp, transaccion as t 
            WHERE e.Id_Transaccion = t.Id_Transaccion AND e.Id_Producto = p.id AND e.Id_Empleado = emp.Id_Empleado AND emp.id_Almacen = '.$_SESSION['almacen'].'
            Order BY e.fecha Desc
            LIMIT 5';
    
    //Ahora con el buscador necesitamos un validador de que es lo que quiere buscar

    $resultados = $conexion_bd->query($consulta);  
    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
      //$resultado .= $row[0]; //Se puede usar el índice de la consulta
      $resultado .= "<tr>";
        $resultado .= "<td>".$row['p_nombre']."</td>";
        $resultado .= "<td>".$row['t_nombre']."</td>";
        $resultado .= "<td>".$row['emp_nombre']."</td>";
        $resultado .= "<td>".$row['e_cantidad']."</td>";
        $resultado .= "<td>".$row['e_fecha']."</td>";
        if($row['t_nombre']!='Entrada'){
        $resultado .= "<td> R ".$row['e_proyecto']."</td>";
    }else{
      $resultado .= "<td>".$row['e_proyecto']."</td>";
    }
        $resultado .= "</tr>" ;
    }
    mysqli_free_result($resultados); //Liberar la memoria

    // desconectarse al termino de la consulta
    desconectar_bd($conexion_bd);

    $resultado .= "</table>";

    return $resultado;
  }


  function encriptarPassword($contraseña){
    //$hash = password_hash($contraseña, PASSWORD_DEFAULT, ['cost' => 10]);
    $hash = hash('sha3-224', $contraseña);
    return $hash;
  }



?>


