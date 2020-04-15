<?php
if (isset($_POST["ID"])) {
      $id = htmlspecialchars($_POST["ID"]);
  } else {
      $id = "";
    }

if(isset($_POST["Nombre"])){
	$nombre = htmlspecialchars($_POST['Nombre']);
}else{
	$nombre = "";
}

if(isset($_POST["estado"])){
	$estado = htmlspecialchars($_POST['estado']);
}else{
	$estado = "";
}
  echo getFruits($id,$nombre,$estado);


?>