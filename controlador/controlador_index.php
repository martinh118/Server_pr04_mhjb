<?php

/**
 * @author Martín H. Jaime Bonvin
 * @version 2.0
 */

include_once("../model/modelo_principal.php");
require_once("../vista/index.vista.php");

/**
 * Funció que fa la crida de les comprovacions necessàries i mostra els articles i la paginació.
 */
function iniciar()
{
    try {
        // Ens connectem a la base de dades...
        $conexion = conectar();

        if ($conexion) {
            $cantidadPagina = 5;


            $total_paginas = calcularPaginas($cantidadPagina);
            if (empty($_GET["pagina"]) || $_GET["pagina"] >  $total_paginas || $_GET["pagina"] <  1) {
                $pagina = 1;
            } else {
                $pagina = $_GET["pagina"];
            }




            mostrarArts($cantidadPagina, $pagina);
            crearPaginacion($total_paginas, $pagina);


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
 * A partir de la selecció total de dades amb la connexió a la BDD i la constant que indica quants articles volem per pàgina...
 * En aquesta funció es retorna el nombre de pàgines necessari dividint la longitud de tots els articles seleccionats i el nombre desitjat d'articles per pàgina.
 * @param conexion: Connexió a la Base de dades.
 * @param cantidadPagina: Quantitat d'articles desitjats a mostrar per pàgina.
 * @return number: Aquest number és el resultat que dona dividir la longitud de l'array on es guarden totes les dades de la BDD, i el valor de la constant amb el nombre desitjat d'articles per pàgina.
 */

function calcularPaginas($cantidadPagina)
{
    try {
        // definim quants post per pagina volem carregar.
        $articles = seleccionarArticulos()->fetchAll();

        return ceil(count($articles) / $cantidadPagina);
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
            $paginacionInput = "<div><section class='paginacio'><ul><li ><a data-disabled='true' class='disabled-link' href='../controlador/controlador_index.php?pagina=" . $retro  . "'>&laquo;</a></li>";
        } else $paginacionInput = "<div><section class='paginacio'><ul><li ><a href='../controlador/controlador_index.php?pagina=" . $retro  . "'>&laquo;</a></li>";


        for ($i = 1; $i <= $paginas; $i++) {
            if ($numPagina == $i) {
                $paginacionInput .= "<li class='active'><a href='../controlador/controlador_index.php?pagina=" . $i  . "' >" . $i . "</a></li>";
            } else $paginacionInput .= "<li><a href='../controlador/controlador_index.php?pagina=" . $i  . "' >" . $i . "</a></li>";
        }

        if ($numPagina == $paginas) {
            $paginacionInput .= "<li data-disabled='true' class='disabled-link'><a href='../controlador/controlador_index.php?pagina=" . $avan  . "'>&raquo;</a></li></ul></section></div>";
        } else $paginacionInput .= "<li><a href='../controlador/controlador_index.php?pagina=" . $avan  . "'>&raquo;</a></li></ul></section></div>";


        echo $paginacionInput;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php

/**
 * Es calcula el número inicial i final dels articles que es mostraran corresponents a la pàgina...
 * A partir d'aquí executa una consulta SQL personalitzada per la selecció d'articles d'entre els rangs d'ID calculats anteriorment.
 * Després d'això mostrarà els articles seleccionats.
 * En cas que no hi hagi cap article redirigeix la pàgina a l'índex.
 * @param conect: Connexió a la Base de dades.
 * @param CANTIDAD: Quantitat d'articles desitjats a mostrar per pàgina.
 * @param pag: Número de la pàgina on es troba actualment l'usuari. 
 * 
 */
function mostrarArts($CANTIDAD, $pag)
{
    try {
        $INICIO = ($CANTIDAD * $pag) - $CANTIDAD;
        $FINAL = $CANTIDAD * $pag;

        $articulos = seleccionarRangoArt($INICIO, $FINAL)->fetchAll();

        if (empty($articulos)) {
?>
            <script>
                location.replace("../vista/index.vista.php");
            </script>
<?php
        } else {
            $articulosInput = "<section class='articles'><ul>";
            foreach ($articulos as $a) {
                $articulosInput .= "<li><strong>" . $a['ID'] . ".- </strong>" . $a['article'] . " ( <strong>" . $a['autor'] . "</strong> )</li>";
            }
            $articulosInput .= "</ul></section>";
            echo $articulosInput;
        }
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>