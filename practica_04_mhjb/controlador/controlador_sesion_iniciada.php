

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
function mostrarNombre(){
    session_start();
    if (isset($_SESSION['usuario'])){
        echo $_SESSION["usuario"];
        
    }
}


/**
 * A partir de seleccionar les dades de l'usuari a partir del nom, guarda l'ID i la suma del nom d'usuari i l'id en variables de $_SESSION.
 * @param connexio: Connexió a la base de dades.
 * @param nom: Nom de l'usuari.
 */
function aplicarDatos($connexio, $nom){
    $statement = selectUsuario($connexio, $nom) -> fetchAll();
    
    foreach($statement as $user){
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
            $cantidadPagina = 5;


            $total_paginas = calcularPaginas($conexion,  $cantidadPagina);
            if (empty($_GET["pagina"]) || $_GET["pagina"] >  $total_paginas || $_GET["pagina"] <  1) {
                $pagina = 1;
            } else {
                $pagina = $_GET["pagina"];
            }


            
            aplicarDatos($conexion, $_SESSION["usuario"]);
            edicion($conexion);
            mostrarArts($conexion, $cantidadPagina, $pagina );
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

function calcularPaginas($conexion,  $cantidadPagina)
{
    try {

        // definim quants post per pagina volem carregar.
        $articles =  seleccionarArticulos($conexion);
        $articles = $articles->fetchAll();

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
 * A partir de la columna d'articles amb el nom de l'usuari actual, es mostraran els articles que té habilitats.
 * A més, afegeix les opcions d'eliminar i editar a cada article.
 * @param conect: Connexió a la Base de dades.
 * @param CANTIDAD: Quantitat d'articles mostrats per pàgina.
 * @param pag: Número de la pàgina seleccionat.
 */
function mostrarArts($conect, $CANTIDAD, $pag)
{
    try {
        $INICIO = ($CANTIDAD * $pag) - $CANTIDAD;
        $FINAL = $CANTIDAD * $pag;

        $statement = mostrarArticulosUsario($conect, $INICIO, $FINAL, $_SESSION['table']);
        $articulos = $statement->fetchAll();

        if (empty($articulos)) {
?>
            <script>
                alert("No hay articulos existentes");
            </script>
<?php
        } else {
            $pag = $_GET['pagina'];
            $articulosInput = "<section class='articles'><ul>";
            foreach ($articulos as $a) {
                $articulosInput .= "<li>" . $a['ID'] . ".- " . $a['article'];
                $articulosInput .= "&nbsp&nbsp<button><a  href='../controlador/controlador_sesion_iniciada.php?pagina=". $pag ."&id= ".$a['ID'] ."&edit=" ."borrar"."'>Borrar</a></button> &nbsp&nbsp" ;
                $articulosInput .= "<button><a href='../controlador/controlador_sesion_iniciada.php?pagina=". $pag ."&id= ".$a['ID'] ."&edit= " ."editar"."'>Editar</a></button>";
                $articulosInput .= "</li>";
                
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

<?php 

/**
 * Depenent del que tingui l'entrada $_GET amb nom 'edit', esborra l'article o dona l'opció d'editar-la.
 * @param conexion: Connexió a la Base de dades.
 */
function edicion($conexion){
    if(empty($_GET['edit'])){
        return;
    }else{
        if($_GET['edit'] == 'borrar'){
            eliminarArticulo($conexion );
        }else if($_GET['edit'] == 'editar'){
            editarArt($conexion);
        }
    }
    

}


/**
 * "Elimina l'article" per l'usuari, és a dir, en la columna que té el nom d'usuari en la taula 'articles',
 * Es canvia el valor a 0 en la fila que té l'article seleccionat, i això farà que l'usuari no el vegi.
 * @param con: Connexió a la Base de dades.
 */
function eliminarArticulo($con ){
    if(empty($_GET['id'])){
        return;
    }else {
        $articuloID = $_GET['id'];
        ocultarArticulo($con, $_SESSION['table'], $articuloID);
    }
}


/**
 * Edita l'article.
 * @param conexion: Connexió a la Base de dades.
 */
function editarArt($conexion){
    
}

?>