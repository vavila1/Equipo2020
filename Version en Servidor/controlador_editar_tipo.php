<?php
  session_start();
  require_once("model_tipoProducto.php");  


   $_POST["nombreTipo"] = htmlspecialchars($_POST["nombreTipo"]);



  if(isset($_POST["nombreTipo"])) {
      if (editar_tipo_nombre($_POST["num"], $_POST["nombreTipo"])) {
          $_SESSION["mensaje"] = "Se editó el tipo de producto";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar el tipo de producto";
      }
  }


  header("location:tipoProducto.php");
?>