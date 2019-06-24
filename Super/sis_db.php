<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	$menu = $_GET['men'];
	
	if($menu == 1){

       	$sqln = "select * from sis_num_fal_art";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			echo("<script language=javascript> 
			alert('Los numeros faltantes ya fueron encontrados');
			location.href='sis_db.php';
			</script>");
		}else{
			$min="select min(cod_item) as num from almacen";
			$min2=@mysql_query($min,$conexion);
			$min3=@mysql_fetch_object($min2);
		
			$max="select max(cod_item) as num from almacen";
			$max2=@mysql_query($max,$conexion);
			$max3=@mysql_fetch_object($max2);
		
			$minimo = $min3->num;
			$maximo = $max3->num;
			
			for($i=$minimo;$i<=$maximo;$i++){
			
				$sqln = "select * from almacen where cod_item =$i";
				$nro = $con -> busca_campo($sqln,$conexion);
				if($nro != 0)
				{
				}else{
					$int="	insert into sis_num_fal_art ( `id_fal` , `no_fal` )
					values ( NULL ,  '$i' );";
					$int2=mysql_query($int,$conexion);
				}
			}
			$tot="select * from sis_num_fal_art";
			$tot2=@mysql_query($tot,$conexion);
			$total=@mysql_num_rows($tot2); 
			echo("<script language=javascript> 
			alert('Se registraron $total nuevos items faltantes del articulo');
			location.href='sis_db.php';
			</script>");
		}
	}
?>
<html>
<head>
<meta>
<title>DB</title>
</head>

<body>
<table width="200" border="1">
  <tr>
    <td><a href="sis_db.php?men=1">Buscar Numero Faltante de Articulo</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>