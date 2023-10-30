<?php

include_once("../model/modelo_sesion_iniciada.php");
include_once("../model/modelo_principal.php");
require_once("../vista/crear_articulo.php");


session_start();
    if (isset($_SESSION['usuario'])){
        $user = $_SESSION["usuario"];
        
}

$articulos = seleccionarArticulos()->fetchAll();
$num = count($articulos) + 1;

crearArticuloUsuario($num, $_POST['content'], $user);
echo "Articulo creado.";
