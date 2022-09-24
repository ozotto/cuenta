<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");

	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	$cod_envia = 1;
	
	$cons="select * from facturacion";
	$cons2=@mysql_query($cons,$conexion);
	$cons3=@mysql_num_rows($cons2);
	$t_inv = $cons3;
	$caracter = "-";
	
	//tamaño de la pagina 
	$tamPag=30;

	//pagina actual si no esta definida y limites 
  if(!isset($_GET["pagina"])){ 
		$pagina=1;
		$inicio=1;
    $final=$tamPag; 
  }else{
  	$pagina = $_GET["pagina"]; 
  }	 
  	
  if($_POST['flag_cerrar'] == "OK")
	{

		$info_fact = "SELECT num_factura, fecha_factura, cod_cli, sum(vr_total) total FROM temporal GROUP BY num_factura, fecha_factura, cod_cli ORDER BY fecha_factura";
		$q_fact=@mysql_query($info_fact,$conexion);
		while($res_fact=@mysql_fetch_object($q_fact)){

			$numero_factura = $res_fact->num_factura;
			$fecha_factura = $res_fact->fecha_factura;
			$cliente_factura = $res_fact->cod_cli;
			$total_factura = $res_fact->total;

			//Information de la factura
			$fac="SELECT * FROM temporal WHERE fecha_factura ='$fecha_factura' AND num_factura ='$numero_factura'";
			$fac2=@mysql_query($fac,$conexion);
			while($fac3=@mysql_fetch_object($fac2)){
				$cod_item 	= $fac3->id_art;
				$cant				= $fac3->cantidad;
				$vr_uni			= $fac3->vr_venta;
				$v_total		= $fac3->vr_total;
				$cod_ven		= $fac3->cod_empleado;
				
				$com="
				INSERT INTO  ar_salida (
					id_sal, id_art, cantidad, vr_venta, vr_total, num_factura, fecha_venta, cod_cli, cod_empleado)
				VALUES (
				NULL,  '$cod_item',  '$cant',  '$vr_uni',  '$v_total',  '$numero_factura',  '$fecha_factura',  '$cliente_factura', '$cod_ven');
				";
				$com2=mysql_query($com,$conexion);
				
				//Actualizar la cantidad del articulo en el inventario
				$alm="SELECT * FROM almacen WHERE cod_item = '$cod_item'";
				$alm2=@mysql_query($alm,$conexion);
				$alm3=@mysql_fetch_object($alm2);
				
				$c_alm = $alm3->cant_stock;
				$stock = $c_alm - $cant;

				$sql5 = "UPDATE almacen SET cant_stock = '$stock' WHERE cod_item ='$cod_item';";
				$consulta=mysql_query($sql5,$conexion);
			
			}

			//Actualizar la tabla facturacion
			$ins="INSERT INTO facturacion (id_fac, no_fac, fecha_fac, fecha_registro, vr_fac, cod_cli)
			VALUES (
			NULL,  '$numero_factura',  '$fecha_factura', '$fecha', '$total_factura',  '$cliente_factura');
			";
			$ins2=mysql_query($ins,$conexion);

			//Borrar desde temporal la factura
			$sql="DELETE FROM temporal WHERE fecha_factura ='$fecha_factura' AND num_factura ='$numero_factura'";
			$bor=@mysql_query($sql,$conexion);
			$bor1 = @mysql_fetch_object($bor);		

			echo("<script language=javascript> 
			alert('La factura $numero_factura de fecha $fecha_factura cerro su facturación con un total de $total_factura ');
			</script>");
		}	 

		echo("<script language=javascript> 
		alert('Todas las facturas fueron cerradas');		
		</script>");
	}	

	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
?>
<html>
<head>
<meta>
<title>Facturacion</title>
</head>
 
<script language="javascript">
	function cerrar_facturas() { 
		document.form1.flag_cerrar.value="OK";
		document.form1.submit();  
	}

</script>	
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu
	@menu_gestion(11);
	?>    
	
	<? //Tabla datos VENTAS
	
	//Validacion aparecer TABLA 3
	$datos_venta = $cod_envia;
	if($datos_venta>0){
	//Consultas	
	// 1. Cantidad de Ventas
	$cant="SELECT count(DISTINCT(num_factura)) as 'num', sum(vr_total) as 'total' FROM temporal";
	$cant2=@mysql_query($cant,$conexion);
	$no_fac=mysql_fetch_object($cant2); 
	$valores = $no_fac->num;
	$numeroRegistros = $valores;

	// Ventas pendientes
	$pen="select * from temporal";
	$pen2=@mysql_query($pen,$conexion);
	$pen3=mysql_num_rows($pen2); 
	$ven_pen = $pen3;
	
	//calculo del limite inferior 
  $limitInf=($pagina-1)*$tamPag;
	
	//calculo del numero de paginas 
  $numPags=ceil($numeroRegistros/$tamPag); 
	if(!isset($pagina)){ 
		$pagina=1; 
		$inicio=1; 
		$final=$tamPag; 
	}else{ 
		$seccionActual=intval(($pagina-1)/$tamPag); 
		$inicio=($seccionActual*$tamPag)+1; 
  	
  	if($pagina<$numPags){ 	
			$x = (($pagina-1)*$tamPag)+$inicio;	
			$final=$inicio+$tamPag-1; 
  	}else{ 
			$x = (($pagina-1)*$tamPag)+$inicio;
     	$final=$numPags; 
  	} 

   	if ($final>$numPags){ 
			$x = (($pagina-1)*$tamPag)+$inicio;
      $final=$numPags; 
  	} 
	}


	?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  	<tr>
    <td width="400" valign="top">
	<? //tabla 3.1, Tabla Datos Venta?>
	<table width="0" border="1">
      <tr>
        <td colspan="2"><div align="center"><span class="Estilo6">DATOS VENTAS </span></div></td>
        </tr>
      <tr>
        <td width="150"><span class="Estilo6">No. de Facturas</span></td>
        <td width="150"><? echo $no_fac->num;?></td>
      </tr>
      <tr>
        <td><span class="Estilo6">Valor Total de Ventas </span></td>
        <td><span class="Estilo12">$ <? echo number_format($no_fac->total, 0, ",", ".");?></span></td>
      </tr>
    </table>

    <? //tabla, Nueva lista para ver el total de ventas por dia?>
    <br>
    <input type="button" name="button2" id="button2" value="Cerrar Totas las Facturas" onClick="cerrar_facturas()" />
    <input name="flag_cerrar" type="hidden" id="flag_cerrar"/>
    <table width="0" border="1">
      <tr>
        <td colspan="3"><div align="center"><span class="Estilo6">TOTAL POR DIA </span></div></td>       
      </tr>
      <?
		if ($ven_pen>0){
		?>
      <tr>
        <td width="100"><div align="center"><span class="Estilo6">Fecha</span></div></td>
        <td width="100"><div align="center"><span class="Estilo6">No. Facturas</span></div></td>
        <td width="100"><div align="center"><span class="Estilo6">Total</span></div></td>
      </tr>
	<?
			$i=1;
			$cant="SELECT fecha_factura, COUNT(DISTINCT(num_factura)) 'fact', sum(vr_total) as 'total' FROM temporal GROUP BY fecha_factura ORDER BY fecha_factura DESC";
			$cant2=@mysql_query($cant,$conexion);
			
			while ($cant3=@mysql_fetch_object($cant2)){
			 
			 $fec_fac = $cant3->fecha_factura;
			 $num_fac = $cant3->fact;
			 $tot_fac = number_format($cant3->total, 2, ",", ".");
			 	
		?>
      <tr>
        <td><div align="center"><span class="Estilo7"><? echo $fec_fac;?></span></div></td>
        <td><div align="center"><span class="Estilo7"><? echo $num_fac;?></span></div></td>
        <td><div align="right"><span class="Estilo7">$ <? echo $tot_fac;?></span></div></td>
      </tr>
      <? 
			$i++;
			}
		}
		?>
    </table>

	</td>
  <td valign="top">
	<? //tabla 3.3, Tabla Compras Pendientes?>
	<table width="500" border="1">
      <tr>
		<td width="500"><div align="center"><span class="Estilo6">VENTAS PENDIENTES POR COMPLETAR</span></div></td>
      </tr>	
      <tr>
        <td>
		<? //tabla 3.3.1, Listado de compras PENDIENTES?>
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<?
		if ($ven_pen>0){
		?>
		<tr>
		<td width="27" ><div align="center"><span class="Estilo6">No</span></div></td>
    	<td width="70" ><div align="center"><span class="Estilo6">No. Factura</span></div></td>
    	<td width="112"><div align="center"><span class="Estilo6">Cliente</span></div></td>
    	<td width="61" ><div align="center"><span class="Estilo6">Total Fac</span></div></td>
    	<td width="100"><div align="center"><span class="Estilo6">Fecha Fac</span></div></td>
  		</tr>
		<?
			$i=1;
			$cant="select distinct num_factura, fecha_factura from temporal order by fecha_factura desc limit ".$limitInf.",".$tamPag;
			$cant2=@mysql_query($cant,$conexion);
			
			while ($cant3=@mysql_fetch_object($cant2)){
			 $no_fac = $cant3->num_factura;			 
			 $fec_fac2 = $cant3->fecha_factura."<br>";
			 	
			 $v_año=substr($fec_fac2,0,4);
			 $v_mes=substr($fec_fac2,5,2);
			 $v_dia=substr($fec_fac2,8,2);

			 $fec_fac = $v_año.$caracter.$v_mes.$caracter.$v_dia;
								
			 $cod_cli = 1;

			 $cli="select * from clientes where cod_cli = $cod_cli";
			 $cli2=@mysql_query($cli,$conexion);
			 $cli3=@mysql_fetch_object($cli2); 

			 $nom_cli = $cli3->name_cli;
			 $nom_cli = strtolower($nom_cli); 		
			 $nom_cli = ucwords($nom_cli);	
			 
			 $suma="select sum(vr_total) as total 
			 		from temporal 
					where num_factura = $no_fac and fecha_factura= '$fec_fac' " ;
			 $suma2=@mysql_query($suma,$conexion);
			 $suma3=@mysql_fetch_object($suma2); 
			 
			 $tot_fac = $suma3->total;
			 $total = number_format($tot_fac, 2, ",", ".");
		?>
  		<tr class="celda" onClick="window.location='ventas2.php?id_pen=<? echo $no_fac;?>&fec=<? echo $fec_fac;?>'">
		<td><div align="center"><span class="Estilo7"><? echo $i;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $no_fac;?></span></div></td>
    	<td><div align="left"><span class="Estilo7"><? echo $nom_cli;?></span></div></td>
    	<td><div align="right"><span class="Estilo7"><? echo $total;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $fec_fac;?></span></div></td>
  		</tr>
		<?
			 $i++;
			} 
		}else{
		?>
  		<tr>
    	<td colspan="5">
		<div align="center"><span class="Estilo7">No existen ventas pendientes</span></div>
		</td>
  		</tr>
		<? }?>
		</table>
			</td>
    </tr>
    <tr>
    	<td>
    		<? // Tabla para numeros de paginacion?>
		    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
		   	<tr><td align="center" valign="top">
			<?  
			//paginacion 
		   	if($pagina>1) 
		   	{ 
		      	if($valores>0){
					echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."'>"; 
		      		echo "<font face='verdana' size='-2'>anterior</font></a>";
				}
				if($reg_art>0){
				 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."'>"; 
		    	 	echo "<font face='verdana' size='-2'>anterior</font>"; 
		      	 	echo "</a> "; 
				}
				if($reg_art<=0 and $valores<=0){
		   		 	echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."'>"; 
		   		 	echo "<font face='verdana' size='-2'>anterior</font></a>"; 
				}		
				
		   	} 

		   	for($i=$inicio;$i<=$final;$i++) 
		   	{ 
		      	 if($i==$pagina) 
		      	 { 
		         	 echo "<font face='verdana' size='-2'><b>".$i."</b> </font>"; 
		      	 }else{ 
				 	if($valores>0){
						echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."'>"; 
		      			echo "<font face='verdana' size='-2'>".$i."</font></a> ";
					}
					if($reg_art>0){
		         	 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."'>"; 
		         	 	echo "<font face='verdana' size='-2'>".$i."</font></a> "; 
					}
					if($reg_art<=0 and $valores<=0){
		   			 	echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."'>"; 
		   			 	echo "<font face='verdana' size='-2'>".$i."</font></a>"; 
					}	
		      	 } 
		   	} 
		   	if($pagina<$numPags) 
		   	{ 
				if($valores>0){
					echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."'>"; 
		      		echo "<font face='verdana' size='-2'>siguiente</font></a>";
				}
				if($reg_art>0){
		      		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."'>"; 
		      		echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
				}
				if($reg_art<=0 and $valores<=0){
		   		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."'>"; 
		   		echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
				}

		   	} 
			?> 
			</td></tr> 
		   	</table>
		    <? //fin tabla paginacion?>


    	</td>
    </tr>
    </table>
	</td>
  	</tr>
	</table>	

  
	<? 
	}
	//Fin tabla VENTAS?>
	</td>
  </tr>
</table>   	
</body>
</html>
