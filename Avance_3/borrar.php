<?php
require_once("model_almacen.php");
$id = htmlspecialchars($_GET["id"]);
borrarAlmacen($id);
header("location:almacenes.php");
?>