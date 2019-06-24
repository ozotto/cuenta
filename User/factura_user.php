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
	//Inicio HTML
	@inicio_html($pagina_actual);
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clases JAVA
	echo $clase_java;
	echo $clase_java_calendario;
	echo $clase_java_completar;
	
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina($act_men_fac_user);
	
	//Encabezado_empresa;
	echo $encabezado_empresa;
	
	//Menu para Factura Ventas
	@menu_gestion($act_men_fac_user);
	$no_empleado	=	$_SESSION['no_emple'];
	//Tabla Informacion De la empresa
	@imp_datos_gestion($txt_contacto,$list_info_empr,$cant_cli,$cod_empresa,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac);
	
//++++++++++++++++++++++++++++++++++++++++++++++	
	//Factura de Venta
//++++++++++++++++++++++++++++++++++++++++++++++	
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
			$mos_art_res = $con -> insertar_tb_temporal($codigo2, $cant_art, $detalle2, $vr_uni, $cod_fac_pen, $fec_fac_asi, $conexion, $ins_default, $cliente_defecto, $no_empleado);					
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
//--------------------------------------------	
	//FIN DEL DISEéO
	@fin_dise_pagina();	
?>
