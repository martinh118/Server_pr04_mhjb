

<?php
/**
 * @author Martin H. Jaime Bonvin
 * @version 2.0
 */
require_once("../model/modelo_principal.php");

/**
 * Selecciona totes les dades de l'usuari especific pasat com a parametre d'entrada.
 * @param connexio: Connexió a la Base de Dades.
 * @param nom: Nom de l'usuari.
 * @return statement: retorna les dades de l'usuari seleccionat.
 */
function selectUsuario($nom){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('SELECT * FROM users WHERE nom_usuari = :nom');
        if ( !empty($nom)) {
            $statement->execute(
                array(
                    ':nom' => $nom
                )
            );
            return $statement;
        } else return;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


/**
 * Insereix les dades de l'usuari a la taula 'users' de la base de dades. En cas que sigui correcte, mostra un missatge.
 * @param connexio: Connexió a la Base de Dades.
 * @param nom: Nom de l'usuari.
 * @param email: Correu electronic de l'usuari.
 * @param contra: Contrasenya de l'usuari
 * 
 */
function registrarUsuario( $nom, $email, $contra){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('INSERT INTO users (nom_usuari, email_usuari, contra) VALUES (:nombre, :gmail, :contra)');
        if ( !empty($nom) && !empty($email) && !empty($contra)) {
            $statement->execute(
                array(
                    
                    ':nombre' => $nom,
                    ':gmail' => $email,
                    ':contra' => $contra
                )
            );
            echo "El usuario se ha registrado correctamente<br><br>";
        } else echo "Error al registrar usuario<br><br>";
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }

}

/**
 * Quan usuari és registrat es crea una columna a articles amb el nom i l'id de l'usuari registrat.
 * El nom de la columna és la suma del nom i l'id perquè si es registra un usuari amb el mateix nom i diferents majúscules o minúscules, la columna no es podrà crear.
 * Com a valor per defecte és el número 1.
 * 
 * @param connexio: Connexió a la Base de Dades.
 * @param id: id de l'usuari de la taula 'users'.
 * @param nom: nom de l'usuari.
 
function añadirColumn( $id, $nom){

    try {
        $connexio = conectar();
        $statement = $connexio->prepare('ALTER TABLE articles ADD '.$nom .$id.' tinyint(1) DEFAULT 1');
        if ( !empty($id)) {
            $statement->execute(
            );
            echo "columna creada.";
        } else echo "columna no creada";
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }

}*/
?>