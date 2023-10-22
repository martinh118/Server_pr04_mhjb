

<?php
require_once("../model/modelo_principal.php");

function selectUsuario($connexio, $nom){
    try {
        
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

function registrarUsuario($connexio, $nom, $email, $contra){
    try {
        
        $statement = $connexio->prepare('INSERT INTO users (nom_usuari, email_usuari, contra) VALUES (:nombre, :gmail, :contra )');
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

function getID($connexio){
    try {
        $statement = $connexio->prepare('SELECT MAX(ID)+1 as id FROM users');
        $statement->execute();
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


function añadirColumn($connexio, $id, $nom){

    try {
        
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

}
?>