<?php
	session_start();
	//Llamado de Clases
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/modificar.php");
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

	//Llamado Clase JAVA Completar Texto
	echo $clase_java_completar;
		
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina();

//-----------------------------------------------------------------------------
//-----------CONTENIDO PAGINA--------------------------------------------------	
?>	
<? 
	//Encabezado Empresa;
	echo $encabezado_empresa;
	
	//Funcion Menu Para Articulos;
	$acti_menu_articulo 	= $_SESSION['act_menu_articulo'];
	
	@menu_gestion($acti_menu_articulo);
	
	//Capturo variable nuevo Articulo
	$act_ver_nue	= $_SESSION['act_ver_nue_art'];	
	$act_ver_mod 	= $_SESSION['act_ver_mod_art'];

//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------
//++++++++ Crear Nuevos Articulos +++++++++++++++++++++++++++++++++++++++++++
//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------
	if($act_ver_nue>0){
		//Tabla Mensaje
		if($act_crea_msj>0){
			@tabla_mensaje($valor_mensaje,$txt_mensaje);
		}	
		//echo "<br>cod_art ".$cod_pro_sig;
		//echo "<br>MENU ".$ban_env_url;
		@formulario_creacion($cod_pro_sig,$valo_art,$vacio,$ban_env_url,$nom_url_env);
	}
//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------
//++++++++ Modificar Articulos +++++++++++++++++++++++++++++++++++++++++++
//----------- ++++++++++++++++++++++++++++++++++++++++++++++ --------------------
	if($act_ver_mod>0){
		//Tabla Mensaje
		if($act_crea_msj>0){
			@tabla_mensaje($valor_mensaje,$txt_mensaje);
		}
		@formulario_creacion($cod_art_mod,$valo_art,$act_ver_mod);
	}	
?>	