<?php 
  require_once("model_proyecto.php");  

  $_POST["nombreProyecto"] = htmlspecialchars($_POST["nombreProyecto"]);
  $_POST["num"] = htmlspecialchars($_POST["num"]);
  $_POST["fechaInicio"] = htmlspecialchars($_POST["fechaInicio"]);
  $_POST["fechaFin"] = htmlspecialchars($_POST["fechaFin"]);
  $_POST["estatus"] = htmlspecialchars($_POST["estatus"]);

  if((isset($_POST["nombreProyecto"])) && (isset($_POST["num"])) && (isset($_POST["fechaInicio"]))&& (isset($_POST["fechaFin"])) && (isset($_POST["estatus"])) ) {
      insertar_proyecto($_POST["num"], $_POST["estatus"] , $_POST["nombreProyecto"],$_POST["fechaInicio"],$_POST["fechaFin"] );
  }

  header("location:index.php");
?>