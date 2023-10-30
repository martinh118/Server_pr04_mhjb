<?php
include_once("../model/modelo_sesion_iniciada.php");
include_once("../model/modelo_principal.php");
require_once("../vista/editar_articulo.php");

if (isset($_SESSION['usuario'])) {
    $user = $_SESSION["usuario"];
    $art = $_POST['content'];
    $id = $_SESSION['idArt'];
   
}


    editarArticulo($id, trim($art));
    echo "Articulo editado.";
