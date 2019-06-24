<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");
	require_once 'Image/Barcode.php';

	$con = new control;
	$con->conectar(); 
	$con->seg_usu();
	$conexion = $con->conectar();
	
	$cod_pro = $_GET['id_pro'];
	
	Image_Barcode::draw($_GET[NUM], $_GET[TYP], $_GET[IMG]);
	
	
	$sql5="select * from almacen where cod_item = '$cod_pro'";
	$sq=@mysql_query($sql5,$conexion);
	$pro=@mysql_fetch_object($sq);
	$dpto = $pro->cod_depto;
	$total_alma = $pro->cant_stock;
	
	$dep="select * from departamento where cod_depto = '$dpto'";
	$dep2=@mysql_query($dep,$conexion);
	$dep3=@mysql_fetch_object($dep2);
	
	$consulta="select * from ar_entrada where id_art ='$cod_pro' and cod_pro ='$inv_ini'";
	$resultado=mysql_query($consulta) or die (mysql_error());
	if (mysql_num_rows($resultado)>0)
	{
	}else {
	
		$con="select * from inicial where cod_item = '$cod_pro'";
		$con2=@mysql_query($con,$conexion);
		$con3=@mysql_fetch_object($con2);
		
		$id_art		= $con3->cod_item;		 
		$cant		= $con3->cant_stock;
		$vr_uni		= $con3->costo;
		$v_total	= $vr_uni * $cant;
		$fec		= $con3->fec_ini;
		$inv_ini;
		
		$con="select * from ar_entrada where id_art ='$id_art' and cod_pro ='$inv_ini' and fecha_compra = '$fec' and num_factura='$n_fac'";
		$resultado=mysql_query($con) or die (mysql_error());
		if (mysql_num_rows($resultado)>0)
		{
		}else {
		
		$com="
		INSERT INTO  ar_entrada (
			id_ent, id_art, cantidad, vr_costo, vr_total, num_factura, fecha_compra, cod_pro)
		VALUES (
		NULL,  '$id_art',  '$cant',  '$vr_uni',  '$v_total',  '$n_fac',  '$fec',  '$inv_ini');
		";
		$com2=mysql_query($com,$conexion);
		}
	}
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
?>
<html>
<head>
<meta>
<title>Articulo</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script language="javascript">
	function valida(form1) { 
		document.form1.op.value="OK";
		document.form1.submit();  
	}
	/*function modificar_articulo()
	{
		//document.form1.modificar_articulo.value="OK";
		//document.form1.action="articulo.php";
		document.form1.submit();
	}*/
</script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu Articulo
	$act_menu_articulo = $_SESSION['act_menu_articulo'];
	//$act_menu_articulo = 4;
	@menu_gestion($act_menu_articulo);
	?>    
	<? //echo "tabla 2";
		$costo		=	$pro->costo;
		$precio		=	$pro->precio;
		$ganancia 	=	$precio - $costo;
		$porcen		= 	(($ganancia*100)/$costo);
	?>
	<table width="800" align="center" border="1" bordercolor="#000000">
          <tr>
            <td>
			<table width="800" border="0">
              <tr>
                <td class="Estilo8">Articulo</td>
                <td colspan="4"><? echo $pro->des_item;?></td>
                </tr>
              <tr>
                <td width="95"><span class="Estilo8">Departamento</span></td>
                <td width="165"><? echo $dep3->nom_depto;?></td>
                <td width="131">&nbsp;</td>
                <td width="100"><span class="Estilo8">Codigo</span></td>
                <td width="165"><? echo $pro->cod_item;?></td>
              </tr>
              <tr>
                <td class="Estilo7"><span class="Estilo8">Cantidad en Almacen </span></td>
                <td class="Estilo12"><? echo $total_alma;?></td>
                <td>&nbsp;</td>
                <td><span class="Estilo8">Codigo de Barras </span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="23"><span class="Estilo8">Costo de Llegada </span></td>
                <td>$ <? echo $pro->costo = number_format($pro->costo, 0, ",", ".");?></td>
                <td>&nbsp;</td>
                <td colspan="2" rowspan="2">
				<p align="center">
                <img src="articulo.php?NUM=<? echo $cod_pro;?>&TYP=<? echo $type_barcode;?>&IMG=<? echo $type_image;?>"/>		        
				</p>				
				</td>
                </tr>
              <tr>
                <td><span class="Estilo8">Valor de Venta </span></td>
                <td class="Estilo12">$ <? echo $pro->precio = number_format($pro->precio, 0, ",", ".");?></td>
                <td>&nbsp;</td>
                </tr>
            </table>
			</td>
          </tr>
        </table>	    
	 <table align="center" border="1" bordercolor="#000000">
        <tr>
          <td width="800">
		    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="88">
				<div align="center">
				<?
				//Guardo en Sesion valores del codifgo a modificar
				$cod_art = $pro->cod_item;
				$_SESSION['cod_art_mod'] = $cod_art;
				
				$des_item	=	$pro->des_item;
				$nom_dept	=	$dep3->nom_depto;
				$barcode	=	$pro->cod_barras;
				$cantidad	=	$total_alma;
				$cod_art	= 	$pro->cod_item;
				$ini		= 	1;
				
				//Lleno Array Con los datos del articulo a modificar
				$list_mod_art[] = array($ini => array(	0 => "$des_item",
														1 => "$nom_dept",
														2 => "$barcode",
														3 => "$cantidad",
														4 => "$costo",
														5 => "$precio",
														6 => "$porcen",
														7 => "$cod_art",
														));
				$_SESSION['valores_array'] = $list_mod_art;
				
				?>
				<a onclick="modificar_articulo()">
				  <img src="../imagenes/logo_modificar.jpg" width="24" height="25" border="0"></a>
				</div>
				<input name='mod_articulo' type='hidden' id='mod_articulo' />	
				</td>
                <td width="415">&nbsp;</td>
                <td width="148">&nbsp;</td>
                <td width="149">&nbsp;</td>
              </tr>
            </table>		  
		  </td>
        </tr>
      </table>	
	  <? //echo "tabla 3";?>  
	<table width="800" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="57">&nbsp;</td>
        <td width="95">ENTRADAS</td>
        <td width="42"><input name="opc" type="radio" value="1" onClick="valida(this)"></td>
        <td width="80">SALIDAS</td>
        <td width="526"><input name="opc" type="radio" value="2" onClick="valida(this)"> <input name="op" type="hidden" id="op" />
		</td>
      </tr>
    </table>	
	<? //echo "tabla 4";
	if($_POST['op'] == "OK")
	{
	  	if($_POST['opc'] == "1")
		{
			$titulo = "ENTRADAS";
			$envio 	= "Proveedor";
			$valor	= "Costo";
		}
		if($_POST['opc'] == "2")
		{
			$titulo = "SALIDAS";
			$envio 	= "Cliente";
			$valor	= "Vr/Venta";
		}
	?> 
	<table width="800" align="center" border="1" bordercolor="#000000">
     <tr>
      <td>
	    <table width="800" border="1">
          <tr bgcolor="#CCCCCC" bordercolor="#000000">
            <td class="Estilo8"> <? echo $titulo;?> </td>
          </tr>
        </table>
		<table width="800"  border="1" bordercolor="#000000">
          <tr>
            <td bgcolor="#CCCCCC" class="Estilo8">Fecha</td>
            <td bgcolor="#CCCCCC" class="Estilo8"><? echo $envio;?></td>
            <td bgcolor="#CCCCCC" class="Estilo8">No. Factura</td>
            <td bgcolor="#CCCCCC" class="Estilo8">Cantidad</td>
            <td bgcolor="#CCCCCC" class="Estilo8"><? echo $valor;?></td>
          </tr>
		  <tr>
		  <?
		  if($_POST['opc'] == "1") //Entradas
		  {
			 $ent="select * from ar_entrada where id_art = '$cod_pro' order by fecha_compra";
			 $ent2=@mysql_query($ent,$conexion);
			 $tabla = "proveedor";
		  }
		  if($_POST['opc'] == "2") //Salidas
		  {
  			 $ent="select * from ar_salida where id_art = '$cod_pro' order by fecha_venta";
			 $ent2=@mysql_query($ent,$conexion);
			 $tabla = "clientes";
		  }
			
		  while ($ent3=@mysql_fetch_object($ent2)){
			  if($_POST['opc'] == "1")
			  {
			  	$campo = "cod_pro";
			  	$ref = $ent3->cod_pro;
			  }
			  if($_POST['opc'] == "2")
			  {
			  	$campo = "cod_cli";
			  	$ref = $ent3->cod_cli;
			  }
			  $pro="select * from $tabla where $campo = '$ref'";
			  $pro2=@mysql_query($pro,$conexion);
			  $pro3=@mysql_fetch_object($pro2);
			 
			  if($_POST['opc'] == "1")
			  {
			  	$fec	= $ent3->fecha_compra;
				$n_ref	= $pro3->name_pro;
				$vr		= $ent3->vr_costo;
			  }
			  if($_POST['opc'] == "2")
			  {
			  	$fec	= $ent3->fecha_venta;
				$n_ref	= $pro3->name_cli;
				$vr		= $ent3->vr_venta;
			  }
			  $n_fac	= $ent3->num_factura;
			  $can		= $ent3->cantidad;
			  
		  if($_POST['opc'] == "1")
		  { 
		  ?>
          <tr class="celda" 
		  onClick="window.location='proveedor2.php?id_pro=<? echo $ref;?>&fac=<? echo $n_fac; ?>&pro=<? echo $cod_pro; ?>'">
		  <? 
		  }
		  if($_POST['opc'] == "2")
		  { 
		  ?>
		  <tr>
		  <? 
		  }
		  ?>
            <td><? echo $fec; ?></td>
            <td><? echo $n_ref; ?></td>
            <td><? echo $n_fac; ?></td>
            <td><? echo $can; ?></td>
            <td><? echo $vr; ?></td>
          </tr>
		  <?
    	  	}
		  ?>
        </table>	 
	  </td>
	 </tr>
	</table>  
	<? //echo "tabla 5";
	}
	?> 
	</td>
  </tr>		
</table>	
</form>
</body>
</html>
