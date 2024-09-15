<?php

/**
 * 
 * @author Martín H. Jaime Bonvin
 * @version 2.0
 * 
 */
include_once("../model/modelo_sesion_iniciada.php");
require_once("../model/modelo_principal.php");
require_once("../model/modelo_registro.php");
require_once("../vista/sesion_iniciada.php");

define('espaciado', "<br><br>");

?>

<?php

/**
 * Comença la sessió en la pàgina i mostra el nom de l'usuari.
 */
function mostrarNombre()
{
    session_start();
    if (isset($_SESSION['usuario'])) {
        echo $_SESSION["usuario"];
    }
}


/**
 * A partir de seleccionar les dades de l'usuari a partir del nom, guarda l'ID i la suma del nom d'usuari i l'id en variables de $_SESSION.
 * @param connexio: Connexió a la base de dades.
 * @param nom: Nom de l'usuari.
 */
function aplicarDatos($nom)
{
    $statement = selectUsuario($nom)->fetchAll();

    foreach ($statement as $user) {
        $_SESSION["ID"] = $user['ID'];
        $_SESSION["table"] = ($nom . $user['ID']);
    }
}

/**
 * Funció que fa la crida de les comprovacions necessàries i mostra els articles i la paginació.
 * Aplica les dades necessàries al $_SESSION i comprova si s'ha esborrat un article o ha sigut editat.
 */
function iniciarPagina()
{
    try {

        // Ens connectem a la base de dades...
        $conexion = conectar();

        if ($conexion) {


            aplicarDatos($_SESSION["usuario"]);
            edicion();

            articulosUser();
            articulosPublicos();


            exit();
        } else {
?>
            <script>
                alert("NO FUNCIONA");
                location.replace("../vista/index.vista.php");
            </script>
<?php     }
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>


<?php
/**
 * Fa la comprovació de a quina pàgina es truca.
 * @param total_paginas: pàgina seleccionada
 * @return pagina: numero de pàgina
 */
function paginas($total_paginas)
{
    if (empty($_GET["pagina"]) || $_GET["pagina"] >  $total_paginas || $_GET["pagina"] <  1) {
        $pagina = 1;
    } else {
        $pagina = $_GET["pagina"];
    }

    return $pagina;
}

/**
 * Executa la visualització d'articles de l'usuari seleccionat i crea la paginació d'aquesta.
 */
function articulosUser()
{
    try {
        $cantidadPagina = 5;
        $quant = seleccionarArticulosUsuario($_SESSION["usuario"])->fetchAll();
        $total_paginas = ceil(count($quant) / $cantidadPagina);
        $pagina = paginas($total_paginas);

        mostrarArtsUsers($quant, $pagina);
        crearPaginacion($total_paginas, $pagina);
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

/**
 * Executa la visualització d'articles publics i dels altres usuaris i crea la paginació d'aquesta.
 */
function articulosPublicos()
{
    try {
        $cantidadPagina = 5;
        $quant = seleccionarArticulos()->fetchAll();
        $total_paginas = ceil(count($quant) / $cantidadPagina);
        $pagina = paginas($total_paginas);

        mostrarArts($cantidadPagina, $pagina);
        crearPaginacion($total_paginas, $pagina);
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>

<?php

/**
 * Crea la paginació mostrada a la pantalla, on en les fletxes situades als extrems tindrà una classe que els desactivarà depenent si l'usuari es troba a la primera pàgina, o a l'última.
 * En cas que l'usuari es trobi a la pàgina número u, la fletxa esquerra es trobarà desactivada. De la mateixa manera amb el de la dreta amb l'última pàgina.
 * @param paginas: Valor on es troba el nombre de pàgines que existeixen depenent de quants articles hi hagi a la BDD.
 * @param numPagina: Número de la pàgina on es troba actualment l'usuari. 
 * 
 */
function crearPaginacion($paginas, $numPagina)
{

    try {
        $retro = $numPagina - 1;
        $avan = $numPagina + 1;
        if ($numPagina == 1) {
            $paginacionInput = "<div><section class='paginacio'><ul><li ><a data-disabled='true' class='disabled-link' href='../controlador/controlador_sesion_iniciada.php?pagina=" . $retro  . "'>&laquo;</a></li>";
        } else $paginacionInput = "<div><section class='paginacio'><ul><li ><a href='../controlador/controlador_sesion_iniciada.php?pagina=" . $retro  . "'>&laquo;</a></li>";


        for ($i = 1; $i <= $paginas; $i++) {
            if ($numPagina == $i) {
                $paginacionInput .= "<li class='active'><a href='../controlador/controlador_sesion_iniciada.php?pagina=" . $i  . "' >" . $i . "</a></li>";
            } else $paginacionInput .= "<li><a href='../controlador/controlador_sesion_iniciada.php?pagina=" . $i  . "' >" . $i . "</a></li>";
        }

        if ($numPagina == $paginas) {
            $paginacionInput .= "<li data-disabled='true' class='disabled-link'><a href='../controlador/controlador_sesion_iniciada.php?pagina=" . $avan  . "'>&raquo;</a></li></ul></section></div>";
        } else $paginacionInput .= "<li><a href='../controlador/controlador_sesion_iniciada.php?pagina=" . $avan  . "'>&raquo;</a></li></ul></section></div>";


        echo $paginacionInput;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php

/**
 * Mostra tots els articles publics i dels usuaris que no sigui l'actual.
 * @param CANTIDAD: Quantitat d'articles mostrats per pàgina.
 * @param pag: Número de la pàgina seleccionat.
 */
function mostrarArts($CANTIDAD, $pag)
{
    try {
        $INICIO = ($CANTIDAD * $pag) - $CANTIDAD;
        $FINAL = $CANTIDAD * $pag;

        $articulos = mostrarArticulosUsuario($INICIO, $FINAL);
        $articulosInput = "";
        if (empty($articulos)) {
            $articulosInput = "<br>No hay articulos disponibles";
        } else {

            $pag = $_GET['pagina'];
            $articulosInput = "<section class='articles'><ul>";

            foreach ($articulos as $a) {

                if ($a['autor'] != $_SESSION['usuario']) {

                    $articulosInput .= "<li><strong>" . $a['ID'] . ".- </strong>" . $a['article'] . " ( <strong>" . $a['autor'] . "</strong> )";
                    $articulosInput .= "</li>";
                }
            }
            $articulosInput .= "</ul></section>";
        }
        echo $articulosInput;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


/**
 * A partir de la columna d'articles amb el nom de l'usuari actual, es mostraran els articles que té habilitats.
 * A més, afegeix les opcions d'eliminar i editar a cada article.
 * @param arts: Connexió a la Base de dades.
 * @param pag: Quantitat d'articles mostrats per pàgina.

 */
function mostrarArtsUsers($arts, $pag)
{
    try {

        $articulos = $arts;
        $articulosInput = "";
        if (empty($articulos)) {
            $articulosInput = "<br>No hay articulos disponibles";
        } else {

            $pag = $_GET['pagina'];
            $articulosInput = "<section class='articles'><ul>";

            foreach ($articulos as $a) {

                if ($a['autor'] == $_SESSION['usuario']) {
                    $articulosInput .= "<li><strong> " . $a['ID'] . ".- </strong>" . htmlspecialchars($a['article']) . " ( <strong>" . $a['autor'] . " </strong>)";
                    $articulosInput .= "&nbsp&nbsp<button id='borrar'><a  href='../controlador/controlador_sesion_iniciada.php?pagina=" . $pag . "&id= " . $a['ID'] . "&edit=" . "borrar" . "'>Borrar</a></button> &nbsp&nbsp";
                    $articulosInput .= "<button><a href='../vista/editar_articulo.php?id= " . $a['ID'] . "'>Editar</a></button>";
                    $articulosInput .= "</li>";
                }
            }
            $articulosInput .= "</ul></section>";
        }
        echo $articulosInput;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
/**
 * Elimina l'article seleccionat.
 */
function edicion()
{

    if (isset($_GET['edit'])) {
        $idart = $_GET['id'];
        require_once('../model/modelo_sesion_iniciada.php');
        eliminarArticulo($idart);
    }
}


?>