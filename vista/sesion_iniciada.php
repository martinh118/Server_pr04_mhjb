<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../estil/estils.css"> <!-- feu referència al vostre fitxer d'estils -->
	<title>Paginació</title>
</head>

<body>
	<?php
	/**
	 * @author Martín Hernan Jaime Bonvin
	 * @version 1.0
	 */

	
	require_once("../controlador/controlador_sesion_iniciada.php");
	
	?>
	<header>
		<h2>Pt_04_Martín_Jaime </h2>
		
		<h3> <?php mostrarNombre(); ?> </h3>
		<a href="../vista/index.vista.php">TANCAR SESSIÓ</a>
	</header>

	<div class="contenidor">
		<h1>Articles</h1>
		<button><a href="../vista/crear_articulo.php">Crear Articulo</a></button>
		<?php

		/**
		 * A partir de fer un require_once de l'arxiu controlador, executa la funció per mostrar tots els articles i la paginació.
		 */
		iniciarPagina();
		?>

	</div>
</body>

</html>