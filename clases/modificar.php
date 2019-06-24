<?
//-Sesion
	session_start();
	require_once ('control.php');
	require_once ('datos.php');
	$con = new control;
	$con->conectar();
	$con-> seg_usu();
	$conexion = $con->conectar();

	//Modificar Proveedor en tabla proveedores
	if($_POST['modificar_proveedor'] == "OK")
	{
		if($_POST['opc'] == 1){
			$pais 		= $_POST['pais2'];
			$depto  	= $_POST['dep2'];
			$ciudad 	= $_POST['ciu2'];
		}
		if($_POST['opc'] == 2){
			$pais	= $_SESSION['pais'];
			$depto	= $_SESSION['prov'];
			$ciudad = $_SESSION['ciu'];
		}

		$nombre 	= strtoupper($_POST['nombre2']);
		$nit 		= strtoupper($_POST['nit2']);
		$direccion 	= strtoupper($_POST['direccion2']);
		$tel1 		= strtoupper($_POST['tel12']);
		$tel2 		= strtoupper($_POST['tel22']);
		$fax 		= strtoupper($_POST['fax2']);
		$celular 	= strtoupper($_POST['celular2']);
		$vendedor 	= strtoupper($_POST['vendedor2']);

		$codigo = $_SESSION['codigo'];

		$sqln = "select * from proveedor where name_pro ='$nombre' and cod_ciudad = $ciudad";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			$ciu = "select * from ciudad where cod_ciudad = $ciudad";
			$ciu2 = @mysql_query($ciu,$conexion);
			$campos2 = @mysql_fetch_object($ciu2);
			$n_ciu = $campos2->nom_ciudad;
			echo("<script language=javascript>
			alert('El proveedor $nombre ya existe en la ciudad de $n_ciu');
			location.href='proveedor.php?id_pro=-1';
			</script>");
		}else{
			$sql5 = "
			update proveedor set 	name_pro 		=  '$nombre',
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
									vendedor		=  '$vendedor'
							WHERE  	cod_pro 		=	$codigo ;
					";


			$consulta=mysql_query($sql5,$conexion);

			echo(	"<script language=javascript>
					alert('El proveedor $nombre se Modifico con exito!!');
					location.href='proveedor.php?id_pro=-1';
					</script>");
		}
	}
	//Modificar Departamento
	if($_POST['modificar_depar'] == "OK"){

		$_SESSION['act_crea_msj'] 	= 0;
		$_SESSION['act_eli']		= 0;
		$_SESSION['act_mod']		= 0;

		//Boton menu principal modificar
		$acti_ver_modificar	= $_SESSION['act_mod_dep'];
		if($acti_ver_modificar > 0){
			$_SESSION['act_mod_tab'] = 1;
		}
		//Capturo los codigos principal del departamento
		$valores = $_POST['valores'];
		$cantidad = count($valores);
		//Capturo los valores del nombre del departamento
		$deptos = $_POST['depto'];
		$can_deptos = count($deptos);

		if($can_deptos > 0 and $cantidad > 0){
			for($i=0;$i<$can_deptos;$i++){
				$codigo	= $valores[$i];
				$nombre	= $deptos[$i];
				$sqln = "select * from departamento where cod_depto = $codigo and nom_depto ='$nombre'";
				$nro = $con -> busca_campo($sqln,$conexion);
				if($nro != 0)
				{
					//Lleno Array Con los datos del listado de los Departamentos
					$list_depar_mods[] = array($i => array(	0 => "$nombre"));
					$_SESSION['valores_array'] = $list_depar_mods;
					//Activo Mostrar mensaje eliminacion correcta Departamentos
					$act_si_mod = 3;
					$_SESSION['act_eli'] = $act_si_mod;	
				}else{
					$sql5 = "update departamento set nom_depto =  '$nombre' WHERE  cod_depto =$codigo;";
					$consulta=mysql_query($sql5,$conexion);

					//Lleno Array Con los datos del listado de los Departamentos
					$list_depar_mod[] = array($i => array(	0 => "$nombre"));
					$_SESSION['valores_array'] = $list_depar_mod;

					//Activo Mostrar mensaje eliminacion correcta Departamentos
					$act_si_mod = 2;
					$_SESSION['act_eli'] = $act_si_mod;
					//Activo Listado
					$_SESSION['act_lis_depto'] 	= 1;
					//Desactivo vista Modificar
					$_SESSION['act_mod_dep']	= 0;
				}
			}
				
			//Activo Crear mensaje
			$act_crea_msj = 3;
			$_SESSION['act_crea_msj'] = $act_crea_msj;
			
			echo("<script language=javascript>
				location.href='$enlace'
			</script>");
			
		}
	}
	//Modificar Departamento
	if($_POST['modifica_prod'] == "OK"){
		
		$i = 1;
		//Reinicio Valor mensaje
		$_SESSION['act_eli'] 		= 0;
		$_SESSION['act_crea_msj'] 	= 0;
		
		$cod_art		= $_SESSION['cod_art_mod']; 
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
			$sql2=@mysql_query($sqln,$conexion);
			$sql3=@mysql_fetch_object($sql2);
			$cod_db_alm = $sql3->cod_item; 
			if($cod_db_alm != $cod_art)
			{
						
				//Activo Mostrar mensaje no es posible eliminar Departamentos
				$act_no_eli = 3; //Error
				$_SESSION['act_eli'] = $act_no_eli;
			
				//Enlace Articulo
				$enlace		= "articulo.php";
			
				//Variable modificacion
				$act_ver_mod = 1;
				$_SESSION['msj_ver_mod'] = $act_ver_mod;
			
			}else{
				$_SESSION['valores_array']	= 0;
				
				$int="	update almacen set
						des_item 	=  '$des_item',
						precio 		=  '$precio',
						costo 		=  '$costo',
						cant_stock 	=  '$cantidad',
						cod_barras	=  '$barcode',
						cod_depto 	=  '$cod_dept' where cod_item =$cod_art
	
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
				//Variable modificacion
				$act_ver_mod = 1;
				$_SESSION['msj_ver_mod'] = $act_ver_mod;
				//Enlace Articulo
				$enlace		= "inventario.php";
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