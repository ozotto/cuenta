<?php
	session_start();
	//Llamado de Clases
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/modificar.php");
	include ("../clases/eliminar.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	
	//Creacion de Objeto
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	//Inicio HTML
	@inicio_html($pagina_actual);
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
	
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina();

//-----------------------------------------------------------------------------
//-----------CONTENIDO PAGINA--------------------------------------------------	
?>	
<? 
	//Encabezado Empresa;
	echo $encabezado_empresa;
	
	$acti_ver_listado 	= $_SESSION['act_lis_depto']; 	//Boton Listado
	$acti_ver_nuevo 	= $_SESSION['act_ver_nue'];		//Boton Nuevo
	$acti_ver_modificar	= $_SESSION['act_mod_dep'];		//Boton Ver Modificar
	$acti_mod_tabla		= $_SESSION['act_mod_tab'];		//Boton Modificar datos
	
	//Funcion Menu Para Departamento;	
	$act_men_departa 	= $_SESSION['men_departa'];
	@menu_gestion($act_men_departa,$acti_ver_nuevo,$acti_ver_modificar);
	//++++++++++++++++++++++++++++++++++++++++++++++	
	//Listado de Departamentos
	//++++++++++++++++++++++++++++++++++++++++++++++	
	if($acti_ver_listado==1){ 
		//Buscar Departamento
		echo $buscar_caja_texto;
		if($act_crea_msj>0){
			@tabla_mensaje($valor_mensaje,$txt_mensaje);
		}
		//Cabecera tabla Departamento
		@cabecera_listado($acti_ver_listado);
		//Funcion para listar los Departamento ;
		for($cont=1; $cont<=$cant_departamento; $cont++){
			@listar_ges_4_col($acti_ver_listado,$pos1, $pos2, $list_departamento,$pos_lista);
			$pos1++;
			$pos2++;
			$pos_lista++;
		}
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag, $numPags, $act_ct_buscar, $buscar_palabra, $con_cant_departa);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++	
	//Crear Nuevos Departamentos
	//++++++++++++++++++++++++++++++++++++++++++++++	
	if($acti_ver_nuevo == 1){
		@formulario_crear($acti_ver_nuevo);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++	
	//Modificar Departamentos
	//++++++++++++++++++++++++++++++++++++++++++++++	
	if($acti_ver_modificar == 1){
		//Buscar Departamento
		echo $buscar_caja_texto;
		//Menu Modificar_Eliminar
		$vr_menu_eliminar	= 2;
		@menu_eliminar($vr_menu_eliminar);
		if($act_crea_msj>0){
			@tabla_mensaje($valor_mensaje,$txt_mensaje);
		}
		//Cabecera tabla Departamento
		@cabecera_listado($acti_ver_listado,$acti_ver_modificar);
		//Funcion para listar los Departamento ;
		for($cont=1; $cont<=$cant_departamento; $cont++){
			@listar_ges_4_col($acti_ver_listado,$pos1, $pos2, $list_departamento,$pos_lista,$acti_ver_modificar,$acti_mod_tabla);
			$pos1++;
			$pos2++;
			$pos_lista++;
		}
		//Tabla Paginacion
		@tabla_paginacion($pagina, $inicio, $final_pag, $numPags, $act_ct_buscar, $buscar_palabra, $con_cant_departa);
	}
?>
<?	
//-----------------------------------------------------------------------------	
//-----------FIN PAGINA--------------------------------------------------	
	//Funcion FIN del Diseño BODY	
	@fin_dise_pagina();	
?>
