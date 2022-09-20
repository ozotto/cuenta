<?
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");
	
	$con = new control;
	$con->conectar(); 
	$conexion = $con->conectar();
	
	
	if($_POST['op2'] == "OK") // Cerrar el dia
	{
		$fac="select * from temporal where fecha_factura ='$fecha'";
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

		$sql5 = "update almacen set cant_stock =  '$stock' WHERE  cod_item ='$cod_item';";
		$consulta=mysql_query($sql5,$conexion);
		
		}
		
		$nfa = "select distinct num_factura from temporal where fecha_factura ='$fecha'";
		$nfa2 = mysql_query($nfa,$conexion); 	
		while($nfa3=@mysql_fetch_object($nfa2)){
			$no_fac = $nfa3->num_factura;
			$sum  = "select sum(vr_total) total from temporal where num_factura = '$no_fac' and fecha_factura ='$fecha'";
			$sum2 = @mysql_query($sum,$con->conectar()); 
			$sum3 = @mysql_fetch_object($sum2);	
			$t_fac = $sum3->total;
			
			$ins="
			insert into facturacion (
			id_fac, no_fac, fecha_fac, vr_fac, cod_cli)
			VALUES (
			NULL,  '$no_fac',  '$fecha',  '$t_fac',  '$cod_cli');
			";
			$ins2=mysql_query($ins,$conexion);
		}	
		
		$sql="delete from temporal where fecha_factura ='$fecha'";
		$bor=@mysql_query($sql,$conexion);
		$bor1 = @mysql_fetch_object($bor);		
		echo("<script language=javascript> 
		alert('El $dia de $mes de $ano cerro su facturación');
		</script>");
		echo '<script type="text/javascript">';
		echo 'location.href="administrar.php"';
		echo '</script>';	
	}	

  	$sqln = "select * from temporal where fecha_factura ='$fecha'";
	$nro = $con -> busca_campo($sqln,$conexion);
	if($nro != 0)
	{
		$fac = "select distinct num_factura from temporal where fecha_factura ='$fecha' order by num_factura asc";
		$fac2 = mysql_query($fac,$conexion); 			
?>
<html>
<head>
<title>Facturacion</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script language="javascript">
function valida()
	{
		document.form1.op2.value="OK";
		document.form1.action="facturacion.php";
		document.form1.submit();
	}
</script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">

  <table width="800" border="0" align="center" cellPadding=0 cellSpacing=0>
    <tr>
      <td width="51">&nbsp;</td>	
      <td width="719">
	    <table width="700" border="0" align="center" cellPadding=0 cellSpacing=0>
          <tr>
            <td><table width="684" border="0">
              <tr>
                <td width="147" rowspan="6"><div align="center"><img src="../imagenes/logo_gif.gif" width="136" height="98"></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="334"><span class="Estilo2"><? echo $nom_empr;?></span></td>
                <td width="189">&nbsp;</td>
              </tr>
	          <tr>
                <td valign="top"><span class="Estilo4"><? echo $nit_empr;?></span></td>
                <td bordercolor="#FF0000">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><span class="Estilo4"><? echo $dir_empr;?></span></td>
                <td bordercolor="#FF0000"><span class="Estilo7">Administrador por:</span></td>
              </tr>
              <tr>
                <td valign="top"><span class="Estilo4"><? echo $tel_empr;?></span></td>
                <td bordercolor="#FF0000"><?php echo $name_empleado;?></td>
              </tr>
              <tr>
                <td valign="top">&nbsp;</td>
                <td bordercolor="#FF0000">&nbsp;</td>
              </tr>
              <tr>
                <td>
				  <input type="button" name="button2" id="button2" value="Cerrar Dia" onClick="valida()" />
                  <input name="op2" type="hidden" id="op2" />
				</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="Estilo6">FECHA</span></td>
                <td><span class="Estilo7"><? echo $mes." ".$dia." de ".$ano; ?></span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="Estilo6">No. FACTURA </span></td>
                <td>
				 <select name="can" id="can" onChange="document.form1.can.selectedindex=0;document.form1.submit();">
                  <option> Seleccione</option>
                  <? 
					while($campo = mysql_fetch_object($fac2)){
				  ?>
                  <option value="<? echo $campo->num_factura;?>"<? if($i==$_POST['can']) echo ("selected"); ?>> 
				  <? echo $campo->num_factura;?> </option>
                  <? } ?>
                </select></td>
                <td><span class="Estilo6">VALOR TOTAL EN CAJA </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
				<?
				   	$sum = "select sum(vr_total) total from temporal where fecha_factura ='$fecha'";
					$sum2 = @mysql_query($sum,$conexion); 
					$sum3 = @mysql_fetch_object($sum2);		     
				?>
                <td><table width="189" border="1" bordercolor="#FF0000">
                  <tr>
                    <td><div align="center"><span class="Estilo11">$ <? echo $sum3->total;?></span></div></td>
                  </tr>
                </table></td>
              </tr>
			  <?php
			  if (isset($_POST['can'])){
			  $num_factura=$_POST['can'];	
			  
			  $consulta = "select * from temporal where num_factura = '$num_factura' and fecha_factura ='$fecha'";
		      $rs 	 = @mysql_query($consulta,$conexion); 
			  $campo = @mysql_fetch_object($rs);
			  
			  $cod_empl = $campo->cod_empleado;
			  
			  $empleado = "select * from empleado where cod_empleado = '$cod_empl'";
		      $empl 	 = @mysql_query($empleado,$conexion); 
			  $empl2 = @mysql_fetch_object($empl);
			  
			  $nom_empl = $empl2->name_empleado;
			  
			  ?>
              <tr>
                <td><span class="Estilo6">VENDEDOR</span></td>
                <td><span class="Estilo7"><? echo $nom_empl;?></span></td>
                <td bordercolor="#FF0000"><span class="Estilo6">FACTURA No. </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td rowspan="2">
				<table width="189" border="1" bordercolor="#FF0000">
                  <tr>
                    <td><div align="center"><span class="Estilo11"> <? echo $num_factura;?></span></div></td>
                  </tr>
                </table>				</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td>
	        <table width="683" border="0">
              <tr>
                <td width="467">&nbsp;</td>
                <td width="206">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
	        <table width="682" border="1" bordercolor="#000000">
				<tr>
					<td width="51" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CODIGO</span></div></td>
					<td width="64" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CANTIDAD</span></div></td>
					<td width="300" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">DETALLE</span></div></td>
					<td width="90" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/UNI</span></div></td>
					<td width="83" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/TOTAL</span></div></td>
			        <td width="54" bgcolor="#990000"><span class="Estilo13">ELIMINAR</span></td>
				</tr>
			   <?
			    $consul = "select * from temporal where num_factura = '$num_factura' and fecha_factura ='$fecha'";
		        $fac = @mysql_query($consul,$conexion); 
				while($campos = @mysql_fetch_object($fac)){
			   ?>
			   <tr>
				   <td><span class="Estilo7"><? echo $campos->id_art;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->cantidad;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->detalle;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->vr_venta;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->vr_total;?></span></td>
			       <td bgcolor="#FFFFFF"><div align="center">
				   <a href="borrar_admin.php?id_tem=<? echo $campos->id_tem;?>">
				   <img src="../imagenes/logo_eliminar" width="24" height="25" border="0">
				   </a></div></td>
			   </tr>
			   <? }	
			    $suma = "select sum(vr_total) total from temporal where num_factura = '$num_factura' and fecha_factura ='$fecha'";
				$suma2 = @mysql_query($suma,$con->conectar()); 
				$suma3 = @mysql_fetch_object($suma2);	
			   ?>
			   <tr>
					<td colspan="4" bgcolor="#CCCC00">
					<div align="right"><strong>TOTAL FACTURA No. 
					<? echo $num_factura;?>
					</strong></div>					</td>
					<td bgcolor="#CCCC00"><span class="Estilo11"><? echo $suma3->total;?></span></td>
			        <td bgcolor="#990000">&nbsp;</td>
			   </tr>
			  </table>							
			</td>
          </tr>
          <tr>
            <td></td>
          </tr>
        </table>	  
	  </td>
      <td width="30">&nbsp;
	  </td>
    </tr>
  </table>    
</form>
</body>
</html>
 <?
	}
	}else{
		echo("<script language=javascript> 
		alert('El $dia de $mes de $ano aun NO registra ventas para facturación');
		</script>");
		echo '<script type="text/javascript">';
		echo 'location.href="administrar.php"';
		echo '</script>';		
	}	
	?>

	 