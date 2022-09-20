<?php
//-Sesion 
	error_reporting(NULL);
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	require_once("control.php");		
	$con = new control;
	$con->conectar(); 
	$conexion = $con->conectar();	
	
//-Fecha	
	$fecha=date("Y-m-d");
	$fecha_ant = date("Y-m-d",strtotime("$from -7 day"));
	
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$mes=date("F");
	if ($mes=="January") $mes="Enero";
	if ($mes=="February") $mes="Febrero";
	if ($mes=="March") $mes="Marzo";
	if ($mes=="April") $mes="Abril";
	if ($mes=="May") $mes="Mayo";
	if ($mes=="June") $mes="Junio";
	if ($mes=="July") $mes="Julio";
	if ($mes=="August") $mes="Agosto";
	if ($mes=="September") $mes="Septiembre";
	if ($mes=="October") $mes="Octubre";
	if ($mes=="November") $mes="Noviembre";
	if ($mes=="December") $mes="Diciembre";
	$dia=date('d');
	$ano=date('Y');

//Capturo datos de Logeo 
	$cod_usu 			= 	$_SESSION['cod_usu'];
	$name_empleado	 	=	$_SESSION['name_empleado'];
	
//Codigo de Barra datos para crear
	$type_barcode		=	'code128';	
	$type_image			=	'png';

//Balance	
	$credito			= 	5000000;
	$balance			= 	0;

//Proveedor Inventario Inicial
	$inv_ini			=	99999;	
	$n_fac				=	0;

//cliente
	$cod_cli			= 	1;	

//Valor CERO
	$vacio				= 	0;
	
//-Titulo de Pagina
	$titulo_pagina = "Objetos";	//Prueba... no se utiliza en ningun lado

//-Pagina Actual
	$url_actual = $_SERVER["PHP_SELF"];
	$pagina_cliente 	= 'cliente';
	$pagina_proveedor 	= 'proveedor';
	
	//Nombre de pagina actual
	if ($url_actual	== '/achete/Admin/cliente.php' or 
		$url_actual	== '/achete/Admin/cliente2.php')
	{
		$pagina_actual = 'cliente';
	}
	if ($url_actual	== '/achete/Admin/proveedor.php' or
		$url_actual	== '/achete/Admin/proveedor2.php')
	{
		$pagina_actual = 'proveedor';
	}
	if ($url_actual	== '/achete/Admin/ventas.php' or
		$url_actual	== '/achete/Admin/ventas2.php')
	{
		$pagina_actual = 'ventas';
	}
	if ($url_actual	== '/achete/Admin/compras.php' or
		$url_actual	== '/achete/Admin/compras1.php' or
		$url_actual	== '/achete/Admin/compras2.php')
	{
		$pagina_actual = 'compras';
		if ($url_actual	== '/achete/Admin/compras1.php'){
			$valor_pagina = 1;
		}
		if ($url_actual	== '/achete/Admin/compras2.php'){
			$valor_pagina = 2;
		}

	}
	if ($url_actual	== '/achete/Admin/administrar.php')
	{	
		$pagina_actual = 'administrar';
	}
	if ($url_actual	== '/achete/Admin/inventario.php')
	{
		$pagina_actual = 'inventario';
	}
	if ($url_actual	== '/achete/Admin/articulo.php')
	{
		$pagina_actual = 'articulo';
	}
	if ($url_actual	== '/achete/Admin/departamento.php')
	{
		$pagina_actual = 'departamento';
	}	
	if ($url_actual	== '/achete/User/factura_user.php')
	{
		$pagina_actual = 'facturacion';
	}	
	
//Configuracion de la Tabla
//Ancho Tabla de Pagina
	$ancho_tabla	= 800;
	$Borde0			= 0;
	$Borde1			= 1;
//Contador Listado Proveedores
	$cont_prov		= 1;
	
//Variable Vacia Valor No Aplica
	$vacia			= 'N/A';		

//Posicion de Array
	$pos1			=	0;
	$pos2			=	1;	

//No aplica	
	$no_apli		= "N/A";

//Simbolo Dinero
	$sim_dinero		= "$";

//Codigo enviado para paginas clientes2 y proveedor2
	$cod_env_ges 	= $_GET['cod_ges'];
	//Variable que activa la paginacion para la lista de ventas y compras, desde proveedores y cllientes
	$can_ven_com	= $cod_env_ges;
	$campos_valor 	= $_GET['val_fin']; // Valor enviado desde la lista de gestion
//Capturo datos para modificacion
	$cod_ges_mod	=   $_GET['cod_tab_mod'];	

//Pago de Contado
	$pago_cont	= "Pago de Contado";

//Datos de Venta y Compra
	$cod_fac_asi		= $_GET['id_com'];
	$cod_fac_pen		= $_GET['id_pen'];
	$cod_fac_pen_pro	= $_GET['id_pro'];	
	$fec_fac_asi		= $_GET['fec'];
	$fec_ven_fac		= $_GET['fec_ven'];


//Capturo valor de la pagina enviado desde paginacion
	$pag_ver_tab = $_GET["pagina"];
	
//Capturo campo oculto para eliminar facturas
	if($_POST['eliminar_fac'] == "OK") 
	{
		$elm_factura_com = 1;
		$_SESSION['elm_factura_com'] = $elm_factura_com;
		$con_factura = 0;
		$_SESSION['continuar_fac'] = $con_factura;
	}
	$elm_factura_com = $_SESSION['elm_factura_com'];
	
	//Validacion Para el MENU de paginas ventas y compras
	//Listar Facturas
	if($cod_fac_pen>0){
		if($pag_ver_tab>0){
			if($elm_factura_com>0){
				$mos_fact = 0;
				$continuar_fac = 0;
			}else{
				$mos_fact = 1;
				$continuar_fac = 0;
			}	
		}else{
			$mos_fact = 1;
			$continuar_fac = 0;
		}
		//Validacion para borrar articulos y elminimar facturas de compras y ventas
		if($elm_factura_com>0) 
		{
			$mos_fact = 0;
			$continuar_fac = 0;
		}	
	}
	//Validacion para listas facturas y borrar el continuar factura, desactiva la bandera
	if($_POST['no_cont_fac'] == "OK") 
	{
		$con_factura = -1;
		$_SESSION['continuar_fac'] = $con_factura;
		$elm_factura_com = 0;
		$_SESSION['elm_factura_com'] = $elm_factura_com;
	}
	//Validacion para continuar factura activa la bandera
	if($_POST['continua_fac'] == "OK") 
	{
		$con_factura = 1;
		$_SESSION['continuar_fac'] = $con_factura;
		$elm_factura_com = 0;
		$_SESSION['elm_factura_com'] = $elm_factura_com;
		if ($pagina_actual == "compras"){
			$act_ver_nue_art = 1;
		}	
	}	
	//Validacion para nueva factura activa la bandera
	if($_POST['n_com'] == "OK"){
		$nue_factura = 0;
		$_SESSION['nue_factura'] = $nue_factura;
	}
	if($_POST['nueva_fact'] == "OK") 
	{
		$nue_factura = 1;
		$_SESSION['nue_factura'] = $nue_factura;
	}	
	
	//Continuar Facturas
	$cont_fact = $_SESSION['continuar_fac'];
	if($cont_fact>0){
		if($pag_ver_tab>0){
			$continuar_fac 	= 1;		
			$mostrar_fac_ped	= 1;
		}else{
			$continuar_fac 		= 1;
			$mostrar_fac_ped	= 1;
		}
	}

	//Nuevas Facturas
	$nuev_fact = $_SESSION['nue_factura'];
	if($nuev_fact>0){
		if($pag_ver_tab>0){
			$mostrar_fac_nueva	= 1;
		}else{
			$mostrar_fac_nueva	= 1;
		}
	}
	
	$var_articulo = $_POST['inputString'];
	list($codigo_art,$detalle_art)=split('[_]',$var_articulo);
	if (empty($var_articulo)){
		unset ($var_articulo);
	}else{
		//Valido que no se registre una articulo, sin ningun valor en la cantidad
		$cant_art_sel	=	$_POST['ar_can'];
		if ($cant_art_sel == "Seleccione"){
			$limpiar_var = 1;
		}else{
			$_SESSION['codigo_art'] = $codigo_art;
		}	
	}
	
	if($_POST['va_insertado'] == "OK"){
		$va_insertado = 1;		
	}

	if (isset($var_articulo)) {
		if($elm_factura_com>0){
			$mos_fact =-1;
			$continuar_fac 	= 0;
		}else{
			$mos_fact =-1;
			$continuar_fac 	= 1;
		}	
		if($va_insertado>0){
			$mostrar_regis		= -1;
			$mostrar_fac_ped 	= 1;
		}else{
			$mostrar_regis	= 1;
			$verificar_exi	= 1;
		}
	}
//-------------------------------------------------------------	
//Paginacion --------------------------------------
	//Cuando se haga la consulta por medio de la caja de texto
	$cant_entra_c_t = $_GET['cant_reg']; //Capturo la cantidad de registros buscados segun la caja de texto
	if($cant_entra_c_t>0){
		$act_ct_buscar = 1;
	  	$buscar_palabra = $_GET['pala_buscar'];
	}
	//Asigno el total de numero de registros a paginar
	if ($pagina_actual == 'proveedor'){
		$numeroRegistros = $cant_prov_total;
	}
	if ($pagina_actual == 'cliente'){
		if($cod_env_ges>0){
			$numeroRegistros = $cant_ven_cli_tot;
		}else{
			$numeroRegistros = $cant_cli_total;
		}
	}
	if ($pagina_actual == 'ventas'){
		if($cod_fac_asi>0){
			$numeroRegistros = $cant_ar_sal_total;
		}	
		if($cod_fac_pen>0){
			$numeroRegistros = $cant_ar_sal_total_tem;
		}	
	}
	if ($pagina_actual == 'compras'){
		if($cod_fac_asi>0){
			$numeroRegistros = $cant_ar_compra_total;
		}	
		if($cod_fac_pen>0){
			$numeroRegistros = $cant_ar_compra_total_tem;
		}	
	}
	if ($pagina_actual == 'departamento'){
		
		$numeroRegistros = $con_cant_departa;
		if($_POST['buscador'] == "OK"){
			$act_caja_buscador = 1;
			$buscar_palabra = $_POST['busco'];
		}
	}
	if($pagina_actual == 'facturacion'){
		$numeroRegistros = $cant_ar_sal_total_tem;
	}
	
	//tamaño de la pagina 
   	$tamPag=10; 
   	//pagina actual si no esta definida y limites 
   	if(!isset($_GET["pagina"])) 
   	{ 	
		//echo "paso 2";
		 $pagina=1; 
      	 $inicio=1; 
      	$final_pag=$tamPag; 
   	}else{
    	 $pagina = $_GET["pagina"]; 
   	}	 
   	//calculo del limite inferior 
	$limitInf=($pagina-1)*$tamPag; 
	if (isset($_POST['can'])){
		//echo "paso 3";
		$pagina=1; 
   	  	$inicio=1; 
   	  	$final_pag=$tamPag; 
		$limitInf=($pagina-1)*$tamPag;
	}
	//Si se presiono un dato de la lista de gestion
	if($cod_env_ges>0 or $cod_ges_mod>0){	
		if($campos_valor>0){
			$limitInf = $campos_valor;
		}	
	}
	
	//calculo del numero de paginas 
	$numPags=ceil($numeroRegistros/$tamPag); 
	if(!isset($pagina)) 
	{ 
		//echo "paso 4";
		 $pagina=1; 
    	 $inicio=1; 
    	 $final_pag=$tamPag; 
   	}else{ 
		 //echo "paso 5";
		 $seccionActual=intval(($pagina-1)/$tamPag); 
     	 $inicio=($seccionActual*$tamPag)+1; 
		
        if($pagina<$numPags) 
      	{ 	
			//echo "paso 6";
			$pos_lista = (($pagina-1)*$tamPag)+$inicio;	
         	$final_pag=$inicio+$tamPag-1; 
       	}else{ 
			//echo "paso 7";			
			$pos_lista = (($pagina-1)*$tamPag)+$inicio;
			$final_pag=$numPags; 
      	} 
		if ($final_pag>$numPags){ 
			//echo "paso 8";
			$pos_lista = (($pagina-1)*$tamPag)+$inicio;
          	$final_pag=$numPags; 
      	} 
   	}
//-------------------------------------------------------------		
//Textos para listado
	$txt_numero		= "No";
	$txt_ciudad		= "CIUDAD";			
	$txt_telefono	= "TELEFONO";			

//Datos para menu de gestion
	//Datos Para pagina CLIENTE
	if ($pagina_actual == 'cliente')
	{
		//Datos Cliente.php
		if($_POST['men_cliente'] == "OK")	
		{
			$valor = 7;
			$_SESSION['men_cliente'] = $valor;
		}	
		$nom_boton_nue = 'Nuevo Cliente';
		$nom_boton_lis = 'Listar Cliente';
		$nom_txt_busca = 'Buscar Cliente';
		$txt_gestion   = "NOMBRE CLIENTE";	
		$txt_mov	   = "VENTAS";
		$act_men_clie2 = 2;
		if($cod_ges_mod>0){
			$cre_titulo	   = "MODIFICAR CLIENTE";
			$nom_boton_cre = "Modificar Cliente";
		}else{
			$cre_titulo	   = "CREAR CLIENTE";
			$nom_boton_cre = "Crear Cliente";
		}
		$txt_contacto  = "CONTACTO";
		$ges_titulo	   = "VENTAS";
	}
	
	//Datos Para pagina PROVEEDOR
	if ($pagina_actual == 'proveedor')
	{
		//Datos Proveedor.php
		if($_POST['men_proveedor'] == "OK")	
		{
			$valor = 8;
			$_SESSION['men_proveedor'] = $valor;
		}
		$nom_boton_nue = 'Nuevo Proveedor';
		$nom_boton_lis = 'Listar Proveedor';
		$nom_txt_busca = 'Buscar Proveedor'; 
		$txt_gestion   = "NOMBRE PROVEEDOR";	
		$txt_mov	   = "COMPRAS";
		$act_men_pro2 = 2;
		if($cod_ges_mod>0){
			$cre_titulo	   = "MODIFICAR PROVEEDOR";
			$nom_boton_cre = "Modificar Proveedor";
		}else{
			$cre_titulo	   = "CREAR PROVEEDOR";
			$nom_boton_cre = "Crear Proveedor";
		}
		$ges_titulo	   = "COMPRAS";
		$txt_contacto  = "VENDEDOR";
	}
	
	//Datos Para pagina VENTAS
	if ($pagina_actual == 'ventas')
	{
		//Datos ventas.php
		if($_POST['men_ventas'] == "OK")	
		{
			$valor = 5;
			$_SESSION['men_ventas'] = $valor;
		}
		//Datos Ventas2.php
		$act_men_ventas2 = 2;
		$nom_boton_lis 	= 'Listar Ventas';
		$txt_contacto  	= "Cliente";
		$txt_vendedor  	= "Vendedor";	
		if($cod_fac_asi > 0){
			$txt_tit_enca	= "FACTURA VENTA";
		}
		if($cod_fac_pen > 0){
			$txt_tit_enca	= "FACTURA VENTA PENDIENTE";
		}
		$txt_codigo    	= "CODIGO";
		$txt_cantidad  	= "CANTIDAD";
		$txt_detalle   	= "DETALLE";
		$txt_var_uni	= "VR/UNI";
		$txt_var_tot	= "VR/TOTAL";
		if($elm_factura_com>0){
			//Valores de Encabezado de Tabla
			$txt_numero		= " "; 
			$txt_codigo		= "No";
		}
	}
	
	//Datos Para pagina COMPRAS
	if ($pagina_actual == 'compras')
	{
		//Activo cuadro para hacer una nueva compra
		if($_POST['n_com'] == "OK") 
		{
			$act_cuadro_nuevo = 1;
			$_SESSION['act_cuadro_nuevo'] = $act_cuadro_nuevo;
			$act_nueva_compra = 0;
			$_SESSION['act_nueva_compra'] = $act_nueva_compra;
		}
		//Boton Nuevo Articulo
		//Capturo campo oculto para crear una nueva factura, desde el boton "nueva compra"
		if($_POST['oc'] == "OK") 
		{
			$act_nueva_compra = 1;
			$_SESSION['act_nueva_compra'] = $act_nueva_compra;
			$act_cuadro_nuevo = 0;
			$_SESSION['act_cuadro_nuevo'] = $act_cuadro_nuevo;
			$_SESSION['ban_nue_art'] = 1;
		}
		//Guardo la URL actual de la factura 		
		if(empty($fec_ven_fac)){
			$enviar_url  = $pagina_actual.$valor_pagina.".php?id_pro=".$cod_fac_pen_pro."&fec=".$fec_fac_asi."&id_pen=".$cod_fac_pen;
		}else{
			$enviar_url  = $pagina_actual.$valor_pagina.".php?id_pro=".$cod_fac_pen_pro."&fec=".$fec_fac_asi."&fec_ven=".$fec_ven_fac."&id_pen=".$cod_fac_pen;
		}
		$_SESSION['gua_nom_url'] = $enviar_url;
		
		//Bandera para mostrar la creacion de un articulo nuevo desde la factura
		echo "<br>bandera ".$ban_nue_art	= $_SESSION['ban_nue_art'];
		if($ban_nue_art>0){
			$act_ver_nue_art = 1;
		}
		
		//Datos compras.php
		if($_POST['men_compras'] == "OK")	
		{
			$valor = 6;
			$_SESSION['men_compras'] = $valor;
		}
		//Datos compras2.php
		$nom_boton_lis 	= 'Listar Compras';
		$txt_contacto  	= "Cliente";
		$txt_vendedor  	= "Vendedor";	
		if($cod_fac_asi > 0){
			$txt_tit_enca	= "FACTURA COMPRA";
		}
		if($cod_fac_pen > 0){
			$txt_tit_enca	= "FACTURA COMPRA PENDIENTE";
		}
		$txt_codigo    	= "CODIGO";
		$txt_cantidad  	= "CANTIDAD";
		$txt_detalle   	= "DETALLE";
		$txt_var_uni	= "VR/UNI";
		$txt_var_tot	= "VR/TOTAL";
		if($elm_factura_com>0){
			//Valores de Encabezado de Tabla
			$txt_numero		= " "; 
			$txt_codigo		= "No";
		}
	}
	
	//Datos Para Pagina DEPARTAMENTOS
	if($pagina_actual == 'departamento'){
		$act_crea_msj		= $_SESSION['act_crea_msj'];
		if($_POST['men_departa'] == "OK")	
		{
			$valor = 9;
			$_SESSION['men_departa'] = $valor;
			//Activo Ver Listado
			$act_ver_listado = 1;
			$_SESSION['act_lis_depto'] = $act_ver_listado;
			//Desactivo Ver Nuevo
			$act_ver_nue = 0;
			$_SESSION['act_ver_nue'] = $act_ver_nue;
			//Desctivo Modifica Departamentos
			$act_mod_dep = 0;
			$_SESSION['act_mod_dep'] = $act_mod_dep;
			//Desactivo tabla de mensaje
			$_SESSION['act_crea_msj'] = 0;
			//Desactivo ver modificar datos
			$_SESSION['act_mod_tab'] = 0;
		}
		if($_POST['n_com'] == "OK"){ // Nuevo Departamento
			//Desactivo Ver Listado
			$act_ver_listado = 0;
			$_SESSION['act_lis_depto'] = $act_ver_listado;
			//Desctivo Modifica Departamentos
			$act_mod_dep = 0;
			$_SESSION['act_mod_dep'] = $act_mod_dep;
			//Activo Ver Nuevo
			$act_ver_nue = 1;
			$_SESSION['act_ver_nue'] = $act_ver_nue;
			//Desactivo tabla de mensaje
			$_SESSION['act_crea_msj'] = 0;
			//Desactivo ver modificar datos
			$_SESSION['act_mod_tab'] = 0;
		}
		if($_POST['btn_mod'] == "OK"){
			//Desactivo Ver Listado
			$act_ver_listado = 0;
			$_SESSION['act_lis_depto'] = $act_ver_listado;
			//Desctivo Ver Nuevo
			$act_ver_nue = 0;
			$_SESSION['act_ver_nue'] = $act_ver_nue;
			//Activo Modifica Departamentos
			$act_mod_dep = 1;
			$_SESSION['act_mod_dep'] = $act_mod_dep;
			//Desactivo tabla de mensaje
			$_SESSION['act_crea_msj'] = 0;
			//Desactivo ver modificar datos
			$_SESSION['act_mod_tab'] = 0;
		}
		$nom_txt_busca = 'Buscar Departamento';
		//Creo Datos para mensaje
		if($act_crea_msj >0 ){ 
			//Mensaje Error eliminar depto
			$act_msj_eli		= $_SESSION['act_eli'];	
			//Capturo los valores seleccionados
			$var_depar = $_SESSION['valores_array'];
			$cant_dep = count($var_depar);
			
			//Mensajes de Eliminar Departamentos
			if($act_crea_msj == 1 ){ 		
				//Datos Mensaje Error
				if($act_msj_eli == 1){
					if($cant_dep == 1){
						$mensaje1 = "No se puede eliminar el departamento ";
						$mensaje2 = " con articulos incluidos ";
					}		
					if($cant_dep > 1){
						$mensaje1 = "No se puede eliminar los departamentos (";
						$mensaje2 = ") con articulos incluidos ";
						$espacio  = ", ";
					}
					$valor_mensaje = 1;
				}
			
				//Datos Mensaje Correcto
				if($act_msj_eli == 2 OR $act_msj_eli == 3){
					if($cant_dep == 1){
						$mensaje1 = "El departamento ";
						$mensaje2 = " se elimino correctamente ";
					}	
					if($cant_dep > 1){
						$mensaje1 = "Los departamentos (";
						$mensaje2 = ") fueron eliminados satisfactoriamente ";
						$espacio  = ", ";
					}
					$valor_mensaje = 2;
					//Datos Mensaje Warning
					if($act_msj_eli == 3){
						$mensaje4 = ". No es posible borrar departamentos con articulos";	
						$valor_mensaje = 3;
					}
				}
			
				//Se crea el mensaje			
				if($cant_dep == 1){	
					$signo	 = $var_depar[0][0][0];
					$txt_mensaje = $mensaje1.$signo.$mensaje2.$mensaje4;
				}
				if($cant_dep > 1){
					$signo	 = $var_depar[0][0][0];
					$signo2	 = $var_depar[1][1][0];
					$signo3	 = $var_depar[2][2][0];
					if($cant_dep > 3){
						$puntos = "...";
					}
					$txt_mensaje = $mensaje1.$signo.$espacio.$signo2.$espacio.$signo3.$puntos.$mensaje2.$mensaje4;
				}
				if($act_msj_eli == 4){
					$txt_mensaje = "Es necesario seleccionar al menos un departamento ";
					$valor_mensaje = 3;
				}
			}
			//Mensajes de Nuevo Departamentos
			if($act_crea_msj == 2 ){
			
				//Mensaje de Correcto
				if($act_msj_eli == 2){
					$mensaje1 	= "El departamento ";	
					$mensaje2 	= " fue creado con exito";	
					$valor		= $var_depar[0][1][0];
					$valor_mensaje = 2;
				}
				//Mensaje de Warning
				if($act_msj_eli == 3){
					$mensaje1 	= "No es posible crear un departamento ";	
					$mensaje2 	= " porque ya existe";	
					$valor		= $var_depar[0][1][0];
					$valor_mensaje = 3;
				}
				$txt_mensaje = $mensaje1.$valor.$mensaje2;
			}
			//Mensajes de Nuevo Departamentos
			if($act_crea_msj == 3 ){
				//Mensaje de Correcto
				if($act_msj_eli == 2){
					$valor_mensaje = 2;
					if($cant_dep == 1){
						$mensaje1 	= "El departamento ";	
						$mensaje2 	= " fue modificado con exito";	
						$valor		= $var_depar[0][0][0];
						$txt_mensaje = $mensaje1.$valor.$mensaje2;
					}	
					if($cant_dep > 1){
						$mensaje1 = "Los departamentos (";
						$mensaje2 = ") fueron modificados con exito";
						$espacio  = ", ";
						$signo	 = $var_depar[0][0][0];
						$signo2	 = $var_depar[1][1][0];
						$signo3	 = $var_depar[2][2][0];
						if($cant_dep > 3){
							$puntos = "...";
						}
						$txt_mensaje = $mensaje1.$signo.$espacio.$signo2.$espacio.$signo3.$puntos.$mensaje2.$mensaje4;
					}
				}
				//Mensaje de Warning
				if($act_msj_eli == 3){
					$valor_mensaje = 3;
					$mensaje1 	= "No es posible modificar departamentos con el mismo nombre";	
					$txt_mensaje = $mensaje1;
				}
			}
			
		}	
	}
	
	//Datos Para Pagina INVENTARIO
	if($pagina_actual == 'inventario')
	{
		$act_crea_msj		= $_SESSION['act_crea_msj'];		
		if($_POST['menu_inven'] == "OK")	
		{
			$valor = 3;
			$_SESSION['act_menu_inventario'] = $valor;
			$_SESSION['continuar_fac'] 		= 0;
			//Deactivo mensaje
			$act_crea_msj = 0;
		}
		//Mensajes
		//Creo Datos para mensaje
		if($act_crea_msj >0 ){ 
			
			//Tipo de Mensaje
			$act_msj_eli		= $_SESSION['act_eli'];	
			//Valor Modifica	
			$mod_msj_ver		= $_SESSION['msj_ver_mod'];
			//Capturo los valores seleccionados
			$valo_art = $_SESSION['valores_array'];
			$cant_art = count($valo_art);
			
			//Mensajes Articulo Nuevo
			if($act_crea_msj == 1 ){ 
				if($mod_msj_ver == 1){
					$tit_msj	= "modificado";
				}
				if($mod_msj_ver == 2){
					$tit_msj	= "creado";
				}
				//Datos Mensaje Correcto
				if($act_msj_eli == 2){
					$mensaje1 	= "El articulo ";	
					$mensaje2 	= " fue $tit_msj con exito, con numero de codigo ";	
					$mensaje3 	= " en el departamento ";	
					$valor		= $valo_art[0][1][0];
					$valor2		= $valo_art[0][1][1];
					$valor3		= $valo_art[0][1][2];
					$valor_mensaje = 2;
					$txt_mensaje = $mensaje1.$valor.$mensaje2.$valor2.$mensaje3.$valor3;
				}
			}	
		}
	}

	//Datos Para Pagina ARTICULO
	if($pagina_actual == 'articulo')
	{
		$act_crea_msj		= $_SESSION['act_crea_msj'];
		
		//Capturo valor para cuando se oprimen los botones de factura
		if($_POST['mostrar_menu'] == "OK" or $_POST['crea_vol_fac'] == "OK"){
			$_SESSION['mostrar_botones'] = 	1;
		}
		$ver_bot = $_SESSION['mostrar_botones'];	
		if($ver_bot > 0){
			$mostrar_botones = 1;
		}
		
		//Capturo URL a enviar despues de crear articulo, si se estaba haciendo factura
		if($mostrar_botones > 0){
			$nom_url_env	=	$_SESSION['gua_nom_url'];
			$ban_env_url	=	$mostrar_botones;
		}	
		
		//Boton Nuevo Articulo
		if($_POST['men_productos'] == "OK")	
		{
			$valor = 4;
			$_SESSION['act_menu_articulo'] = $valor;
			
			$act_ver_nue = 1;
			$_SESSION['act_ver_nue_art'] = $act_ver_nue;
			//Deactivo mensaje
			$act_crea_msj = 0;
			$_SESSION['act_ver_mod_art'] = 0;
			//Deactivo la bandera de mostrar la creacion de un nuevo articulo desde compras
			$_SESSION['ban_nue_art'] = 0;
		}
		//Boton Modificar Articulo
		if($_POST['mod_articulo'] == "OK")	
		{
			$act_ver_mod = 1;
			$_SESSION['act_ver_mod_art'] = $act_ver_mod;
			
			$valor = 4;
			$_SESSION['act_menu_articulo'] = $valor;
			
			$_SESSION['act_ver_nue_art'] = 0;
			$cod_art_mod 	= $_SESSION['cod_art_mod'];
			$valo_art 		= $_SESSION['valores_array'];
			//Deactivo mensaje
			$act_crea_msj = 0;
		}
		
		//Capturo Valor del articulo para cuando se envia desde inventario 
		if($cod_fac_pen_pro > 0){
			$valor = 4;
			$_SESSION['act_menu_articulo'] = $valor;
		}
		
		//Mensajes
		//Creo Datos para mensaje
		if($act_crea_msj >0 ){ 
			
			//Tipo de Mensaje
			$act_msj_eli		= $_SESSION['act_eli'];	
			//Valor Modifica	
			$mod_msj_ver		= $_SESSION['msj_ver_mod'];
			
			//Capturo los valores seleccionados
			$valo_art = $_SESSION['valores_array'];
			//print_r($valo_art);
			$cant_art = count($valo_art);
			
			//Mensajes Articulo Nuevo
			if($act_crea_msj == 1 ){ 
				
				if($mod_msj_ver == 1){
					$tit_msj	= "modificar";
					$valor_mensaje = 1;
				}
				
				if($mod_msj_ver == 2){
					$tit_msj	= "crear";
					$valor_mensaje = 3;
				}
				//Datos Mensaje Correcto
				if($act_msj_eli == 3){
					$mensaje1 	= "No es posible $tit_msj el articulo ";	
					$mensaje2 	= ", porque ya existe en el departamento ";	
					$valor		= $valo_art[0][1][0];
					$valor2		= $valo_art[0][1][1];
					$txt_mensaje = $mensaje1.$valor.$mensaje2.$valor2;
				}
				if($act_msj_eli == 1){ //Departamento no existe
					$mensaje1 	= "Seleccione un departamento valido ";	
					$valor_mensaje = 1;
					$txt_mensaje = $mensaje1;
				}
			}
		}
	}
	//Datos Para Pagina ADMINISTRAR	
	if($pagina_actual == 'administrar')
	{
		if($_POST['menu_admin'] == "OK")	
		{
			$act_menu_admin = 1;
			//Dejo en 0 la sesion de eliminar factura y continuar
			$_SESSION['elm_factura_com'] 	= 0;
			$_SESSION['continuar_fac'] 		= 0;
		}
	}
	//Datos Para pagina FACTURACION USUARIO
	if($pagina_actual == 'facturacion'){
		$act_men_fac_user	=	10;
		$txt_contacto  		= "Cliente";
		$txt_vendedor  		= "Vendedor";
		$txt_tit_enca	= "FACTURA VENTA";
		$txt_codigo    	= "CODIGO";
		$txt_cantidad  	= "CANTIDAD";
		$txt_detalle   	= "DETALLE";
		$txt_var_uni	= "VR/UNI";
		$txt_var_tot	= "VR/TOTAL";
		//Datos por defecto para vendedor y empleado
		if($_GET['v_def'] > 0 or $_GET['pagina'] > 0){
			$datos_defecto 		= 1;
			$cliente_defecto	= 1;
			$ins_default		=	$_GET['v_def'];
		}
	}
	
	//Volver a la factura desde crear articulo
	if($_POST['volver_fact'] == "OK") 
	{
		$gua_nom_url = $_SESSION['gua_nom_url'];
		$_SESSION['ban_nue_art'] = 1;
		echo("<script language=javascript>
		location.href='$gua_nom_url';
		</script>");
	}
	
	if($_POST['guarda_url'] == "SI") 
	{
		//En la pagina articulo muestra los botones para volver a la factura
		$mostrar_botones = 1;
	}elseif($_POST['guarda_url'] == "NO"){
		//Borro todas las variables que me hacen mostrar los botones de factura
		$mostrar_botones = 0;
		$_SESSION['mostrar_botones'] = 	0;
	}
		
	//Validar una nueva factura
	if($_POST['nueva_fac'] == "OK") 
	{
		$no_sig = $con -> num_factura_siguiente($conexion);
		$vr_def = 123;
		$_SESSION['continuar_fac'] = 0;
		echo("<script language=javascript>
			location.href='factura_user.php?id_pen=$no_sig&fec=$fecha&v_def=$vr_def';
		</script>");
	}
	
	//Cerrar Sesion
	$cerrar_sesion 	= $_GET['cerrar_sesion'];
	if($cerrar_sesion>0){
//		session_start();
		session_unset();
		session_destroy();
		echo("<script language=javascript>
			location.href='../index.php';
		</script>");
	}
	

?>
