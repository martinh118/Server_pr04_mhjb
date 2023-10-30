<?php

/**
 * @author Martín Hernan Jaime Bonvin
 * @version 2.0
 */

require_once("../model/modelo_principal.php");
require_once("../model/modelo_registro.php");
require_once("../model/modelo_sesion_iniciada.php");
require_once("../vista/inicio_sesion.php");
define('espaciado', "<br><br>");

/**
 * Fa les comprovacions necessàries a l'hora d'iniciar sessió.
 * En cas que estigui tot correcte, carrega l'arxiu amb l'usuari inicialitzat.
 */
function comprobarExistencia()
{

    try {
        $errors = "";
        $conect = conectar();
        if ($conect) {

            $errors .= comprobarDatosVaciosSesion();
            $errors .= comprobarExistenciaNombreSesion($_POST['nom']);
            $errors .= comprobarExistenciaContraSesion($_POST['contra'], $_POST['nom']);

            if ($errors == "") {
                $nom = $_POST['nom'];

                $script = <<<EOT
                <script type='text/javascript'>
                window.location.replace("../vista/sesion_iniciada.php?nom=$nom&pagina=1");
                </script>
                EOT;
                session_start();
                $user = selectUsuario($nom);
                $_SESSION["usuario"] = $nom;

                echo ($script);
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
 * Fa la comprovació que la contrasenya sigui la correcta a partir de password_verify.
 * @param con: Connexió a la Base de Dades.
 * @param contra: Contrasenya a comprovar.
 * @param nom: Nom d'usuari a comprovar.
 */
function comprobarExistenciaContraSesion($contra, $nom)
{
    try {
        $user = selectUsuario($nom)->fetchAll();

        if (empty($user)) {
            return;
        } else {
            $results = $user;
            foreach ($results as $user) {
                if (password_verify($contra, $user['contra'])) {
                    return "";
                }
            }
            return "La contrasenya no es la correcta.<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error al iniciar sessió.";
    }
}

/**
 * Fa la comprovació que el nom sigui el correcte.
 * @param con: Connexió a la Base de Dades.
 * @param nom: Nom d'usuari a comprovar.
 */
function comprobarExistenciaNombreSesion($nom)
{
    $results = seleccionarUsuarios()->fetchAll();
    foreach ($results as $user) {
        if ($user['nom_usuari'] == $nom) {
            return "";
        }
    }
    return "No existeix cap usuari amb aquest nom.<br><br>";
}


/**
 * Comprova que no hi hagi cap camp buit.
 */
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