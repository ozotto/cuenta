<?php
//-Sesion 
	session_start();
	require_once ('control.php');
	require_once ('datos.php');
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();

	//Eliminar Articulos Factura
	if($_POST['eliminar_articulo_fac'] == "OK")
	{
		$fecha_fac 	= $_GET['fec'];
		$num_fac 	= $_GET['id_pen'];
		$cod_pro 	= $_GET['id_pro'];
		
		if($pagina_actual == "ventas"){
			$nom_tabla = "temporal";
			$nom_campo = "id_tem";
			$enlace		= $pagina_actual."2.php?id_pen=".$num_fac."&fec=".$fecha_fac;
		}
		if($pagina_actual == "compras"){
			$nom_tabla 	= "compra_temporal";
			$nom_campo 	= "id_tem_c";
			$enlace		= $pagina_actual."2.php?id_pen=".$num_fac."&fec=".$fecha_fac."&id_pro=".$cod_pro;
		}
		
		$valores = $_POST['valores'];
		$cantidad = count($valores);
	
		for($i=0;$i<$cantidad;$i++){
			$sql3 = "delete from $nom_tabla where $nom_campo = '". $valores[$i] ."'";
			$sql2	=	@mysql_query($sql3,$conexion);
			$sql 	= 	@mysql_fetch_object($sql2);	
		}
	
		echo("<script language=javascript> 
			location.href='$enlace'
		</script>");
	}
	//Eliminar Toda la Factura
	if($_POST['eliminar_toda_factura'] == "OK")
	{		
		$fecha_fac 	= $_GET['fec'];
		$num_fac 	= $_GET['id_pen'];
		$cod_pro 	= $_GET['id_pro'];
		
		if($pagina_actual == "ventas"){
			$consulta = "delete from temporal where 	num_factura 	= '".$num_fac."' and
														fecha_factura	= '".$fecha_fac."'";
		}
		if($pagina_actual == "compras"){
			$consulta = "delete from compra_temporal where 	num_factura 	= '".$num_fac."' and
													cod_pro 		= '".$cod_pro."' and
													fecha_compra	= '".$fecha_fac."'";
		}
		
		$sql3 = $consulta;
		$sql2	=	@mysql_query($sql3,$conexion);
		$sql 	= 	@mysql_fetch_object($sql2);
		
		$_SESSION['elm_factura_com'] = 0;
		
		echo("<script language=javascript> 
			location.href='$pagina_actual.php?val=1'
		</script>");
	
	}
	//Eliminar Departamentos
	if($_POST['eliminar_depar'] == "OK")
	{
		$valores = $_POST['valores'];
		$cantidad = count($valores);
		$enlace		= "departamento.php";
		$nom_tabla	= "departamento";
		$nom_campo	= "cod_depto";
		
		$_SESSION['act_eli'] 		= 0;
		$_SESSION['act_crea_msj'] 	= 0;

		//print_r ($valores);
			
		for($i=0;$i<$cantidad;$i++){

			//Busco si el departamento no tiene asignado articulos para poder borrar
			//Cantidad de Articulos por Departamento
			$con_can_art3		= 'select * from almacen where cod_depto = '.$valores[$i];
			$con_can_art2		= @mysql_query($con_can_art3,$conexion);
			$cant_articulo		= mysql_num_rows($con_can_art2);
			
			//Consulto Nombres de Departamento
				$con_departamento3		= "select * from $nom_tabla where $nom_campo = '".$valores[$i]."'";
				$con_departamento2		= @mysql_query($con_departamento3,$conexion);
				$con_depar=@mysql_fetch_object($con_departamento2);
				
			//Nombre del Departamento
				$nom_depar 	= $con_depar->nom_depto;
				$nom_depar 	= strtolower($nom_depar); 		
				$nom_depar 	= ucwords($nom_depar);
			
			if($cant_articulo>0){
				 
				//Lleno Array Con los datos del listado de los Departamentos
				$list_depar_no_elim[] = array($i => array(	0 => "$nom_depar"));
				$_SESSION['valores_array'] = $list_depar_no_elim;
				//print_r($list_depar_no_elim);
				//Activo Mostrar mensaje no es posible eliminar Departamentos
				$act_no_eli = 1;
				$_SESSION['act_eli'] = $act_no_eli;
				
			}else{		
				$sql3 = "delete from $nom_tabla where $nom_campo = '". $valores[$i] ."'";
				$sql2	=	@mysql_query($sql3,$conexion);
				$sql 	= 	@mysql_fetch_object($sql2);
				
				//Lleno Array Con los datos del listado de los Departamentos
				$list_depar_elim[] = array($i => array(	0 => "$nom_depar"));
				$_SESSION['valores_array'] = $list_depar_elim;
		
				//Activo Mostrar mensaje eliminacion correcta Departamentos
				$act_si_eli = 2;
				$_SESSION['act_eli'] = $act_si_eli;
				
			}	
		
		}

		$cant_eli 		=	count($list_depar_elim);
		$cant_no_eli	=	count($list_depar_no_elim);
		if($cant_eli>0 and $cant_no_eli >0){
			//Activo mensaje WARNING Departamentos
			$act_si_eli = 3;
			$_SESSION['act_eli'] = $act_si_eli;
		}
		if($cantidad == 0 ){
			//Advertencia seleccionar un departamento
			$act_si_eli = 4;
			$_SESSION['act_eli'] = $act_si_eli;
		}	
		
		//Activo Crear mensaje
		$act_crea_msj = 1;
		$_SESSION['act_crea_msj'] = $act_crea_msj;

		echo("<script language=javascript> 
			location.href='$enlace'
		</script>");

	}
	
?>