<?php
//-Sesion 
	session_start();
	require_once ('control.php');
	require_once ('datos.php');
	require_once ('consultar.php');
	require_once ('../estilo/estilo.css');
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	//-Datos de Pagina	
	$encabezado="<img src=imagen/encabezado.jpg width=800 height=200 border=0 />";
	$pie="<img src=imagen/pie.jpg width=800 height=100 border=0 />";
	$titulo="Facturacion";
	
	//Inicio Encabezado HTML
	function inicio_html($pagina_actual){
		$pagina_actual 		= 	strtolower($pagina_actual); 		
		$pagina_actual		= 	ucwords($pagina_actual);
		
		$tabla .="
		<html>
		 <head>
		 <title>$pagina_actual</title>
		 </head>
		";
		
		echo $tabla;
	} 
	
	//Llamado clase de ESTILOS
	$clase_estilo = "<link href='../Estilo/estilo.css' rel='stylesheet' type='text/css' media='screen' />";
	
	//Llamado clase JAVA
	$clase_java	  = "<script src='../clases/fun_java/java.js' type='text/javascript'></script>";
	
	//Llamado clase JAVA COMPLETAR
	$clase_java_completar	= "<script type='text/javascript' src='../clases/auto/jquery-1.2.1.pack.js'></script>	";
	
	//Llamado clase JAVA CALENDARIO
	$clase_java_calendario	= "<script language='javascript' src='../clases/calendario/popcalendar.js'></script>";
	
	//Funcion Diseño Tabla TOTAL, PRINCIPAL de la pagina INICIO
	function ini_dise_pagina($focus){
		if($focus > 0){
			$tabla .="
				<body leftMargin='0' topMargin='0' marginheight='0' marginwidth='0' onLoad='sf_focus();'>
			";
		}else{
			$tabla .="
				<body leftMargin='0' topMargin='0' marginheight='0' marginwidth='0'>
			";	
		}
		$tabla .="
		<form id='form1' name='form1' method='post' action=''>
		 <table width='800' border='0' align='center' cellpadding='0' cellspacing='0'>
		 <tr>
		 <td>
		";
		echo $tabla;
	}

	//Funcion Diseño Tabla TOTAL, PRINCIPAL de la pagina FIN
	function fin_dise_pagina(){
		$tabla .="
		 </td>
		 </tr>
		</table>
		</form>
		</body>
		</html>
		";
		echo $tabla;
	}
	
	
	//Encabezado de Empresa
	$encabezado_empresa= "
    <table width='800' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='165'>&nbsp;</td>
        <td width='221'>&nbsp;</td>
        <td width='100'>&nbsp;</td>
        <td width='81'>&nbsp;</td>
        <td width='233'>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan='5'><img src=../imagenes/logo_gif.gif width='136' height='98' /></td>
        <td colspan='3'><span class='Estilo2'> $nom_empr </span></td>
        <td><span class='Estilo7'> $mes $dia de $ano </span></td>
      </tr>
      <tr>
        <td colspan='3'><span class='Estilo4'> $nit_empr </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan='3'><span class='Estilo4'> $dir_empr </span></td>
        <td><span class='Estilo7'>Administrador por:</span></td>
      </tr>
      <tr>
        <td colspan='3'><span class='Estilo4'> $tel_empr </span></td>
        <td> $name_empleado </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>      
	";

//Funcion Encabezado Empresa Pequeño
	function encabezado_emp_pe($nom_empr,$di_log_emp){
		$ancho_tabla 	= 800;
		$Borde0			= 0;
		$Borde1			= 1;
		$an_img			= 70;
		$la_img			= 40;
		
		$encabezado_pe = "
		<table width=$ancho_tabla border=$Borde1>
		<tr>
		 <td>
			<table width=$ancho_tabla border=$Borde0>
			<tr>
			<td width=80><img src=$di_log_emp width=$an_img height=$la_img /></td>
			<td width=320><span class='Estilo3'> $nom_empr </span></td>
			<td width=200>&nbsp;</td>
			<td width=200>&nbsp;</td>
			</tr>
			</table>
		 </td>
		</tr>
		</table> ";
		echo $encabezado_pe;
	}

//--Menu para gestion de proveedores y clientes
	function menu_gestion($cod_envia,$nom_boton_nue,$nom_boton_lis,$cod_fac_pen,$fec_fac_asi)
	{
		if($cod_envia==1){
			$boton = "<input type=button value='$nom_boton_nue' onClick='nuevo_gestion();'/>" ;
		}
		if($cod_envia==2){
			$boton = "<input type=button value='$nom_boton_lis' onClick='listar_gestion();'/>" ;
			$oculto = "<input name='no_cont_fac' type='hidden' id='no_cont_fac'/>";
		}
/*		if($cod_fac_pen>2){
			$boton1 = "<input type=button value='Cerrar Factura' onClick='cerrar_factura();'/>" ;
			$oculto1 = "<input name='cerrar_fac' type='hidden' id='cerrar_fac'/>";
			$oculto3 = "<input name='cerrar_fac_compras' type='hidden' id='cerrar_fac_compras'/>";
			$boton2 = "<input type=button value='Continuar Factura' onClick='continuar_factura();'/>" ;
			$oculto2 = "<input name='continua_fac' type='hidden' id='continua_fac'/>";
		}
		if($act_menu>0){ 
			$boton 	= "<input type=button value='$boton1' onClick='$funcion1'/>" ;
			$boton2 = "<input type=button value='$boton2' onClick='$funcion2'/>" ;
			$oculto  = "<input name='$var_oculto1' 	type='hidden' id='$var_oculto1'/>";
			$oculto2 = "<input name='$var_oculto2'	type='hidden' id='$var_oculto2'/>";
		}*/
		if($cod_envia == 3){ //Pagina Inventario
			$nom_boton1 	= "Menu Principal";
			$nom_boton2		= "Nuevo Articulo";
			$var_oculto1	= "menu_admin";
			$var_oculto2	= "menu_inven";
			$var_oculto3	= "men_productos";		
			$var_oculto4	= "guarda_url";		
			$vacio			= 0;
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$boton2 = "<input type=button value='$nom_boton2' onClick='menu_productos(".$vacio.");'/>" ;
			$oculto  = "<input name='$var_oculto1' 	type='hidden' id='$var_oculto1'/>";
			$oculto2 = "<input name='$var_oculto2' 	type='hidden' id='$var_oculto2'/>";
			$oculto3 = "<input name='$var_oculto3' 	type='hidden' id='$var_oculto3'/>";
			$oculto4 = "<input name='$var_oculto4' 	type='hidden' id='$var_oculto4'/>";
		}		
		if($cod_envia==4){ //Pagina Articulo
			$nom_boton1 	= "Menu Principal";
			$nom_boton2		= "Listar Inventario";
			$var_oculto1	= "menu_admin";
			$var_oculto2	= "menu_inven";
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$boton2 = "<input type=button value='$nom_boton2' onClick='menu_inventario();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
			$oculto2 = "<input name='$var_oculto2' 		type='hidden' id='$var_oculto2'/>";
		}
		if($cod_envia==5){ //Pagina Ventas
			$nom_boton1 	= "Menu Principal";
			$nom_boton2		= $nom_boton_lis;
			$var_oculto1	= "menu_admin";
			//$var_oculto2	= "menu_inven";
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
			if($nom_boton_nue>0){
				$boton2 = "<input type=button value='$nom_boton2' onClick='listar_gestion();'/>" ;	
				$oculto2 = "<input name='no_cont_fac' type='hidden' id='no_cont_fac'/>";
				if($cod_fac_pen>0){

					$boton3 = "<input type=button value='Eliminar Factura' onClick='eliminar_factura();'/>" ;
					$oculto3 = "<input name='eliminar_fac' type='hidden' id='eliminar_fac'/>";
					
					$boton4 = "<input type=button value='Cerrar Factura' onClick='cerrar_factura();'/>" ;
					$oculto4 = "<input name='cerrar_fac' type='hidden' id='cerrar_fac'/>";
					
					$boton1 = "<input type=button value='Continuar Factura' onClick='continuar_factura();'/>" ;
					$oculto1 = "<input name='continua_fac' type='hidden' id='continua_fac'/>";
				}
			}
		}
		
		if($cod_envia==6){ //Pagina Compras
			$nom_boton1 	= "Menu Principal";	
			$nom_boton2		= $nom_boton_lis;
			$var_oculto1	= "menu_admin";
			//$var_oculto2	= "menu_inven";
				
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
			if($nom_boton_nue>0){
				$boton1 = "<input type=button value='Nueva Compra' onClick='nueva_compra();'/>" ;	
				$oculto1 = "<input name='n_com' type='hidden' id='n_com' />";
			}
			if($nom_boton_lis>0){
				$boton2  = "<input type=button value='Listar Compras' onClick='menu_compras();'/>" ;	
				$oculto2 = "<input name='men_compras' 	type='hidden' id='men_compras'/>";
				$oculto1 = "<input name='nueva_fact' type='hidden' id='nueva_fact'/>";
			}
			if($fec_fac_asi>0){
				$boton2 = "<input type=button value='$nom_boton2' onClick='listar_gestion();'/>" ;	
				$oculto2 = "<input name='no_cont_fac' type='hidden' id='no_cont_fac'/>";
				
				if($cod_fac_pen>0){
					$boton3 = "<input type=button value='Eliminar Factura' onClick='eliminar_factura();'/>" ;
					$oculto3 = "<input name='eliminar_fac' type='hidden' id='eliminar_fac'/>";
					
					$boton4 = "<input type=button value='Cerrar Factura' onClick='cerrar_factura();'/>" ;
					$oculto4 = "<input name='cerrar_fac_compras' type='hidden' id='cerrar_fac_compras'/>";
	
					$boton1 = "<input type=button value='Continuar Factura' onClick='continuar_factura();'/>" ;
					$oculto1 = "<input name='continua_fac' type='hidden' id='continua_fac'/>";
				}
			}
		}
		if($cod_envia == 7){	//Pagina Cliente
			$nom_boton1 	= "Menu Principal";
			$nom_boton3		= $nom_boton_lis;
			
			$var_oculto1	= "menu_admin";
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
		
			$boton1 = "<input type=button value='Nuevo Cliente' onClick='nuevo_gestion();'/>" ;
			
			if($fec_fac_asi>0 or $nom_boton_nue>0){
				$boton2 = "<input type=button value='$nom_boton3' onClick='listar_gestion();'/>" ;	
				$oculto2 = "<input name='no_cont_fac' type='hidden' id='no_cont_fac'/>";
			}	
		}
		if($cod_envia == 8){	//Pagina Proveedor
			$nom_boton1 	= "Menu Principal";
			$var_oculto1	= "menu_admin";
			$nom_boton3		= $nom_boton_lis;
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
			
			$boton1 = "<input type=button value='Nuevo Proveedor' onClick='nuevo_gestion();'/>" ;
			if($fec_fac_asi>0 or $nom_boton_nue>0){
				$boton2 = "<input type=button value='$nom_boton3' onClick='listar_gestion();'/>" ;	
				$oculto2 = "<input name='no_cont_fac' type='hidden' id='no_cont_fac'/>";
			}
		}
		if($cod_envia == 9){	//Pagina Departamento
			$nom_boton1 	= "Menu Principal";
			$var_oculto1	= "menu_admin";
			
			$boton 	= "<input type=button value='$nom_boton1' onClick='menu_inicio();'/>" ;
			$oculto  = "<input name='$var_oculto1' 		type='hidden' id='$var_oculto1'/>";
			
			$boton1 = "<input type=button value='Nuevo Departamento' onClick='nueva_compra();'/>" ;
			$oculto1 = "<input name='n_com' type='hidden' id='n_com' />";
			
			$boton2 = "<input type=button value='Modificar Departamento' onClick='mod_gestion();'/>" ;
			$oculto2 = "<input name='btn_mod' type='hidden' id='btn_mod'/>";
						
			if($nom_boton_nue>0){ //Crear departamento
				$boton1 	= "<input type=button value='Listar Departamentos' onClick='menu_departa();'/>" ;
				$oculto1 	= "<input name='men_departa' 	type='hidden' id='men_departa'/>";
				
				$boton2		= " ";
				$oculto2 	= " ";
			}
			if($nom_boton_lis>0){
				$boton2 	= "<input type=button value='Listar Departamentos' onClick='menu_departa();'/>" ;
				$oculto2 	= "<input name='men_departa' 	type='hidden' id='men_departa'/>";
			}
		}
		if($cod_envia == 10){ //Pagina Usuario Facturacion
			$boton 	= "<input type=button value='Nueva Factura' onClick='nueva_factura();'/>" ;
			$oculto  = "<input name='nueva_fac' type='hidden' id='nueva_fac'/>";
			$oculto1 = "<input name='continua_fac' type='hidden' id='continua_fac'/>";
		}
		
		$menu_proveedor = "
		<table width=$ancho_tabla border=$Borde0>
		<tr>
		 <td>$boton  $oculto 	</td>
		 <td>$boton2 $oculto2 	</td>
         <td>$boton1 $oculto1 	</td>
		 <td>$boton3 $oculto3	</td>
		 <td>$boton4 $oculto4	</td>
		 <td>&nbsp;</td>
		</tr>
		</table> ";
		echo $menu_proveedor;
	}	

//Funcion Menu_ELIMINAR
	function menu_eliminar($cod_pagina){
		if($cod_pagina == 1){ //Ventas y Compras
			$boton  	= "<input type=button value='Eliminar Articulos' 	onClick='eliminar_articulo();'	/>" ;		
			$boton1 	= "<input type=button value='Eliminar Factura' 		onClick='eliminar_fact();'	/>" ;
			$oculto  	= "<input name='eliminar_articulo_fac' 		type='hidden' id='eliminar_articulo_fac'/>";
			$oculto1 	= "<input name='eliminar_toda_factura' 		type='hidden' id='eliminar_toda_factura'/>";
		}
		if($cod_pagina == 2){ //Departamento
			$boton  	= "<input type=button value='Eliminar Departamentos' 	onClick='eliminar_departamento();'	/>" ;		
			$oculto  	= "<input name='eliminar_depar' 		type='hidden' id='eliminar_depar'/>";
			$boton1 	= "<input type=button value='Modificar Departamentos' 		onClick='modificar_departamento();'	/>" ;
			$oculto1 	= "<input name='modificar_depar' 		type='hidden' id='modificar_depar'/>";
		}
		
		$tabla .="
		<table>
		<tr>
			<td>$boton $oculto</td>
			<td>$boton1 $oculto1</td>
		</tr>
		</table>
		";
		echo $tabla;
	}
	
//Funcion MENU PRINCIPAL
	function menu_principal(){

		//Para cuando le ponga diseño!! va con la class= 
		//$boton1 = "<input type=button value='Inventario' 	onClick='menu_inventario();'	class='menu_principal'/>" ;
		$vacio = 0;
		
		$boton  = "<input type=button value='Inicio' 		onClick='menu_inicio();'		class='menu_principal' />" ;		
		$boton1 = "<input type=button value='Inventario' 	onClick='menu_inventario();'	class='menu_principal' />" ;
		$boton2 = "<input type=button value='Productos' 	onClick='menu_productos(".$vacio.");'		class='menu_principal' />" ;
		$boton3 = "<input type=button value='Ventas' 		onClick='menu_ventas();'		class='menu_principal' />" ;
		$boton4 = "<input type=button value='Compras' 		onClick='menu_compras();'		class='menu_principal' />" ;
		$boton5 = "<input type=button value='Clientes' 		onClick='menu_cliente();'		class='menu_principal' />" ;
		$boton6 = "<input type=button value='Proveedores' 	onClick='menu_proveedor();'		class='menu_principal' />" ;
		$boton7 = "<input type=button value='Departamentos' onClick='menu_departa();'		class='menu_principal' />" ;
		$boton8 = "<input type=button value='Facturacion' 	onClick='menu_factura();'		class='menu_principal' />" ;
		$boton9 = "<input type=button value='Cerrar Sesion'	onClick='menu_ce_sesion();'		class='menu_principal' />" ;
	
		$c_oculto  = "<input name='menu_admin' 		type='hidden' id='menu_admin'/>";
		$c_oculto1 = "<input name='menu_inven' 		type='hidden' id='menu_inven'/>";
		$c_oculto2 = "<input name='men_productos' 	type='hidden' id='men_productos'/>";
		$c_ocult22 = "<input name='guarda_url' 		type='hidden' id='guarda_url'/>";
		$c_oculto3 = "<input name='men_ventas' 		type='hidden' id='men_ventas'/>";
		$c_oculto4 = "<input name='men_compras' 	type='hidden' id='men_compras'/>";
		$c_oculto5 = "<input name='men_cliente' 	type='hidden' id='men_cliente'/>";
		$c_oculto6 = "<input name='men_proveedor' 	type='hidden' id='men_proveedor'/>";
		$c_oculto7 = "<input name='men_departa' 	type='hidden' id='men_departa'/>";
		$c_oculto8 = "<input name='men_factura' 	type='hidden' id='men_factura'/>";
		$c_oculto9 = "<input name='men_ce_sesion' 	type='hidden' id='men_ce_sesion'/>";

		$tabla .="
			<table border='0'>
			<tr>
			 <td>$boton $c_oculto</td>
			</tr>
			<tr>
			 <td>$boton1 $c_oculto1</td>
			</tr>
			<tr>
			 <td>$boton2 $c_oculto2 $c_ocult22</td>
			</tr>
			<tr>
			 <td>$boton3 $c_oculto3</td>
			</tr>
			<tr>
			 <td>$boton4 $c_oculto4</td>
			</tr>
			<tr>
			 <td>$boton5 $c_oculto5</td>
			</tr>
			<tr>
			 <td>$boton6 $c_oculto6</td>
			</tr>
			<tr>
			 <td>$boton7 $c_oculto7</td>
			</tr>
			<tr>
			 <td>$boton8 $c_oculto8</td>
			</tr>
			<tr>
			 <td>$boton9 $c_oculto9</td>
			</tr>
			</table>
		";	
		echo $tabla;
	
	}
	
//-- Buscar proveedor con caja de texto
	$buscar_caja_texto = "
	<table>
	  <tr>
        <td><span class='Estilo8'>$nom_txt_busca</span></td>
        <td>
		<input name='busco' type='text' id='busco'>
		<input type='button' name='b' id='b' value='Buscar' onClick='buscar_proveedor();' />
		<input name='buscador' type='hidden' id='buscador'/>
		</td>
      </tr>
    </table>
	";

//Funcion Cabecera Listado	
	function cabecera_listado($act_ver_listado,$acti_ver_modificar){
	  
	  if($act_ver_listado == 1){
		$txt_1	= "No";						$ancho1	= 30;
		$txt_2	= "NOMBRE DEPARTAMENTO";	$ancho2	= 250;
		$txt_3	= "COD DEPARTAMENTO";		$ancho3	= 50;
		$txt_4	= "CANT ARTICULOS";			$ancho4	= 50;
	  }
	  if($acti_ver_modificar == 1){
		$txt_0	= "";						$ancho	= 10;
		$txt_1	= "No";						$ancho1	= 50;
		$txt_2	= "NOMBRE DEPARTAMENTO";	$ancho2	= 450;
		$txt_3	= "COD DEPARTAMENTO";		$ancho3	= 130;
		$txt_4	= "CANT ARTICULOS";			$ancho4	= 100;
		$mas_col	= 1;
	  }
	  
	  $tabla .="
	  <table width='800' border='1'>
      <tr>
	  ";
	  if($mas_col==1){
		$tabla .="
		<td width=$ancho> <div align=center> <span class=Estilo6> $txt_0	</span></div></td>
		";
	  }
	  $tabla .="
        <td width=$ancho1> <div align=center> <span class=Estilo6> $txt_1	</span></div></td>
        <td width=$ancho2> <div align=center> <span class=Estilo6> $txt_2	</span></div></td>
        <td width=$ancho3> <div align=center> <span class=Estilo6> $txt_3	</span></div></td>
        <td width=$ancho4> <div align=center> <span class=Estilo6> $txt_4	</span></div></td>
      </tr>
	  ";
	  echo $tabla;
	}
//Funcion Listado de datos con 4 columnas
	function listar_ges_4_col($act_ver_listado,$pos1, $pos2, $lista,$pos_lista,$act_eliminar,$acti_mod_tabla){
		if($act_ver_listado == 1 or $act_eliminar == 1 or $acti_mod_tabla == 1){
			$alineacion0	= "center";
			$alineacion1	= "center";
			$alineacion2	= "left";
			$alineacion3	= "center";
			$alineacion4	= "center";
		} 
		
		//Valores de la tabla
		$var_col0	= "<input type='checkbox' name='valores[]' value=".$lista[$pos1][$pos2][1]." />";
		$var_col1	= $pos_lista;
		$var_col2	= $lista[$pos1][$pos2][0];
		$var_col3	= $lista[$pos1][$pos2][1];
		$var_col4	= $lista[$pos1][$pos2][2];
		
		//Habilito poder modificar
		if($acti_mod_tabla == 1){
			//$act_modifica
			$valor = $lista[$pos1][$pos2][1];
			$nom_campo = "depto".$pos2;
			$var_col0 =  "<input type='checkbox' name='valores[]' value='$valor' onclick='document.form1.$nom_campo.disabled=!document.form1.$nom_campo.disabled' />";
			$var_col2 = "<input type='text' name='depto[]' id='$nom_campo' size='70' value='$var_col2' disabled>";
		}
		
		//Dibujo Tabla
		$tabla .="	
		<tr>
		";
		if($act_eliminar>0){
			$tabla .="
			<td><div align=$alineacion0>  	<span class=Estilo7>". $var_col0	."</span></div></td>
			";
		}
		$tabla .="
		<td><div align=$alineacion1>  	<span class=Estilo7>". $var_col1	."</span></div></td>
        <td><div align=$alineacion2>    <span class=Estilo7>". $var_col2 	."</span></div></td>
        <td><div align=$alineacion3>	<span class=Estilo7>". $var_col3  	."</span></div></td>
        <td><div align=$alineacion4>	<span class=Estilo7>". $var_col4	."</span></div></td>
        </tr>
		";
		echo $tabla;
	}	
	
//--Listado Proveedores

	$cabecera_listado_proveedor = "
	<table width=$ancho_tabla border=$Borde1>
      <tr>
        <td width=30 > <div align=center> <span class=Estilo6> $txt_numero		</span></div></td>
        <td width=248> <div align=center> <span class=Estilo6> $txt_gestion		</span></div></td>
        <td width=117> <div align=center> <span class=Estilo6> $txt_ciudad		</span></div></td>
        <td width=118> <div align=center> <span class=Estilo6> $txt_telefono	</span></div></td>
        <td width=155> <div align=center> <span class=Estilo6> $txt_contacto	</span></div></td>
        <td width=92 > <div align=center> <span class=Estilo6> $txt_mov 		</span></div></td>
      </tr>
	 ";
			
	function listar_gestion($cont_prov,$pos1,$pos2, $lista,$pos_lista,$pagina_actual,$lim_final,$cod_fac_asi,$act_eliminar)
	{
		$col1	=	1;
		$col2	=	2;
		$col3	=	3;
		$col4	=	4;
		$col5	=	5;
		$col6	=	6;
		
		$vl_col1 = $pos_lista;
		$vl_col2 = $lista[$pos1][$pos2][$col1];
		$vl_col3 = $lista[$pos1][$pos2][$col2];
		$vl_col4 = $lista[$pos1][$pos2][$col3];
		$vl_col5 = $lista[$pos1][$pos2][$col4];
		$vl_col6 = $lista[$pos1][$pos2][$col5];
		
		if($cod_fac_asi>0){
			$alineacion1	= "center";
			$alineacion2	= "center";
			$alineacion3	= "center";
			$alineacion4	= "left";
			$alineacion5	= "right";
			$alineacion6	= "right";
		}else{
			$alineacion1	= "center";
			$alineacion2	= "left";
			$alineacion3	= "left";
			$alineacion4	= "center";
			$alineacion5	= "left";
			$alineacion6	= "center";
		}
		
		if(($pagina_actual == "compras" or $pagina_actual == "ventas") and $cod_fac_asi > 0 and $act_eliminar>0){
			$vl_col1 	= "<input type='checkbox' name='valores[]' value=".$lista[$pos1][$pos2][$col6]." />";
			$vl_col2	= $pos_lista;
		}
		
		$tabla .="";
		if($cod_fac_asi>0){
			$encabezado .="
			<tr class=celda>
			";
		}else{
			$encabezado .="	
			<tr class=celda onClick=window.location='".$pagina_actual."2.php?cod_ges=". $lista[$pos1][$pos2][0]."&val_fin=".$lim_final."'>
			";
		}
        $encabezado .="	
		<td><div align=$alineacion1>  	<span class=Estilo7>". $vl_col1 ."</span></div></td>
        <td><div align=$alineacion2>    <span class=Estilo7>". $vl_col2	."</span></div></td>
        <td><div align=$alineacion3>	<span class=Estilo7>". $vl_col3	."</span></div></td>
        <td><div align=$alineacion4>	<span class=Estilo7>". $vl_col4	."</span></div></td>
        <td><div align=$alineacion5>	<span class=Estilo7>". $vl_col5	."</span></div></td>
        <td><div align=$alineacion6>	<span class=Estilo7>". $vl_col6	."</div></td>
        </tr>
		";
		echo $encabezado;		
	}
	
	$fin_tabla_proveedor = " 
    </table>
	";

//Funcion Formulario Crear
	function formulario_crear($acti_ver_nuevo){
		$ancho		= '800';
		$borde		= '1';
		$estilo		= 'Estilo6';
		if($acti_ver_nuevo==1){ //DEPARTAMENTO
			
			$cre_titulo			=	"CREAR DEPARTAMENTO";
			
			$nom_campo			=	"NOMBRE";
			$id_campo			= 	"nombre";
			$tamano1			=	"30";
			
			$nom_boton_cre		=	$cre_titulo;
			$nom_boton_cre 		= 	strtolower($nom_boton_cre); 		
			$nom_boton_cre 		= 	ucwords($nom_boton_cre);
			$campo_oculto		=  	"crea_depto";
			
		}
		
		$tabla .= "
		<table width=$ancho border=$borde>
		<tr>
			<td colspan='2'><div align='center'><span class=$estilo>$cre_titulo </span></div></td>
		</tr> 
		<tr>
			<td>	<span class=$estilo>$nom_campo</span></td>
			<td>	<input name='$id_campo' type='text' id='$id_campo' size='$tamano'></td>	
		</tr>
		<tr>
			<td colspan='2'>
			<div align='center'>
			<input type='button' value='$nom_boton_cre' onClick='val_formulario()' />
			<input name='$campo_oculto' type='hidden' id='$campo_oculto' />	
			</div>
			</td>
		</tr>
		</tabla>
		";
		echo $tabla;
	}
//--Crear Productos
	function formulario_creacion($cod_art,$ar_mensaje,$act_modicar,$act_env_url,$nom_url){
		
		//Datos para crear Producto
		$ancho		= '800';
		$borde		= '1';
		$estilo		= 'Estilo6';
		$cero		=   "0";
		
		$cre_titulo			=	"CREAR PRODUCTO";
		$campo_oculto		=  	"crea_articulo";	
		
		$nom_campo			=	"CODIGO";
		$id_campo			= 	"cod_art";
		$tamano				=	"10";
		
		$nom_campo0			=	"CODIGO DE BARRAS";
		$id_campo0			= 	"barras";
		$tamano0			=	"30";
		$cod_barcode		= 	$cod_art;
		
		$nom_campo1			=	"DESCRIPCION";
		$id_campo1			= 	"descripcion";
		$tamano1			=	"90";
		
		$nom_campo2			=	"DEPARTAMENTO";
		$id_campo2			= 	"departamento";
		$tamano2			=	"60";
		
		$nom_campo3			=	"CANTIDAD";
		$id_campo3			= 	"cantidad";
		$tamano3			=	"10";
		$value_canti		= 	$cero;
		
		$nom_campo4			=	"COSTO $";
		$id_campo4			= 	"costo";
		$tamano4			=	"10";
		$value_costo		= 	$cero;
		
		$nom_campo5			=	"PRECIO VENTA $";
		$id_campo5			= 	"precio";
		$tamano5			=	"10";
		$value_preci		=	$cero;
		
		$nom_campo6			=	"%";
		$id_campo6			= 	"porcentaje";
		$tamano6			=	"10";
		$value_porce		= 	$cero;
		$cod_val_acc		= 	1;
			
		//Valores de Modificacion
		if($act_modicar>0){
			$cre_titulo		=	"MODIFICAR PRODUCTO";	
			$campo_oculto	= 	"modifica_prod";
			$cod_val_acc	= 	2;
		}
		//Valores para crear articulo y regresar a la factura
		if ($act_env_url>0){
			$cre_titulo1		=	"VOLVER A LA FACTURA";
			$campo_oculto1		=	"volver_fact";
			
			$cre_titulo2		=	"CREAR PRODUCTO";	
			$campo_oculto2		=  	"crea_articulo";
			$campo_ocult22		=  	"mostrar_menu";
			$cod_val_acc2		= 	3;
			
			$cre_titulo			= 	"CREAR PRODUCTO Y REGRESAR A LA FACTURA";
			$campo_oculto		=  	"crea_volver";
			$campo_ocult23		=	"crea_vol_fac";
			$cod_val_acc		= 	4;
		}
		
		$cant_art = count($ar_mensaje);
			
		//Valores de Array
		if($cant_art > 0){
			
			$cod_art		=	$ar_mensaje[0][1][7];
			$cod_barcode	=	$ar_mensaje[0][1][2];
			$value_descr	=	$ar_mensaje[0][1][0];
			$value_depar	=	$ar_mensaje[0][1][1];
			$value_canti	=	$ar_mensaje[0][1][3];
			$value_costo	=	$ar_mensaje[0][1][4];
			$value_porce	=	$ar_mensaje[0][1][6];
			$value_preci	=	$ar_mensaje[0][1][5];
			
		}
		
		$nom_boton_cre		=	$cre_titulo;
		$nom_boton_cre 		= 	strtolower($nom_boton_cre); 		
		$nom_boton_cre 		= 	ucwords($nom_boton_cre);
		
		$nom_boton_cre1		=	$cre_titulo1;
		$nom_boton_cre1		= 	strtolower($nom_boton_cre1); 		
		$nom_boton_cre1		= 	ucwords($nom_boton_cre1);
		
		$nom_boton_cre2		=	$cre_titulo2;
		$nom_boton_cre2		= 	strtolower($nom_boton_cre2); 		
		$nom_boton_cre2		= 	ucwords($nom_boton_cre2);
		
		$tabla ="
		<table width=$ancho border=$borde>
		<tr>
			<td  colspan='2'><div align='center'><span class=$estilo>$cre_titulo </span></div></td>
		</tr> 
		<tr>
		<td colspan='2'>
			<table>
			<tr>
				<td>	<span class=$estilo>$nom_campo</span></td>
				<td>	<input type='text' size='$tamano' value='$cod_art' disabled></td>	
				<td>	<span class=$estilo>$nom_campo0</span></td>
				<td>	<input name='$id_campo0' type='text' id='$id_campo0' size='$tamano0' value='$cod_barcode'></td>	
			</tr>
			</table>
		</td>	
		</tr>
		<tr>
			<td>	<span class=$estilo>$nom_campo1</span></td>
			<td>	<input name='$id_campo1' type='text' id='$id_campo1' size='$tamano1' value='$value_descr'></td>	
		</tr>
		<tr>
			<td>	<span class=$estilo>$nom_campo2</span></td>
			<td>	
			<input name='inputString' type='text' class='Estilo7' id='inputString' value='$value_depar' onBlur='fill_departamento();'
			onKeyUp='lookup_departamento(this.value);' size='30'/>
			<div span class='Estilo7'>
			<div class='suggestionsBox' id='suggestions' style='display: none;'>
			<img src='../clases/auto/upArrow.png' style='position: relative; top: -12px; left: 30px;' alt='upArrow' />
			<div class='suggestionList' id='autoSuggestionsList'> &nbsp; </div>			
			</td>
		</tr>
		<tr>
		<td colspan='2' align='center'>
			<table>
			</tr>
				<td>	<span class=$estilo>$nom_campo3</span>																						</td>
				<td>	<input name='$id_campo3' type='text' id='$id_campo3' size='$tamano3' value='$value_canti' onkeyUp='return ValNumero(this);'>		</td>	
				<td>	<span class=$estilo>$nom_campo4</span>																						</td>
				<td>	<input name='$id_campo4' type='text' id='$id_campo4' size='$tamano4' value='$value_costo' onkeyUp='calcula_precio(this);'>			</td>
				<td>	<span class=$estilo>$nom_campo6</span>																						</td>
				<td>	<input name='$id_campo6' type='text' id='$id_campo6' size='$tamano6' value='$value_porce' onkeyUp='calcula_precio(this);'>			</td>
				<td>	<span class=$estilo>$nom_campo5</span>																						</td>
				<td>	<input name='$id_campo5' type='text' id='$id_campo5' size='$tamano5' value='$value_preci' onkeyUp='calcula_porciento(this);'>		</td>				
			<tr>
			<table>
		</td>		
		</tr>
		<tr>
			<td  colspan='2'>
			<div align='center'>
		";		
		if ($act_env_url>0){
		$tabla.= "
			<input type='button' value='$nom_boton_cre1' onClick='vol_factura();' /> 
			<input type='button' value='$nom_boton_cre2' onClick='val_articulo(".$cod_val_acc2.");' /> 
			<input name='$campo_oculto1' type='hidden' id='$campo_oculto1' />		
			<input name='$campo_oculto2' type='hidden' id='$campo_oculto2' />			
			<input name='$campo_ocult22' type='hidden' id='$campo_ocult22' />			
			<input name='$campo_ocult23' type='hidden' id='$campo_ocult23' />			
		";	
		}
		$tabla.="
			<input type='button' value='$nom_boton_cre' onClick='val_articulo(".$cod_val_acc.");' /> 
			<input name='$campo_oculto' type='hidden' id='$campo_oculto' />		
			</div>
			</td>
		</tr>
		</tabla>	
		";
		echo $tabla;
	}

//--Crear Proveedores & Clientes
	function formulario_mod_pro($cre_titulo,$txt_contacto,$nom_boton_cre,$lista,$cant_lista,$cod_ges)
	{
		if($cod_ges>0){
			$pos1	=	0;
			$pos2	=	1;
			for($cont=1; $cont<=$cant_lista; $cont++){
				if ($lista[$pos1][$pos2][0] == $cod_ges){
			
					$nombre_gestion 	= $lista[$pos1][$pos2][1];
					$num_registro_tri	= $lista[$pos1][$pos2][6];
					$dir_gestion		= $lista[$pos1][$pos2][7];
					$num_telefono		= $lista[$pos1][$pos2][3];
					$n_ciu				= $lista[$pos1][$pos2][2];
					$n_dep				= $lista[$pos1][$pos2][8];
					$n_pai				= $lista[$pos1][$pos2][9];
					$num_telefono2		= $lista[$pos1][$pos2][10];
					$num_fax			= $lista[$pos1][$pos2][11];
					$contacto			= $lista[$pos1][$pos2][4];
					$num_celular		= $lista[$pos1][$pos2][12];	
					$num_ventas			= $lista[$pos1][$pos2][5];
				}
				$pos1++;
				$pos2++;
			}
			$campo_oculto = "mod_ges";
		}else{
			$campo_oculto = "crea_pro";
		}
		
		$formulario = "
		<table width=800 border=1>
		<tr>
			<td colspan='4'><div align='center'><span class='Estilo6'>$cre_titulo </span></div></td>
		</tr> 
		<tr>
			<td width='110'>	<span class='Estilo6'>NOMBRE</span></td>
			<td width='210'>	<input name='nombre' type='text' id='nombre' value='$nombre_gestion' size='30'></td>
			<td width='157'>	<span class='Estilo6'>	NIT</span></td>
			<td width='250'>	<input name='nit' type='text' id='nit' value='$num_registro_tri' size='30'></td>
		</tr>
		<tr>
			<td><span class='Estilo6'>DIRECCION</span></td>
			<td colspan='3'>
			<input name='direccion' type='text' id='direccion' value='$dir_gestion' size='30'>
			</td>
		</tr>
		<tr>
			<td><span class='Estilo6'>No. TELEFONO 1</span></td>
			<td><input name='tel1' type='text' id='tel1' value='$num_telefono' size='30'></td>
			<td><span class='Estilo6'>No. TELEFONO 2 </span></td>
			<td><input name='tel2' type='text' id='tel2' value='$num_telefono2' size='30'></td>
		</tr>
		<tr>
			<td><span class='Estilo6'>No. FAX </span></td>
			<td><input name='fax' type='text' id='fax' value='$num_fax' size='30'></td>
			<td><span class='Estilo6'>No. CELULAR </span></td>
			<td><input name='celular' type='text' id='celular' value='$num_celular' size='30'></td>
		</tr>
		<tr>
			<td><span class='Estilo6'>$txt_contacto</span></td>
			<td colspan='3'>
			<input name='vendedor' type='text' id='vendedor' value='$contacto' size='30'>
			</td>
		</tr>
		<tr>
			<td width='104'><span class='Estilo6'>CIUDAD</span></td>
			<td width='111' colspan='3'> 	
			<input name='inputString' type='text' class='Estilo7' id='inputString' value='$n_ciu' onBlur='fill_ciudad();'
			onKeyUp='lookup_ciudad(this.value);' size='30'/>
			<div span class='Estilo7'>
			<div class='suggestionsBox' id='suggestions' style='display: none;'>
			<img src='../clases/auto/upArrow.png' style='position: relative; top: -12px; left: 30px;' alt='upArrow' />
			<div class='suggestionList' id='autoSuggestionsList'> &nbsp; </div>
			</div>
			</div> 
			</td>
		</tr>
		<tr>
			<td colspan='6'>
			<div align='center'>
			<input type='button' name='button22' id='button22' value='$nom_boton_cre' onClick='val_cre_prov(".$cod_ges.")' />
			<input name='$campo_oculto' type='hidden' id='$campo_oculto' />	
			</div>
			</td>
		</tr>
		</table>    
		";
		echo $formulario;
	}
		
//Funcion Paginacion tabla numeros inferiores

	function tabla_paginacion($pagina, $inicio, $final,$numPags,$act_ct_buscar,$buscar_palabra,$cant_prov_total,$cod_fac,$fecha_fac,$cod_fac_pen,$cod_proveedor,$can_ven_com)
	{	
		if($pagina>1) 
		{
			if($cod_fac>0){
				$anterior = "	
				<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&id_com=".$cod_fac."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
				<font face='verdana' size='-2'>anterior</font></a>
				";
			}else{
				if($cod_fac_pen>0){
					$anterior = "	
					<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&id_pen=".$cod_fac_pen."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
					<font face='verdana' size='-2'>anterior</font></a>
					";
				}else{
					if($act_ct_buscar>0){
					$anterior = "
					<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina-1)."&cant_reg=".$cant_prov_total."&pala_buscar=".$buscar_palabra."'>
					<font face='verdana' size='-2'>anterior</font></a>
					";	
					}else{
						if($can_ven_com>0){
							$anterior.= "
							<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&cod_ges=".$can_ven_com."&val_fin=0'>
							<font face='verdana' size='-2'>anterior</font></a>	
							";
						}else{
							$anterior = "	
							<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina-1)."'>
							<font face='verdana' size='-2'>anterior</font></a>
							";
						}	
					}
				}
			}
		}
		
		$formulario= "
		<table border='0' cellspacing='0' cellpadding='0' align='center'> 
		<tr>
		 <td align='center' valign='top'>
			$anterior
			$campo_oculto
		";
		
		for($i=$inicio;$i<=$final;$i++) 
		{ 
			if($i==$pagina) 
			{ 
			  $formulario.=  "	<font face='verdana' size='-2'><b>".$i."</b> </font>";
			}else{
				if($cod_fac>0){
					$formulario.=  "
					<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&id_com=".$cod_fac."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
					<font face='verdana' size='-2'>".$i."</font></a>
					";
				}else{
					if($cod_fac_pen>0){
					$formulario.= "
					<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&id_pen=".$cod_fac_pen."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
					<font face='verdana' size='-2'>".$i."</font></a>
					";
					}else{
						if($act_ct_buscar>0){
						$formulario.= "
						<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".$i."&cant_reg=".$cant_prov_total."&pala_buscar=".$buscar_palabra."'>
						<font face='verdana' size='-2'>".$i."</font></a>
						";
						}else{
							if($can_ven_com>0){
								$formulario.= "
								<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&cod_ges=".$can_ven_com."&val_fin=0'>
								<font face='verdana' size='-2'>".$i."</font></a>	
								";
							}else{
								$formulario.=  "
								<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".$i."'>
								<font face='verdana' size='-2'>".$i."</font></a>
								";
							}
						}
					}
				}
			}
		}
		if($pagina<$numPags) 
		{ 
			if($cod_fac>0){
				$formulario.= "
				<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&id_com=".$cod_fac."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
				<font face='verdana' size='-2'>siguiente</font></a>
				";
			}else{
				if($cod_fac_pen>0){
					$formulario.= "
					<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&id_pen=".$cod_fac_pen."&fec=".$fecha_fac."&id_pro=".$cod_proveedor."'>
					<font face='verdana' size='-2'>siguiente</font></a>
					";
				}else{
					if($act_ct_buscar>0){
					$formulario.= "
					<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina+1)."&cant_reg=".$cant_prov_total."&pala_buscar=".$buscar_palabra."'>
					<font face='verdana' size='-2'>siguiente</font></a>
					";
					}else{
						if($can_ven_com>0){
							$formulario.= "
							<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&cod_ges=".$can_ven_com."&val_fin=0'>
							<font face='verdana' size='-2'>siguiente</font></a>	
							";
						}else{
							$formulario.= "
							<a class='p' href='".$_SERVER["PHP_SELF"]."?val=1&pagina=".($pagina+1)."'>
							<font face='verdana' size='-2'>siguiente</font></a>
							";
						}	
					}
				}
			}
		}
		$formulario.= "
		 </td>
		</tr> 
		</table>	
		";
		echo $formulario;
	}

//Funcion buscar datos segun almacenamiento en array
	function busca_valor_asiento($cant_lista,$lista,$cod_ges){
	$pos1	=	0;
	$pos2	=	1;
		for($cont=1; $cont<=$cant_lista; $cont++){
			if ($lista[$pos1][$pos2][0] == $cod_ges){
				$num_ventas			= $lista[$pos1][$pos2][5];
			}
			$pos1++;
			$pos2++;
		}
		return $num_ventas;
	}
//Funcion Imprimir datos de gestion	
	function imp_datos_gestion($txt_contacto,$lista,$cant_lista,$cod_ges,$txt_mov,$txt_vendedor,$cod_fac_asi,$cod_fac_pen,$continuar_fac,$inicial){
		
	$txt_contacto = strtolower($txt_contacto); 		
	$txt_contacto = ucwords($txt_contacto);
	
	$txt_mov = strtolower($txt_mov); 		
	$txt_mov = ucwords($txt_mov);
	
	$txt_vendedor = strtolower($txt_vendedor); 		
	$txt_vendedor = ucwords($txt_vendedor);
	
	$pos1	=	0;
	$pos2	=	1;

	for($cont=1; $cont<=$cant_lista; $cont++){
		
		if ($lista[$pos1][$pos2][0] == $cod_ges){
				
			$nombre_gestion 	= $lista[$pos1][$pos2][1];
			$num_registro_tri	= $lista[$pos1][$pos2][6];
			$dir_gestion		= $lista[$pos1][$pos2][7];
			$num_telefono		= $lista[$pos1][$pos2][3];
			$n_ciu				= $lista[$pos1][$pos2][2];
			$n_dep				= $lista[$pos1][$pos2][8];
			$n_pai				= $lista[$pos1][$pos2][9];
			$num_telefono2		= $lista[$pos1][$pos2][10];
			$num_fax			= $lista[$pos1][$pos2][11];
			$contacto			= $lista[$pos1][$pos2][4];
			$num_celular		= $lista[$pos1][$pos2][12];	
			$num_ventas			= $lista[$pos1][$pos2][5];
			$suma_total			= $lista[$pos1][$pos2][13];
			$num_factura_ve		= $lista[$pos1][$pos2][14];
			$fec_factura_ve		= $lista[$pos1][$pos2][15];
			$nom_vendedor		= $lista[$pos1][$pos2][16];
			//Textos 
			$txt_columna4		= "No. ".$txt_mov;
			$txt_col4_fil3		= "Valor de ".$txt_mov;
			$txt_col4_fil4		= "Telefonos";
			$txt_col4_fil5		= "Fax";
			$txt_col4_fil6		= "Celular";
			$car_barra			= "/";
			$sim_din			= "$";
			$valor_total		= $sim_din." ".$suma_total;
			//Estilo
			$var_estilo1		= "Estilo12";
			$var_estilo6		= "Estilo6";
			$var_estilo8		= "Estilo6";
		}
		$pos1++;
		$pos2++;
	}
	if($inicial>0){
		$num_factura_ve		= $cod_fac_pen;
		$fec_factura_ve		= $txt_mov;
	}
	if($continuar_fac>0){
		$cod_fac_asi = $continuar_fac;
	}
	if($cod_fac_asi>0 or $cod_fac_pen>0){
		$txt_columna4 		= "Fecha Factura";
		$txt_col4_fil3 		= $fec_factura_ve;
		$txt_col4_fil4 		= " ";
		$txt_col4_fil5 		= " ";
		$txt_col4_fil6		= " ";
		$num_ventas			= " ";
		$num_telefono		= " ";
		$num_telefono2		= " ";
		$car_barra			= " ";
		$sim_din			= " ";
		$tab_num_fac		= "
		<table border='1' bordercolor='#FF0000'>
        <tr>
          <td>
		  <div align='center'>
            <label>
              <input type='vr' name='vr2' value='$num_factura_ve' 
              size='3' readonly style='font-family: 
              Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC'>
            </label>
          </div>
		  </td>
        </tr>
      </table>
		";
		$valor_total 		=	"No. Factura";
		//Estilo
		$var_estilo1		= "Estilo6";
		$var_estilo6		= "Estilo6";
		$var_estilo8		= " ";
	}
	if($cod_fac_pen>0){
		$txt_pendiente 		= "FACTURA PENDIENTE";
	}
	$datos_gestion = "
	
	<table width='800' border='1' bordercolor='#000000'>
    <tr>
        <td>
        <table border='0'>
        <tr>
            <td width='400' colspan='4'>
				<div align='left'>
				<span class='Estilo8'>
				 $nombre_gestion
				</span>
				</div>				  
			</td>
            <td width='100'>&nbsp;</td>
            <td width='150'>&nbsp;</td>
            <td width='150'><span class='Estilo15'>$txt_pendiente</span></td>
        </tr>
        <tr>
			<td colspan='4'>
				<div align='left'><span class='Estilo7'>$num_registro_tri</span></div>				  
			</td>
            <td><span class='$var_estilo6'>$txt_columna4</span></td>
            <td><span class='Estilo12'>$num_ventas</span></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
			<td colspan='4' class='Estilo7'>
				<div align='left'>$dir_gestion</div>				  
			</td>
            <td><span class='$var_estilo8'>$txt_col4_fil3</span></td>
            <td><span class='$var_estilo1'>$valor_total</span></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
			<td colspan='4' class='Estilo7'>
				<div align='left'>$n_ciu - $n_dep - $n_pai</div>				  
			</td>
            <td><span class='Estilo6'>$txt_col4_fil4</span></td>
            <td>$tab_num_fac $num_telefono $car_barra $num_telefono2</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2'><span class='Estilo6'>$txt_vendedor</span></td>
            <td>$nom_vendedor</td>
            <td>&nbsp;</td>
            <td><span class='Estilo6'>$txt_col4_fil5</span></td>
            <td>$num_fax</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
			<td colspan='2'><span class='Estilo6'>$txt_contacto</span></td>
            <td colspan='2'>$contacto</td>
            <td><span class='Estilo6'>$txt_col4_fil6</span></td>
            <td>$num_celular</td>
            <td>&nbsp;</td>
        </tr>
		</table>
		</td>
    </tr>
    </table>
	
	";
	echo $datos_gestion;
	}

//Funcion mostrar tabla que no registra datos	
	function no_registra_datos($ges_titulo,$pagina_actual){
		$ges_titulo2 = strtolower($ges_titulo); 
		$tabla = "
		<table width='800' border='1'>
		<tr>
			<td>
			 <div align=ringh><span class=Estilo6> $ges_titulo			</span></div>
			</td>
        </tr>
		<tr>
            <td class='Estilo7'>	No se registran $ges_titulo2 al $pagina_actual</td>
        </tr>
        </table>
		";
		echo $tabla;
	}

//Listado de numero de compras o ventas
//Encabezado listado
	function encabezado_numero_gestion($ges_titulo,$pagina_actual){
		$ges_titulo2 = strtolower($ges_titulo); 
		$nom_columna1	= 'No.';
		$nom_columna5	= 'Valor Factura';
		if($pagina_actual == 'cliente'){
			$nom_columna2	= 'Nombre cliente';
			$nom_columna3	= 'No. Factura';
			$nom_columna4	= 'Fecha de '. $ges_titulo2;
		}
		if($pagina_actual == 'proveedor'){
			$nom_columna4	= 'Fecha de Vencimiento';
			$nom_columna2	= 'No. Factura';
			$nom_columna3	= 'Fecha de '. $ges_titulo2;
		}
		
		
		$cabecera_listado_proveedor = "
		<table width=800 border=1>
		<tr>
			<td colspan='5' > <div align=ringh> <span class=Estilo6> $ges_titulo			</span></div></td>
		</tr>
        <tr>
			<td width=30 > <div align=center> <span class=Estilo6> $nom_columna1				</span></div></td>
			<td width=248> <div align=center> <span class=Estilo6> $nom_columna2 				</span></div></td>
			<td width=117> <div align=center> <span class=Estilo6> $nom_columna3				</span></div></td>
			<td width=118> <div align=center> <span class=Estilo6> $nom_columna4				</span></div></td>
			<td width=155> <div align=center> <span class=Estilo6> $nom_columna5				</span></div></td>
        </tr>
		";	
		echo $cabecera_listado_proveedor;
	}
//Informacion listado
	function listado_numero_gestion($pos1,$pos2, $lista,$pos_lista,$pagina_actual,$lim_final)
	{
		if($pagina_actual == 'proveedor'){
			$id_com 	= $lista[$pos1][$pos2][0];
			$fec		= $lista[$pos1][$pos2][1];
			$prov		= $lista[$pos1][$pos2][4];
			$pagina_en 	= 'compras2.php';
			$link_envia = $pagina_en."?id_com=".$id_com."&fec=".$fec."&id_pro=".$prov;
		}
		if($pagina_actual == 'cliente'){
			$id_com 	= $lista[$pos1][$pos2][1];
			$fec		= $lista[$pos1][$pos2][2];
			$pagina_en 	= 'ventas2.php';
			$link_envia = $pagina_en."?id_com=".$id_com."&fec=".$fec;
		}
		$encabezado="
	    <tr class=celda onClick=window.location='". $link_envia."'>
        <td><div align=center>  <span class=Estilo7>". $pos_lista."</span></div></td>
        <td><div align=center>  <span class=Estilo7>". $lista[$pos1][$pos2][0] 	."</span></div></td>
        <td><div align=center>	<span class=Estilo7>". $lista[$pos1][$pos2][1]  ."</span></div></td>
        <td><div align=center>	<span class=Estilo7>". $lista[$pos1][$pos2][2]	."</span></div></td>
        <td><div align=right>	<span class=Estilo7> $ ". $lista[$pos1][$pos2][3] 	."</span></div></td>
        </tr>
		";
		echo $encabezado;		
	}
//Tabla para modificacion con logos eliminar, modificar	
	function tabla_modificacion($pagina_actual,$codigo,$limitInf){
		$cadena_envio = $pagina_actual."2.php?cod_tab_mod=".$codigo."&val_fin=".$limitInf;
		$tabla = "
		<table width='800' border='1'>
        <tr>
			<td>
			<table border='0'>
			<tr>
				<td width='90'>
				 <div align='center'>
				 <a href='$cadena_envio'>
				 <img src='../imagenes/logo_modificar.jpg' width='24' height='25' border='0'>
				 </a>
				 </div>
				</td>
				<td width='415'>&nbsp;</td>
				<td width='148'>&nbsp;</td>
				<td width='149'>&nbsp;</td>
			</tr>
			</table>
			</td>
		</tr>
        </table>		  	
		";
		echo $tabla;
	}

//Encabezado Factura
	$cabecera_factura_ventas = "
	<table width=$ancho_tabla border=$Borde1>
      <tr>
		<td colspan='6'>
		<div align=center> <span class=Estilo6> $txt_tit_enca		</span></div>
		</td>
	  </tr>
	  <tr>	
        <td width=25 > <div align=center> <span class=Estilo6> $txt_numero		</span></div></td>
        <td width=25 > <div align=center> <span class=Estilo6> $txt_codigo		</span></div></td>
        <td width=65 > <div align=center> <span class=Estilo6> $txt_cantidad	</span></div></td>
        <td width=300> <div align=center> <span class=Estilo6> $txt_detalle		</span></div></td>
        <td width=90 > <div align=center> <span class=Estilo6> $txt_var_uni		</span></div></td>
        <td width=90 > <div align=center> <span class=Estilo6> $txt_var_tot		</span></div></td>
      </tr>
	 ";
	
	function fin_tabla_factura($num_factura,$total){
		$tabla ="
		<tr>
			<td colspan='5'>
			 <div align=right> <span class=Estilo6>TOTAL FACTURA No. $num_factura </span></div>
			</td>
			<td>
			 <div align=right> <span class=Estilo6> $ $total</span></div>
			</td>
		</tr>
		";
		echo $tabla;
	}

	function tabla_sum_parcial($num_factura,$total){
		$tabla ="
		<tr>
			<td colspan='5'>
			 <div align=right> <span class=Estilo6>SubTotal Pagina No. $num_factura </span></div>
			</td>
			<td>
			 <div align=right> <span class=Estilo6> $ $total</span></div>
			</td>
		</tr>
		";
		echo $tabla;
	}	

//---- FACTURACION
	function buscar_articulo($act_ver_nue_art,$url){
	
	if($act_ver_nue_art>0){
		$boton 		= "<input type=button value='Nuevo Articulo'	onClick='menu_productos(".$act_ver_nue_art.");'	/>" ;
		$c_oculto  	= "<input name='men_productos' 	type='hidden' id='men_productos'/>";
		$c_oculto2 	= "<input name='guarda_url' 	type='hidden' id='guarda_url'/>";
	}	
	
	$tabla = "
		<table border='0'>
		<tr>
		<td>
		 <table border='0'>
		 <tr>
		  <td valign='top'>
		   <span class='Estilo6'>Seleccione Articulo</span>
		   <input name='va_insertado' type='hidden' id='va_insertado'/>
		  </td>
		  <td>
		  <input name='inputString' type='text' class='Estilo7' id='inputString' onBlur='fill();' 
		  onKeyUp='lookup(this.value);' size='30'/>
		  <div span class='Estilo7'>
		  <div class='suggestionsBox' id='suggestions' style='display: none;'>
		  <img src='../clases/auto/upArrow.png' style='position: relative; top: -12px; left: 30px;' alt='upArrow' />
		  <div class='suggestionList' id='autoSuggestionsList'> &nbsp; </div>
		  </div>
		  </div>
		  </td>
		  <td>
		  $boton $c_oculto $c_oculto2
		  </td>
		 </tr>
		 <tr>
		  <td><span class='Estilo6'>Codigo de Barras Articulo</span></td>
		  <td>
		  <span class='Estilo7'>
          <input type='text' name='clave' id='clave' 
          onKeyUp= '
		  document.form1.action='ventas2.php?men2= ".$men_env."&id_pen=".$num_factura."&fec=".$fecha_fac."';
		  document.form1.submit();
		  '>
          </span>
		  </td>
		  <td>
		  </td>
		 </tr>
		 </table>
		</td>
		</tr>
		</table>
		";
		echo $tabla;
	}
	
	function articulo_seleccionada($detalle, $codigo,$conexion,$cod_compra_pen){
	    				
		$sql2="select * from almacen where cod_item = '$codigo'";
		$consulta2=@mysql_query($sql2,$conexion);
		$campos=@mysql_fetch_object($consulta2);
		$cant1=$campos->cant_stock;
		
		$tem="select sum(cantidad) As TOTAL from temporal where id_art= '$codigo' ";
		$tem2=@mysql_query($tem,$conexion);
		$tem3=@mysql_fetch_object($tem2);
		$cant2=$tem3->total;
		
		if($cod_compra_pen>0){
			$cantidad	= 100;
			$vr=$campos->costo;

		}else{
			$cantidad=$cant1-$cant2;
			$vr=$campos->precio;
			
		}
	
		$tabla = "
		<table width='800' border='0'>
		<tr>
		<td>
		  <table width='800' border='0'>
		  <tr>
		  <td width='146'><span class='Estilo6'>Articulo</span></td>
		  <td width='380'>
		  <input type='articulo' name='articulo' value= '$detalle' readonly size='60'>
		  </td>
		  <td width='260'><span class='Estilo6'>VALOR UNITARIO</span></td>
		  </tr>
		  <tr>
		  <td><span class='Estilo6'>Cantidad</span></td>
		  <td>
		  <input name='ver_cero' type='hidden' id='ver_cero'/>
		  <select name='ar_can' id='ar_can' onChange='document.form1.ar_can.selectedindex=0;document.form1.submit();'>
		  <option> Seleccione</option>
		  ";
		  for($i=1;$i<=$cantidad;$i++){
		  $tabla .= "
		  <option value=$i> $i </option>
		  ";
		  }
		  $tabla .="
		  </select>
	      </td>
		  <td rowspan='2'>
			<table width='208' border='1' bordercolor='#FF0000'>
			<tr>
			<td width='198'>
			 <div align='center'><span class='Estilo11'>$</span>
			";
			if($cod_compra_pen>0){
				$tabla .="
				<label>
				<input type='vr' name='vr' value='$vr' size='10' 
				style='font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC'>
				</label>
				";
			}else{
				$tabla .="
				<label>
				<input type='vr' name='vr' value='$vr' size='10' readonly
				style='font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC'>
				</label>
				";
			}
			$tabla .="
			 </div>
			</td>
			</tr>
			</table>
		  </td>
		  </tr>
		  <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  </table>
		</td>
		</tr>
		</table>
		";
		echo $tabla;
	}
	function mensaje_sin_articulos($detalle){
		echo("<script language=javascript> 
			alert('El Articulo $detalle NO registra existencias en stock');
			</script>");
	}
	
//Informacion
	
	function articulos_mas_vendidos($conexion){
		$titulo = "Articulos MAS Vendidos";
		
		$pos1	= 0;
		$pos2	= 1;
		$i		= 1;
		$con3	= 'select distinct id_art from ar_salida';
		$con2	= @mysql_query($con3,$conexion);
		while ($con=@mysql_fetch_object($con2)){
			$id = $con->id_art;
			
			$sum = "select sum(cantidad) total from ar_salida where id_art = '$id'";
			$sum2=@mysql_query($sum,$conexion);
			$sum3=@mysql_fetch_object($sum2);	
			
			$cant_total = $sum3->total;
			
			$nom = "select * from almacen where cod_item = '$id'";
			$nom2=@mysql_query($nom,$conexion);
			$nom3=@mysql_fetch_object($nom2);
			
			$nombre = $nom3->des_item;
			
			//Lleno Array Con los datos del listado de Proveedores
			$ar_mas_ven[] = array($i => array(	0 => "$nombre",
												1 => $cant_total, 
												2 => $id, 
											));
			
//			$ar_mas_ven = array ($i,"$nombre",$cant_total, $id);
			$i++;								
		}
		print_r ($ar_mas_ven);
		// $ar_mas_ven[asort]
		
		array_multisort($ar_mas_ven[][1], SORT_ASC, SORT_STRING,
						$ar_mas_ven[][1], SORT_NUMERIC, SORT_DESC);
		$tabla .="
			<table border = 1>
			<tr>
			 <td colspan='3'>
			 $titulo
			 </td>
			</tr>
			<tr>
			 <td> No.</td>
			 <td> Detalle</td>
			 <td> Cant Ventas</td>
			</tr>
		";
			
		
		for($i=1;$i<=10;$i++){
		$tabla .="
			<tr>
			<td>".$ar_mas_ven[$pos1][$pos2][2]."</td>
			<td>".$ar_mas_ven[$pos1][$pos2][0]."</td>
			<td>".$ar_mas_ven[$pos1][$pos2][1]."</td>
			</tr>
		";
		$pos1++;
		$pos2++;
		}
		$tabla .="
			</table>
		";
		echo $tabla;
		
	}

//TABLA DE MENSAJES
	function tabla_mensaje	($cod_mensaje,$txt_mensaje){
		if ($cod_mensaje == 1){ //Mensaje ERROR
			$icono = "<img src=../imagenes/icono_error.gif width='25' height='25' />";
			$color_fondo = "#CC0000";
			$estilo = "Estilo6";
		}
		if ($cod_mensaje == 2){ //Mensaje CORRECTO
			$icono = "<img src=../imagenes/check.gif width='25' height='25' />";
			$color_fondo = "#66FF66";
			$estilo = "Estilo6";
		}
		if ($cod_mensaje == 3){ //Mensaje WARNING
			$icono = "<img src=../imagenes/warning.gif width='25' height='25' />";
			$color_fondo = "#FFFF99";
			$estilo = "Estilo6";
		}
		$color_fondo = "FFFFFF";
		$tabla = "
		<table width='800' bgcolor='$color_fondo' border = '1'>
		<tr><td>
		<table>
		<tr>
		<td> $icono			</td>
		<td><span class='$estilo'> $txt_mensaje	</span></td>
		</tr>
		</table>
		</td></tr>
		</table>
		";
		echo $tabla;
	}
//Funcion Crear datos de la Factura DE MENSAJES	
	function datos_factura($listado,$conexion){
		
		//Crear Datos Factura compras
		$titulo	= "SELECCIONE LOS DATOS DE LA FACTURA";
		$ancho		= '800';
		$borde		= '1';
		$estilo		= 'Estilo6';
		$estilo1	= 'Estilo1';
		$cero		=   "0";
		
		$nom_campo1	=	"SELECCIONE PROVEEDOR";
		$id_campo1	= 	"proveedor";
		$tamano1	=	"40";
		
		$nom_campo2	=	"No. FACTURA DE COMPRA";
		$id_campo2	= 	"num_fac";
		$tamano2	=	"10";
		
		$nom_campo3	=	"FORMA DE PAGO";
		$id_campo3	= 	"form_pago";
		$tamano3	=	"10";
		
		$nom_campo4	=	"FECHA DE COMPRA";
		$id_campo4	= 	"fecha_compra";
		$tamano4	=	"10";
		
		$nom_campo5	=	"FECHA DE VENCIMIENTO";
		$id_campo5	= 	"fecha_vence";
		$tamano5	=	"10";
		
		//	print_r($listado);
		$cant_list = count($listado);
		//echo "<br>cant ".$cant_list;
		$x	=	0;
		$j	=	1;
		
		$fomato_fecha	= "yyyy-mm-dd";

			
		$tabla .="
		<table width=$ancho border=$borde>
		<tr>
			<td colspan='2'><div align='center'><span class=$estilo> $titulo</span></div></td>
		</tr>
		<tr>
			<td><span class=$estilo> $nom_campo1</span></td>
			<td>
			<select name='$id_campo1' id='$id_campo1'>
				<option> Seleccione</option>
				";
				for($i=0;$i<$cant_list;$i++){
					$cod_list		=	$listado[$x][1][0];
					$nom_list		=	$listado[$x][1][1];
		$tabla .="
					<option value='$cod_list'> $nom_list </option>
		";
					$x++;
					$j++;
				}
			//	onClick=window.location='". $link_envia."'>
		$tabla .="
			</select>			 
			</td>
		</tr>
		<tr>
			<td><span class=$estilo> $nom_campo2</span></td>
			<td><input name='$id_campo2' type='text' id='$id_campo2' size='$tamano2' value='$value_descr' onkeyUp='return ValNumero(this);'></td>
		</tr>
		<tr>
			<td colspan='2'>
			<table>
			<tr>
				<td><span class=$estilo> $nom_campo3</span></td>
				<td><span class=$estilo1>Contado<input type='radio' name='ver' checked onclick='form1.$id_campo5.disabled = true;' /></span></td>
				<td><span class=$estilo1>Credito<input type='radio' name='ver' onclick='form1.$id_campo5.disabled = false;' /></span></td>
			</tr>
			<tr>
				<td><span class=$estilo> $nom_campo4</span></td>
				<td>
				<input name='$id_campo4' type='text' id='$id_campo4' size='$tamano4' value='$value_descr' readonly onClick='popUpCalendar(this, form1.fecha_compra, ' $fomato_fecha' );'>
				</td>
				<td><span class=$estilo> $nom_campo5</span></td>
				<td>
				<input name='$id_campo5' type='text' id='$id_campo5' size='$tamano5' value='$value_descr' readonly disabled>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		";
		echo $tabla;
	}
?>