<?
//-Sesion 
	session_start();
	require_once ('control.php');
	require_once ('datos.php');
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();

	//Crear Clientes o proveedores Inserta en tabla proveedores, Clientes
	if($_POST['crea_pro'] == "OK")
	{
		if ($pagina_actual == 'proveedor'){
			$nom_tabla = "proveedor";
			$cam_name  = "name_pro";
			$cam_cod   = "cod_pro";
			$cam_con   = "vendedor";
		}
		if ($pagina_actual == 'cliente'){
			$nom_tabla = "clientes";
			$cam_name  = "name_cli";
			$cam_cod   = "cod_cli";
			$cam_con   = "contacto";
		}
		$nom_ciudad	= $_POST['inputString'];		
		$depto 		= $con -> bus_cod_provincia($nom_ciudad,$conexion);
		$ciudad		= $con -> bus_cod_ciudad($nom_ciudad,$conexion);
		$pais		= $con -> bus_cod_pais($depto,$conexion);
		$nombre 	= strtoupper($_POST['nombre']);
		$nit 		= strtoupper($_POST['nit']);
		$direccion 	= strtoupper($_POST['direccion']);
		$tel1 		= strtoupper($_POST['tel1']);
		$tel2 		= strtoupper($_POST['tel2']);
		$fax 		= strtoupper($_POST['fax']);
		$celular 	= strtoupper($_POST['celular']);
		$conta_ges 	= strtoupper($_POST['vendedor']);
				
		$sqln = "select * from ". $nom_tabla." where ". $cam_name  ." ='$nombre' and cod_ciudad = $ciudad";
		
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			$ciu = "select * from ciudad where cod_ciudad = $ciudad";
			$ciu2 = @mysql_query($ciu,$conexion); 
			$campos2 = @mysql_fetch_object($ciu2);
			$n_ciu = $campos2->nom_ciudad; 
			echo("<script language=javascript> 
			alert('El $pagina_actual $nombre ya existe en la ciudad de $n_ciu');
			location.href='$pagina_actual.php?val=2';
			</script>");
		}else{
		
		$int="	
			INSERT INTO ". $nom_tabla ." (
			".$cam_cod.", ".$cam_name.", direcc1, cod_pais, cod_provincia, cod_ciudad, nro_telefo, nro_telefo2, nro_celular,
			nro_fax, max_credi, balance, nro_tribut, ".$cam_con.")
			
			VALUES (
			NULL,  '$nombre',  '$direccion',  '$pais',  '$depto',  '$ciudad',  '$tel1',  '$tel2',  '$celular',  
			'$fax',  '$credito',  '$balance',  '$nit',  '$conta_ges'
			);
			";
			
			$int2=mysql_query($int,$conexion);
			echo(	"<script language=javascript>
					alert('El $pagina_actual $nombre se creo con exito');
					location.href='$pagina_actual.php?val=1';
					</script>");
					
		}
	}

//Modificar Proveedores Modifica en tabla proveedores, clientes	
	if($_POST['mod_ges'] == "OK"){
		
		if ($pagina_actual == 'proveedor'){
			$nom_tabla = "proveedor";
			$cam_name  = "name_pro";
			$cam_cod   = "cod_pro";
			$cam_con   = "vendedor";
		}
		if ($pagina_actual == 'cliente'){
			$nom_tabla = "clientes";
			$cam_name  = "name_cli";
			$cam_cod   = "cod_cli";
			$cam_con   = "contacto";
		}

		$nom_ciudad	= $_POST['inputString'];		
		$depto 		= $con -> bus_cod_provincia($nom_ciudad,$conexion);
		$ciudad		= $con -> bus_cod_ciudad($nom_ciudad,$conexion);
		$pais		= $con -> bus_cod_pais($depto,$conexion);		
		$nombre 	= strtoupper($_POST['nombre']);
		$nit 		= strtoupper($_POST['nit']);
		$direccion 	= strtoupper($_POST['direccion']);
		$tel1 		= strtoupper($_POST['tel1']);
		$tel2 		= strtoupper($_POST['tel2']);
		$fax 		= strtoupper($_POST['fax']);
		$celular 	= strtoupper($_POST['celular']);
		$conta_ges 	= strtoupper($_POST['vendedor']);
		
		$sqln = "select * from ". $nom_tabla ." where ". $cam_cod ." ='$cod_ges_mod'";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			$sql5 = "
			update ". $nom_tabla ." set 	". $cam_name ." =  '$nombre',
											direcc1	 		=  '$direccion',
											cod_pais 		=  '$pais',
											cod_provincia 	=  '$depto',
											cod_ciudad		=  '$ciudad',
											nro_telefo		=  '$tel1',
											nro_telefo2		=  '$tel2',
											nro_celular		=  '$celular',
											nro_fax			=  '$fax',
											max_credi		=  '$credito',
											balance			=  '$balance',
											nro_tribut		=  '$nit',
											". $cam_con ."	=  '$conta_ges' 
									WHERE  	". $cam_cod ."	=	$cod_ges_mod ;
					";
							 
			$consulta=mysql_query($sql5,$conexion);
		
			echo(	"<script language=javascript>
					alert('El $pagina_actual $nombre se Modifico con exito!!');
					location.href='$pagina_actual.php?val=1';
					</script>");	
		}				
	}
	
//Cerrar Facturas VENTAS Pendientes	
	if($_POST['cerrar_fac'] == "OK"){
	
		$fecha_fac 	= $_GET['fec'];
		$num_fac = $_GET['id_pen'];
		
		$fac="select * from temporal where fecha_factura ='$fecha_fac' and num_factura = '$num_fac'";
		$fac2=@mysql_query($fac,$conexion);
		while($fac3=@mysql_fetch_object($fac2)){
		
		$cod_item 	= $fac3->id_art;
		$cant		= $fac3->cantidad;
		$vr_uni		= $fac3->vr_venta;
		$v_total	= $fac3->vr_total;
		$no_orde	= $fac3->num_factura;
		$fec_com	= $fac3->fecha_factura;
		$cod_ven	= $fac3->cod_empleado;
				
		$com="
		INSERT INTO  ar_salida (
			id_sal, id_art, cantidad, vr_venta, vr_total, num_factura, fecha_venta, cod_cli, cod_empleado)
		VALUES (
		NULL,  '$cod_item',  '$cant',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$cod_cli', '$cod_ven');
		";
		$com2=mysql_query($com,$conexion);
		
		$alm="select * from almacen where cod_item = '$cod_item'";
		$alm2=@mysql_query($alm,$conexion);
		$alm3=@mysql_fetch_object($alm2);
		
		$c_alm = $alm3->cant_stock;
		
		$stock = $c_alm - $cant;

		$sql5 = "update almacen set cant_stock = '$stock' WHERE  cod_item ='$cod_item';";
		$consulta=mysql_query($sql5,$conexion);

		}		
		
		$sum  = "select sum(vr_total) total from temporal where num_factura = '$num_fac' and fecha_factura ='$fecha_fac'";
		$sum2 = @mysql_query($sum,$con->conectar()); 
		$sum3 = @mysql_fetch_object($sum2);	
		$t_fac = $sum3->total;
			
		$ins="
			insert into facturacion (
			id_fac, no_fac, fecha_fac, fecha_registro, vr_fac, cod_cli)
			VALUES (
			NULL,  '$num_fac', '$fecha_fac', '$fecha', '$t_fac',  '$cod_cli');
			";
		$ins2=mysql_query($ins,$conexion);
		
		$sql="delete from temporal where fecha_factura ='$fecha_fac' and num_factura = '$num_fac'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);		

		echo("<script language=javascript> 
		alert('La factura No. $num_fac del $fecha_fac se cerro corractamente por un valor de $ $t_fac');
		location.href='ventas.php?val=1'
		</script>");
	}

//Cerrar Facturas COMPRAS Pendientes
	if($_POST['cerrar_fac_compras'] == "OK"){
		
		//echo "<br>estor  ".
		$fecha_fac 	= $_GET['fec'];
		$num_fac = $_GET['id_pen'];	

		$sum  = "select sum(vr_total) total from compra_temporal where num_factura = '$num_fac' and fecha_compra = '$fecha_fac'";
		$sum2 = @mysql_query($sum,$con->conectar()); 
		$sum3 = @mysql_fetch_object($sum2);	
		$t_fac = $sum3->total;
			
		$lle="select * from compra_temporal where num_factura = '$num_fac' and fecha_compra = '$fecha_fac'";
		$lle2=@mysql_query($lle,$conexion);
		while ($campos=@mysql_fetch_object($lle2)){
		
			$cod_item 	= $campos ->id_art; 
			$cant 		= $campos ->cantidad;
			$detalle 	= $campos ->detalle;
			$vr_uni 	= $campos ->vr_costo;
			$v_total 	= $campos ->vr_total;
			$no_orde 	= $campos ->num_factura;
			$fec_com 	= $campos ->fecha_compra;
			$fec_ven 	= $campos ->fecha_ven;
			$cod_pro 	= $campos ->cod_pro;
		
			$int="	
			INSERT INTO  compras (
				id_compra, id_art, cantidad, detalle, vr_costo, vr_total, num_factura, fecha_compra, fecha_ven, cod_pro)
			VALUES (
			NULL, '$cod_item',  '$cant',  '$detalle',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$fec_ven',  '$cod_pro');	
				 ";			 
			$int2=mysql_query($int,$conexion);
		
			$ins_entrada2="
			INSERT INTO  ar_entrada (
				id_ent, id_art, cantidad, vr_costo, vr_total, num_factura, fecha_compra, cod_pro)
			VALUES (
			NULL,  '$cod_item',  '$cant',  '$vr_uni',  '$v_total',  '$no_orde',  '$fec_com',  '$cod_pro');
				";
			$ins_entrada=mysql_query($ins_entrada2,$conexion);
		
			$alm="select * from almacen where cod_item = '$cod_item'";
			$alm2=@mysql_query($alm,$conexion);
			$alm3=@mysql_fetch_object($alm2);
		
			$c_alm = $alm3->cant_stock;
		
			$stock = $c_alm + $cant;
			
			$sql5 = "update almacen set cant_stock =  '$stock' WHERE  cod_item ='$cod_item';";
			$consulta=mysql_query($sql5,$conexion);
			
			$borrar		=	"delete from compra_temporal where 	id_art='$cod_item' 		and 
																num_factura='$no_orde' 	and 
																fecha_compra='$fec_com' and 
																cod_pro='$cod_pro'	";
			$borrar1	=	@mysql_query($borrar,$conexion);
			$borrar2 	= 	@mysql_fetch_object($borrar1);	
		}	
				
		echo("<script language=javascript> 
		alert('La factura No. $num_fac del $fecha_fac se cerro corractamente por un valor de $ $t_fac');
		location.href='compras.php?val=1'
		</script>");		
		
	}

//Crear Departamentos
	if($_POST['crea_depto'] == "OK"){
		//Departamento
		$enlace		= "departamento.php";
		//Inicio Variable de mensaje
		$_SESSION['act_eli'] 		= 0;
		$_SESSION['act_crea_msj'] 	= 0;
		//Desactivo Ver nuevo
		$_SESSION['act_ver_nue'] 	= 0;
		//Activo Ver Listado
		$act_ver_listado = 1;
		$_SESSION['act_lis_depto'] = $act_ver_listado;
		$i = 1;
		
		$name = $_POST['nombre']; 
		
		$sqln = "select * from departamento where nom_depto ='$name'";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			//Lleno Array Con los datos del listado de los Departamentos
			$list_depar_nuevo[] = array($i => array(	0 => "$name"));
			$_SESSION['valores_array'] = $list_depar_nuevo;
			//print_r ($list_depar_nuevo);
			//Activo Mostrar mensaje no es posible eliminar Departamentos
			$act_no_eli = 3; //Warning
			$_SESSION['act_eli'] = $act_no_eli;
			
		}else{
		
			$int="	INSERT INTO  `departamento` ( `cod_depto` , `nom_depto` )
				VALUES ( NULL ,  '$name' );";
			$int2=mysql_query($int,$conexion);
			
			//Lleno Array Con los datos del listado de los Departamentos
			$list_depar_nuevo[] = array($i => array(	0 => "$name"));
			$_SESSION['valores_array'] = $list_depar_nuevo;
			
			//Activo Mostrar mensaje no es posible eliminar Departamentos
			$act_no_eli = 2; //Correcto
			$_SESSION['act_eli'] = $act_no_eli;

		}
		//Activo Crear mensaje
		$act_crea_msj = 2;
		$_SESSION['act_crea_msj'] = $act_crea_msj;
		
		echo("<script language=javascript> 
			location.href='$enlace'
		</script>");
		
	}
	
	//Crea Articulo
	$crear_articulo  = $_POST['crea_articulo'] == "OK";
	if($crear_articulo == "OK"){
		$i = 1;
		//Reinicio Valor mensaje
		$_SESSION['act_eli'] 		= 0;
		$_SESSION['act_crea_msj'] 	= 0;
		
		
		$cod_art		= $_SESSION['cod_pro_sig']; 
		$barcode 		= $_POST['barras']; 
		$des_item		= strtolower($_POST['descripcion']); 
		$des_item		= ucwords($des_item); 
		$nom_dept		= $_POST['inputString']; 
		$cod_dept		= $con -> bus_cod_departamento($nom_dept,$conexion);	
		$cantidad		= $_POST['cantidad']; 
		$costo			= $_POST['costo']; 
		$precio			= $_POST['precio']; 
		$porcen			= $_POST['porcentaje'];
		
		//Lleno Array Con los datos del listado de los Departamentos
		$list_no_art[] = array($i => array(	0 => "$des_item",
											1 => "$nom_dept",
											2 => "$barcode",
											3 => "$cantidad",
											4 => "$costo",
											5 => "$precio",
											6 => "$porcen",
											7 => "$cod_art",
											));
		$_SESSION['valores_array'] = $list_no_art;
		
		if($cod_dept>0){
		
			$sqln = "select * from almacen where des_item ='$des_item' and cod_depto ='$cod_dept'";
			$nro = $con -> busca_campo($sqln,$conexion);
			if($nro != 0)
			{				
				//Activo Mostrar mensaje no es posible eliminar Departamentos
				$act_no_eli = 3; //Error
				$_SESSION['act_eli'] = $act_no_eli;
			
				//Enlace Articulo
				$enlace		= "articulo.php";
				
				//Variable modificacion
				$act_ver_mod = 2;
				$_SESSION['msj_ver_mod'] = $act_ver_mod;
			
			}else{
				$_SESSION['valores_array']	= 0;
				//Borro el valor del consecutivo en la tabla de sistema
				$buscar = "select * from sis_num_fal_art where no_fal=$cod_art ";
				$buscar2 = $con -> busca_campo($buscar,$conexion);
				if($buscar2 != 0)
				{
					$sql="delete from sis_num_fal_art where no_fal='$cod_art'";
					$bor=@mysql_query($sql,$conexion);
					$bor1 = @mysql_fetch_object($bor);				
				}
			
				$int="	INSERT INTO  almacen
						(`cod_item` ,`des_item` ,`precio` ,`precio2` ,`costo` ,`cant_stock` ,`cant_mini`, `cod_depto`, `cod_barras`)
						VALUES ('$cod_art',  '$des_item',  '$precio',  '',  '$costo',  '$cantidad',  '', '$cod_dept', '$barcode');
					";
				$int2=mysql_query($int,$conexion);
			
				//Lleno Array Con los datos del listado de los Departamentos
				$list_art_nuevo[] = array($i => array(	0 => "$des_item",
														1 => "$cod_art",
														2 => "$nom_dept"
													));
				$_SESSION['valores_array'] = $list_art_nuevo;
			
				//Activo Mostrar mensaje no es posible eliminar Departamentos
				$act_no_eli = 2; //Correcto
				$_SESSION['act_eli'] = $act_no_eli;
				//Enlace Articulo
				$enlace		= "inventario.php";
				
				//Variable modificacion
				$act_ver_mod = 2;
				$_SESSION['msj_ver_mod'] = $act_ver_mod;
			}
		}else{
			//Enlace Articulo
			$enlace		= "articulo.php";
			$act_no_eli = 1; //Error
			$_SESSION['act_eli'] = $act_no_eli;
		}
		//Activo Crear mensaje
		$act_crea_msj = 1;
		$_SESSION['act_crea_msj'] = $act_crea_msj;
		
		echo("<script language=javascript> 
			location.href='$enlace'
		</script>");
		
	}
	
?>