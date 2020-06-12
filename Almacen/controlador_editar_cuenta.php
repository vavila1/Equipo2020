<?php
  session_start();
  require_once("model_empleado.php");  


   $_POST["nombre"] = htmlspecialchars($_POST["nombre"]);
   $_POST["correo"] = htmlspecialchars($_POST["correo"]);
   $_POST["usuario"] = htmlspecialchars($_POST["usuario"]);
   $_POST["puesto"] = htmlspecialchars($_POST["puesto"]);
   $_POST["almacen"] = htmlspecialchars($_POST["almacen"]);
   $_POST["rol"] = htmlspecialchars($_POST["rol"]);




  if(isset($_POST["nombre"])) {
      if (editar_cuenta_nombre($_POST["idempleado"], $_POST["nombre"])) {
          $_SESSION["mensaje"] = "Se editó la cuenta";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar la cuenta";
      }
  }
  if(isset($_POST["correo"])) {
      if (editar_cuenta_correo($_POST["idempleado"], $_POST["correo"])) {
           $_SESSION["mensaje"] = "Se editó la cuenta";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar la cuenta";
      }
  }
  if(isset($_POST["usuario"])) {
      if (editar_cuenta_usuario($_POST["idcuenta"], $_POST["usuario"])) {
           $_SESSION["mensaje"] = "Se editó la cuenta";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar la cuenta";
      }
  }
  if(isset($_POST["puesto"])) {
      if (editar_cuenta_puesto($_POST["idempleado"], $_POST["puesto"])) {
          $_SESSION["mensaje"] = "Se editó la cuenta";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar la cuenta";
      }
  }
  

  header("location:cuentas.php");
?>