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
	
	//Inicio HTML
	@inicio_html($pagina_actual);
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clases JAVA
	echo $clase_java;
	echo $clase_java_calendario;
	echo $clase_java_completar;
	
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina();
	
	//Encabezado_empresa;
	echo $encabezado_empresa;

	$nueva_compra		=	1;
	$no_mostrar			=	$vacio;

	
	//Mostrar cuadro para hacer la factura nueva
	$act_cuadro_nuevo	=	$_SESSION['act_cuadro_nuevo'];
	
	//Activar nueva compra
	$act_nueva_compra	=	$_SESSION['act_nueva_compra'];
	$hacer_fac			= 	$act_nueva_compra;
	
	//Menu
	$act_men_compras = $_SESSION['men_compras'];
	@menu_gestion($act_men_compras,$no_mostrar,$nueva_compra);

//++++++++++++++++++++++++++++++++++++++++++++++	
	//Datos Factura de Compra
//++++++++++++++++++++++++++++++++++++++++++++++	
	if ($act_cuadro_nuevo>0){
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
		<td><span class="Estilo1">Contado<input type='radio' name='ver' value = '1' checked onclick="form1.fecha_vence.disabled = true;" /></span></td>
		<td><span class="Estilo1">Credito<input type='radio' name='ver' value = '2' onclick="form1.fecha_vence.disabled = false;" /></span></td>
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
	  <input type="button" name="b" id="b" value="Crear Factura" onClick="crea_fac_info()" />
      <input name="oc" type="hidden" id="oc"/>
	  </div>
	 </td>
    </tr>
   </table>
   	<?
	}
//++++++++++++++++++++++++++++++++++++++++++++++	
	//Hacer Factura de Compra
//++++++++++++++++++++++++++++++++++++++++++++++
	if($hacer_fac>0){
		
		//Tabla Informacion De la empresa a quien se compra
		@imp_datos_gestion($txt_contacto,$list_info_prov,$cant_cli,$cod_fac_pen_pro,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac,$inicial);

		//Buscar Articulo
		@buscar_articulo($act_ver_nue_art);
		//Consultar si se registra existencias del articulo en stock
		$verificar_exi;
		if ($verificar_exi>0 and $codigo_art>0){
			$cantidad_stock = $con -> verificar_existencia_art($codigo_art, $conexion);
			if($cantidad_stock<=0){
				$mostrar_regis = 1;
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
				@articulo_seleccionada($detalle_art,$codigo_art,$conexion,$cod_fac_pen_pro);
			}
			if (isset($cant_art)) {
				//Capturo Datos del articulo
				$vr_uni		=	$_POST['vr'];
				$detalle2	=	$_POST['articulo'];
				$codigo2 	= 	$_SESSION['codigo_art'];
				if($vr_uni<=0){
					//Muestro Mensaje Advertencia de poner valor al articulo
					echo("<script language=javascript> 
						alert('Debe seleccionar un valor para el articulo');
					</script>");		
				}else{
					//Inserto Datos de Articulo
					$mos_art_res = $con -> insertar_tb_compra_temporal($codigo2, $cant_art, $detalle2, $vr_uni, $cod_fac_pen, $fec_fac_asi, $fec_ven_fac, $cod_fac_pen_pro, $conexion);				
				}	
			}
		}	
		if($mos_art_res>0){
			echo("<script language=javascript> 
				document.form1.nueva_fact.value='OK';
				document.form1.va_insertado.value='OK';
				document.form1.submit(); 
			</script>");
		}
		
		if($mostrar_fac_nueva>0){
			//Encabezado factura
			echo $cabecera_factura_ventas;
			//Detalle Factura
			for($cont_prov=1; $cont_prov<=$cant_art_fac_compra_tem; $cont_prov++){
				@listar_gestion($cont_prov, $pos1, $pos2,$list_fac_com_tem,$pos_lista,$pagina_actual,$limitInf,$cod_fac_pen);
				$pos1++;
				$pos2++;
				$pos_lista++;
			}
			tabla_sum_parcial($pagina,$sum_par_factura_tem_com);
			fin_tabla_factura($cod_fac_pen,$suma_tot_fac_compra_tem);
			
			$numeroRegistros = $cant_ar_compra_total_tem;
			$numPags=ceil($numeroRegistros/$tamPag); 
			$final_pag=$numPags;
			
			@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ar_compra_total_tem,$cod_fac_asi,$fec_fac_asi,$cod_fac_pen,$cod_fac_pen_pro);
		}
	}
	?>
	 </td>
  </tr>
</table>
</form>
</body>
</html>

