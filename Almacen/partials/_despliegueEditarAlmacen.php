<?php
$id = htmlspecialchars($_GET["id"]);
if(isset($_POST["estado"])){
	$id = htmlspecialchars($_GET["id"]);
	$estado = htmlspecialchars($_POST['estado']);
	editarAlmacen($id,$estado);
	header("location:almacenes.php");
}else{
	$estado = "";
}




?>