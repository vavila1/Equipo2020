<?php
session_start();
require_once("model_almacen.php");
$id = htmlspecialchars($_GET["id"]);
borrarAlmacen($id);
header("location:almacenes.php");
$_SESSION["delete"] = "Se ha eliminado un registro con exito";
?>