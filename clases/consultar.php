<?
//-Sesion 
	error_reporting(NULL);
	Session_start (); 	
	
	//session_start();
	require_once ('control.php');
	require_once ('datos.php');
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
		
	//--- Consultar datos empleado
	$sql4="select * from empleado where cod_usu = '$cod_usu'";
	$empl=@mysql_query($sql4,$conexion);
	$empl2=@mysql_fetch_object($empl);
	$numrto =mysql_num_rows($empl); 	
	
	$cod_empresa =	$empl2->cod_empresa;
	$cod_emple	 = 	$empl2->cod_empleado;

//------------------------------------------------------------------------------------------------------------------------------------------------------	
//--- Consultar tabla EMPRESA
	$sql3="select * from empresa where cod_empresa = '$cod_empresa'";
	$emp=@mysql_query($sql3,$conexion);
	$emp3=@mysql_fetch_object($emp);
	
	//Nombre Empresa
	$nom_empr	=	$emp3->name_empresa;
	//Direccion Empresa
	$dir_empr	=	$emp3->direcc1;
	//No Telefono Empresa
	$tel_empr	=	$emp3->nro_telefo;
	//Numero NIT Empresa
	$nit_empr	=	$emp3->nro_tribut;
	//Nombre de ciudad Empresa
	$ciu_empr 	= 	$emp3->ciudad;
	//Nombre de Departamento Empresa
	$dep_empr 	= 	$emp3->state;
	//Nombre de Pais Empresa
	$pai_empr 	= 	$emp3->pais;
	//Nombre Contacto o Vendedor de la empresa
	$ven_empr 	= 	$emp3->vendedor;
	//Direccion Logo Empresa
	$di_log_emp = 	"../imagenes/logo_gif.gif";

	if($cod_fac_asi > 0){
		//--Consulta datos AR_SALIDA	
		$con_sal3			= "select * from ar_salida where num_factura = '$cod_fac_asi' and fecha_venta = '$fec_fac_asi'";
		$cod_fac_enc		= $cod_fac_asi;
	}	
	if($cod_fac_pen > 0){
		//--Consulta datos TEMPORAL
		$con_sal3			= "select * from temporal where num_factura = '$cod_fac_pen' and fecha_factura = '$fec_fac_asi'";
		$cod_fac_enc		= $cod_fac_pen;
	}	
		$con_sal2			= @mysql_query($con_sal3,$conexion);
		$con_sal			= @mysql_fetch_object($con_sal2);
	
		if($datos_defecto>0){
			$cod_emp_ven = $_SESSION['no_emple'];
			$cod_cli_ven = $cliente_defecto;
		}else{
			//Codigo Empleado
			$cod_emp_ven = $con_sal->cod_empleado;
			//Codigo Cliente
			$cod_cli_ven = $con_sal->cod_cli;
		}	
	
		//Consulto nombre Vendedor	
		$con_emple3="select * from empleado where cod_empleado = '$cod_emp_ven'";
		$con_emple2=@mysql_query($con_emple3,$conexion);
		$con_emple=@mysql_fetch_object($con_emple2);	
	
		$nom_empl_fac = $con_emple->name_empleado;
		$nom_empl_fac = strtolower($nom_empl_fac); 		
		$nom_empl_fac = ucwords($nom_empl_fac);	
	
		//Consulto nombre Cliente
		$con_clien3="select * from clientes where cod_cli = '$cod_cli_ven'";
		$con_clien2=@mysql_query($con_clien3,$conexion);
		$con_clien=@mysql_fetch_object($con_clien2);	
	
		$nom_clien_fac = $con_clien->name_cli;
		$nom_clien_fac = strtolower($nom_clien_fac); 		
		$nom_clien_fac = ucwords($nom_clien_fac);	
	$i = 1;
//-Array con informacion de Ventas	
	$list_info_empr[] = array($i => array(	0 => $cod_empresa,
											1 => "$nom_empr",
											2 => "$ciu_empr",
											3 => $tel_empr,
											4 => $nom_clien_fac,
											5 => $nit_empr, //ver que es que publica
											6 => $nit_empr, 
											7 => $dir_empr,
											8 => $dep_empr,
											9 => $pai_empr,
											14 => $cod_fac_enc,
											15 => $fec_fac_asi,
											16 => $nom_empl_fac,
										));

//------------------------------------------------------------------------------------------------------------------------------------------------------										
//--- Consultar datos PROVEEDOR
	$sql_pro="select * from proveedor where cod_pro = '$cod_fac_pen_pro'";
	$sql_pro2=@mysql_query($sql_pro,$conexion);
	$sql_pro3=@mysql_fetch_object($sql_pro2);
	
	//Nombre Proveedor
	$nom_prov		=	$sql_pro3->name_pro;
	$nom_prov 		= 	strtolower($nom_prov); 		
	$nom_prov		= 	ucwords($nom_prov);
	
	//Direccion Proveedor
	$dir_prov		=	$sql_pro3->direcc1;
	
	//No Telefono Proveedor
	$tel_prov		=	$sql_pro3->nro_telefo;
	
	//Numero NIT Proveedor
	$nit_prov		=	$sql_pro3->nro_tribut;
	
	//Nombre de ciudad Proveedor
	$cod_ciu_prov 	= 	$sql_pro3->cod_ciudad;
	$nom_ciu_prov 	= 	$con -> bus_nom_ciudad($cod_ciu_prov,$conexion);
	$nom_ciu_prov 	= 	strtolower($nom_ciu_prov); 		
	$nom_ciu_prov	= 	ucwords($nom_ciu_prov);
	
	//Nombre de Departamento Proveedor
	$cod_dep_prov 	= 	$sql_pro3->cod_provincia;
	$nom_dep_prov 	= 	$con -> bus_nom_provincia($cod_dep_prov,$conexion);
	$nom_dep_prov 	= 	strtolower($nom_dep_prov); 		
	$nom_dep_prov	= 	ucwords($nom_dep_prov);
	
	//Nombre de Pais Proveedor
	$cod_pai_prov 	= 	$sql_pro3->cod_pais;
	$nom_pai_prov 	= 	$con -> bus_nom_pais($cod_pai_prov,$conexion);	
	$nom_pai_prov 	= 	strtolower($nom_pai_prov); 		
	$nom_pai_prov	= 	ucwords($nom_pai_prov);
	
	//Nombre Contacto o Vendedor de la Proveedor
	$ven_prov 	= 	$sql_pro3->vendedor;	
	$ven_prov 	= 	strtolower($ven_prov); 		
	$ven_prov	= 	ucwords($ven_prov);
	
	//Nombre de mi empresa para facturacion del proveedor
	$nom_emp_enpro	= 	$nom_empr;
	$nom_emp_enpro 	= 	strtolower($nom_emp_enpro); 		
	$nom_emp_enpro	= 	ucwords($nom_emp_enpro);
	
	if($cod_fac_asi > 0){
		$cod_fac_enc		= $cod_fac_asi;
	}	
	if($cod_fac_pen > 0){
		$cod_fac_enc		= $cod_fac_pen;
	}	
			
	//Nombre del Vendedor del Proveedor
	$nom_ven_pro		=	$sql_pro3->vendedor;
	$nom_ven_pro 		= 	strtolower($nom_ven_pro); 		
	$nom_ven_pro		= 	ucwords($nom_ven_pro);
	
	//-Array con informacion de Ventas	
	$i = 1;
	//unset($list_info_prov);
	$list_info_prov[] = array($i => array(	0 => $cod_fac_pen_pro,
											1 => "$nom_prov",
											2 => "$nom_ciu_prov",
											3 => $tel_prov,
											4 => $nom_emp_enpro,
											6 => $nit_prov,
											7 => $dir_prov,
											8 => $nom_dep_prov,
											9 => $nom_pai_prov,
											14 => $cod_fac_enc,
											15 => $fec_fac_asi,
											16 => $nom_ven_pro,
										));
	
//------------------------------------------------------------------------------------------------------------------------------------------------------	
//-- Armo Factura AR_SALIDA
	//Consulta tabla AR_SALIDA
	$cant_sali = "select * from ar_salida where num_factura = '$cod_fac_asi' and fecha_venta = '$fec_fac_asi'";
	$cant_sali2 = @mysql_query($cant_sali,$conexion); 
	$cant_ar_sal_total = @mysql_num_rows($cant_sali2);

	$i = 1;
	//Datos de Factura
//	$con_sal_fac3			= "select * from ar_salida where num_factura = '$cod_fac_asi' and fecha_venta = '$fec_fac_asi'";
	$con_sal_fac3			= 'select * from ar_salida where num_factura = "'.$cod_fac_asi.'" 
								and fecha_venta = "'.$fec_fac_asi.'" order by fecha_venta asc limit '.$limitInf.','.$tamPag;
	$con_sal_fac2			= @mysql_query($con_sal_fac3,$conexion);
	$cant_art_fac_ven 		= mysql_num_rows($con_sal_fac2);
	
	while ($con_sal=@mysql_fetch_object($con_sal_fac2)){
	//Codigo de Articulo
	$cod_art_ven = $con_sal->id_art;
	
	//Nombre de Articulo
	$nom_art_ven3 = "select * from almacen where cod_item = '$cod_art_ven'";
	$nom_art_ven2 = @mysql_query($nom_art_ven3,$con->conectar()); 
	$nom_art_ven4 = @mysql_fetch_object($nom_art_ven2);
	
	$nom_art_ven = $nom_art_ven4->des_item;
	$nom_art_ven = strtolower($nom_art_ven); 		
	$nom_art_ven = ucwords($nom_art_ven);
	
	//Cantidad de Articulo
	$can_art_ven = $con_sal->cantidad;	
	
	//Valor Venta de articulo
	$val_art_uni = $con_sal->vr_venta;	
	$val_art_uni = number_format($val_art_uni, 0, ",", ".");
	$val_art_uni = $sim_dinero." ".$val_art_uni;
	
	//Valor Total de articulo
	$val_art_tot = $con_sal->vr_total;	
	$val_art_tot = number_format($val_art_tot, 0, ",", ".");
	$val_art_tot = $sim_dinero." ".$val_art_tot;
	
	//Suma Parcial
	$val1 = $con_sal->vr_total;
	$val2 = $sum_par_factura;
	$sum_par_factura =  $val1 + $val2;
	
	$list_fac_ven[] = array($i => array(	1 => $cod_art_ven,
											2 => $can_art_ven,
											3 => "$nom_art_ven",
											4 => "$val_art_uni",
											5 => "$val_art_tot",
										));
	$i++;
	}

	$sum_par_factura = number_format($sum_par_factura, 0, ",", ".");
	//Suma Factura 
	$sum_tot_fac_ven3 	= "select sum(vr_total) total from ar_salida where num_factura = '$cod_fac_asi' and fecha_venta = '$fec_fac_asi'";
	$sum_tot_fac_ven2	= @mysql_query($sum_tot_fac_ven3,$conexion);
	$sum_tot_fac_ven	= @mysql_fetch_object($sum_tot_fac_ven2);
	
	$suma_tot_fac_venta = $sum_tot_fac_ven->total;
	$suma_tot_fac_venta = number_format($suma_tot_fac_venta, 0, ",", ".");

//------------------------------------------------------------------------------------------------------------------------------------------------------		
//-- Armo Factura COMPRAS, Esta Array se mostrara en compras2.php
	//Consulta tabla COMPRAS
	$cant_compras  = "select * from compras where num_factura = '$cod_fac_asi' and fecha_compra = '$fec_fac_asi'";
	$cant_compras2 = @mysql_query($cant_compras,$conexion); 
	$cant_ar_compra_total = @mysql_num_rows($cant_compras2);

	$i = 1;
	//Datos de Factura Compra
	$con_compra_fac3		= 'select * from compras where num_factura = "'.$cod_fac_asi.'" 
								and fecha_compra = "'.$fec_fac_asi.'" order by fecha_compra asc limit '.$limitInf.','.$tamPag;
	$con_compra_fac2		= @mysql_query($con_compra_fac3,$conexion);
	$cant_art_fac_compra	= mysql_num_rows($con_compra_fac2);
	
	while ($con_sal=@mysql_fetch_object($con_compra_fac2)){
	//Codigo de Articulo compra
	$cod_art_com = $con_sal->id_art;
	
	//Nombre de Articulo compra
	$nom_art_com = $con_sal->detalle;
	$nom_art_com = strtolower($nom_art_com); 		
	$nom_art_com = ucwords($nom_art_com);
	
	//Cantidad de Articulo compra
	$can_art_com = $con_sal->cantidad;	
	
	//Valor Venta de articulo compra
	$val_art_uni_com = $con_sal->vr_costo;	
	$val_art_uni_com = number_format($val_art_uni_com, 0, ",", ".");
	$val_art_uni_com = $sim_dinero." ".$val_art_uni_com;
	
	//Valor Total de articulo compra
	$val_art_tot_com = $con_sal->vr_total;	
	$val_art_tot_com = number_format($val_art_tot_com, 0, ",", ".");
	$val_art_tot_com = $sim_dinero." ".$val_art_tot_com;
	
	//Suma Parcial Factura Compra
	$val1_com = $con_sal->vr_total;
	$val2_com = $sum_par_factura_compra;
	$sum_par_factura_compra =  $val1_com + $val2_com;
	
	$list_fac_com[] = array($i => array(	1 => $cod_art_com,
											2 => $can_art_com,
											3 => "$nom_art_com",
											4 => "$val_art_uni_com",
											5 => "$val_art_tot_com",
										));
	$i++;
	}

	$sum_par_factura_compra = number_format($sum_par_factura_compra, 0, ",", ".");
	//Suma Total Factura de Compras
	$sum_tot_fac_com3 	= "select sum(vr_total) total from compras where num_factura = '$cod_fac_asi' and fecha_compra = '$fec_fac_asi'";
	$sum_tot_fac_com2	= @mysql_query($sum_tot_fac_com3,$conexion);
	$sum_tot_fac_com	= @mysql_fetch_object($sum_tot_fac_com2);
	
	$suma_tot_fac_compra = $sum_tot_fac_com->total;
	$suma_tot_fac_compra = number_format($suma_tot_fac_compra, 0, ",", ".");
	
//------------------------------------------------------------------------------------------------------------------------------------------------------	
//-- Armo Factura TEMPORAL

	//Consulta tabla TEMPORAL
	$cant_sali_tem = "select * from temporal where num_factura = '$cod_fac_pen' and fecha_factura = '$fec_fac_asi'";
	$cant_sali_tem2 = @mysql_query($cant_sali_tem,$conexion); 
	$cant_ar_sal_total_tem = @mysql_num_rows($cant_sali_tem2);

	$i = 1;
	//Datos de Factura
	$con_sal_fac_tem3			= 'select * from temporal where num_factura = "'.$cod_fac_pen.'" 
								and fecha_factura = "'.$fec_fac_asi.'" order by fecha_factura asc limit '.$limitInf.','.$tamPag;
	$con_sal_fac_tem2			= @mysql_query($con_sal_fac_tem3,$conexion);
	$cant_art_fac_ven_tem		= mysql_num_rows($con_sal_fac_tem2);
	
	while ($con_sal_tem=@mysql_fetch_object($con_sal_fac_tem2)){
	//Codigo de Articulo
	$cod_art_ven = $con_sal_tem->id_art;
	
	//Nombre de Articulo	
	$nom_art_ven = $con_sal_tem->detalle;
	$nom_art_ven = strtolower($nom_art_ven); 		
	$nom_art_ven = ucwords($nom_art_ven);
	
	//Cantidad de Articulo
	$can_art_ven = $con_sal_tem->cantidad;	
	
	//Valor Venta de articulo
	$val_art_uni = $con_sal_tem->vr_venta;	
	$val_art_uni = number_format($val_art_uni, 0, ",", ".");
	$val_art_uni = $sim_dinero." ".$val_art_uni;
	
	//Valor Total de articulo
	$val_art_tot = $con_sal_tem->vr_total;	
	$val_art_tot = number_format($val_art_tot, 0, ",", ".");
	$val_art_tot = $sim_dinero." ".$val_art_tot;
	
	//Suma Parcial
	$val1 = $con_sal_tem->vr_total;
	$val2 = $sum_par_factura_tem;
	$sum_par_factura_tem =  $val1 + $val2;
	
	//Codigo Unico Posicion del Articulo
	$cod_art_posci = $con_sal_tem->id_tem;
	
	$list_fac_ven_tem[] = array($i => array(	1 => $cod_art_ven,
												2 => $can_art_ven,
												3 => "$nom_art_ven",
												4 => "$val_art_uni",
												5 => "$val_art_tot",
												6 => $cod_art_posci,
											));
	$i++;
	}

	$sum_par_factura_tem = number_format($sum_par_factura_tem, 0, ",", ".");
	
	//Suma Factura 
	$sum_tot_fac_ven_tem3 	= "select sum(vr_total) total from temporal where num_factura = '$cod_fac_pen' and fecha_factura = '$fec_fac_asi'";
	$sum_tot_fac_ven_tem2	= @mysql_query($sum_tot_fac_ven_tem3,$conexion);
	$sum_tot_fac_ven_tem	= @mysql_fetch_object($sum_tot_fac_ven_tem2);
	
	$suma_tot_fac_venta_tem = $sum_tot_fac_ven_tem->total;
	$suma_tot_fac_venta_tem = number_format($suma_tot_fac_venta_tem, 0, ",", ".");

//------------------------------------------------------------------------------------------------------------------------------------------------------
//-- Armo Factura COMPRA_TEMPORAL

	//Consulta tabla compra_temporal

	$con_compra_tem 			= "select * from compra_temporal where num_factura = '$cod_fac_pen' and fecha_compra = '$fec_fac_asi'";
	$con_compra_tem2 			= @mysql_query($con_compra_tem,$conexion); 
	$cant_ar_compra_total_tem 	= @mysql_num_rows($con_compra_tem2);

	$i = 1;
	//Datos de Factura compra temporal
	$con_compra_fac_tem3		= 'select * from compra_temporal where num_factura = "'.$cod_fac_pen.'" 
								and fecha_compra = "'.$fec_fac_asi.'" order by fecha_compra asc limit '.$limitInf.','.$tamPag;
	$con_compra_fac_tem2		= @mysql_query($con_compra_fac_tem3,$conexion);
	$cant_art_fac_compra_tem	= @mysql_num_rows($con_compra_fac_tem2);
	
	while ($con_com_tem=@mysql_fetch_object($con_compra_fac_tem2)){
	
	//Codigo de Articulo compra temporal
	$cod_art_com = $con_com_tem->id_art;
	
	//Nombre de Articulo compra temporal	
	$nom_art_com = $con_com_tem->detalle;
	$nom_art_com = strtolower($nom_art_com); 		
	$nom_art_com = ucwords($nom_art_com);
	
	//Cantidad de Articulo compra temporal
	$can_art_com = $con_com_tem->cantidad;	
	
	//Valor Venta de articulo compra temporal
	$val_art_uni_com = $con_com_tem->vr_costo;	
	$val_art_uni_com = number_format($val_art_uni_com, 0, ",", ".");
	$val_art_uni_com = $sim_dinero." ".$val_art_uni_com;
	
	//Valor Total de articulo
	$val_art_tot_com = $con_com_tem->vr_total;	
	$val_art_tot_com = number_format($val_art_tot_com, 0, ",", ".");
	$val_art_tot_com = $sim_dinero." ".$val_art_tot_com;
	
	//Suma Parcial Fcatura compras
	$val_1[] = $con_com_tem->vr_total;
	
	//Codigo Unico Posicion del Articulo
	$cod_art_posci = $con_com_tem->id_tem_c;
	
	$list_fac_com_tem[] = array($i => array(	1 => $cod_art_com,
												2 => $can_art_com,
												3 => "$nom_art_com",
												4 => "$val_art_uni_com",
												5 => "$val_art_tot_com",
												6 => $cod_art_posci,
											));
	$i++;
	}

	$sum_par_factura_tem_com = 0;
	for($i=0; $i<$cant_art_fac_compra_tem; $i++){
		$sum_par_factura_tem_com = $sum_par_factura_tem_com + $val_1[$i];
	}
	$sum_par_factura_tem_com = number_format($sum_par_factura_tem_com, 0, ",", ".");
	
	//Suma Total Factura compra temporal
	$sum_tot_fac_com_tem3 	= "select sum(vr_total) total from compra_temporal where num_factura = '$cod_fac_pen' and fecha_compra = '$fec_fac_asi'";
	$sum_tot_fac_com_tem2	= @mysql_query($sum_tot_fac_com_tem3,$conexion);
	$sum_tot_fac_com_tem	= @mysql_fetch_object($sum_tot_fac_com_tem2);
	
	$suma_tot_fac_compra_tem = $sum_tot_fac_com_tem->total;
	$suma_tot_fac_compra_tem = number_format($suma_tot_fac_compra_tem, 0, ",", ".");
	
//------------------------------------------------------------------------------------------------------------------------------------------------------
	
//-Tabla PROVEEDORES	
	//Consulta tabla Proveedores
	$dep = 'select * from proveedor order by name_pro';
	$dep2 = @mysql_query($dep,$conexion); 
	$cant_prov_total = @mysql_num_rows($dep2);
	
	//Consulta para boton buscar de caja de texto
	if($_POST['buscador'] == "OK")
	{
		$buscar_palabra = $_POST['busco'];
		$act_ct_buscar = 1;
	}
	if ($act_ct_buscar == 1 and $pagina_actual == 'proveedor'){
		$cant="select * from proveedor where name_pro LIKE '%$buscar_palabra%'";
		$cant2=@mysql_query($cant,$conexion);
		$cant_prov_total = @mysql_num_rows($cant2);
	}
	
	//--- Consultar Proveedores con datos para paginacion		
	$i=1;
	if ($act_ct_buscar == 1 and $pagina_actual == 'proveedor'){
		$dep = "select * from proveedor where name_pro LIKE '%$buscar_palabra%' order by name_pro asc limit ".$limitInf.",".$tamPag;
	}else{
		$dep = 'select * from proveedor order by name_pro asc limit '.$limitInf.','.$tamPag;
	} 
	$dep2 = @mysql_query($dep,$conexion); 
	$cant_prov 	= @mysql_num_rows($dep2);
	while($campos = @mysql_fetch_object($dep2)){ 
		//Codigo Proveedor
		$codigo_proveedor = $campos->cod_pro;
		
		//Columna 1 "Nombre Proveedor"
		$nombre_proveedor = $campos->name_pro;
		$nombre_proveedor = strtolower($nombre_proveedor); 		
		$nombre_proveedor = ucwords($nombre_proveedor);	
		
		//Columna 2 "Nombre Ciudad del Proveedor"
		$cod_ciu_pro 	 = $campos->cod_ciudad;  
		$ciu 			= "select * from ciudad where cod_ciudad = $cod_ciu_pro";
		$ciu2 			= @mysql_query($ciu,$conexion); 
		$cant_ciu 		= @mysql_num_rows($ciu2);
		$campos2 		= @mysql_fetch_object($ciu2);
		
		$nombre_ciudad = $campos2->nom_ciudad;
		$nombre_ciudad = strtolower($nombre_ciudad); 		
		$nombre_ciudad = ucwords($nombre_ciudad);
				
		//Columna 3 "Telefono Proveedor"
		$telefono_proveedor = $campos->nro_telefo;
		
		//Columna 4 "Contacto Proveedor"
		$contacto_proveedor = $campos->vendedor;
		$contacto_proveedor = strtolower($contacto_proveedor); 		
		$contacto_proveedor = ucwords($contacto_proveedor);	
		
		//Columna 5 "Numero de Compras Realizadas x Proveedor"
		$cant_comp 		= "select distinct num_factura from compras where cod_pro = $codigo_proveedor";
		$cant_comp2 	= @mysql_query($cant_comp,$conexion);
		$cant_comp_pro 	= @mysql_num_rows($cant_comp2); 
	
		//Columna 6 "Numero de registro tributario"
		$num_nit		= $campos->nro_tribut;
	
		//Columana 7 "Direccion Proveedor"
		$dir_ges		= $campos->direcc1;
		
		//Columna 8 "Nombre de provincia"
		$cod_provi = $campos2->cod_provincia;

		$prov 			 = "select * from provincia where cod_provincia = $cod_provi";
		$prov2 			 = @mysql_query($prov,$conexion); 
		$campos_prov_con = @mysql_fetch_object($prov2);
		
		$nom_provin		= $campos_prov_con->nom_provincia;
		$nom_provin 	= strtolower($nom_provin); 		
		$nom_provin 	= ucwords($nom_provin);	
		
		//Columna 9 Nombre de Pais
		$cod_pais_ges		 = $campos_prov_con->cod_pais;
		$pais_ges 			 = "select * from pais where cod_pais = $cod_pais_ges";
		$pais_ges2 			 = @mysql_query($pais_ges,$conexion); 
		$campos_pais_ges 	 = @mysql_fetch_object($pais_ges2);

		$nom_pais_ges		= $campos_pais_ges->nom_pais;
		$nom_pais_ges 		= strtolower($nom_pais_ges); 		
		$nom_pais_ges 		= ucwords($nom_pais_ges);		
		
		//Columna 10 Telefono 2
		$telefono_ges2 		= $campos->nro_telefo2;
		
		//Columna 11 Numero de fax
		$fax_ges 			= $campos->nro_fax;
		
		//Columna 12 Numeor de celular
		$celular_ges 		= $campos->nro_celular;

		//Columna 13 Valor total de compras
		$sum_tot_pro = "select sum(vr_total) total from compras where cod_pro = '$codigo_proveedor'";
		$sum_tot_pro2=@mysql_query($sum_tot_pro,$conexion);
		$sum_tot_pro3=@mysql_fetch_object($sum_tot_pro2);	
		$suma_tot_pro = $sum_tot_pro3->total;
	  	$suma_tot_pro = number_format($suma_tot_pro, 0, ",", ".");

		
		if ($cant_ciu == 0){
			$nombre_ciudad = $no_apli;
		}
		if (empty($telefono_proveedor)){
			$telefono_proveedor = $no_apli;
		}
		if (empty($contacto_proveedor)){
			$contacto_proveedor = $no_apli;
		}
		if (empty($num_nit)){
			$num_nit 			= $no_apli;
		}
		if (empty($dir_ges)){
			$dir_ges			= $no_apli;
		}
		if (empty($nom_provin)){
			$nom_provin			= $no_apli;
		}
		if (empty($nom_pais_ges)){
			$nom_pais_ges		= $no_apli;
		}
		if (empty($telefono_ges2)){
			$telefono_ges2		= $no_apli;
		}
		if (empty($fax_ges)){
			$fax_ges			= $no_apli;
		}
		if (empty($celular_ges)){
			$celular_ges		= $no_apli;
		}
										
		//Lleno Array Con los datos del listado de Proveedores
		$list_prov[] = array($i => array(	0 => $codigo_proveedor,
											1 => "$nombre_proveedor", 
											2 => "$nombre_ciudad", 
											3 => $telefono_proveedor,
											4 => "$contacto_proveedor",
											5 => $cant_comp_pro,
											6 => $num_nit,
											7 => $dir_ges,
											8 => $nom_provin,
											9 => $nom_pais_ges,
											10 => $telefono_ges2,
											11 => $fax_ges,
											12 => $celular_ges,
											13 => $suma_tot_pro
											));
		$i++;
	}

//------------------------------------------------------------------------------------------------------------------------------------------------------		
//-Tabla CLIENTES
	//Consulta tabla clientes
	$cli = 'select * from clientes';
	$cli2 = @mysql_query($cli,$conexion); 
	$cant_cli_total = @mysql_num_rows($cli2);
	
	if ($act_ct_buscar == 1 and $pagina_actual == 'cliente'){
		$cant="select * from clientes where name_cli LIKE '%$buscar_palabra%'";
		$cant2=@mysql_query($cant,$conexion);
		$cant_cli_total = @mysql_num_rows($cant2);
	}
	//--- Consultar clientes con datos para paginacion		
	$i=1;
	if ($act_ct_buscar == 1 and $pagina_actual == 'cliente'){
		$cli = "select * from clientes where name_cli LIKE '%$buscar_palabra%' order by name_cli asc limit ".$limitInf.",".$tamPag;
	}else{
		if($cod_fac_asi>0 or $cod_fac_pen>0){
			$cli = 'select * from clientes order by name_cli';
		}else{
			if($cod_env_ges>0){
				$cli = 'select * from clientes where cod_cli = '.$cod_env_ges;
			}else{
				$cli = 'select * from clientes order by name_cli asc limit '.$limitInf.','.$tamPag;
			}	
		}
	} 
	$cli2 		= @mysql_query($cli,$conexion); 
	$cant_cli 	= @mysql_num_rows($cli2);
	while($campos = @mysql_fetch_object($cli2)){ 
		
		//Codigo cliente
		$codigo_cliente = $campos->cod_cli;
		
		//Columna 1 "Nombre Cliente"
		$nombre_cliente = $campos->name_cli;
		$nombre_cliente = strtolower($nombre_cliente); 		
		$nombre_cliente = ucwords($nombre_cliente);	
		
		//Columna 2 "Nombre Ciudad del Cliente"
		$cod_ciu_cli 	= $campos->cod_ciudad;  
		$ciu 			= "select * from ciudad where cod_ciudad = $cod_ciu_cli";
		$ciu2 			= @mysql_query($ciu,$conexion); 
		$cant_ciu 		= @mysql_num_rows($ciu2);
		$campos2 		= @mysql_fetch_object($ciu2);
		
		$nombre_ciudad = $campos2->nom_ciudad;
		$nombre_ciudad = strtolower($nombre_ciudad); 		
		$nombre_ciudad = ucwords($nombre_ciudad);
		
		//Columna 3 "Telefono Cliente"
		$telefono_cliente = $campos->nro_telefo;
		
		//Columna 4 "Contacto Cliente"
		$contacto_cliente = $campos->contacto;
		$contacto_cliente = strtolower($contacto_cliente); 		
		$contacto_cliente = ucwords($contacto_cliente);	
		
		//Columna 5 "Numero de Ventas Realizadas x Cliente"
		$cant_comp 		= "select distinct num_factura, fecha_venta from ar_salida where cod_cli = $codigo_cliente";
		$cant_comp2 	= @mysql_query($cant_comp,$conexion);
		$cant_comp_pro 	= @mysql_num_rows($cant_comp2); 
	
		//Columna 6 "Numero de registro tributario"
		$num_nit		= $campos->nro_tribut;
	
		//Columana 7 "Direccion Proveedor"
		$dir_ges		= $campos->direcc1;
		
		//Columna 8 "Nombre de provincia"
		$cod_provi = $campos2->cod_provincia;

		$prov 			 = "select * from provincia where cod_provincia = $cod_provi";
		$prov2 			 = @mysql_query($prov,$conexion); 
		$campos_prov_con = @mysql_fetch_object($prov2);
		
		$nom_provin		= $campos_prov_con->nom_provincia;
		$nom_provin 	= strtolower($nom_provin); 		
		$nom_provin 	= ucwords($nom_provin);	
		
		//Columna 9 Nombre de Pais
		$cod_pais_ges		 = $campos_prov_con->cod_pais;
		$pais_ges 			 = "select * from pais where cod_pais = $cod_pais_ges";
		$pais_ges2 			 = @mysql_query($pais_ges,$conexion); 
		$campos_pais_ges 	 = @mysql_fetch_object($pais_ges2);

		$nom_pais_ges		= $campos_pais_ges->nom_pais;
		$nom_pais_ges 		= strtolower($nom_pais_ges); 		
		$nom_pais_ges 		= ucwords($nom_pais_ges);		
		
		//Columna 10 Telefono 2
		$telefono_ges2 		= $campos->nro_telefo2;
		
		//Columna 11 Numero de fax
		$fax_ges 			= $campos->nro_fax;
		
		//Columna 12 Numeor de celular
		$celular_ges 		= $campos->nro_celular;
	
		//Columna 13 Valor total de ventas
		$sum_total = "select sum(vr_total) total from ar_salida where cod_cli = '$codigo_cliente'";
		$sum_total2=@mysql_query($sum_total,$conexion);
		$sum_total3=@mysql_fetch_object($sum_total2);	
		$suma_tot_cli = $sum_total3->total;
	  	$suma_tot_cli = number_format($suma_tot_cli, 0, ",", ".");
	
		if ($cant_ciu == 0){
			$nombre_ciudad = $no_apli;
		}
		if (empty($telefono_cliente)){
			
			$telefono_cliente = $no_apli;
		}
		if (empty($contacto_cliente)){
			$contacto_cliente = $no_apli;
		}
		if (empty($num_nit)){
			$num_nit 			= $no_apli;
		}
		if (empty($dir_ges)){
			$dir_ges			= $no_apli;
		}
		if (empty($nom_provin)){
			$nom_provin			= $no_apli;
		}
		if (empty($nom_pais_ges)){
			$nom_pais_ges		= $no_apli;
		}
		if (empty($telefono_ges2)){
			$telefono_ges2		= $no_apli;
		}
		if (empty($fax_ges)){
			$fax_ges			= $no_apli;
		}
		if (empty($celular_ges)){
			$celular_ges		= $no_apli;
		}		
		
		//Lleno Array Con los datos del listado de Proveedores
		$list_cli[] = array($i => array(	0 => $codigo_cliente,
											1 => "$nombre_cliente", 
											2 => "$nombre_ciudad", 
											3 => "$telefono_cliente",
											4 => "$contacto_cliente",
											5 => $cant_comp_pro,
											6 => $num_nit,
											7 => $dir_ges,
											8 => $nom_provin,
											9 => $nom_pais_ges,
											10 => $telefono_ges2,
											11 => $fax_ges,
											12 => $celular_ges,
											13 => $suma_tot_cli
											));
		$i++;
	}

//------------------------------------------------------------------------------------------------------------------------------------------------------	
//--Tabla PROVEEDORES, listado de compras por proveedor

	$i = 1;
	$con_com3='select distinct num_factura from compras where cod_pro = '.$cod_env_ges.' order by num_factura';
	$con_com2=@mysql_query($con_com3,$conexion);
//	$cant_cli 	= @mysql_num_rows($cli2);
	while ($con_com=@mysql_fetch_object($con_com2)){
		//Numero de todas las facturas
		$n_fac = $con_com->num_factura;
		
		//Fecha de compra
		$fac="select * from compras where cod_pro = '$cod_env_ges' and num_factura = '$n_fac' order by fecha_compra";
		$fac2=@mysql_query($fac,$conexion);
		$fac3=@mysql_fetch_object($fac2);
				
		//Codigo de la factura	
		//verificar este valor
		$cod_fac = $fac3->cod_pro;
		//Numero de la factura
		$num_fac = $fac3->num_factura;
								
		//Fecha inicial
		$fec_inicial = $fac3->fecha_compra;
		//Fecha Vencimiento
		$fec_vence 	 = $fac3->fecha_ven;
		if($fec_vence == "0000-00-00"){
			$fec_vence = $pago_cont;
		}
		
		//Valor Factura
		$sum = "select sum(vr_total) total from compras where cod_pro = '$cod_env_ges' and num_factura = '$n_fac'";
		$sum2=@mysql_query($sum,$conexion);
		$sum3=@mysql_fetch_object($sum2);	
		$suma_fac = $sum3->total;
	  	$suma_fac = number_format($suma_fac, 0, ",", ".");
		
		//Lleno Array Con los datos del listado de Proveedores
		$list_fac_tot[] = array($i => array(	0 => $num_fac,
												1 => "$fec_inicial", 
												2 => "$fec_vence", 
												3 => $suma_fac,
												4 => $cod_env_ges,
											));
		$i++;
	}	

//------------------------------------------------------------------------------------------------------------------------------------------------------	
//Tabla Ventas
	
	$con_ven_cli		= 'select distinct num_factura, fecha_venta from ar_salida where cod_cli = '.$cod_env_ges.' order by num_factura';
	$con_ven_cli2 		= @mysql_query($con_ven_cli,$conexion); 
	$cant_ven_cli_tot 	= @mysql_num_rows($con_ven_cli2);
	
	$i = 1;
	$con_ven_cli3	= 'select distinct num_factura, fecha_venta from ar_salida where cod_cli = '.$cod_env_ges.' order by num_factura asc limit '.$limitInf.','.$tamPag;
	$con_ven_cli2	= @mysql_query($con_ven_cli3,$conexion);
	$cant_ven_cli	= @mysql_num_rows($con_ven_cli2);
	
	while ($con_ven_cli=@mysql_fetch_object($con_ven_cli2)){

		//Numero de todas las facturas
		$n_fac_cli 		= $con_ven_cli->num_factura;
		$fec_ven_cli	= $con_ven_cli->fecha_venta;	
	
		//Nombre Cliente 
		$cli = "select * from clientes where cod_cli = '$cod_env_ges'";
		$cli2=@mysql_query($cli,$conexion);
		$cli3=@mysql_fetch_object($cli2);
		
		$nom_cli_lis = $cli3->name_cli;
		$nom_cli_lis = strtolower($nom_cli_lis); 		
		$nom_cli_lis = ucwords($nom_cli_lis);		
			
		//Valor Factura
		$sum = "select sum(vr_total) total from ar_salida where num_factura = '$n_fac_cli' and fecha_venta = '$fec_ven_cli'";
		$sum2=@mysql_query($sum,$conexion);
		$sum3=@mysql_fetch_object($sum2);	
		$suma_fac_lis = $sum3->total;
	  	$suma_fac_lis = number_format($suma_fac_lis, 0, ",", ".");
				
		//Lleno Array Con los datos del listado de Proveedores
		$list_ven_tot[] = array($i => array(	0 => "$nom_cli_lis",
												1 => $n_fac_cli, 
												2 => "$fec_ven_cli", 
												3 => $suma_fac_lis,
											));
		$i++;		
	}	

//------------------------------------------------------------------------------------------------------------------------------------------------------	
//Tabla DEPARTAMENTOS
	
	$i = 1;
	//Consulta total de Departamentos
	$con_cant_departa3 = 'select * from departamento';
	$con_cant_departa2 = @mysql_query($con_cant_departa3,$conexion); 
	$con_cant_departa  = @mysql_num_rows($con_cant_departa2);
	
	//Datos de Factura Departamentos, con limite para paginacion
	$con_departamento3		= 'select * from departamento order by nom_depto asc limit '.$limitInf.','.$tamPag;
	$con_departamento2		= @mysql_query($con_departamento3,$conexion);
	$cant_departamento		= mysql_num_rows($con_departamento2);
	
	if($act_caja_buscador>0){ //Cuando se activa la caja de busqueda
		$con_departamento3		= 'select * from departamento where nom_depto like "%'.$buscar_palabra.'%" order by nom_depto asc limit '.$limitInf.','.$tamPag; 
		$con_departamento2		= @mysql_query($con_departamento3,$conexion);
		$cant_departamento		= mysql_num_rows($con_departamento2);
		$con_cant_departa	=	$cant_departamento;
	}
	
	while ($con_depar=@mysql_fetch_object($con_departamento2)){
	
		//Nombre del Departamento
		$nom_depar 	= $con_depar->nom_depto;
		$nom_depar 	= strtolower($nom_depar); 		
		$nom_depar 	= ucwords($nom_depar);
	
		//Codigo del Departamento
		$cod_depar 	= $con_depar->cod_depto;
		
		//Cantidad de Articulos por Departamento
		$con_can_art3		= 'select * from almacen where cod_depto = '.$cod_depar;
		$con_can_art2		= @mysql_query($con_can_art3,$conexion);
		$cant_articulo		= mysql_num_rows($con_can_art2);
		
	//Lleno Array Con los datos del listado de los Departamentos
		$list_departamento[] = array($i => array(	0 => "$nom_depar",
													1 => "$cod_depar", 
													2 => "$cant_articulo", 
											));
		$i++;
	}
//---------------------------------------------------------------------------------	
	//Buscar Codigo para producto
	//Buscar numero continuo de id articulo	
	$sqln = "select * from sis_num_fal_art";
	$nro = $con -> busca_campo($sqln,$conexion);
	if($nro != 0)
	{
		$sql="select min(no_fal) as num from sis_num_fal_art";
		$sql2=@mysql_query($sql,$conexion);
		$sql3=@mysql_fetch_object($sql2);
		$cod_pro_sig = $sql3->num; 
	}else{

		$max="select max(cod_item) as max from almacen";
		$max2=@mysql_query($max,$conexion);
		$max3=@mysql_fetch_object($max2);
		$mayor = $max3->max;
		$cod_pro_sig = $mayor + 1; 
	}
	$_SESSION['cod_pro_sig'] = $cod_pro_sig;
	
//-------------------------------------------------------------------------------------
?>