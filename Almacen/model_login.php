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


    function autenticar($username, $password){
    $con = conectar_bd();
   
    $query = " SELECT p.nombre as per, e.Nombre as nom
               FROM cuenta as c , cuenta_rol as cr, rol as r, rol_privilegio as rp, privilegio as p, empleado as e
               WHERE e.Id_Empleado = c.Id_Empleado
               AND c.Id_Cuenta = cr.Id_Cuenta
               AND cr.Id_Rol = r.Id_Rol
               AND rp.Id_Rol = r.Id_Rol
               AND rp.Id_Privilegio = p.Id_Privilegio
               AND     usuario='$username' 
               AND     contraseña='$password'";
      
   $result = mysqli_query($con, $query);
   
   while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
       if($row['per'] == 'Ver'){
               $_SESSION['Ver'] = 1;
       }
       if($row['per'] == 'Editar'){
           $_SESSION['Editar'] = 1;
       }
       if($row['per'] == 'Registar'){
           $_SESSION['Registar'] = 1;
       }
       if($row['per'] == 'Eliminar'){
           $_SESSION['Eliminar'] = 1;
       }
       if($row['per'] == 'Consultar'){
           $_SESSION['Consultar'] = 1;
       }
       $_SESSION['usuario'] = $row['nom'];
    }
   mysqli_close($con);
}


 //Cerrar conexion de Base de Datos
    //@param $conexion: Conexion que se cerrara
    function desconectar_bd($conexion_bd){
        mysqli_close($conexion_bd);
    }




?>


