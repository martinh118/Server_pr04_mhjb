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
        <form action="../controlador/controlador_iniciar_sessio.php" method="post" id="firstForm">
            <h2>Inici sessió</h2>
            <div>

                <label>* Nom d'usuari</label>
                <div>
                    <!-- Valor d'entrada amb el nom 'nom'. El value que conté dades php fa que en cas que detecti el valor de 'nom' amb la funció isset,
                        mostrarà el valor, en cas contrari mostra null (el valor estarà buit)  -->
                    <input type="text" name="nom" value="<?php echo isset($_POST['nom']) ? $_POST['nom']  : null; ?>">
                </div>
            </div>

            <div>
                <label>* Contrasenya</label>
                <div>
                    <!-- Valor d'entrada amb el nom 'contra'. El value que conté dades php fa que en cas que detecti el valor d''contra' amb la funció isset,
                    mostrarà el valor, en cas contrari mostra null (el valor estarà buit)  -->
                    <input type="password" name="contra" value="<?php echo isset($_POST['contra']) ? $_POST['contra']  : null; ?>">
                </div>
            </div>

            <div>
                <label>* Repetir Contrasenya</label>
                <div>
                    <!-- Valor d'entrada amb el nom 'contra'. El value que conté dades php fa que en cas que detecti el valor d''contra' amb la funció isset,
                    mostrarà el valor, en cas contrari mostra null (el valor estarà buit)  -->
                    <input type="password" name="reContra" value="<?php echo isset($_POST['reContra']) ? $_POST['reContra']  : null; ?>">
                </div>
            </div>

            <div>
                <div>
                    <!-- Botó d'enviar la informació. Un cop clicat executarà l'arxiu 'controlador.php' especificat en action a l'obertura de l'etiqueta form-->
                    <input type="submit">
                </div>
            </div>


        </form>
        </form>

        <form action="../vista/index.vista.php" id="secondForm">
            <div>
                <input type="submit" value="Inici">
            </div>
        </form>

        <form action="../vista/registro.php" id="thirthForm">
            <div>
                <input type="submit" value="Encara no tens compte?">
            </div>
        </form>
    </div>
</body>

</html>