<?php 
/**
 * @author Martin H. Jaime Bonvin
 * @version 2.0
 */

 require_once("../model/modelo_principal.php");
/**
 * Mostra els articles amb els rangs de números corresponents i que el valor de la columna de l'usuari sigui 1.
 * @param connexio: Connexió a la Base de Dades.
 * @param INICIO: Número inicial del rang.
 * @param FINAL: Número final del rang.
 * @param nom: Nom de l'usauri.
 * @return statement: Retorna els articles seleccionats amb els parametres demanats.
 */
function mostrarArticulosUsuario($INICIO, $FINAL)
{
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ID > :inicio AND ID <= :final ');
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
function seleccionarArticulosUsuario($nom)
{
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('SELECT * FROM articles WHERE autor = :nom' );
        $statement->execute(
            array(
                ':nom' => $nom
            )
        );
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
function eliminarArticulo($idart){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('DELETE FROM articles WHERE ID = :idart');
        $statement->execute(
            array(
                ':idart' =>$idart
            )
        );
        reordenarArticulos();
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

/**
 * Ordena els articles amb l'identificador adequat.
 */
function reordenarArticulos(){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare("ALTER TABLE articles DROP ID");
        $statement->execute();
        $statement = $connexio->prepare("ALTER TABLE articles AUTO_INCREMENT = 1");
        $statement->execute();
        $statement = $connexio->prepare("ALTER TABLE articles ADD ID int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
        $statement->execute();
        
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


/**
 * Edita l'article seleccionat
 * @param idart: identiicador de l'article
 * @param article: articles a modificar.
 */
function editarArticulo($idart, $article){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('UPDATE articles SET article = :article WHERE id = :id');
        $statement->execute(
            array(
                ':id' =>$idart,
                ':article' => $article
            )
        );
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


function crearArticuloUsuario($id, $article, $autor){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('INSERT INTO articles (ID,  article, autor) VALUES (:id, :article, :autor )');
        $statement->execute(
            array(
                ':id' => $id,
                ':article' => $article,
                ':autor' => $autor
            )
        );
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }

}

function seleccionarArticuloUnico($id){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ID = :id');
        $statement->execute(
            array(
                ':id' => $id
            )
        );
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }

}

?>