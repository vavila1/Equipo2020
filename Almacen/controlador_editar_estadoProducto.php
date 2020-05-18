<?php
  session_start();


   $_POST["nombreEstado"] = htmlspecialchars($_POST["nombreEstado"]);



  if(isset($_POST["nombreEstado"])) {
      if (editar_estado_nombre($_POST["num"], $_POST["nombreEstado"])) {
          $_SESSION["mensaje"] = "Se editó el estado de producto";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al estado el tipo de producto";
      }
  }


  header("location:estadoProducto.php");
?>