<?php

	// PHP5 Implementation - uses MySQLi.
	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
	$conexion = new mysqli('localhost', 'root' ,'', 'cuenta');
	
//	if(!$db) {

	if(!$conexion) {
		// Show error if we cannot connect.
		echo 'ERROR: No Se ha Conectado Con la Base De Datos.';
	} else {
		// Is there a posted query string?
		if(isset($_POST['queryString'])) {
			$queryString = $conexion->real_escape_string($_POST['queryString']);
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) {
				// Run the query: We use LIKE '$queryString%'
				// The percentage sign is a wild-card, in my example of countries it works like this...
				// $queryString = 'Uni';
				// Returned data = 'United States, United Kindom';
				
				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
				
	//			$query = $conexion->query("SELECT nom_campo from campo_profesional where nom_campo LIKE '$queryString%' LIMIT 10");
//				$query = $conexion->query("SELECT nom_universidad from universidad where nom_universidad LIKE '$queryString%' LIMIT 10");
			//$query = $conexion->query("SELECT nom_carrera from carrera where nom_carrera LIKE '$queryString%' LIMIT 10"); 
				//$query = $conexion->query("SELECT nom_ciudad from ciudad where nom_ciudad LIKE '$queryString%' LIMIT 10"); nombre de ciudad
				$query = $conexion->query
				("SELECT * from almacen where des_item LIKE '$queryString%' or cod_item LIKE '$queryString%' LIMIT 60");  
				
		//		//$query = $conexion->query("select * from temporal where cod_usu='154'");
				if($query) {
					// While there are results loop through them - fetching an Object (i like PHP5 btw!).
					while ($result = $query ->fetch_object()) {
						// Format the results, im using <li> for the list, you can change it.
						// The onClick function fills the textbox with the result.
						
						// YOU MUST CHANGE: $result->value to $result->your_colum
					$result->des_item;			
//		       		echo '<li onClick="fill(\''.$result->cod_item.'_'.$result->des_item.'\');document.form1.submit();">
//												   '.$result->cod_item.'___'.$result->des_item.'___'.$result->precio.'</li>';
					echo '<li onClick="fill(\''.$result->cod_item.'_'.$result->des_item.'\');document.form1.submit();">
												   '.$result->des_item.'___'.$result->cod_item.'</li>';							   
	         		}
				} else {
					echo 'ERROR: Se ha producido un problema con la consulta.';
				}
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'No debe haber acceso directo a este script!';
		}
	}
?>