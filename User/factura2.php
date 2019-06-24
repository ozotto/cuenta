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
	
	//Verifico que el rol sea VENDEDOR para factura
	$cod_rol =	$empl2->cod_rol;

	if($cod_rol = 2)
	{
		$activa = 1;
	}else{
		$activa = 0;
	}
	
	//-Datos de Empleado	
	$cod_empresa =	$empl2->cod_empresa;
	$cod_emple	 = 	$empl2->cod_empleado;	

	//-Consulta tabla Empresa	
	$sql3="select * from empresa where cod_empresa = '$cod_empresa'";
	$emp=@mysql_query($sql3,$conexion);
	$emp3=@mysql_fetch_object($emp);
	
	//-Datos de Empresa	
	$nom_empr=$emp3->name_empresa;
	$nit_empr=$emp3->nro_tribut;
	$dir_empr=$emp3->direcc1;
	$tel_empr=$emp3->nro_telefo;
	$n_ciu = $emp3->ciudad;
	$n_dep = $emp3->state;
	$n_pai = $emp3->pais;
	
	//-Datos de Cliente
	$cli = "select * from clientes where cod_cli = 1";
	$cli2 = @mysql_query($cli,$con->conectar()); 
	$cli3 = @mysql_fetch_object($cli2);
	$cod_cli = $cli3->cod_cli;	
	$nom_cli = $cli3->name_cli;	
	$nom_cli = strtolower($nom_cli); 		
	$nom_cli = ucwords($nom_cli);	

	//Valor Total En Caja
   	$sum = "select sum(vr_total) total from temporal where fecha_factura ='$fecha'";
	$sum2 = @mysql_query($sum,$conexion); 
	$sum3 = @mysql_fetch_object($sum2);	
	$sum3->total = number_format($sum3->total, 0, ",", ".");

//Datos Ultima Factura Registrada
   	$ult 	= "select * from temporal order by num_factura desc";
	$ult2 	= @mysql_query($ult,$conexion); 
	$t_art	= @mysql_num_rows($ult2);
	$ult3 	= @mysql_fetch_object($ult2);	
	$ult_fac = $ult3->num_factura;
	$fec_fac = $ult3->fecha_factura;
	$numeroRegistros = $t_art;
	
	$sum_ult = "select sum(vr_total) total from temporal where num_factura ='$ult_fac'";
	$sum_ult2 = @mysql_query($sum_ult,$conexion); 
	$sum_ult3 = @mysql_fetch_object($sum_ult2);	
	$sum_ult_fac = $sum_ult3->total;
	$sum_ult_fac = number_format($sum_ult_fac, 0, ",", ".");
	
	$can_ult = "select * from temporal where num_factura ='$ult_fac'";
	$can_ult2 = @mysql_query($can_ult,$conexion); 
	$can_art	= @mysql_num_rows($can_ult2);
		
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
			$fac_dia=1;

		}else{
			$sql5="select max(no_fac) as num_fac from facturacion";
			$num=@mysql_query($sql5,$conexion);
			$num2=@mysql_fetch_object($num);
			$mayor = $num2->num_fac;
			$num_fac = $mayor + 1;
			$fac_dia=1;
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
			$fac_dia=1;
		}else{
			$num_fac = 1;
			$fac_dia=1;
		}
	}
	$_SESSION['fac_dia'] = $fac_dia; 
	$_SESSION['factura'] = $num_fac;

//Boton Nueva Factura	
	if($_POST['op2'] == "OK")
	{
		//Nueva factura
		$valor=$_POST['no_fac'];
		$num_fac = $valor +1;
		$_SESSION['factura'] = $num_fac;
		//Contador Facturas
		$cont = $_POST['fac_dia'];
		$fac_dia = $cont + 1;
		$_SESSION['fac_dia'] = $fac_dia; 
	}	
//Campo de texto del articulo	
	$cadena=$_POST['inputString'];
	if($cadena>0){
		$nueva=10;
	}
	if (isset($_POST['can'])){
		$nueva=10;
		$hacer_factura = 1;
	}
	if($_POST['oc'] == "OK")
	{
		$nueva=10;
	}
	if($nueva==10){
		$valor=$_POST['no_fac'];
		$num_fac = $valor;
		$_SESSION['factura'] = $num_fac;
	}
//FIN Busco el numero de la factura		
	
//Validacion Datos de busqueda del articulo
	$cadena=$_POST['inputString'];
	list($codigo,$detalle)=split('[_]',$cadena);
	if (empty($cadena)){
	}else{
		$cod_item 			= $codigo; 	//Guardo el codigo de articulo
		$busca_art 			= 1;			//Activo la para hacer la busqueda
		$tex_art 			= 1;			//Para mostrar el mensaje de alerta
		$_SESSION['cod'] 	= $codigo;
	}
	$cod=$_POST['clave'];
	if (empty($cod)){
	}else{
		$cod_item 			= $cod;		//Guardo el codigo de articulo
		$busca_art 			= 1;			//Activo la para hacer la busqueda
		$tex_art 			= 2;			//Para mostrar el mensaje de alerta
		$_SESSION['cod']	= $cod;	//Guardo el codigo del articulo en una sesion
	}
	if($busca_art == 1){
		$sql2="select * from almacen where cod_item = '$cod_item'";
		$consulta2=@mysql_query($sql2,$con-> conectar());
		$campos=@mysql_fetch_object($consulta2);
		$cant1=$campos->cant_stock;
					
		$tem="select sum(cantidad) as total from temporal where id_art= '$cod_item' ";
		$tem2=@mysql_query($tem,$conexion);
		$tem3=@mysql_fetch_object($tem2);
		$cant2=$tem3->total;
					
		$cant=$cant1-$cant2;
		$vr=$campos->precio;
		//$vr = number_format($vr, 0, ",", ".");
		if($cant<=0){
			if($tex_art == 1){
				echo("<script language=javascript> 
				alert('El articulo $detalle NO registra existencias en stock');
				</script>");
			}
			if($tex_art == 2){
				echo("<script language=javascript> 
				alert('El codigo $cod_item NO registra existencias en stock');
				</script>");
			}
		}
	}   
//Mostrar Factura, hace calculos
	if ($hacer_factura==1){
		$cantidad	=$_POST['can'];
		$producto	=$_POST['articulo'];
		$valor		=$_POST['vr'];
		$cod 		=$_SESSION['cod'];
			
		$v_total=$valor*$cantidad;
				
		if($cantidad>0){
		$int="	
		insert into temporal 
		(id_tem ,id_art ,cantidad, detalle ,vr_venta ,vr_total, num_factura, fecha_factura, cod_empleado, cod_cli)
		VALUES 
		(NULL , '$cod', '$cantidad', '$producto', $valor, '$v_total', $num_fac, '$fecha', '$cod_emple', '$cod_cli');";
		$int2=mysql_query($int,$conexion);
		}

	}
	$orden="fecha_factura"; 
	$criterio = "where fecha_factura = '$fecha' and num_factura = '$num_fac'";

	
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

<? 
//Verifico el Valor para que solo el usuario de tipo vendedor pueda crear la factura
if ($activa == 1){
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <?  //echo tabla1 Encabezado empresa?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="165">&nbsp;</td>
        <td width="221">&nbsp;</td>
        <td width="100">&nbsp;</td>
        <td width="81">&nbsp;</td>
        <td width="233">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="5"><img src="../imagenes/logo_gif.gif" width="136" height="98" /></td>
        <td colspan="3"><span class="Estilo2"><? echo $nom_empr;?></span></td>
        <td><span class="Estilo7"><? echo $mes." ".$dia." de ".$ano; ?></span></td>
      </tr>
      <tr>
        <td colspan="3"><span class="Estilo4"><? echo $nit_empr;?></span></td>
        <td><span class="Estilo6">VALOR TOTAL EN CAJA </span></td>
      </tr>
      <tr>
        <td colspan="3"><span class="Estilo4"><? echo $dir_empr;?></span></td>
        <td rowspan="3" valign="top">
        <table width="100" border="1" bordercolor="#FF0000">
          <tr>
            <td width="100"><div align="center">
              <table width="100" border="0">
                <tr>
                  <td width="32"><div align="center"><span class="Estilo11">$</span></div></td>
                  <td width="100"><div align="right"><span class="Estilo10"><span class="Estilo10"></span><? echo $sum3->total;?></span></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td colspan="3"><span class="Estilo4"><? echo $tel_empr;?></span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table>      
    <?  //echo FIN tabla1 Encabezado empresa?>
    <?  //echo tabla2 Menu?>
    <table width="787" border="0">
      <tr>
        <td>
			<input type="button" name="button2" id="button2" value="Nueva Factura" onClick="valida()" />
            <input name="op2" type="hidden" id="op2" />
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <?  //echo FIN tabla2 Menu?>
    <? //Tabla tabla2.1 Info Facturacion?>
    <table width="800" align="center" border="1" bordercolor="#000000">
    <tr>
     <td>
     <table width="800" border="0">
     <tr>
     <td width="156" class="tit_peq">No. Factura en el Dia</td>
     <td width="149"><span class="tit_peq">No. Ultima Factura</span></td>
     <td width="154"><span class="tit_peq">Fecha  Ult Factura</span></td>
     <td width="172"><p><span class="tit_peq">Valor  Ultima Factura</span></p></td>
     <td width="147"><span class="tit_peq">Cantidad de Articulos</span></td>
     </tr>
     <tr>
       <td>
       <input type="text" name="fac_dia" id="fac_dia" value="<? echo $fac_dia;?>" size="2" readonly >
       </td>
       <td>
       <input type="text" name="fac_dia" id="fac_dia" value="<? echo $ult_fac;?>" size="10" readonly >
       </td>
       <td><input type="text" name="fac_dia4" id="fac_dia4" value="<? echo $fec_fac;?>" size="10" readonly ></td>
       <td><input type="text" name="fac_dia3" id="fac_dia3" value="$ <? echo $sum_ult_fac;?>" size="10" readonly ></td>
       <td><input type="text" name="fac_dia2" id="fac_dia2" value=" <? echo $can_art;?>" size="10" readonly ></td>
       </tr>
     </table>
     </td>
    </tr>
    </table>
	<? //Tabla FIN tabla2.1 Info Facturacion?>
	<?  //echo tabla3 Encabezado factura?>
    <table width="800" align="center" border="1" bordercolor="#000000">
    <tr>
     <td>
     <table width="800" border="0">
     <tr>
      <td colspan="4" class="Estilo8">
       <div align="left"><? echo $nom_empr;?></div>				  
      </td>
      <td width="133">&nbsp;</td>
      <td width="208">&nbsp;</td>
      <td width="25">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="4">
		<div align="left"><span class="Estilo7"><? echo $nit_empr;?></span></div>				  
      </td>
      <td><span class="Estilo8">Fecha Factura</span></td>
      <td><span class="Estilo8">No. Factura</span></td>
      <td>&nbsp;</td>
     </tr>
     <tr>
      <td colspan="4" class="Estilo7">
       <div align="left"><? echo $dir_empr;?></div>				  
      </td>
      <td><span class="Estilo7"><? echo $mes." ".$dia." de ".$ano; ?></span></td>
      <td rowspan="2"><table width="208" border="1" bordercolor="#FF0000">
        <tr>
          <td width="198"><div align="center">
            <label>
              <input type="no_fac" name="no_fac" value="<? echo $num_fac;?>" 
              size="10" readonly style="font-family: 
              Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC">
            </label>
          </div></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
     </tr>
     <tr>
       <td colspan="4" class="Estilo7">
         <div align="left"><? echo $n_ciu." - ".$n_dep." - ".$n_pai;?></div>				  
         </td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td colspan="2"><span class="Estilo8">Vendedor</span></td>
       <td colspan="2"><? echo $name_empleado;?></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td colspan="2"><span class="Estilo8">Cliente</span></td>
       <td colspan="2"><? echo $nom_cli;?></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     </table>
     </td>
    </tr>
    </table>	    
    <?  //echo FIN tabla3 Encabezado factura?>
    <? //echo Tabla 4 Buscar Articulo?>
    <table width="800" border="0">
    <tr>
     <td>
	 <table width="800" border="0">
     <tr>
      <td width="158" valign="top"><span class="Estilo6">Seleccione Articulo</span></td>
      <td width="626">
	   <input name="inputString" type="text" class="Estilo7" id="inputString" onBlur="fill();" 
       onKeyUp="lookup(this.value);" size="30"/>
	   <div span class="Estilo7">
	   <div class="suggestionsBox" id="suggestions" style="display: none;">
	   <img src="../clases/auto/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
       <div class="suggestionList" id="autoSuggestionsList"> &nbsp; </div>
  	   </div>
	   </div>
	  </td>
     </tr>
     <tr>
      <td><span class="Estilo6">Codigo de Barras Articulo</span></td>
      <td>
		<span class="Estilo7">
         <input type="text" name="clave" id="clave" onKeyUp= "enviar()">
        </span>
	  </td>
     </tr>
     </table>
	 </td>
    </tr>
    </table>
    <? //echo FIN Tabla 4 Buscar Articulo?>
    <? //echo Tabla5 Datos Articulo?>
    <? 
	if($cant>0){
	?>
    <table width="800" border="0">
    <tr>
     <td>
	 <table width="800" border="0">
     <tr>
      <td width="146"><span class="Estilo6">Articulo</span></td>
      <td width="380">
	   <input type="articulo" name="articulo" value="<? echo $detalle; ?>" readonly size="60">
	  </td>
      <td width="260"><span class="Estilo6">VALOR UNITARIO</span></td>
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
	  	</select>
	  </td>
      <td rowspan="2">
	  <table width="208" border="1" bordercolor="#FF0000">
      <tr>
       <td width="198">
		<div align="center"><span class="Estilo11">$</span>
		<label>
		<input type="vr" name="vr" value="<? echo $vr; ?>"  size="10" readonly
		style="font-family: Arial; font-size: 24px; color:#FF0000; font-weight: bold; background-color: #CCCCCC">
  		</label>
		</div>
	   </td>
      </tr>
      </table>
	  </td>
     </tr>
     <tr>
      <td>&nbsp;</td>
      <td><input name="re" type="hidden" id="re"/>
	  </td>
     </tr>
     </table>
	 </td>
    </tr>
    </table>
    <?
	}
	?>
	<? //echo FIN Tabla5 Datos Articulos?>
    <? // Tabla6 Factura?>
    <?
    if (isset($_POST['can'])){
	?>
    <table width="800" border="0">
    <tr>
     <td>
	 <table width="800" border="1" bordercolor="#000000">
     <tr>
      <td width="29" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">No</span></div></td>
      <td width="70" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CODIGO</span></div></td>
      <td width="90" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">CANTIDAD</span></div></td>
      <td width="393" bgcolor="#CCCC00"><div align="center">
      <div align="center"><span class="Estilo6">DETALLE</span></div>
      </div>
	  </td>
      <td width="86" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/UNI</span></div></td>
      <td width="92" bgcolor="#CCCC00"><div align="center"><span class="Estilo6">VR/TOTAL</span></td>
      </tr>
	 <?
	 $contador=1;
	 $com="select * from temporal ".$criterio;
	 $com2=@mysql_query($com,$conexion);
	 while ($campos=@mysql_fetch_object($com2)){
		 $vr_venta = $campos->vr_venta;
		 $vr_total = $campos->vr_total;
		 $vr_venta = number_format($vr_venta, 0, ",", ".");
		 $vr_total = number_format($vr_total, 0, ",", ".");
		 
	 ?>
     <tr>
      <td><span class="Estilo7"><? echo $contador;?></span></td>
      <td><span class="Estilo7"><? echo $campos->id_art;?></span></td>
      <td><span class="Estilo7"><? echo $campos->cantidad;?></span></td>
      <td><span class="Estilo7"><? echo $campos->detalle;?></span></td>
      <td><span class="Estilo7"><? echo $vr_venta;?></span></td>
      <td><span class="Estilo7"><? echo $vr_total;?></span></td>
      </tr>
	 <? 
	 $contador++;
	 }
	 $sum = "select sum(vr_total) total from temporal where fecha_factura = '$fecha' and num_factura = '$num_fac'";
	 $sum2 = @mysql_query($sum,$conexion); 
	 $sum3 = @mysql_fetch_object($sum2);	
	 $sum3->total = number_format($sum3->total, 0, ",", ".");

     ?>
     <tr>
      <td colspan="5" bgcolor="#CCCC00">
  	   <div align="right"><span class="Estilo6">TOTAL FACTURA No. <? echo $no_orde;?>  </span></div>
	  </td>
      <td bgcolor="#CCCC00"><span class="Estilo11"><? echo $sum3->total;?></span></td>
     </tr>
     </table>
	 </td>
    </tr>
    </table>
    <?
	}
	?>
	<? // FIN Tabla6 Factura?>
    </td>
  </tr>
</table>
<?
}else{
	echo "No esta autorizado para crear factura";
	}
?>
</body>
</html>
