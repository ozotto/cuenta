<?
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");

	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	$cod_envia = $_GET['val'];
	
	$cons="select * from facturacion";
	$cons2=@mysql_query($cons,$conexion);
	$cons3=@mysql_num_rows($cons2);
	$t_inv = $cons3;
	$caracter = "-";
	//Paginacion****************************************************

	//Validacion desde java para saber si esta seleccionado un depar
	if($_POST['ver2'] == "OK")
	{
		$val_java = "0"; // Falta seleccio un departamento
	}else{
		if (isset($_POST['can'])){
			$val_java = "9"; // Selecciono un departamento 
		}	
	}
	
	//Valido el siguiente de los departamentos
	$val_dep2 = $_GET['cano'];
	if($val_dep2>0){
		$val_java ="9";
	}
	
	//Para el combo de los proveedores
	if($val_java==9){
	 if (isset($_POST['can'])){
		$val_dep = $_POST['can']; //cuando presiono el combo
		$cod_pro=$_POST['can'];
		$dig = -1;
	 }else{
	 	$cod_pro=$_GET['cano']; // lo envia la paginacion
		$reg_art = $cod_pro;
		$val_dep = $cod_pro; 
	 }	
	}	
	
	if($val_dep>0){
			
		$cant="select * from facturacion where cod_cli = '$cod_pro'";
		$cant2=@mysql_query($cant,$conexion);
		$t_art=@mysql_num_rows($cant2); 
	 }
	 //Para la caja de buscar
	 if($val_dep2>0){
	 	$dig = -1;
	 }else{
	 	$dig = $_GET['dig'];
	 }
	
	 if($dig>0){
	 	
		$buscador = 1;
	  	$buscar = $_GET['buscor'];
		$val_dep = -1;
		if (isset($_POST['can'])){
			$buscador = -1;
		}
	 }
	 if($_POST['ver'] == "OK")
	 {
		if ($cod_depto>0){
			$buscador = -1;
	 	}else{
			$buscador = 1;
		}	
		$buscar = $_POST['busco'];
		$val_dep = -1;
	 }	
	 if($buscador>0)
	 {
		$cant="select count(no_fac) as total from facturacion where no_fac LIKE '%$buscar%'";
		$cant2=@mysql_query($cant,$conexion);
		$cant3=@mysql_fetch_object($cant2);
		$t_art_bus = $cant3->total; 
		$valores = $t_art_bus; 
	 }		
	 if (isset($_POST['can'])){
	 	$numeroRegistros = $t_art;
	 }else{
	 	$numeroRegistros = $t_inv;
	 }
	 if($reg_art>0){
	 	$numeroRegistros = $t_art;
	 }
	 if($valores>0){
	 	$numeroRegistros = $t_art_bus;
	 }
	//echo "num reg ".$numeroRegistros;
	//Paginacion
		if(!isset($orden)) 
   		{ 
    	  	 $orden="fecha_compra"; 
   		}
		//tamaño de la pagina 
   		$tamPag=5; 

   		//pagina actual si no esta definida y limites 
   		if(!isset($_GET["pagina"])) 
   		{ 
			 $pagina=1; 
    	  	 $inicio=1; 
    	  	 $final=$tamPag; 
   		}else{
      		 $pagina = $_GET["pagina"]; 
   		}	 
   		//calculo del limite inferior 
   		$limitInf=($pagina-1)*$tamPag; 

		if (isset($_POST['can'])){
			$pagina=1; 
    	  	$inicio=1; 
    	  	$final=$tamPag; 
			$limitInf=($pagina-1)*$tamPag;
			//$limitInf=1;
		}
		
   		//calculo del numero de paginas 
   		$numPags=ceil($numeroRegistros/$tamPag); 
   		if(!isset($pagina)) 
   		{ 
			 $pagina=1; 
      		 $inicio=1; 
      		 $final=$tamPag; 
   		}else{ 
			 $seccionActual=intval(($pagina-1)/$tamPag); 
      	 	 $inicio=($seccionActual*$tamPag)+1; 
			
      	 	if($pagina<$numPags) 
      	 	{ 	
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
	//Fin Paginacion
	
	
	if($_POST['val'] == "OK" ) // cerrar factura
	{
		/*$fecha 	= $_GET['f_fac'];
		$num_fac = $_GET['n_fac'];
		$fac="select * from temporal where fecha_factura ='$fecha' and num_factura = '$num_fac'";
		$fac2=@mysql_query($fac,$conexion);
		while($fac3=@mysql_fetch_object($fac2)){
		
		$cod_item 	= $fac3->id_art;
		$cant		= $fac3->cantidad;
		$vr_uni		= $fac3->vr_venta;
		$v_total	= $fac3->vr_total;
		$no_orde	= $fac3->num_factura;
		$fec_com	= $fac3->fecha_factura;
		$cod_ven	= $fac3->cod_empleado;
				
		$com="
		INSERT INTO  ar_salida (
			id_sal, id_art, cantidad, vr_venta, vr_total, num_factura, fecha_venta, cod_cli, cod_empleado)
		VALUES (
		NULL,  '$cod_item',  '$cant',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$cod_cli', '$cod_ven');
		";
		$com2=mysql_query($com,$conexion);
		
		$alm="select * from almacen where cod_item = '$cod_item'";
		$alm2=@mysql_query($alm,$conexion);
		$alm3=@mysql_fetch_object($alm2);
		
		$c_alm = $alm3->cant_stock;
		
		$stock = $c_alm - $cant;

		$sql5 = "update almacen set cant_stock = '$stock' WHERE  cod_item ='$cod_item';";
		$consulta=mysql_query($sql5,$conexion);
		
		$sum  = "select sum(vr_total) total from temporal where num_factura = '$num_fac' and fecha_factura ='$fecha'";
		$sum2 = @mysql_query($sum,$con->conectar()); 
		$sum3 = @mysql_fetch_object($sum2);	
		$t_fac = $sum3->total;
			
		$ins="
			insert into facturacion (
			id_fac, no_fac, fecha_fac, vr_fac, cod_cli)
			VALUES (
			NULL,  '$num_fac', '$fecha',  '$t_fac',  '$cod_cli');
			";
		$ins2=mysql_query($ins,$conexion);
		
		}
				
		$sql="delete from temporal where fecha_factura ='$fecha' and num_factura = '$num_fac'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);		
		*/
		echo("<script language=javascript> 
		alert('La factura No. $num_fac del $fecha se cerro corractamente');
		
		</script>");
		echo '<script type="text/javascript">';
		echo 'location.href="ventas.php';
		echo '</script>';	
		
	/*	document.form1.crea.value='OK';
		document.form1.submit();*/
	}
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
?>
<html>
<head>
<meta>
<title>Ventas</title>
</head>
<script language='javascript' src="../clases/calendario/popcalendar.js"></script> 
<script language="javascript">
	function valida(form1) { 
		
		document.form1.oc.value="OK";
		document.form1.submit();  
	}
	function valida2(form1) { 
		
		document.form1.op.value="OK";
		document.form1.submit();  
	}
		function buscar(form1) { 
		if(document.form1.can.value=="Seleccione" )
		{
			document.form1.ver2.value="OK";
		}else{
			document.form1.action="ventas.php?val=1";
		}
		if(document.form1.busco.value=="" )
		{
			alert("Debe completar el Numero de la Factura");
			document.form1.busco.focus();
		}else{
			document.form1.ver.value="OK";
			document.form1.submit();  
		}	
	}
</script>	
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
<?
if($_GET['crea'] == "OK")
	{
	//echo "prueb";
	$_POST['op'] == "OK";
	}
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu Ventas
	$act_men_ventas = $_SESSION['men_ventas'];
	@menu_gestion($act_men_ventas);
	?>    
	<?
	//echo "tabla2";
	?>
    <? //Tabla datos VENTAS
	//Validacion aparecer TABLA 3
	$datos_venta = $cod_envia;
	if($datos_venta>0){
	 //Consultas	
	// 1. Cantidad de Ventas
	$cant="select no_fac from facturacion";
	$cant2=@mysql_query($cant,$conexion);
	$no_fac=mysql_num_rows($cant2); 
	
	// 2. Suma total de Ventas
	$sum="select sum(vr_fac) as total from facturacion";
	$sum2=@mysql_query($sum,$conexion);
	$sum3=@mysql_fetch_object($sum2); 
	$tot_venta = $sum3->total;
	$tot_venta = number_format($tot_venta, 0, ",", ".");
	
	// 3. Ultimas Ventas realizadas
	$ult="select * from facturacion where fecha_fac between '$fecha_ant' and '$fecha' limit 0, 5";
	$ult2=@mysql_query($ult,$conexion);
	$u_art=mysql_num_rows($ult2); 
	$ult_pro = $u_art;
	
	// 4. La ultima venta realizada
	$ulta="select max(fecha_fac) as total from facturacion";
	$ulta2=@mysql_query($ulta,$conexion);
	$ulta3=@mysql_fetch_object($ulta2); 
	$ult_com = $ulta3->total;
	
	// 5. Ventas pendientes
	$pen="select * from temporal";
	$pen2=@mysql_query($pen,$conexion);
	$pen3=mysql_num_rows($pen2); 
	$ven_pen = $pen3;
	
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
        <td width="150"><span class="Estilo6">No. de Ventas</span></td>
        <td width="150"><? echo $no_fac;?></td>
      </tr>
      <tr>
        <td><span class="Estilo6">Valor Total de Ventas </span></td>
        <td><span class="Estilo12">$ <? echo $tot_venta;?></span></td>
      </tr>
    </table>

    <? //tabla, Nueva lista para ver el total de ventas por dia?>
    <br>
    <table width="0" border="1">
      <tr>
        <td colspan="2"><div align="center"><span class="Estilo6">TOTAL POR DIA </span></div></td>       
      </tr>
      <?
		if ($ven_pen>0){
		?>
      <tr>
        <td width="150"><span class="Estilo6">Fecha</span></td>
        <td width="150"><span class="Estilo6">Total</span></td>
      </tr>
	<?
			$i=1;
			$cant="SELECT fecha_factura, sum(vr_total) as 'total' FROM temporal GROUP BY fecha_factura ORDER BY fecha_factura DESC";
			$cant2=@mysql_query($cant,$conexion);
			
			while ($cant3=@mysql_fetch_object($cant2)){
			 
			 $fec_fac = $cant3->fecha_factura;
			 $tot_fac = number_format($cant3->total, 2, ",", ".");
			 	
		?>
      <tr>
        <td><span class="Estilo7"><? echo $fec_fac;?></span></td>
        <td><span class="Estilo7">$ <? echo $tot_fac;?></span></td>
      </tr>
      <? 
			$i++;
			}
		}
		?>
    </table>

	</td>
    <td width="400" valign="top">
	<? //tabla 3.2, Tabla Ultimas Ventas?>
	<table width="500" border="1">
      <tr>
        <td width="500"><div align="center"><span class="Estilo6">ULTIMAS VENTAS REGISTRADAS </span></div></td>
      </tr>
      <tr>
        <td>
		<? //tabla 3.2.1, Listado de Ventas?>
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<? 
		if($ult_pro > 0	){
		?>
		<tr>
		<td width="27"><div align="center"><span class="Estilo6">No</span></div></td>
    	<td width="70"><div align="center"><span class="Estilo6">No. Factura</span></div></td>
    	<td width="112"><div align="center"><span class="Estilo6">Cliente</span></div></td>
    	<td width="61"><div align="center"><span class="Estilo6">Total Fac</span></div></td>
    	<td width="100"><div align="center"><span class="Estilo6">Fecha Fac</span></div></td>
  		</tr>
		<?
			$i=1;
//			$cant="select distinct no_fac from facturacion ORDER BY fecha_fac DESC limit 0, 5";
			$cant="select * from facturacion ORDER BY fecha_registro DESC limit 0, 5";
			$cant2=@mysql_query($cant,$conexion);
			while ($cant3=@mysql_fetch_object($cant2)){
	  		 $id_cli = $cant3->cod_cli;
			 $cli="select * from clientes where cod_cli = $id_cli";
			 $cli2=@mysql_query($cli,$conexion);
			 $cli3=@mysql_fetch_object($cli2); 	
				 
			 $no_fac = $cant3->no_fac;
			 $fe_fac = $cant3->fecha_fac;
			 $tot_fac = $cant3->vr_fac;
			 $tot_fac = number_format($tot_fac, 2, ",", ".");
			 
			 $cli = $cli3->name_cli;
			 $nom_cli = strtolower($cli); 		//Pasar todo a minusculas
			 $nom_cli = ucwords($nom_cli);		//Pasar a mayuscula la primera letra de cada cadena	
			
		?>
  		<tr class="celda" onClick="window.location='ventas2.php?id_com=<? echo $no_fac;?>&fec=<? echo $fe_fac;?>'">
    	<td><div align="center"><span class="Estilo7"><? echo $i;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $no_fac;?></span></div></td>
    	<td><div align="left"><span class="Estilo7"><? echo $nom_cli;?></span></div></td>
    	<td><div align="right"><span class="Estilo7"><? echo $tot_fac;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $fe_fac;?></span></div></td>
  		</tr>
		<? 
			$i++;
			}
		}else{
		?>
  		<tr>
    	<td colspan="5">
		<div align="center"><span class="Estilo7">No se registran ventas desde <? echo $ult_com;?></span></div>
		</td>
    	</tr>
		<? }?>
		</table>
		</td>
      </tr>
    </table>
	</td>
  	</tr>
  	<tr>
    <td>&nbsp;
    
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
			$cant="select distinct num_factura, fecha_factura from temporal order by fecha_factura desc limit 0,5";
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
    </table>
	</td>
  	</tr>
	</table>	
	<? //Tabla Filtros?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="205"><span class="Estilo8">Filtrar por Clientes </span></td>
        <td width="595">
		<select name="can" id="can" onChange="document.form1.can.selectedindex=0;
        									  document.form1.action='ventas.php?val=1';
                                              document.form1.submit();">
          <option> Seleccione</option>
          <? 
		  $depto="select * from clientes order by name_cli";
		  $depto2=@mysql_query($depto,$conexion);
		  while($campo = mysql_fetch_object($depto2)){
		   $name_cli = strtolower($campo->name_cli); 		//Pasar todo a minusculas
		   $name_cli = ucwords($name_cli);		//Pasar a mayuscula la primera letra de cada cadena	
		  echo'<option value="'.$campo->cod_cli.'">'.$name_cli.'</option>';
		  } 
		  ?>
        </select>
		<input name="ver2" type="hidden" id="ver2"/>		
        </td>
      </tr>
      <tr>
        <td><span class="Estilo8">Buscar No. Factura </span></td>
        <td>
		<input name="busco" type="text" id="busco">
		<input type="button" name="b" id="b" value="Buscar" onClick="buscar(this)" />
		<input name="ver" type="hidden" id="ver"/>
		</td>
      </tr>
    </table>
    <? //Tabla LISTAR FACTURAS DE COMPRAS?>
	<table width="800" border="1">
      <tr>
        <td width="34"><div align="center"><span class="Estilo6">No</span></div></td>
        <td width="96"><div align="center"><span class="Estilo6">No. FACTURA</span></div></td>
        <td width="118"><div align="center"><span class="Estilo6">FECHA FACTURA</span></div></td>
        <td width="343"><div align="center"><span class="Estilo6">CLIENTE</span></div></td>
        <td width="175"><div align="center"><span class="Estilo6">TOTAL FACTURA</span></div></td>
      </tr>
	  <?
	  
	  $cant="select * from facturacion ORDER BY fecha_fac DESC limit ".$limitInf.",".$tamPag;
      $alm2=@mysql_query($cant,$conexion);
 	  $cuan2=@mysql_num_rows($alm2); 

	  if($val_dep>0){
		$cant=" select * from facturacion
				where cod_cli='$cod_pro' 
				ORDER BY fecha_fac DESC 
				limit ".$limitInf.",".$tamPag;
        $alm2=@mysql_query($cant,$conexion);
	  }
	  
	  if($buscador>0)
	  {
		$cant=" select * from facturacion
				where no_fac LIKE '%$buscar%' 
				ORDER BY fecha_fac DESC 
				limit ".$limitInf.",".$tamPag;
        $alm2=@mysql_query($cant,$conexion);
		$val_dep=0;
	  }
	 
	  while($dep3 = mysql_fetch_object($alm2)){
	  	$no_fac 	= $dep3->no_fac;
		$fecha_fac  = $dep3->fecha_fac;
		$cod_cli	= $dep3->cod_cli;
		$to_fac 	= $dep3->vr_fac;
				
		$cli="select * from clientes where cod_cli = $cod_cli ";
		$cli2=@mysql_query($cli,$conexion);
		$cli3=@mysql_fetch_object($cli2);		
		
		$nom_cli	= $cli3->name_cli;	
		$nom_cli 	= strtolower($nom_cli); 		
		$nom_cli 	= ucwords($nom_cli);	
			 
	  	$to_fac 	= number_format($to_fac, 0, ",", ".");
	 
	  ?>
      <tr class="celda" onClick="window.location='ventas2.php?id_com=<? echo $no_fac;?>&fec=<? echo $fecha_fac;?>'">
        <td><div align="center"><span class="Estilo7"> <? echo $x;?>	  </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $no_fac;?> </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $fecha_fac;?> </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $nom_cli;?> </span></div></td>
        <td>
   		 <table width="70" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
           <td width="10"><div align="right"><span class="Estilo7">$</span></div></td>
           <td width="60"><div align="right"><span class="Estilo7"><? echo $to_fac;?></span></div></td>
          </tr>
        </table>
        </td>
      </tr>
	  <?
	  	$x++;
	  }
	  if($numeroRegistros==0){
	  ?>
	  <tr>
       <td colspan="6" class="Estilo7">
	   <?
	   if($val_dep>0){
		//Busco nombre de proveedor
		$pro="select * from clientes where cod_cli = $cod_pro ";
		$pro2=@mysql_query($pro,$conexion);
		$pro3=@mysql_fetch_object($pro2);		   
    	$name_cli = strtolower($pro3->name_cli); 		
		$name_cli = ucwords($name_cli);		

	   ?>
	   <div align="center">
	   	No se existen facturas para el proveedor <? echo $name_cli;?>
	   </div>                 
	   <?
	   }
	   if($buscador>0)
	   {
	   ?>
	   <div align="center">
	   	No se existen Facturas con el numero <? echo $buscar;?>
	   </div>                 
	   <?
	   }
	   ?>
	   </td>
      </tr>
	  <?
	  }
	  ?>
    </table>
    <? // Tabla para numeros de paginacion?>
    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
   	<tr><td align="center" valign="top">
	<?  
	//paginacion 
   	if($pagina>1) 
   	{ 
      	if($valores>0){
			echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina-1)."&dig=".$valores."&buscor=".$buscar."'>"; 
      		echo "<font face='verdana' size='-2'>anterior</font></a>";
		}
		if($reg_art>0){
		 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina-1)."&orden=".$orden."&cano=".$cod_dep."'>"; 
    	 	echo "<font face='verdana' size='-2'>anterior</font>"; 
      	 	echo "</a> "; 
		}
		if($reg_art<=0 and $valores<=0){
   		 	echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina-1)."&orden=".$orden."'>"; 
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
				echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".$i."&dig=".$valores."&buscor=".$buscar."'>"; 
      			echo "<font face='verdana' size='-2'>".$i."</font></a> ";
			}
			if($reg_art>0){
         	 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".$i."&orden=".$orden."&cano=".$cod_dep."'>"; 
         	 	echo "<font face='verdana' size='-2'>".$i."</font></a> "; 
			}
			if($reg_art<=0 and $valores<=0){
   			 	echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".$i."&orden=".$orden."'>"; 
   			 	echo "<font face='verdana' size='-2'>".$i."</font></a>"; 
			}	
      	 } 
   	} 
   	if($pagina<$numPags) 
   	{ 
		if($valores>0){
			echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina+1)."&dig=".$valores."&buscor=".$buscar."'>"; 
      		echo "<font face='verdana' size='-2'>siguiente</font></a>";
		}
		if($reg_art>0){
      		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina+1)."&orden=".$orden."&cano=".$cod_pro."'>"; 
      		echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
		}
		if($reg_art<=0 and $valores<=0){
   		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina+1)."&orden=".$orden."'>"; 
   		echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
		}

   	} 
	?> 
	</td></tr> 
   	</table>
    <? //fin tabla paginacion?>
	<? 
	}
	//Fin tabla VENTAS?>
	</td>
  </tr>
</table>   	
</body>
</html>
