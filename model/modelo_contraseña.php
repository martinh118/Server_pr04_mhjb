<?php 

include_once("modelo_principal.php");

function cambiarToken($token, $email){
    try {
        $connexio = conectar();
        $statement = $connexio->prepare('UPDATE users SET token = :token WHERE email_usuari = :email');
        $statement->execute(
            array(
                ':token' => $token,
                ':email' => $email
            )
        );
        
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}