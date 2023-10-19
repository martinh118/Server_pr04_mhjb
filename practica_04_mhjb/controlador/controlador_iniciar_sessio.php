<?php

/**
 * @author Martín Hernan Jaime Bonvin
 * @version 1.0
 */

require_once("../model/modelo_principal.php");
require_once("../model/modelo_registro.php");
require_once("../vista/inicio_sesion.php");
define('espaciado', "<br><br>");

function comprobarExistencia(){

    try {
        $errors = "";
        $conect = conectar();
        if ($conect) {

            $errors .= comprobarDatosVaciosSesion();
            $errors .= comprobarExistenciaNombreSesion($conect, $_POST['nom']);
            $errors .= comprobarExistenciaContraSesion($conect, $_POST['contra']);

            if ($errors == "") {
                $nom = $_POST['nom'];
                
                $script = <<<EOT
                <script type='text/javascript'>
                window.location.replace("../vista/sesion_iniciada.php?nom=$nom&pagina=1");
                </script>
                EOT;
                session_start();
                $_SESSION["usuario"] = $nom;

                echo($script);

            } else echo $errors;
        } else return false;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>

<?php

function comprobarExistenciaContraSesion($con, $contra)
{
    $contra = hash("sha512", $contra);
    $results = seleccionarUsuarios($con)-> fetchAll();
    foreach ($results as $user) {
        if ($user['contra'] == $contra) {
            return "";
        }
        
    }
    return "La contrasenya no es la correcta.<br><br>";
}

function comprobarExistenciaNombreSesion($con, $nom)
{
    $results = seleccionarUsuarios($con) -> fetchAll();
    foreach ($results as $user) {
        if ($user['nom_usuari'] == $nom) {
            return "";
        }
        
    }
    return "No existeix cap usuari amb aquest nom.<br><br>";
}

function comprobarDatosVaciosSesion()
{
    $errors = "";

    if (empty($_POST['nom'])) {
        $errors .= "Los datos de nombre están vacios." . espaciado;
    }


    if (empty($_POST['contra']) || empty($_POST['reContra'])) {
        $errors .= "Los datos de contraseña están vacios." . espaciado;
    } else if ($_POST['reContra'] != $_POST['contra']) {
        $errors .= "Los datos de contraseña no son correctos." . espaciado;
    }

    return $errors;
}



comprobarExistencia();
?>