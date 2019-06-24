<?
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	//-Consulta tabla Empleado
	$sql4="select * from empleado where cod_usu = '$cod_usu'";
	$empl=@mysql_query($sql4,$conexion);
	$empl2=@mysql_fetch_object($empl);
	//-Datos de Empleado	
	$cod_empresa =	$empl2->cod_empresa;
	$cod_emple	 = 	$empl2->cod_empleado;	

	//-Consulta tabla Empresa	
	$sql3="select * from empresa where cod_empresa = '$cod_empresa'";
	$emp=@mysql_query($sql3,$conexion);
	$emp3=@mysql_fetch_object($emp);
	//-Datos de Empresa	
	$nom_empr=$emp3->name_empresa;
	$dir_empr=$emp3->direcc1;
	$tel_empr=$emp3->nro_telefo;
	$nit_empr=$emp3->nro_tribut;
	
	
//Busco el numero de la factura	
	$sqln = "select * from facturacion";
	$nro = $con -> busca_campo($sqln,$conexion);
	if($nro != 0)
	{
		$sqln = "select * from temporal";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			$sql5="select max(num_factura) as num_fac from temporal";
			$num=@mysql_query($sql5,$conexion);
			$num2=@mysql_fetch_object($num);
			$mayor = $num2->num_fac;
			$num_fac = $mayor + 1;

		}else{
			$sql5="select max(no_fac) as num_fac from facturacion";
			$num=@mysql_query($sql5,$conexion);
			$num2=@mysql_fetch_object($num);
			$mayor = $num2->num_fac;
			$num_fac = $mayor + 1;

		}
	}else{
		
		$sqln = "select * from temporal";
		$nro = $con -> busca_campo($sqln,$conexion);
		if($nro != 0)
		{
			$sql5="select max(num_factura) as num_fac from temporal";
			$num=@mysql_query($sql5,$conexion);
			$num2=@mysql_fetch_object($num);
			$mayor = $num2->num_fac;
			$num_fac = $mayor + 1;
		}else{
			$num_fac = 1;
		}
	}
	$_SESSION['factura'] = $num_fac;

//Boton Nueva Factura	
	if($_POST['op2'] == "OK")
	{
		//Nueva factura
		$valor=$_POST['fr'];
		$num_fac = $valor +1;
		$_SESSION['factura'] = $num_fac;
	}	
//Campo de texto del articulo	
	$cadena=$_POST['inputString'];
	if($cadena>0){
		$nueva=10;
	}
	if (isset($_POST['can'])){
		$nueva=10;
	}
	if($_POST['oc'] == "OK")
	{
		$nueva=10;
	}
	if($nueva==10){
		$valor=$_POST['fr'];
		$num_fac = $valor;
		$_SESSION['factura'] = $num_fac;
	}
//FIN Busco el numero de la factura		
	
?>
<html>
<head>
<title>Facturacion</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script type="text/javascript" src="../clases/auto/jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("../clases/auto/comboauto.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
		
	}
	
</script>
<script>
function sf(ID){
document.form1.inputString.focus();
//document.form1.clave.focus();
}
</script>
<script language="javascript">
	function enviar(){
		document.form1.oc.value="OK";
		document.form1.action="factura2.php";
		document.form1.submit();
	}
	function valida()
	{
		document.form1.op2.value="OK";
		document.form1.action="factura2.php";
		document.form1.submit();
	}
</script>

<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onLoad="sf('text');">
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
                <td bordercolor="#FF0000">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><span class="Estilo4"><? echo $tel_empr;?></span></td>
                <td bordercolor="#FF0000">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top">&nbsp;</td>
                <td bordercolor="#FF0000">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="Estilo6">FECHA</span></td>
                <td><span class="Estilo7"><? echo $mes." ".$dia." de ".$ano; ?></span></td>
                <td bordercolor="#FF0000"><span class="Estilo6">FACTURA No. </span></td>
              </tr>
              <tr>
                <td><span class="Estilo6">VENDEDOR</span></td>
                <td><span class="Estilo7"><? echo $name_empleado;?></span></td>
                <td rowspan="4" valign="top">
				<table width="189" border="1" bordercolor="#FF0000">
                  <tr>
                    <td>
					<label>
					<input type="fr" name="fr" value="<? echo $num_fac; ?>"  size="10"
					style="font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC">
  					</label>
					</td>
                  </tr>
                </table>				</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
				  <input type="button" name="button2" id="button2" value="Nueva Factura" onClick="valida()" />
                  <input name="op2" type="hidden" id="op2" />
				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td>
			
			<table width="682" border="0" cellPadding=0 cellSpacing=0>
              <tr>
                <td width="152" valign="top"><span class="Estilo6">Digite el Nombre o Codigo del  Articulo</span></td>
                <td width="530">   			
				<input name="inputString" type="text" id="inputString" onBlur="fill();" onKeyUp="lookup(this.value);" size="30"/>
				<div class="suggestionsBox" id="suggestions" style="display: none;"><span class="Estilo7">
	   			<img src="../clases/auto/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
       			<div class="suggestionList" id="autoSuggestionsList"> &nbsp; </span></div>
  			    </div>
			    </td>
              </tr>
              <tr>
                <td valign="top"><span class="Estilo6">Codigo de Barras Articulo</span></td>
                <td><span class="Estilo7"><input type="text" name="clave" id="clave" onKeyUp="enviar();">
                  <input name="oc" type="hidden" id="oc" />
                </span></td>
              </tr>
            </table>
			<?
  				$cadena=$_POST['inputString'];
				$num_factura = $num_fac;
				//echo $num_factura;
				list($codigo,$detalle)=split('[_]',$cadena);
				if (empty($cadena)){
				}else{
					//echo $no_fact=$_POST['fr'];
					
					$sql2="select * from almacen where cod_item = '$codigo'";
					$consulta2=@mysql_query($sql2,$con-> conectar());
					$campos=@mysql_fetch_object($consulta2);
					$cant1=$campos->cant_stock;
					
					$tem="select sum(cantidad) as total from temporal where id_art= '$codigo' ";
					$tem2=@mysql_query($tem,$conexion);
					$tem3=@mysql_fetch_object($tem2);
					$cant2=$tem3->total;
					
					$cant=$cant1-$cant2;
					$vr=$campos->precio;
					if($cant<=0){
						echo("<script language=javascript> 
						alert('El articulo $detalle NO registra existencias en stock');
						</script>");
					}
				}
	
			$cod=$_POST['clave'];
			if (empty($cod)){
			}else{

				$sql2="select * from almacen where cod_item = '$cod'";
				$consulta2=@mysql_query($sql2,$con-> conectar());
				$campos=@mysql_fetch_object($consulta2);
				$cant1=$campos->cant_stock;
				$detalle=$campos->des_item;
				
				$tem="select sum(cantidad) As TOTAL from temporal where id_art= '$cod' ";
				$tem2=@mysql_query($tem,$con-> conectar());
				$tem3=@mysql_fetch_object($tem2);
				$cant2=$tem3->total;
				
				$cant=$cant1-$cant2;
				$vr=$campos->precio;
				if($cant<=0){
					echo("<script language=javascript> 
					alert('El codigo $cod NO registra existencias en stock');
					</script>");
				}
			}   
   			if($cant>0){	
   			?>
	        <table width="682" border="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="149"><span class="Estilo6">Articulo</span></td>
                <td width="335">
				<label><input type="articulo" name="articulo" value="<? echo $detalle; ?>" readonly size="60">
  				</label>				</td>
                <td width="184"><span class="Estilo6">VALOR UNITARIO</span></td>
              </tr>
              <tr>
                <td><span class="Estilo6">Cantidad</span></td>
                <td>
				
				<select name="can" id="can" onChange="document.form1.can.selectedindex=0;document.form1.submit();">
    			<option> Seleccione</option>
			
			  	<? 
			  	for($i=1;$i<=$cant;$i++){ ?>
				<option value="<? echo $i;?>"<? if($i==$_POST['can']) echo ("selected"); ?>> <? echo $i;?> </option>
			  	<? } ?>
			  	</select>				</td>
                <td rowspan="2"><table width="208" border="1" bordercolor="#FF0000">
                  <tr>
                    <td width="198">
					<div align="center"><span class="Estilo11">$</span>
					<label>
					<input type="vr" name="vr" value="<? echo $vr; ?>"  size="10" readonly
					style="font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC">
  					</label>
					</div>					</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table>
	          <?
				}
				if (isset($_POST['can'])){
					$cantidad=$_POST['can'];
					$producto=$_POST['articulo'];
					$valor=$_POST['vr'];
					
					$cod="select * from almacen where des_item='$producto'";
					$cod2=@mysql_query($cod,$conexion);
					$cod3=@mysql_fetch_object($cod2);
					$cod=$cod3->cod_item;
					$v_total=$valor*$cantidad;
					
					if($cantidad>0){
					$int="	INSERT INTO temporal (id_tem ,id_art ,cantidad, detalle ,vr_venta ,vr_total, num_factura, fecha_factura, cod_empleado)
							VALUES (NULL , '$cod', '$cantidad', '$producto', $valor, '$v_total', $num_factura, '$fecha', '$cod_emple');";
					$int2=mysql_query($int,$conexion);
	
				   	$sum = "select sum(vr_total) total from temporal where fecha_factura ='$fecha'";
					$sum2 = @mysql_query($sum,$conexion); 
					$sum3 = @mysql_fetch_object($sum2);	
				 }
			     
			?>
	        <table width="683" border="0">
              <tr>
                <td width="467">&nbsp;</td>
                <td width="206"><span class="Estilo6">VALOR TOTAL EN CAJA </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
				<table width="189" border="1" bordercolor="#FF0000">
                  <tr>
                    <td><div align="center"><span class="Estilo11">$ <? echo $sum3->total;?></span></div></td>
                  </tr>
                </table>
				</td>
              </tr>
            </table>
	        <table width="682" border="1" bordercolor="#000000">
				<tr>
				  <td width="80" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CODIGO</span></div></td>
				  <td width="71" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CANTIDAD</span></div></td>
				  <td width="293" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">DETALLE</span></div></td>
					<td width="94" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/UNI</span></div></td>
					<td width="110" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/TOTAL</span></div></td>
			   </tr>
			   <?
				$consulta = "select * from temporal where num_factura = '$num_factura' and fecha_factura ='$fecha'";
				$rs = mysql_query($consulta,$con->conectar()); 
				while($campos = mysql_fetch_object($rs)){
			   ?>
			   <tr>
				   <td><span class="Estilo7"><? echo $campos->id_art;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->cantidad;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->detalle;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->vr_venta;?></span></td>
				   <td><span class="Estilo7"><? echo $campos->vr_total;?></span></td>
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
					</strong></div>
					</td>
					<td bgcolor="#CCCC00"><span class="Estilo11"><? echo $suma3->total;?></span></td>
			   </tr>
			  </table>
			   <? }?>										
			</td>
          </tr>
          <tr>
            <td><a href="javascript:location.reload()">Actualizar</a></td>
          </tr>
        </table>	  </td>
      <td width="30">&nbsp;</td>
    </tr>
  </table>   
</form>
<?
	//}
?>
</body>
</html>
