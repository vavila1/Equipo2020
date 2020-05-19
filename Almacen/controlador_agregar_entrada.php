<?php
$id = htmlspecialchars($_GET['id']);
if(isset($_POST['Cantidad'])){
	$cantidad = htmlspecialchars($_POST['Cantidad']);
	registrarEntrada($id,$cantidad);
	header("location:productos.php");
}

?>