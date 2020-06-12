<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_cbarra.php");

    $id = $_GET["id"];

    //Probamos conexicon con la funcion creada en model.php conectar_bd()
    //var_dump(conectar_bd());
if ($_SESSION["ImprimirCB"]) {
    include("partials/_header.html");
    include("partials/_footer.html");
    include("partials/_generarCodigo.html");
} else{
        header("location:logout.php");
    }

if(isset($_GET['id'])) { 
echo "<script>
        window.print();
</script>";

 } 


?>

