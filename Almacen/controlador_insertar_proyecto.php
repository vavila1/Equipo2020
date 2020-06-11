<?php 
  require_once("model_proyecto.php");  

  $_POST["nombreProyecto"] = htmlspecialchars($_POST["nombreProyecto"]);
  $_POST["num"] = htmlspecialchars($_POST["num"]);
  $_POST["fecha"] = htmlspecialchars($_POST["fecha"]);
  $_POST["empleado"] = htmlspecialchars($_POST["empleado"]);

  if((isset($_POST["nombreProyecto"])) & (isset($_POST["num"])) && (isset($_POST["fecha"])) && (isset($_POST["empleado"]))) {
      insertar_proyecto($_POST["num"], 4 , $_POST["nombreProyecto"],  $_POST["fecha"], $_POST["empleado"]);
      $_SESSION["mensaje"] = "Se completo el registro";
  }  else {
            $_SESSION["warning"] = "Ocurrio un error al registar el proyecto";
        }

  header("location:proyectos.php");
?>



   