<?php
require_once("../vista/registro.php");
require_once("../model/modelo_registro.php");
require_once("../model/modelo_principal.php");
define('espaciado', "<br><br>");

function comprobarRegistro()
{

    try {
        $errors = "";
        $conect = conectar();
        if ($conect) {

            $errors .= comprobarDatosVacios();
            $errors .= comprobarExistenciaNombre($conect, $_POST['nom']);
            $errors .= comprobarExistenciaEmail($conect, $_POST['email']);

            if ($errors == "") {
                $nombre = $_POST['nom'];
                $email = $_POST['email'];
                $contra = hash("sha512","prueba");
                vaciarCampos();
                registrarUsuario($conect, $nombre, $email, $contra);
            } else echo $errors;
        } else return false;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php


function comprobarExistenciaNombre($con, $nom)
{
    $results = seleccionarUsuarios($con) -> fetchAll();
    foreach ($results as $user) {
        if ($user['nom_usuari'] == $nom) {
            return "Ya existe un usuario con ese nombre.<br><br>";
        }
        return "";
    }
}

function comprobarExistenciaEmail($con, $email)
{
    $results = seleccionarUsuarios($con)-> fetchAll();
    foreach ($results as $user) {
        if ($user['email_usuari'] == $email) {
            return "Este correo electronico ya está registrado.<br><br>";
        }
        return "";
    }
}
?>

<?php

function comprobarDatosVacios()
{
    $errors = "";

    if (empty($_POST['nom'])) {
        $errors .= "Los datos de nombre están vacios." . espaciado;
    }

    if (empty($_POST['email']) || empty($_POST['reEmail'])) {
        $errors .= "Los datos de e-mail están vacios." . espaciado;
    } else if ($_POST['reEmail'] != $_POST['email']) {
        $errors .= "Los datos de e-mail no son correctos." . espaciado;
    }

    if (empty($_POST['contra']) || empty($_POST['reContra'])) {
        $errors .= "Los datos de contraseña están vacios." . espaciado;
    } else if ($_POST['reContra'] != $_POST['contra']) {
        $errors .= "Los datos de contraseña no son correctos." . espaciado;
    }

    return $errors;
}


comprobarRegistro();
?>
<?php
function vaciarCampos()
{
?>

    <script>
        document.getElementsByName("nom").value = null;
        document.getElementsByName("email").value = null;
        document.getElementsByName("reEmail").value = null;
        document.getElementsByName("contra").value = null;
        document.getElementsByName("reContra").value = null;
    </script>


<?php
}


?>