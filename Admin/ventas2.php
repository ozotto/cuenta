<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/eliminar.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
?>	
<html>
<head>
<meta>
<title>Ventas</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script src="../clases/fun_java/java.js" type="text/javascript"></script>
<script type="text/javascript" src="../clases/auto/jquery-1.2.1.pack.js"></script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu
	$act_men_ventas 	= $_SESSION['men_ventas'];
	@menu_gestion($act_men_ventas,$act_men_ventas2,$nom_boton_lis,$cod_fac_pen,$fec_fac_asi);
	
	//Tabla Informacion De la empresa
	@imp_datos_gestion($txt_contacto,$list_info_empr,$cant_cli,$cod_empresa,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac);

//++++++++++++++++++++++++++++++++++++++++++++++	
	//Factura de Venta
//++++++++++++++++++++++++++++++++++++++++++++++	
	if($cod_fac_asi>0){
		//Encabezado factura
		echo $cabecera_factura_ventas;
		//Detalle Factura
		for($cont_prov=1; $cont_prov<=$cant_art_fac_ven; $cont_prov++){
			@listar_gestion($cont_prov, $pos1, $pos2,$list_fac_ven,$pos_lista,$pagina_actual,$limitInf,$cod_fac_asi);
			$pos1++;
			$pos2++;
			$pos_lista++;
		}
		tabla_sum_parcial($pagina,$sum_par_factura);
		fin_tabla_factura($cod_fac_asi,$suma_tot_fac_venta);
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ar_sal_total,$cod_fac_asi,$fec_fac_asi);
	}
//++++++++++++++++++++++++++++++++++++++++++++++	
	//Factura de Venta Pendiente
//++++++++++++++++++++++++++++++++++++++++++++++	
	if($mos_fact>0 and $continuar_fac<>1){
		//Encabezado factura
		echo $cabecera_factura_ventas;
		//Detalle Factura
		for($cont_prov=1; $cont_prov<=$cant_art_fac_ven_tem; $cont_prov++){
			@listar_gestion($cont_prov, $pos1, $pos2,$list_fac_ven_tem,$pos_lista,$pagina_actual,$limitInf,$cod_fac_pen);
			$pos1++;
			$pos2++;
			$pos_lista++;
		}
		tabla_sum_parcial($pagina,$sum_par_factura_tem);
		fin_tabla_factura($cod_fac_pen,$suma_tot_fac_venta_tem);
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ar_sal_total_tem,$cod_fac_asi,$fec_fac_asi,$cod_fac_pen);
	}
//++++++++++++++++++++++++++++++++++++++++++++++	
	//Continuar Factura
//++++++++++++++++++++++++++++++++++++++++++++++
	if($continuar_fac > 0) 
	{
		@buscar_articulo();
		//Consultar si se registra existencias del articulo en stock
		if ($verificar_exi>0 and $codigo_art>0){
			$cantidad_stock = $con -> verificar_existencia_art($codigo_art, $conexion);
			if($cantidad_stock<=0){
				$mostrar_regis = -1;
				@mensaje_sin_articulos($detalle_art);
			}else{
				$mostrar_regis = $cantidad_stock;
			}			
		}
		//Captura la cantidad de articulos seleccionados
		$cant_art	=	$_POST['ar_can'];
		if(isset($cant_art)){
			$mostrar_regis = 1;
		}
		if($mostrar_regis>0){
			//Limpio la variable cuando esta el valor = "seleccione"
			if($limpiar_var == 1){
				unset($cant_art);
			}
			//Muestra el articulo seleccionado
			if (empty($cant_art)) {
				@articulo_seleccionada($detalle_art,$codigo_art,$conexion);
			}
			if (isset($cant_art)) {
				//Capturo Datos del articulo
				$vr_uni		=	$_POST['vr'];
				$detalle2	=	$_POST['articulo'];
				$codigo2 	= 	$_SESSION['codigo_art'];
				//Inserto Datos de Articulo
				$mos_art_res = $con -> insertar_tb_temporal($codigo2, $cant_art, $detalle2, $vr_uni, $cod_fac_pen, $fec_fac_asi, $conexion);				
			}
		}	
		if($mos_art_res>0){
			echo("<script language=javascript> 
				document.form1.continua_fac.value='OK';
				document.form1.va_insertado.value='OK';
				document.form1.submit(); 
			</script>");
		} 
		if($mostrar_fac_ped>0){
			//Encabezado factura
			echo $cabecera_factura_ventas;
			//Detalle Factura
			for($cont_prov=1; $cont_prov<=$cant_art_fac_ven_tem; $cont_prov++){
				@listar_gestion($cont_prov, $pos1, $pos2,$list_fac_ven_tem,$pos_lista,$pagina_actual,$limitInf,$cod_fac_pen);
				$pos1++;
				$pos2++;
				$pos_lista++;
			}
			@tabla_sum_parcial($pagina,$sum_par_factura_tem);
			@fin_tabla_factura($cod_fac_pen,$suma_tot_fac_venta_tem);
			//Tabla Paginacion
			@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ar_sal_total_tem,$cod_fac_asi,$fec_fac_asi,$cod_fac_pen);
		}
	}		
//++++++++++++++++++++++++++++++++++++++++++++++	
	//Eliminar Factura Ventas
//++++++++++++++++++++++++++++++++++++++++++++++
	if($elm_factura_com > 0){
		//Menu Eliminar
		@menu_eliminar($elm_factura_com);
		//Encabezado factura
		echo $cabecera_factura_ventas;
		//Detalle Factura
		for($cont_prov=1; $cont_prov<=$cant_art_fac_ven_tem; $cont_prov++){
			@listar_gestion($cont_prov, $pos1, $pos2,$list_fac_ven_tem,$pos_lista,$pagina_actual,$limitInf,$cod_fac_pen,$elm_factura_com);
			$pos1++;
			$pos2++;
			$pos_lista++;
		}
		@tabla_sum_parcial($pagina,$sum_par_factura_tem);
		@fin_tabla_factura($cod_fac_pen,$suma_tot_fac_venta_tem);
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ar_sal_total_tem,$cod_fac_asi,$fec_fac_asi,$cod_fac_pen);
	}	
	?>
    </td>
  </tr>
</table>
</form>
</body>
</html>
