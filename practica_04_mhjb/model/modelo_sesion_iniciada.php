<?php 

function mostrarArticulosUsario($connexio, $INICIO, $FINAL, $nom)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ID > :inicio AND ID <= :final AND ' . $nom . '=1');
        $statement->execute(
            array(
                ':inicio' => $INICIO,
                ':final' => $FINAL
            )
        );
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

function seleccionarArticulosUsuario($connexio, $nom)
{
    try {
        $statement = $connexio->prepare('SELECT * FROM articles WHERE ' . $nom . '=1');
        $statement->execute();
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}


function ocultarArticulo($connexio, $column, $idart){
    try {
        $statement = $connexio->prepare('UPDATE articles SET ' . $column .' = 0 WHERE ID = :idart');
        $statement->execute(
            array(
                ':idart' =>$idart
            )
        );
        return $statement;
    } catch (PDOException $e) { //
        // mostrarem els errors
        echo "Error: " . $e->getMessage();
    }
}

?>