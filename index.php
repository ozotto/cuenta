<?php
	session_start();
	include("clases/control.php");
	include("clases/datos.php");
	$con=new control;
	$con->conectar();
	$conexion =$con->conectar();
	
	$valor_inicial = isset($_POST['op']) ? $_POST['op'] : NULL;
		
	if($valor_inicial == "OKS")
	{
		 $ced = $_POST['ced'];
		 $pwd = $_POST['pwd'];
		 
		 $sqlenc="select md5('$pwd') as enc";
		 $cons1 =  @mysql_query($sqlenc,$conexion);
		 $campos1 = @mysql_fetch_object($cons1);
		
		 $contra = $campos1 -> enc; 
	 
		 $sqln = "select * from usuario where login='$ced' and contrasena = '$contra'";
		 $nro = $con -> busca_campo($sqln,$conexion);
		 if($nro != 0)
		 {
		
		 	$sql4="select * from usuario where login='$ced' and contrasena = '$contra'";
		 	$consulta4=mysql_query($sql4,$conexion);
		 	$campos4=mysql_fetch_object($consulta4);
	 
		 	$cod_usu= $campos4->cod_usu;
 	
		 	$sql="select * from empleado where cod_usu='$cod_usu'";
		 	$co1=mysql_query($sql,$conexion);
		 	$cam=mysql_fetch_object($co1);
	 	 
		 	$cod_rol	= $cam->cod_rol;
			$no_emple	= $cam->cod_empleado;
		 	$name_empleado = $cam->name_empleado;
		 
	 		if($cod_rol == 1)
	 		{
	 		
				$_SESSION['contra'] 		= $contra;
				$_SESSION['cod_usu']		= $cod_usu;
				$_SESSION['name_empleado']	= $name_empleado;
			
	 			echo("<script language=javascript>
					location.href='Admin/administrar.php';
					</script>");	
	 		}
	 		if($cod_rol == 2)
	 		{	
				$_SESSION['contra'] 		= $contra;
				$_SESSION['cod_usu']		= $cod_usu;
				$_SESSION['no_emple']		= $no_emple;
				$_SESSION['name_empleado']	= $name_empleado;
			//location.href='User/factura2.php';
			//location.href='prueba/objetos.php';
			$no_sig = $con -> num_factura_siguiente($conexion);
			$vr_def = 123;
				//Para ir a la vieja facturacion	
			/*	if($cod_usu	== '201'){
					echo("<script language=javascript>
					location.href='User/factura2.php';
					</script>");
				}else{
					echo("<script language=javascript>
					location.href='User/factura_user.php?id_pen=$no_sig&fec=$fecha&v_def=$vr_def';
					</script>");	
				}	
	 		*/
			echo("<script language=javascript>
					location.href='User/factura_user.php?id_pen=$no_sig&fec=$fecha&v_def=$vr_def';
					</script>");
			
			}
			if($cod_rol == 3)
	 		{
	 		
				$_SESSION['contra'] 		= $contra;
				$_SESSION['cod_usu']		= $cod_usu;
				$_SESSION['name_empleado']	= $name_empleado;
			
	 			echo("<script language=javascript>		
					location.href='Super/admin.php';
					</script>");	
	 		}
		}else{
			echo("<script language=javascript>
					alert('El usuario y la contraseña son incorrectos!!');
				</script>");
		}
	}
?>
<html>
<head>
<meta>
<title>Logeo</title>
<link href="Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script>
function sf(ID){
document.form1.ced.focus();
}
</script>
<script  language="javascript">
	function valida2()
	{
		if(document.form1.ced.value=="" )
		{
			alert("FALTA LLENAR CAMPOS REQUERIDOS");
		}
		else
		{	
			document.form1.op.value="OKS";
			document.form1.action="index.php";
			document.form1.method="Post";
			document.form1.submit();			
		}		
	}
</script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onLoad="sf('text');">
<form action="" method="post" name="form1" class="Estilo3" id="form1">
<table width="224" border="0" align="center" cellPadding=0 cellSpacing=0>
    <tr>
      <td width="79"><span class="Estilo1 Estilo12">Login:</span></td>
      <td width="75">
	   <input name="ced" type="text" id="ced" style="font:'Trebuchet MS'; font-size:10px;" size="15" maxlength="12" align="right" />	  </td>
    </tr>
    <tr>
      <td><span class="Estilo1 Estilo12">Contrase&ntilde;a:</span></td>
      <td>
	  <input name="pwd" type="password" id="pwd" style="font:'Trebuchet MS'; font-size:10px;" size="15" maxlength="12" align="right" />	  
	  <input name='dat_def' type='hidden' id='dat_def'/>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label></label></td>
      <td><label>
        <input type="submit" name="Submit2" value="Ingresar" onClick="valida2()">
        </label>
          <input name="op" type="hidden" id="op" /></td>
    </tr>
</table>
</form>
</body>
</html>
