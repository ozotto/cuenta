<?
	session_start();
	include("../clases/control.php");
	$con=new control;
	$con->conectar();
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	$valor = $_GET['id_tem'];
	$valor1 = $_GET['id_depto'];
	$valor2 = $_GET['id_pro'];
	$valor3 = $_GET['id_fac'];
	$valor4 = $_GET['art'];
	$valor5 = $_GET['cod_art'];
	
	if($valor >0){
		$sql="delete from temporal where id_tem='$valor'";
		$con->borrar1($sql,$conexion);
	}
	if($valor1 >0){
		$sql="delete from departamento where cod_depto='$valor1'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Departamento se Elimino Exitosamente')
		 location.href='departamento.php?id_depto=-1';
		</SCRIPT>";
	}
	if($valor2 >0){
		$sql="delete from proveedor where cod_pro='$valor2'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Proveedor se Elimino Exitosamente')
		 location.href='proveedor.php?id_pro=-1';
		</SCRIPT>";
	}
	if($valor3 >0){
		$sql="delete from compra_temporal where id_tem_c='$valor3'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		  location.href='compras.php?val=2';
		</SCRIPT>";
		//alert('El Articulo se Elimino Exitosamente de la Factura')
	}
	if($valor4 >0){
		$valor4 = $_GET['art'];
		$cod_pen	= $_GET['id_pen'];
		$fecha_fac	= $_GET['fec'];
		
		echo $sql="delete from compra_temporal where id_tem_c='$valor4'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		  location.href='compras2.php?men2=1&id_pen=".$cod_pen."&fec=".$fecha_fac."';
		</SCRIPT>";
	}
	if($valor5 >0){
		$valor5 = $_GET['cod_art'];
		$menu	= $_GET['men2'];
		$id_fac	= $_GET['id_pen'];
		$fecha_fac	= $_GET['fec'];
		
		$sql="delete from temporal where id_tem='$valor5'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);	
		echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		  location.href='ventas2.php?men2=".$menu."&id_pen=".$id_fac."&fec=".$fecha_fac."';
		</SCRIPT>";
	}

//	$con->borrar1($sql,$con-> conectar());
	?>