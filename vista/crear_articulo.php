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
        <form action="../controlador/controlador_crear_articulo.php" method="post" id="firstForm">
            <h2>Inici sessió</h2>
            <div>

                <label>* Contingut article</label>
                <div>
                    <!-- Valor d'entrada amb el nom 'nom'. El value que conté dades php fa que en cas que detecti el valor de 'nom' amb la funció isset,
                        mostrarà el valor, en cas contrari mostra null (el valor estarà buit)  -->
                    <textarea name="content" id="content" cols="30" rows="10" ></textarea>
                </div>
            </div>
            <div>
                <!-- Botó d'enviar la informació. Un cop clicat executarà l'arxiu 'controlador.php' especificat en action a l'obertura de l'etiqueta form-->
                <input type="submit">
            </div>

        </form>

        <form action=" ../controlador/controlador_sesion_iniciada.php" id="thirthForm">
        <div>
                <input type="submit" value="Inici" name="pagina">
            </div>
        </form>
    </div>
</body>

</html>