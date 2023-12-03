<?php

include_once("../model/modelo_sesion_iniciada.php");
include_once("../model/modelo_principal.php");
require_once("../vista/crear_articulo.php");

// Inicia la session
session_start();
    if (isset($_SESSION['usuario'])){
        $user = $_SESSION["usuario"];
        
}

//Selecciona tots els articles registrats a la base de dades per obtenir el següent numero d'identificació del nou article.
$articulos = seleccionarArticulos()->fetchAll();
$num = count($articulos) + 1;

// Crea l'article.
crearArticuloUsuario($num, $_POST['content'], $user);
echo "Articulo creado.";
