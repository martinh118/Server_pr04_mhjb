<?php
require_once("../model/modelo_registro.php");
require_once("../model/modelo_contraseña.php");
include_once('../vista/cambiar_contraseña.php');



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

function comprobarToken()
{
    session_start();
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
    $user = selectEmail($email)->fetch();
    return $user['token'] == $token ? true : false;
}

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