<?php 
    require_once("../model/modelo_registro.php");
    include_once("../controlador/controlador_cambiar_contraseña.php");

    $token = $_GET['token'];
    $email = $_GET['email'];

    $user = selectEmail($email)->fetch();
    
    if($user['token'] == $token){

?>


<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="../estil/estil_inici_sessio.css" type="text/css">
    <meta charset="UTF-8" />
    <title></title>
</head>

<body>
    <div>

        <!--Acciona l'arxiu 'controlador.php' quan es clica l'input amb type="submit" (botó d'enviar)-->
        <form action="../controlador/controlador_cambiar_contraseña.php" method="post" class="firstForm">
            <h2>Recuperar contrasenya</h2>
            <div>

                <label>* Contrasenya antiga</label>
                <div>
                    <input type="password" name="contraVieja" value="<?php echo isset($_POST['contraVieja']) ? $_POST['contraVieja'] : null; ?> ">
                </div>
            </div>

            <div>
                <label>* Contrasenya nova</label>
                <div>
                    <input type="password" name="contraNueva" value="<?php echo isset($_POST['contraNueva']) ? $_POST['contraNueva']  : null; ?>">
                </div>
            </div>

            <div>
                <label>* Repetir contrasenya nova</label>
                <div>
                    <input type="password" name="reContraNueva" value="<?php echo isset($_POST['reContraNueva']) ? $_POST['reContraNueva']  : null; ?>">
                </div>
            </div>


            <div>
                <div>
                    <!-- Botó d'enviar la informació. Un cop clicat executarà l'arxiu 'controlador.php' especificat en action a l'obertura de l'etiqueta form-->
                    <input type="submit">
                </div>
            </div>
        </form>
        
        <form action="../vista/index.vista.php" method="post" class="thirthForm">
            <div>
                <input type="submit" value="Inici">
            </div>
        </form>

    </div>
</body>

</html>
<?php 
    }else{

?>


<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="../estil/estil_inici_sessio.css" type="text/css">
    <meta charset="UTF-8" />
    <title></title>
</head>

<body>
    <div>

        <!--Acciona l'arxiu 'controlador.php' quan es clica l'input amb type="submit" (botó d'enviar)-->
        <form action="../controlador/controlador_cambiar_contraseña.php" method="post" class="firstForm">
            <h2>ERROR: El token no coincideix</h2>

        </form>

        <form action="../vista/contraseña_olvidada.php" method="post" class="secondForm">
            <div>
                <input type="submit" value="Tornar a intentar">
            </div>
        </form>
        
        <form action="../vista/index.vista.php" method="post" class="thirthForm">
            <div>
                <input type="submit" value="Inici">
            </div>
        </form>

    </div>
</body>

</html>

<?php 
}

?>