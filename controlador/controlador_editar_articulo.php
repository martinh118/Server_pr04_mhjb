<?php
include_once("../model/modelo_sesion_iniciada.php");
include_once("../model/modelo_principal.php");
require_once("../vista/editar_articulo.php");

// Obté les dades de l'usuari al qual pertany l'article.
if (isset($_SESSION['usuario'])) {
    $user = $_SESSION["usuario"];
    $art = $_POST['content'];
    $id = $_SESSION['idArt'];
   
}

//Edita l'article creat.
    editarArticulo($id, trim($art));
    echo "Articulo editado.";
