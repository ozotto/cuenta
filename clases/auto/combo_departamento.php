<?php
	
	$conexion = new mysqli('localhost', 'root' ,'', 'cuenta');
	if(!$conexion) {
		echo 'ERROR: No Se ha Conectado Con la Base De Datos.';
	} else {
		if(isset($_POST['queryString'])) {
			$queryString = $conexion->real_escape_string($_POST['queryString']);
						
			if(strlen($queryString) >0) {
				$query = $conexion->query
				("SELECT * from departamento where nom_depto LIKE '%$queryString%' LIMIT 60"); 
				
				if($query) {
					while ($result = $query ->fetch_object()) {
					$nom_depto = strtolower($result->nom_depto); 		
					$nom_depto = ucwords($nom_depto);
					
					echo '<li onClick="fill_departamento(\''.$nom_depto.'\');">
														 '.$nom_depto.'</li>';							   
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