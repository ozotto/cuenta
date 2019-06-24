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
	
	$cod_envia = $_GET['val'];
		
	$cons="select distinct num_factura from compras";
	$cons2=@mysql_query($cons,$conexion);
	$cons3=@mysql_num_rows($cons2);
	$t_inv = $cons3;
	
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
			
		$cant="select distinct num_factura from compras where cod_pro = '$cod_pro'";
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
		$cant="select count(num_factura) as total from compras where num_factura LIKE '%$buscar%'";
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
	
	if($_POST['n_com'] == "OK") //Boton Nueva compra
	{
		$nueva_compra = 3;
		$datos_compra = -3;
	}
	if($_POST['op'] == "OK") //Seleccion Credito o Contado
	{
		$nueva_compra = 3;
		$datos_compra = -3;
	}
	if($_POST['oc'] == "OK") //Boton Datos nueva compra
	{
		$fecha_ven = $_POST['fecha_vence'];
		$proveedor = $_POST['can'];
		$fecha_com = $_POST['fecha_compra'];
		$no_orden = $_POST['orden'];
		$_SESSION['valores_nue_compra']	= 1;
	
		echo "<br>a: ".$_SESSION['f_ven'] 		= $fecha_ven;
		echo "<br>b: ".$_SESSION['can'] 		= $proveedor;
		echo "<br>c: ".$_SESSION['f_compra'] 	= $fecha_com;
		echo "<br>d: ".$_SESSION['orden'] 		= $no_orden;
		
		$nueva_compra = -3;
		$datos_compra = -3;
		$hacer_fac	  = 3;			
	}
	//Cadena seleccionar articulo
	$cadena=$_POST['inputString'];
	list($codigo,$detalle)=split('[_]',$cadena);
	if (empty($cadena)){
	}else{
		//Aperecer y Ocultar tablas
		$cant = $codigo;
		$nueva_compra = -3;
		$datos_compra = -3;
		$hacer_fac	  = 3;
		
		$cod_item = $codigo;
		$_SESSION['cod'] = $codigo;		
	}
	$cod=$_POST['clave'];
	if (empty($cod)){
	}else{
		$cant = $cod;
		$cod_item = $cod;
		$_SESSION['cod'] = $cod;
	}
	if($_POST['re'] == "OK") //Registro Articulo en Factura
	{
		$registro = 3;
		$cant = $_SESSION['cod'];
		$nueva_compra = -3;
		$datos_compra = -3;
		$hacer_fac	  = 3;
	}	
	if($_POST['fac'] == "OK") //Registro Articulo en Factura
	{
		$registro = -3;
		$cant = -3;
		$nueva_compra = -3;
		$datos_compra = 3;
		$hacer_fac	  = -3;
		$reg_fac	= 3;
	}
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
?>	
<html>
<head>
<script language='javascript' src="../clases/calendario/popcalendar.js"></script> 
<script type="text/javascript" src="../clases/auto/jquery-1.2.1.pack.js"></script>
<script language="javascript">
	function valida()
	{
		document.form1.n_com.value="OK";
		document.form1.action="compras.php";
		document.form1.submit();
	}
	function valida2(form1) { 
		document.form1.op.value="OK";
		document.form1.submit();  
	}
	function vacio(q) {  
        for ( i = 0; i < q.length; i++ ) {  
                if ( q.charAt(i) != " " ) {  
                        return true  
                }  
        }  
        return false  
	} 
	function getRadioButtonSelectedValue(ctrl)
	{
		for(i=0;i<ctrl.length;i++)
			if(ctrl[i].checked) return ctrl[i].value;
	}
	
	function c_fac(form1) {  
		
		for(i=0; i <document.form1.ver.length; i++){
			if(document.form1.ver[i].checked){
				valorSeleccionado = document.form1.ver[i].value;
			}
		}
		//alert (valorSeleccionado);
		
		if(document.form1.can.value == "Seleccione" ) {  
			alert("Es necesario seleccionar el Proveedor");
			document.form1.can.focus();
            return false  
        }
		if( vacio(document.form1.orden.value) == false ) {  
			alert("Digite el numero de la Factura de compra");
			document.form1.orden.focus();
            return false  
        }	
		if( vacio(document.form1.fecha_compra.value) == false ) {  
			alert("Debe seleccionar la fecha de compra de la Factura");
			document.form1.fecha_compra.focus();
            return false  
        }
		if(valorSeleccionado == 2){
			if( vacio(document.form1.fecha_vence.value) == false ) { 
				alert("Debe seleccionar la fecha de vencimiento de la Factura");
				document.form1.fecha_vence.focus();
				return false  
			} 	
			if(document.form1.fecha_vence.value <= document.form1.fecha_compra.value) {
				alert("La fecha de Vencimiento debe ser MAYOR a la fecha de Compra");
				document.form1.fecha_vence.focus();
				return false
			}
		}
		document.form1.oc.value="OK";
		//document.form1.action="compras.php";
		document.form1.submit();  
	
	}
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("../clases/auto/comboauto2.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	
	} // lookup
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
		
	}
		
	function c_reg(form1) {  
		if( vacio(document.form1.cant.value) == false ) {  
                alert("Es necesario digitar la cantidad a comprar");
				document.form1.cant.focus();
                return false  
        }
		if( document.form1.vr.value == 0){
				alert("Es necesario digitar el valor de compra del articulo");
				document.form1.vr.focus();
                return false  
		}
		document.form1.re.value="OK";
		document.form1.action="compras.php";
		document.form1.submit();    
	}
	function factura(form1) {  
		document.form1.fac.value="OK";
		document.form1.action="compras.php";
		document.form1.submit();    
	}

	function buscar(form1) { 
		if(document.form1.can.value=="Seleccione" )
		{
			document.form1.ver2.value="OK";
		}else{
			document.form1.action="compras.php?val=1";
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
<meta>
<title>Compras</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu
	$act_men_compras = $_SESSION['men_compras'];
	@menu_gestion($act_men_compras,$act_men_compras,$nueva_compra);
	?>    
	<? //tabla 3, Tabla Informacion
	//Validacion aparecer TABLA 3
	$datos_compra = $cod_envia;
	if($datos_compra>0){
	 //Consultas	
	// 1. Cantidad de Compras
	$cant="select distinct num_factura from compras";
	$cant2=@mysql_query($cant,$conexion);
	$no_fac=mysql_num_rows($cant2); 
	
	// 2. Suma total de Compras
	$sum="select sum(vr_total) as total from compras";
	$sum2=@mysql_query($sum,$conexion);
	$sum3=@mysql_fetch_object($sum2); 
	$tot_compra = $sum3->total;
	$tot_compra = number_format($tot_compra, 0, ",", ".");
	
	// 3. Ultimas Compras realizadas
	$ult="select * from compras where fecha_compra between '$fecha_ant' and '$fecha' limit 0, 5";
	$ult2=@mysql_query($ult,$conexion);
	$u_art=mysql_num_rows($ult2); 
	$ult_pro = $u_art;
	
	// 4. La ultima compra realizada
	$ulta="select max(fecha_compra) as total from compras";
	$ulta2=@mysql_query($ulta,$conexion);
	$ulta3=@mysql_fetch_object($ulta2); 
	$ult_com = $ulta3->total;
	
	// 5. Compras pendientes
	$pen="select * from compra_temporal";
	$pen2=@mysql_query($pen,$conexion);
	$pen3=mysql_num_rows($pen2); 
	$com_pen = $pen3;
	?>
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  	<tr>
    <td width="400" valign="top">
	<? //tabla 3.1, Tabla Datos Compra?>
	<table width="0" border="1">
      <tr>
        <td colspan="2"><div align="center"><span class="Estilo6">DATOS COMPRAS </span></div></td>
        </tr>
      <tr>
        <td width="150"><span class="Estilo6">No. de Compras</span></td>
        <td width="150"><? echo $no_fac;?></td>
      </tr>
      <tr>
        <td><span class="Estilo6">Valor Total de Compras </span></td>
        <td><span class="Estilo12">$ <? echo $tot_compra;?></span></td>
      </tr>
    </table>
	</td>
    <td width="400" valign="top">
	<? //tabla 3.2, Tabla Ultimas Compras?>
	<table width="500" border="1">
      <tr>
        <td width="500"><div align="center"><span class="Estilo6">ULTIMAS COMPRAS REGISTRADAS </span></div></td>
      </tr>
      <tr>
        <td>
		<? //tabla 3.2.1, Listado de compras?>
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<? 
		if($ult_pro > 0	){
		?>
		<tr>
		<td width="27"><div align="center"><span class="Estilo6">No</span></div></td>
    	<td width="70"><div align="center"><span class="Estilo6">No. Factura</span></div></td>
    	<td width="112"><div align="center"><span class="Estilo6">Proveedor</span></div></td>
    	<td width="61"><div align="center"><span class="Estilo6">Total Fac</span></div></td>
    	<td width="100"><div align="center"><span class="Estilo6">Fecha Fac</span></div></td>
  		</tr>
		<?
			$i=1;
			$cant="select distinct num_factura from compras ORDER BY fecha_compra DESC limit 0, 5";
			$cant2=@mysql_query($cant,$conexion);
			while ($cant3=@mysql_fetch_object($cant2)){
	  		 $no_fac = $cant3->num_factura;
			
			 $fac="select * from compras where num_factura = $no_fac ";
			 $fac2=@mysql_query($fac,$conexion);
			 $fac3=@mysql_fetch_object($fac2); 
			 $fe_com = $fac3->fecha_compra;
			 $id_pro = $fac3->cod_pro;
			
			 $pro="select * from proveedor where cod_pro = $id_pro ";
			 $pro2=@mysql_query($pro,$conexion);
			 $pro3=@mysql_fetch_object($pro2); 
			
			 $suma="select sum(vr_total) as total from compras where num_factura = $no_fac";
			 $suma2=@mysql_query($suma,$conexion);
			 $suma3=@mysql_fetch_object($suma2); 
			 
			 $tot_fac = $suma3->total;
			 $tot_fac = number_format($tot_fac, 0, ",", ".");
			 $pro = $pro3->name_pro;
			 $nom_pro = strtolower($pro); 		//Pasar todo a minusculas
			 $nom_pro = ucwords($nom_pro);		//Pasar a mayuscula la primera letra de cada cadena	
			
		?>
  		<tr class="celda" onClick="window.location='compras2.php?id_com=<? echo $no_fac;?>&fec=<? echo $fe_com;?>&id_pro=<? echo $id_pro;?>'">
    	<td><div align="center"><span class="Estilo7"><? echo $i;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $no_fac;?></span></div></td>
    	<td><div align="left"><span class="Estilo7"><? echo $nom_pro;?></span></div></td>
    	<td><div align="right"><span class="Estilo7"><? echo $tot_fac;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $fe_com;?></span></div></td>
  		</tr>
		<? 
			$i++;
			}
		}else{
		?>
  		<tr>
    	<td colspan="5">
		<div align="center"><span class="Estilo7">No se registran compras desde <? echo $ult_com;?></span></div>
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
		<td width="500"><div align="center"><span class="Estilo6">COMPRAS PENDIENTES POR COMPLETAR</span></div></td>
      </tr>
      <tr>
        <td>
		<? //tabla 3.3.1, Listado de compras PENDIENTES?>
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<? 
		if ($com_pen>0){
		?>
		<tr>
		<td width="27" ><div align="center"><span class="Estilo6">No</span></div></td>
    	<td width="70" ><div align="center"><span class="Estilo6">No. Factura</span></div></td>
    	<td width="112"><div align="center"><span class="Estilo6">Proveedor</span></div></td>
    	<td width="61" ><div align="center"><span class="Estilo6">Total Fac</span></div></td>
    	<td width="100"><div align="center"><span class="Estilo6">Fecha Fac</span></div></td>
  		</tr>
		<?
			$i=1;
			$cant="select distinct num_factura from compra_temporal ORDER BY fecha_compra DESC limit 0, 5";
			$cant2=@mysql_query($cant,$conexion);
			while ($cant3=@mysql_fetch_object($cant2)){
			 $no_fac = $cant3->num_factura;
			 
			 $fac="select * from compra_temporal where num_factura = $no_fac";
			 $fac2=@mysql_query($fac,$conexion);
			 $fac3=@mysql_fetch_object($fac2); 
			 $fe_com = $fac3->fecha_compra;
			 $id_pro = $fac3->cod_pro;
			 
 			 $pro="select * from proveedor where cod_pro = $id_pro ";
			 $pro2=@mysql_query($pro,$conexion);
			 $pro3=@mysql_fetch_object($pro2); 

			 $suma="select sum(vr_total) as total from compra_temporal where num_factura = $no_fac";
			 $suma2=@mysql_query($suma,$conexion);
			 $suma3=@mysql_fetch_object($suma2); 
			 
			 $tot_fac = $suma3->total;
			 $tot_fac = number_format($tot_fac, 0, ",", ".");
			 
			 $pro = $pro3->name_pro;
			 $nom_pro = strtolower($pro); 		//Pasar todo a minusculas
			 $nom_pro = ucwords($nom_pro);		//Pasar a mayuscula la primera letra de cada cadena	
		?>
  		<tr class="celda" onClick="window.location='compras2.php?id_pen=<? echo $no_fac; ?>&fec=<? echo $fe_com;?>&id_pro=<? echo $id_pro;?>'">
		<td><div align="center"><span class="Estilo7"><? echo $i;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $no_fac;?></span></div></td>
    	<td><div align="left"><span class="Estilo7"><? echo $nom_pro;?></span></div></td>
    	<td><div align="right"><span class="Estilo7"><? echo $tot_fac;?></span></div></td>
    	<td><div align="center"><span class="Estilo7"><? echo $fe_com;?></span></div></td>
  		</tr>
		<?
			 $i++;
			} 
		}else{
		?>
  		<tr>
    	<td colspan="5">
		<div align="center"><span class="Estilo7">No existen compras pendientes</span></div>
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
        <td width="205"><span class="Estilo8">Filtrar por Proveedor </span></td>
        <td width="595">
		<select name="can" id="can" onChange="document.form1.can.selectedindex=0;
        									  document.form1.action='compras.php?val=1';
                                              document.form1.submit();">
          <option> Seleccione</option>
          <? 
		  $depto="select * from proveedor order by name_pro";
		  $depto2=@mysql_query($depto,$conexion);
		  while($campo = mysql_fetch_object($depto2)){
		   $name_pro = strtolower($campo->name_pro); 		//Pasar todo a minusculas
		   $name_pro = ucwords($name_pro);		//Pasar a mayuscula la primera letra de cada cadena	
		  echo'<option value="'.$campo->cod_pro.'">'.$name_pro.'</option>';
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
        <td width="30"><div align="center"><span class="Estilo6">No</span></div></td>
        <td width="85"><div align="center"><span class="Estilo6">No. FACTURA</span></div></td>
        <td width="105"><div align="center"><span class="Estilo6">FECHA COMPRA</span></div></td>
        <td width="135"><div align="center"><span class="Estilo6">FECHA VENCIMIENTO</span></div></td>
        <td width="323"><div align="center"><span class="Estilo6">PROVEEDOR</span></div></td>
        <td width="82"><div align="center"><span class="Estilo6">TOTAL FAC</span></div></td>
      </tr>
	  <?
	  
	  $cant="select distinct num_factura from compras ORDER BY fecha_compra DESC limit ".$limitInf.",".$tamPag;
      $alm2=@mysql_query($cant,$conexion);
 	  $cuan2=@mysql_num_rows($alm2); 

	  if($val_dep>0){
		$cant=" select distinct num_factura from compras 
				where cod_pro='$cod_pro' 
				ORDER BY fecha_compra DESC 
				limit ".$limitInf.",".$tamPag;
        $alm2=@mysql_query($cant,$conexion);
	  }
	  
	  if($buscador>0)
	  {
		$cant=" select distinct num_factura from compras 
				where num_factura LIKE '%$buscar%' 
				ORDER BY fecha_compra DESC 
				limit ".$limitInf.",".$tamPag;
        $alm2=@mysql_query($cant,$conexion);
		$val_dep=0;
	  }
	 
	  while($dep3 = mysql_fetch_object($alm2)){
	  	$no_fac = $dep3->num_factura;
			
		$fac="select * from compras where num_factura = $no_fac ";
		$fac2=@mysql_query($fac,$conexion);
		$fac3=@mysql_fetch_object($fac2);
		$cod_pro = $fac3->cod_pro; 
		
		$pro="select * from proveedor where cod_pro = $cod_pro ";
		$pro2=@mysql_query($pro,$conexion);
		$pro3=@mysql_fetch_object($pro2);		
		
	  	$fe_com = $fac3->fecha_compra;
	  	$fe_ven = $fac3->fecha_ven;
		if($fe_ven == "0000-00-00"){
			$fe_ven = "Pago de Contado";
		}
	  	$pro 	= $pro3->name_pro;
    	$name_pro = strtolower($pro3->name_pro); 		
		$name_pro = ucwords($name_pro);		
		
		$suma="select sum(vr_total) as total from compras where num_factura = $no_fac";
		$suma2=@mysql_query($suma,$conexion);
		$suma3=@mysql_fetch_object($suma2); 

	  	$to_fac = $suma3->total;
	  	$to_fac = number_format($to_fac, 0, ",", ".");
	 
	  ?>
      <tr class="celda" onClick="window.location='compras2.php?id_com=<? echo $no_fac;?>&fec=<? echo $fe_com;?>&id_pro=<? echo $cod_pro;?>'">
        <td><div align="center"><span class="Estilo7"> <? echo $x;?>	  </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $no_fac;?> </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $fe_com;?> </span></div></td>
        <td><div align="center"><span class="Estilo7"> <? echo $fe_ven;?> </span></div></td>
        <td><div align="left">	<span class="Estilo7"> <? echo $name_pro;?> </span></div></td>
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
		$pro="select * from proveedor where cod_pro = $cod_pro ";
		$pro2=@mysql_query($pro,$conexion);
		$pro3=@mysql_fetch_object($pro2);		   
    	$name_pro = strtolower($pro3->name_pro); 		
		$name_pro = ucwords($name_pro);		

	   ?>
	   <div align="center">
	   	No se existen facturas para el proveedor <? echo $name_pro;?>
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
	<? //fin tabla para numeros de paginacion?>
	<? 
	// FIN validacion TABLA 3
	}
	?>
	<? //tabla 4, Menu 1
//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------
//++++++++ Crear Nueva Compra++++++++ +++++++++++++++++++++++++++++++++++++++++++
//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------	
	
	if($nueva_compra>0){
//	@datos_factura($list_pro_combo,$conexion);
//	echo "<br>prove";
	//print_r($list_prov	);
	?>
	<table width="800" border="1">
    <tr>
     <td colspan="3"><div align="center"><span class="Estilo6">SELECCIONE LOS DATOS DE LA FACTURA </span></div></td>
    </tr>
    
    <tr>
     <td width="224"><span class="Estilo6">SELECCIONE PROVEEDOR </span></td>
     <td colspan="2">
	 <select name="can" id="can">
     <option> Seleccione</option>
    <? 
	 $pro = "select * from proveedor order by name_pro";
	 $pro2 = mysql_query($pro,$conexion); 
     while($campo = mysql_fetch_object($pro2)){
	 	$nombre_proveedor	=	$campo->name_pro;
		$nombre_proveedor 	= 	strtolower($nombre_proveedor); 		
		$nombre_proveedor 	= 	ucwords($nombre_proveedor);
    ?>
     <option value="<? echo $campo->cod_pro;?>"> <? echo $nombre_proveedor;?> </option>
    <? } ?>
     </select>			 
	 </td>
    </tr>
	<tr>
     <td><span class="Estilo6">No. FACTURA DE COMPRA </span></td>
     <td colspan="2">
	  <label>
      <input name="orden" type="text" id="orden" onkeyUp="return ValNumero(this);">
      </label>
	 </td>
    </tr>
    <tr>
     <td colspan="2">
	 <table>
	 <tr>
		<td><span class="Estilo6">FORMA DE PAGO </span></td>
		<td><span class="Estilo1">Contado<input type='radio' name='ver' value = '1' checked onClick="form1.fecha_vence.disabled = true;" /></span></td>
		<td><span class="Estilo1">Credito<input type='radio' name='ver' value = '2' onClick="form1.fecha_vence.disabled = false;" /></span></td>
	 </tr>
	 <tr>
		<td><span class="Estilo6">FECHA DE COMPRA</span></td>
		<td>
		<input name='fecha_compra' type='text' id='fecha_compra' size='10' readonly onClick='popUpCalendar(this, form1.fecha_compra, "yyyy-mm-dd" );'>
		</td>
		<td><span class="Estilo6">FECHA DE VENCIMIENTO</span></td>
		<td>
		<input name='fecha_vence' type='text' id='fecha_vence' size='10' readonly disabled onClick='popUpCalendar(this, form1.fecha_vence, "yyyy-mm-dd" );'>
		</td>
	 </tr>	
	 </table>	
	 </td>
    </tr>
    <tr>
     <td colspan="3">
	  <div align="center">
	  <input type="button" name="b" id="b" value="Crear Factura" onClick="c_fac()" />
      <input name="oc" type="hidden" id="oc"/>
	  </div>
	 </td>
    </tr>
	<?
	  //}
	?>
    </table>
	<? 
	//Fin Nueva compra
	}
	?>
	<? //echo Tabla 5
//------------------------------------------------------------
//------------------ Hacer Factura ---------------------------
//------------------------------------------------------------	
	if($hacer_fac>0){
		//Consultas
		$cod_pro = $_SESSION['can'];
		$fec_ven = $_SESSION['f_ven'];
		$fec_com = $_SESSION['f_compra'];
		$no_orde = $_SESSION['orden'];
	
	print_r($list_info_prov);
	
	//Tabla Informacion De la empresa
	echo "<br>dato A: ".$txt_contacto;
	echo "<br>dato B: ".$cant_cli;
	echo "<br>dato C: ".$cod_fac_pen_pro = $cod_pro;
	echo "<br>dato D: ".$txt_mov;
	echo "<br>dato E: ".$txt_vendedor;
	echo "<br>dato F: ".$cod_fac_asi;
	echo "<br>dato G: ".$cod_fac_pen = $no_orde;
	echo "<br>dato H: ".$continuar_fac;
	
	@imp_datos_gestion($txt_contacto,$list_info_prov,$cant_cli,$cod_fac_pen_pro,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac);
	
	//Tabla Informacion De la empresa
	@imp_datos_gestion($txt_contacto,$list_info_prov,$cant_cli,$cod_fac_pen_pro,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac,$inicial);
	@buscar_articulo($act_ver_nue_art);	
	?>
	<? 
	 //Tabla Seleccionar Articulo
	?>

	<? 
	}
	//echo Tabla 6
	//Detalle Articulo
	if($cant>0){
		$alm="select * from almacen where cod_item = '$cod_item'";
		$alm2=@mysql_query($alm,$conexion);
		$alm3=@mysql_fetch_object($alm2);
		$detalle = $alm3->des_item;
		$vr	     = $alm3->costo;
	?>	
    <table width="800" border="0">
    <tr>
     <td>
	 <table width="800" border="0">
     <tr>
      <td width="146"><span class="Estilo6">Articulo</span></td>
      <td width="380">
	   <input type="articulo" name="articulo" value="<? echo $detalle; ?>" readonly size="60">
	  </td>
      <td width="260"><span class="Estilo6">Digite el Valor Unitario de Llegada </span></td>
     </tr>
     <tr>
      <td><span class="Estilo6">Cantidad</span></td>
      <td>
	   <input name="cant" type="text" id="cant" onKeyPress="return esInteger(event);">
	  </td>
      <td rowspan="2">
	  <table width="208" border="1" bordercolor="#FF0000">
      <tr>
       <td width="198">
		<div align="center"><span class="Estilo11">$</span>
		<label>
		<input type="vr" name="vr" value="<? echo $vr; ?>"  size="10" onKeyPress="return esInteger(event);"
		style="font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC">
  		</label>
		</div>
	   </td>
      </tr>
      </table>
	  </td>
     </tr>
     <tr>
      <td>&nbsp;</td>
      <td>
	   <input type="button" name="b5" id="b5" value="Registrar Producto" onClick="c_reg(this)" />
       <input name="re" type="hidden" id="re"/>
	  </td>
     </tr>
     </table>
	 </td>
    </tr>
    </table>
	<? }?>
	<? //echo tabla 7
	if($registro>0){
		$detalle	=$_POST['articulo'];
		$cant		=$_POST['cant'];
		$vr_uni		=$_POST['vr'];
		$cod_item = $_SESSION['cod'];
		
		$_SESSION['codigo'] 	= $cod_pro;
		$_SESSION['n_orden']	= $no_orde;
		$_SESSION['fecha_com']	= $fec_com;
			
		$v_total=$vr_uni*$cant;
			
		$int="	
		INSERT INTO  compra_temporal (
			id_tem_c, id_art, cantidad, detalle, vr_costo, vr_total, num_factura, fecha_compra, fecha_ven, cod_pro)
		VALUES (
		NULL, '$cod_item',  '$cant',  '$detalle',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$fec_ven',  '$cod_pro');	
			 ";
		$int2=mysql_query($int,$conexion);
	?>	
	<table width="800" border="0">
    <tr>
     <td>
	 <table width="800" border="1" bordercolor="#000000">
     <tr>
      <td width="76" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CANTIDAD</span></div></td>
      <td width="459" bgcolor="#CCCC00"><div align="center">
      <div align="center"><span class="Estilo6">DETALLE</span></div>
      </div>
	  </td>
      <td width="79" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/UNI</span></div></td>
      <td width="78" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/TOTAL</span></div></td>
      <td width="78" bgcolor="#990000"><div align="center"><span class="Estilo13">ELIMINAR</span></div></td>
     </tr>
	 <?
	 $com="select * from compra_temporal where cod_pro = '$cod_pro' and num_factura = '$no_orde' ";
	 $com2=@mysql_query($com,$conexion);
	 while ($com3=@mysql_fetch_object($com2)){
	 ?>
     <tr>
      <td><? echo $com3->cantidad;?></td>
      <td><? echo $com3->detalle;?></td>
      <td><? echo $com3->vr_costo;?></td>
      <td><? echo $com3->vr_total;?></td>
      <td>
	   <div align="center">
	   <a href="borrar_admin.php?id_fac=<? echo $com3->id_tem_c;?>">
	   <img src="../imagenes/logo_eliminar" width="24" height="25" border="0">
	   </a>
	   </div>
	  </td>
     </tr>
	 <? }
	 $sum = "select sum(vr_total) total from compra_temporal where cod_pro = '$cod_pro' and num_factura = '$no_orde'";
	 $sum2 = @mysql_query($sum,$conexion); 
	 $sum3 = @mysql_fetch_object($sum2);	
     ?>
     <tr>
      <td colspan="3" bgcolor="#CCCC00">
  	   <div align="right"><span class="Estilo6">TOTAL FACTURA No. <? echo $no_orde;?>  </span></div>
	  </td>
      <td colspan="2" bgcolor="#CCCC00"><span class="Estilo11"><? echo $sum3->total;?></span></td>
     </tr>
     <tr>
      <td colspan="5">
	   <div align="center">
	   <input type="button" name="b6" id="b6" value="Finalizar Factura" onClick="factura(this)" />
       <input name="fac" type="hidden" id="fac"/>
	   </div>
	  </td>
     </tr>
     </table>
	 </td>
    </tr>
    </table>
	<? 
	}
	//echo tabla 8?>	 
	 </td>
  </tr>
</table>
</form>
</body>
</html>
<?
if($reg_fac>0)
{
	$cod_pro = $_SESSION['codigo'];
	$no_orde = $_SESSION['n_orden']; 
	$fec_com = $_SESSION['fecha_com'];
	$lle="select * from compra_temporal where cod_pro = '$cod_pro' and num_factura = '$no_orde' and fecha_compra = '$fec_com'";
	$lle2=@mysql_query($lle,$conexion);
	while ($campos=@mysql_fetch_object($lle2)){
		
		$cod_item 	= $campos ->id_art; 
		$cant 		= $campos ->cantidad;
		$detalle 	= $campos ->detalle;
		$vr_uni 	= $campos ->vr_costo;
		$v_total 	= $campos ->vr_total;
		$no_orde 	= $campos ->num_factura;
		$fec_com 	= $campos ->fecha_compra;
		$fec_ven 	= $campos ->fecha_ven;
		$cod_pro 	= $campos ->cod_pro;       
	
		$int="	
			INSERT INTO  compras (
				id_compra, id_art, cantidad, detalle, vr_costo, vr_total, num_factura, fecha_compra, fecha_ven, cod_pro)
			VALUES (
			NULL, '$cod_item',  '$cant',  '$detalle',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$fec_ven',  '$cod_pro');	
				 ";
			 
		$int2=mysql_query($int,$conexion);
		
		$com="
		INSERT INTO  ar_entrada (
			id_ent, id_art, cantidad, vr_costo, vr_total, num_factura, fecha_compra, cod_pro)
		VALUES (
		NULL,  '$cod_item',  '$cant',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$cod_pro');
		";
		$com2=mysql_query($com,$conexion);
		
		$alm="select * from almacen where cod_item = '$cod_item'";
		$alm2=@mysql_query($alm,$conexion);
		$alm3=@mysql_fetch_object($alm2);
		
		$c_alm = $alm3->cant_stock;
		
		$stock = $c_alm + $cant;

		$sql5 = "update almacen set cant_stock =  '$stock' WHERE  cod_item ='$cod_item';";
		$consulta=mysql_query($sql5,$conexion);
		
		$sql="delete from compra_temporal where id_art='$cod_item' 		and 
												num_factura='$no_orde' 	and 
												fecha_compra='$fec_com' and 
												cod_pro='$cod_pro'	";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La factura se creo exitosamente')
		 location.href='compras.php?val=1';
		</SCRIPT>";
	}
}
