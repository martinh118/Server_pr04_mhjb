<?php
/**
 * @author Martín Hernan Jaime Bonvin
 * @version 4.0
 */
require_once("../model/modelo_registro.php");
require_once("../model/modelo_contraseña.php");
include_once('../vista/cambiar_contraseña.php');


/**
 * Quan es pasa per primer cop les dades, es guarden al "session".
 * Si no detecta cap GET, fa les comprovacions per mostrar el formulari de recuperar contrasenya, i per fer el canvi de contrasenya.
 */
if (isset($_GET['token']) && isset($_GET['email'])) {
    try {
        $_SESSION['token'] = $_GET['token'];
        $_SESSION['email'] = $_GET['email'];
        $user = selectEmail($_SESSION['email'])->fetch();
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        $error = "";
        $token = $_SESSION['token'];
        //echo $token;
        $email = $_SESSION['email'];
        //echo $email;

        $error .= comprobarContraseñasNuevas();

        if ($error != "") {
            echo $error;
        } else {
            $contra = password_hash($_POST['contraNueva'], PASSWORD_DEFAULT);
            cambioContraseña($email, $contra);
            echo "Contraseña cambiada correctamente";
        }
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

/**
 * Comprova si el token a l'hora d'obrir la pàgina coincideix amb el que té l'usuari a la base de dades.
 * @return Boolean: retorna true en cas de que hi coincideixi.
 */
function comprobarToken()
{
    session_start();
    $token = $_SESSION['token'];
    if (isset($_GET['token']) && isset($_GET['email'])) {
        try {
            $_SESSION['token'] = $_GET['token'];
            $_SESSION['email'] = $_GET['email'];
            $user = selectEmail($_SESSION['email'])->fetch();
        } catch (PDOException $e) { //
            // mostrarem els errors
            echo "Error: " . $e->getMessage();
        }
    }
    return $user['token'] == $token ? true : false;
}

/**
 * Fa les correctes comprovacions per verificar la contrasenya nova.
 * @return String: En cas de que hi hagi un error, retorna el missatge d'aquest. En cas contrari retorna un string buit.  
 */
function comprobarContraseñasNuevas()
{
    $nuevaContra = password_hash($_POST['contraNueva'], PASSWORD_DEFAULT);
    $reNuevaContra = $_POST['reContraNueva'];

    if ($_POST['contraNueva'] != null && $_POST['reContraNueva'] != null) {
        if (password_verify($reNuevaContra, $nuevaContra)) {
            return "";
        } else return "Las nuevas contraseñas NO coinciden<br>";
    } else return "Los campos no pueden estar vacios<br>";
}