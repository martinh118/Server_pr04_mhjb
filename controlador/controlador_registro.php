<?php

/**
 * @author Martín Hernan Jaime Bonvin
 * @version 2.0
 */

require_once("../vista/registro.php");
require_once("../model/modelo_registro.php");
require_once("../model/modelo_principal.php");
define('espaciado', "<br><br>");

/**
 * Fa les comprovacions necessàries per poder executar l'enregistrament.
 */
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
                $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT);
                vaciarCampos();
                registrarUsuario( $nombre, $email, $contra);


                //$id =  getIDUser($conect, $nombre);
                //añadirColumn($conect, $id, $nombre);
                
            } else echo $errors;
        } else return false;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php

/**
 * Funció feta per obtenir l'id de l'usuari en la base de dades.
 * @param connexio: Connexió a la Base de Dades.
 * @param nom: nom de l'usuari registrat.
 * @return user['ID']: Retorna l'id del nom d'usuari passat com a paràmetre d'entrada. En cas de que no el trobi, no retorna res.
 */
function getIDUser($connexio, $nom){
    $results = selectUsuario($connexio, $nom)-> fetchAll();
    foreach ($results as $user) {
        if ($user['nom_usuari'] == $nom) {
            return $user['ID'];
        }
        return "";
    }
}

/**
 * Fa la comprovació de l'existència de nom d'usuari.
 * @param con: Connexió a la Base de Dades.
 * @param nom: Nom d'usuari.
 * @return: Si troba el nom d'usuari aplicat retorna el text d'error, en cas contrari no retorna res.
 */
function comprobarExistenciaNombre($con, $nom)
{
    $results = seleccionarUsuarios($con) -> fetchAll();
    foreach ($results as $user) {
        if ($user['nom_usuari'] == $nom) {
            return "Ja existeix un usuari amb aquest nom.<br><br>";
        }
        return "";
    }
}

/**
 * Fa la comprovació de l'existència del correu electronic.
 * @param con: Connexió a la Base de Dades.
 * @param email: Correu electronic aplicat.
 * @return: Si troba el correu electronic aplicat retorna el text d'error, en cas contrari no retorna res.
 */
function comprobarExistenciaEmail($con, $email)
{
    $results = seleccionarUsuarios($con)-> fetchAll();
    foreach ($results as $user) {
        if ($user['email_usuari'] == $email) {
            return "Aquest correu electronic ja està enregistrat.<br><br>";
        }
        return "";
    }
}
?>

<?php

/**
 * Comprova que no hi hagi cap camp buit.
 */
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

}


?>