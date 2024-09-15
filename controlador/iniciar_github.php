<?php 
include '../hybridauth-master/src/autoload.php';

define('espaciado', "<br><br>");


/**
 * OAUTH CONFIGURATION
 */

 $config = [
    'callback' => 'http://localhost/practiques/UF2/practica_05_mhjb/vista/sesion_iniciada.php?pagina=1',

    'keys' => [
        'key' => '43bc8c727edbd4f537e8',
        'secret' => 'e7f490b1a25216a236f5e8d26030bc6c9b7c089b',
    ],
];

$login = oauth($config);
$pdo = seleccionarUsuarios();
$email = $login->email;
$username = $login->displayName;


/**
 * fa les configuracions necessaries per iniciar sessió amb github
 * @param config: configuració hybridauth_master
 * @return usuari: retrona l'usuari github
 */
function oauth($config){
    try{

        $github = new Hybridauth\Provider\Github($config);
        $github->authenticate();
        $usuari = $github->getUserProfile();
        $github->disconnect();
    
        return $usuari;
        exit;
    }catch (Hybridauth\Exception\AuthorizationDeniedException $e) {
        // El usuario canceló el proceso de autenticación
        header("Location: ../vista/inicio_sesion.php");
        exit;
    } catch (Exception $e) {
        // Otro tipo de excepción, manejar según sea necesario
        echo "Error: " . $e->getMessage();
    }
}