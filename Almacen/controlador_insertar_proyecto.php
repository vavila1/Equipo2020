<?php 
  require_once("model_proyecto.php");  

  $_POST["nombreProyecto"] = htmlspecialchars($_POST["nombreProyecto"]);
  $_POST["num"] = htmlspecialchars($_POST["num"]);
  //$_POST["estatusProyecto"] = htmlspecialchars($_POST["estatusProyecto"]);

  //var_dump($_POST["nombreProyecto"]);
  //var_dump($_POST["num"]);
  //var_dump($_POST["estatusProyecto"]);

  if((isset($_POST["nombreProyecto"])) && (isset($_POST["num"])) /*&& (isset($_POST["estatusProyecto"]))*/ ) {
      insertar_proyecto($_POST["num"], 4 , $_POST["nombreProyecto"]);
      $_SESSION["mensaje"] = "Se completo el registro";
  }  else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }

  header("location:index.php");
?>



   