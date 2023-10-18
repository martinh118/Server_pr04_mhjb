

<?php
require_once("../model/modelo_principal.php");

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
            echo "El usuario se ha registrado correctamente";
        } else echo "Error al registrar usuario";
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
