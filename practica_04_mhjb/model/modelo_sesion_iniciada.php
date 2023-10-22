<?php 
/**
 * @author Martin H. Jaime Bonvin
 * @version 2.0
 */

/**
 * Mostra els articles amb els rangs de números corresponents i que el valor de la columna de l'usuari sigui 1.
 * @param connexio: Connexió a la Base de Dades.
 * @param INICIO: Número inicial del rang.
 * @param FINAL: Número final del rang.
 * @param nom: Nom de l'usauri.
 * @return statement: Retorna els articles seleccionats amb els parametres demanats.
 */
function mostrarArticulosUsario($connexio, $INICIO, $FINAL, $nom)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ID > :inicio AND ID <= :final AND ' . $nom . '=1');
        $statement->execute(
            array(
                ':inicio' => $INICIO,
                ':final' => $FINAL
            )
        );
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

/**
 * Selecciona tots els articles on el valor de la columna amb el nom de l'usuari sigui 1.
 * @param connexio: Connexió a la Base de Dades.
 * @return statement: Retorna els articles seleccionats amb els parametres demanats.
 */
function seleccionarArticulosUsuario($connexio, $nom)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ' . $nom . '=1');
        $statement->execute();
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


/**
 * Canvia el valor de la columna de l'usuari seleccionat amb l'id de l'article.
 * @param connexio: Connexió a la Base de Dades.
 * @param column: Columna de l'usuari.
 * @param idart: ID de l'article.
 * 
 */
function ocultarArticulo($connexio, $column, $idart){
    try {
        $statement = $connexio->prepare('UPDATE articles SET ' . $column .' = 0 WHERE ID = :idart');
        $statement->execute(
            array(
                ':idart' =>$idart
            )
        );
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>