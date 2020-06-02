<?php
  session_start();
  require_once("model_proyecto.php");  


   $_POST["nombreProyecto"] = htmlspecialchars($_POST["nombreProyecto"]);
   $_POST["estatusProyecto"] = htmlspecialchars($_POST["estatusProyecto"]);
   $_POST["num"] = htmlspecialchars($_POST["num"]);

   var_dump($_POST["nombreProyecto"]);
   var_dump($_POST["estatusProyecto"]);
   var_dump($_POST["num"]);


  if(isset($_POST["estatusProyecto"])) {
      if (editar_proyecto_estatus($_POST["num"], $_POST["estatusProyecto"])) {
          $_SESSION["mensaje"] = "Se editó el proyecto";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar el proyecto";
      }
  }
  if(isset($_POST["nombreProyecto"])) {
      if (editar_proyecto_nombre($_POST["num"], $_POST["nombreProyecto"])) {
          $_SESSION["mensaje"] = "Se editó el proyecto";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar el proyecto";
      }
  }

 // header("location:proyectos.php");
?>