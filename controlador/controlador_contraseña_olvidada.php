<?php

//Importa les classes de PHPMailer a un namespace global.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Fem la càrrega de requisit dels arxius de PHPMailer.
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

include_once("../vista/contraseña_olvidada.php");
require_once("../model/modelo_registro.php");
require_once("../model/modelo_contraseña.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    iniciar();

} else {
?>
    <script>
        alert("NO FUNCIONA");
        location.replace("../vista/index.vista.php");
    </script>
<?php
}

/**
 * Inicia el formulari per enviar el missatge al correu indicat per poder canviar de contrasenya.
 * 
 */
function iniciar(){
    
    $error = "";

    if($_POST['email'] == null || $_POST['reEmail'] == null){
        $error .= "Cap camp pot estar buit. <br>";
    }

    if($error == ""){

        $token = uniqid();
        
        $email = trim($_POST['email']);
        $reEmail = trim($_POST['reEmail']);
        cambiarToken($token, $email);
        comprobarEmail($email, $reEmail, $token);


    }else echo $error;

}

/**
 * Comprova que els emails introduits siguin el mateix i els correctes.
 * @param email: Comprovació de email 1
 * @param reEmail: Comprovació de email 2
 * @param token: token a enviar per fer el canvi de contrasenya.
 */
function comprobarEmail($email, $reEmail, $token){
    $user = selectEmail($email);
    $user = $user->fetch();

    if($user != null && $user['email_usuari'] == $email){
        if($email == $reEmail){

            enviarCorreo($email, $user['nom_usuari'], $token);
            
            echo "Correo enviado<br>";
        }else echo "Els dos emails han de ser iguals. <br>";
    }else echo "Email no registrado. <br>";
}

/**
 * Realitza el enviament de correu electronic al correu indicat.
 * @param correo: correu al qual s'enviarà el missatge
 * @param nombre: Nom de l'usuari al qual s'enviarà el missatge.
 * @param token: Token aplicat al link en el body del missatge.
 */

function enviarCorreo($correo, $nombre, $token){

    //Crea l'objecte de PHPMailer, passant el paràmetre boolean 'true' per deixar passar excepcions.
    $mail = new PHPMailer(true);
    //Passa a la variable $mail l'opció d'enviar correu fent servir SMTP.
    $mail->isSMTP(); 
    try {
        //Server settings
        $mail->CharSet  = "utf-8";
        $mail->SMTPDebug = 0;                                //Versió 0 de sortida de debug, és a dir, sense missatges. 1 per mostrar errors. 2 per mostrar errors i warnings.
        $mail->Host       = 'smtp.gmail.com';                //Passar servidor SMTP per fer l'enviament.
        $mail->SMTPAuth   = true;                            //Habilitar autenticació SMTP.
        $mail->Username   = 'martinjaime118@gmail.com';      //Nom d'usuari SMTP (el meu correu electrònic).
        $mail->Password   = 'tzme wvif twez tnij';           //Contrasenya d'usuari SMTP (contrasenya generat amb la seguretat de Google).
        $mail->SMTPSecure = 'ssl';                           //Habilitar enviament amb seguretat SSL.
        $mail->Port       =  465;                            //Port pel qual s'envia el correu.

        //Recipients
        $mail->setFrom('martinjaime118@gmail.com'); //Nom del correu pel qual s'enviarà el missatge.
        $mail->addAddress($correo, $nombre);     //Correu on s'enviarà el missatge.

        //Content
        $mail->isHTML(true);         //Cambiar el format HTML a true.
        $mail->Subject = "Recuperar contrasenya.";    //Assumpte del correu. En aquest cas el nom aplicat al formulari.   
        $mail->Body    = 
        "<html>
        <head>
            <title>Recuperar contrasenya MHJB</title>   
        </head>
        <body>
            <h3>Link per recuperar contrasenya: </h3>
            <a href='http://localhost/practiques/UF2/practica_05_mhjb/controlador/controlador_cambiar_contraseña.php?token=$token&email=$correo'> Click aquí per recuperar contrasenya.</a>
        </body>
        </html>";    //Cos del missatge. En aquest cas el text aplicat al formulari.

        $mail->send(); //Realitzar l'enviament.
        return "Enviat correctament.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
