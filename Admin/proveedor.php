<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
		
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	//Valor enviado para mostrar formularios
	$cod_envia = $_GET['val'];	
	if($cod_envia==1){
		//Variable para Mostrar Listado de Pro
		$listado=1; 
	}
	if($cod_envia==2){
		//Variable para Mostrar Modificar de Pro
		$creacion=1; 
		$mostrar_listar_cli = 2;
	}
	
?>	
<html>
<head>
<meta>
<title>Proveedor</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script src="../clases/fun_java/java.js" type="text/javascript"></script>
<script type="text/javascript" src="../clases/auto/jquery-1.2.1.pack.js"></script>	
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onLoad="sf('text');">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellPadding=0 cellSpacing=0>
  <tr>
    <td>
    <? 
	//Tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Tabla2 Funcion Menu Para Proveedor;	
	$act_men_proveedor = $_SESSION['men_proveedor'];
	@menu_gestion($act_men_proveedor,$nom_boton_nue,$nom_boton_lis,$vacio,$mostrar_listar_cli);
	//Tabla3 listar Proveedores;
	if($listado==1){
		//Buscar proveedor
		echo $buscar_caja_texto;
		//Cabecera tabla proveedores
		echo $cabecera_listado_proveedor;
		//Funcion para listar los proveedores ;
		for($cont_prov=1; $cont_prov<=$cant_prov; $cont_prov++){
		@listar_gestion($cont_prov, $pos1, $pos2,$list_prov,$pos_lista,$pagina_actual,$limitInf,$cod_fac_asi);
	 		$pos1++;
			$pos2++;
			$pos_lista++;
		}
		//Cierro Tabla Listado proveedor;
		echo $fin_tabla_proveedor;
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag,$numPags,$act_ct_buscar,$buscar_palabra,$cant_prov_total);
	}
	//Tabla4 Crear Proveedores;
	if($creacion==1){
		@formulario_mod_pro($cre_titulo,$txt_contacto,$nom_boton_cre,$list_prov,$cant_prov,$cod_ges_mod);		
	}
	?>
    </td>
  </tr>
</table>
</form>
</body>
</html>
