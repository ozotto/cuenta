<?php
	
	$conexion = new mysqli('localhost', 'root' ,'', 'cuenta');
	if(!$conexion) {
		echo 'ERROR: No Se ha Conectado Con la Base De Datos.';
	} else {
		if(isset($_POST['queryString'])) {
			$queryString = $conexion->real_escape_string($_POST['queryString']);
						
			if(strlen($queryString) >0) {
				$query = $conexion->query
				("SELECT * from ciudad where nom_ciudad LIKE '%$queryString%' LIMIT 60"); 
				
				if($query) {
					while ($result = $query ->fetch_object()) {

					echo '<li onClick="fill_ciudad(\''.$result->nom_ciudad.'\');">
												   '.$result->nom_ciudad.'</li>';							   
	         		}
				} else {
					echo 'ERROR: Se ha producido un problema con la consulta.';
				}
			} else {
			} 
		} else {
			echo 'No debe haber acceso directo a este script!';
		}
	}
?>