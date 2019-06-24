<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
				
?>	
<html>
<head>
<meta>
<title>Cliente</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script src="../clases/fun_java/java.js" type="text/javascript"></script>
<script type="text/javascript" src="../clases/auto/jquery-1.2.1.pack.js"></script>	
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onLoad="sf('text');">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Tabla2 Funcion Menu Para Proveedor;	
	$act_men_cliente = $_SESSION['men_cliente'];
	@menu_gestion($act_men_cliente,$act_men_clie2,$nom_boton_lis);
	if($cod_env_ges>0){
		//Tabla Informacion Proveedor
		@imp_datos_gestion($txt_contacto,$list_cli,$cant_cli,$cod_env_ges,$txt_mov,$txt_vendedor,$cod_fac_asi);	    
		//Tabla no existe informacion
		//Llamo a funcion busca valor de numero de registros
		$num_asiento_cont 	= busca_valor_asiento($cant_cli,$list_cli,$cod_env_ges);	
		//Tabla modificacion
		@tabla_modificacion($pagina_actual,$cod_env_ges,$limitInf);
		if($num_asiento_cont<=0){
			@no_registra_datos($ges_titulo,$pagina_actual);
		}else{
			@encabezado_numero_gestion($ges_titulo,$pagina_actual);
			for($conta=1; $conta<=$cant_ven_cli; $conta++){
				@listado_numero_gestion($pos1, $pos2,$list_ven_tot,$pos_lista,$pagina_actual,$limitInf);
				$pos1++;
				$pos2++;
				$pos_lista++;
			}	
			//Tabla Paginacion
			@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_ven_cli_tot,$cod_fac_asi,$fec_fac_asi,$cod_fac_pen,$cod_fac_pen_pro,$can_ven_com);
		}
	}
	//Tabla modificar 
	if($cod_ges_mod>0){
		@formulario_mod_pro($cre_titulo,$txt_contacto,$nom_boton_cre,$list_cli,$cant_cli,$cod_ges_mod);	
	}
	?>
    </td>
  </tr>		
</table>
</form>
</body>
</html>

