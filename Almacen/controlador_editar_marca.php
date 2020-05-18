<?php
  session_start();
  require_once("model_marca.php");  


   $_POST["nombreMarca"] = htmlspecialchars($_POST["nombreMarca"]);



  if(isset($_POST["nombreMarca"])) {
      if (editar_marca_nombre($_POST["num"], $_POST["nombreMarca"])) {
          $_SESSION["mensaje"] = "Se editó la marca";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar la marca";
      }
  }


  header("location:marcas.php");
?>