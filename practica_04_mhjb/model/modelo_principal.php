<?php

/**
 * @author Martín Hernan Jaime Bonvin
 * @version 1.0
 */


/**
 * Crea la connexió a la base de dades i retorna la petició.
 * @return connexio: objecte PDO amb la connexió directa a la base de dades.
 */
function conectar()
{
    try {
        $connexio = new PDO('mysql:host=localhost;dbname=pt04_martin_jaime', 'root', '');
        //echo "Connexio correcta!!" . "<br />";
        return $connexio;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
function seleccionarUsuarios($connexio)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM users');
        $statement->execute();
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>

<?php
/**
 * A partir de l'objecte PDO ($connexio) amb la connexió a la base de dades es crea una consulta SQL per seleccionar tot el contingut de la taula i s'executa.
 * Guarda el resultat en $statement i retorna la informació.
 * @param connexio: Paràmetre d'entrada amb les dades de la connexió a la base de dades.
 * @return statement: Retorna la informació seleccionada a partir de la consulta SQL. 
 *  
 */
function seleccionarArticulos($connexio)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles');
        $statement->execute();
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
/**
 * A partir de l'objecte PDO ($connexio) amb la connexió a la base de dades es crea una consulta SQL per seleccionar els articles que hi ha entre un rang de IDs.
 * Guarda el resultat en $statement i retorna la informació.
 * Aquesta consulta és creada per mostrar els articles corresponents depenent la pàgina on estigui l'usuari.
 * @param connexio: Paràmetre d'entrada amb les dades de la connexió a la base de dades.
 * @param INICIO: Valor per agafar el primer ID de l'article a mostrar en la pàgina depenent on es trobi l'usuari. 
 * @param FINAL: Valor per agafar l'últim ID de l'article a mostrar en la pàgina depenent on es trobi l'usuari.
 * @return statement: Retorna la informació seleccionada a partir de la consulta SQL. 
 *  
 */
function seleccionarRangoArt($connexio, $INICIO, $FINAL)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ID > :inicio AND ID <= :final');
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



?>