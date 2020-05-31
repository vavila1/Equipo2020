<?php 
  session_start();
  require_once("model_empleado.php");  


  $_POST["nombre"] = htmlspecialchars($_POST["nombre"]);
  $_POST["correo"] = htmlspecialchars($_POST["correo"]);
  $_POST["usuario"] = htmlspecialchars($_POST["usuario"]);
  $_POST["contra"] = htmlspecialchars($_POST["contra"]);

  $_POST["puesto"] = htmlspecialchars($_POST["puesto"]);
  $_POST["almacen"] = htmlspecialchars($_POST["almacen"]);
  $_POST["rol"] = htmlspecialchars($_POST["rol"]);



  if((isset($_POST["nombre"])) && (isset($_POST["correo"])) && (isset($_POST["usuario"])) && (isset($_POST["contra"])) && (isset($_POST["puesto"])) && (isset($_POST["almacen"])) && (isset($_POST["rol"])) ) {
      insertar_empleado($_POST["nombre"], $_POST["correo"] , $_POST["usuario"] , $_POST["contra"] , $_POST["puesto"] , $_POST["almacen"] , $_POST["rol"]);
      $_SESSION["mensaje"] = "Se completo el registro";
  }  else {
            $_SESSION["warning"] = "Ocurrio un error al registrar la cuenta";
        }

  header("location:cuentas.php");
?>



   