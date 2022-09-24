<?php
	if(!isset($_SESSION)) 
  { 
        session_start(); 
  }
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");
		
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	$cod_envia = $_GET['id_art'];
			
	//Consultas
	$cons="select count(cod_item) as total from almacen";
	$cons2=@mysql_query($cons,$conexion);
	$cons3=@mysql_fetch_object($cons2);
	$t_inv = $cons3->total;
	
	$con="select sum(costo) as total from almacen";
	$con2=@mysql_query($con,$conexion);
	$con3=@mysql_fetch_object($con2);
	$c_inv = $con3->total;
	
	$c_inv = number_format($c_inv, 2, ",", ".");
	
	$dep="select count(cod_depto) as total from departamento";
	$dep2=@mysql_query($dep,$conexion);
	$dep3=@mysql_fetch_object($dep2);
	$t_dep = $dep3->total;

	$ult="select * from compras where fecha_compra between '$fecha_ant' and '$fecha' limit 0, 5";
	$ult2=@mysql_query($ult,$conexion);
	$u_art=mysql_num_rows($ult2); 
	$ult_pro = $u_art;
	
	$ulta="select max(fecha_compra) as total from compras";
	$ulta2=@mysql_query($ulta,$conexion);
	$ulta3=@mysql_fetch_object($ulta2); 
	$ult_com = $ulta3->total;
	
	//Paginacion
	//Validacion desde java para saber si esta seleccionado un depar
	if($_POST['ver2'] == "OK")
	{
		$val_java = "0"; // Falta seleccio un departamento
	}else{
		if (isset($_POST['can'])){
			$val_java = "9"; // Selecciono un departamento 
		}	
	}
	
	//Valido el siguiente de los departamentos
	$val_dep2 = $_GET['cano'];
	if($val_dep2>0){
		$val_java ="9";
	}
	
	//Para el combo de los departamento	
	if($val_java==9){
	 if (isset($_POST['can'])){
		$val_dep = $_POST['can'];
		$cod_depto=$_POST['can'];
		$dig = -1;
	 }else{
	 	$cod_depto=$_GET['cano'];
		$reg_art = $cod_depto;
		$val_dep = $cod_depto; 
	 }	
	}	
	
	if($val_dep>0){
		
		$cant="select * from almacen".$criterio." where cod_depto='$cod_depto'";
		$cant2=@mysql_query($cant,$conexion);
		$t_art=mysql_num_rows($cant2); 
	 }
	 //Para la caja de buscar
	 if($val_dep2>0){
	 	$dig = -1;
	 }else{
	 	$dig = $_GET['dig'];
	 }
	
	 if($dig>0){
	 	
		$buscador = 1;
	  	$buscar = $_GET['buscor'];
		$val_dep = -1;
		if (isset($_POST['can'])){
			$buscador = -1;
		}
	 }
	 if($_POST['ver'] == "OK")
	 {
		if ($cod_depto>0){
			$buscador = -1;
	 	}else{
			$buscador = 1;
		}	
		$buscar = $_POST['busco'];
		$val_dep = -1;
	 }	
	 if($buscador>0)
	 {
		$cant="select count(cod_item) as total from almacen where des_item LIKE '%$buscar%' or cod_item LIKE '%$buscar%'";
		$cant2=@mysql_query($cant,$conexion);
		$cant3=@mysql_fetch_object($cant2);
		$t_art_bus = $cant3->total; 
		$valores = $t_art_bus; 
	 }		
	 if (isset($_POST['can'])){
		if($_POST['menu_inven'] == "OK"){ //Enviado desde el menu Articulos
			$numeroRegistros = $t_inv;
		}else{
			$numeroRegistros = $t_art;
		}	
	 }else{
	 	$numeroRegistros = $t_inv;
	 }
	 if($reg_art>0){
	 	$numeroRegistros = $t_art;
	 }
	 if($valores>0){
	 	$numeroRegistros = $t_art_bus;
	 }
	//echo "num reg ".$numeroRegistros;
	//Paginacion
		if(!isset($orden)) 
   		{ 
    	  	 $orden="des_item"; 
   		}
		//tamaño de la pagina 
   		$tamPag=10; 

   		//pagina actual si no esta definida y limites 
   		if(!isset($_GET["pagina"])) 
   		{ 
			 $pagina=1; 
    	  	 $inicio=1; 
    	  	 $final=$tamPag; 
   		}else{
      		 $pagina = $_GET["pagina"]; 
   		}	 
   		//calculo del limite inferior 
   		$limitInf=($pagina-1)*$tamPag; 

		if (isset($_POST['can'])){
			$pagina=1; 
    	  	$inicio=1; 
    	  	$final=$tamPag; 
			$limitInf=($pagina-1)*$tamPag;
			//$limitInf=1;
		}
		
   		//calculo del numero de paginas 
   		$numPags=ceil($numeroRegistros/$tamPag); 
   		if(!isset($pagina)) 
   		{ 
			 $pagina=1; 
      		 $inicio=1; 
      		 $final=$tamPag; 
   		}else{ 
			 $seccionActual=intval(($pagina-1)/$tamPag); 
      	 	 $inicio=($seccionActual*$tamPag)+1; 
			
      	 	if($pagina<$numPags) 
      	 	{ 	
				$x = (($pagina-1)*$tamPag)+$inicio;	
         	 	$final=$inicio+$tamPag-1; 
      	 	}else{ 
				$x = (($pagina-1)*$tamPag)+$inicio;
         	 	$final=$numPags; 
      	 	} 
		
       	 	if ($final>$numPags){ 
				$x = (($pagina-1)*$tamPag)+$inicio;
          		$final=$numPags; 
      	 	} 
   	  	}
		
	//Inicio HTML
	@inicio_html($pagina_actual);
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
	
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina();	
?>	


<script language="javascript">
	function buscar(form1) { 
		if(document.form1.can.value=="Seleccione" )
		{
			document.form1.ver2.value="OK";
		}else{
			document.form1.action="inventario.php";
		}
		if(document.form1.busco.value=="" )
		{
			alert("Debe completar un nombre de busqueda");
			document.form1.busco.focus();
		}else{
			document.form1.ver.value="OK";
			document.form1.submit();  
		}	
	}
</script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onLoad="sf('text');">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<? 
	//echo tabla1 encabezado_empresa;
	echo $encabezado_empresa;
	//Menu Inventario
	$act_menu_inventario = $_SESSION['act_menu_inventario'];
	@menu_gestion($act_menu_inventario);
	?>
    <?
	//echo "tabla2";	
	?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="353" valign="top">
		  <table border="1" >
            <tr>
              <td colspan="2">
			   <div align="center"><span class="Estilo6">DATOS INVENTARIO</span></div>
			   </td>
              </tr>
            <tr>
              <td width="159"><span class="Estilo6">No. Total de Articulos</span></td>
              <td width="139"><? echo $t_inv;?></td>
            </tr>
            <tr>
              <td><span class="Estilo6">Costo del Inventario</span></td>
              <td><span class="Estilo12">$ <? echo $c_inv;  ?> </span></td>
            </tr>
            <tr>
              <td><span class="Estilo6">No. de Departamentos</span></td>
              <td><? echo $t_dep;?></td>
            </tr>
          </table>		
		  </td>
        <td width="447" valign="top">
		<table border="1">
          <tr>
            <td width="403"><div align="center"><span class="Estilo6">ULTIMOS ARTICULOS REGISTRADOS </span></div></td>
          </tr>
          <tr>
            <td><table width="427" height="22" border="0" align="center" cellpadding="0" cellspacing="0">
            <?
			if($ult_pro > 0	){
				$i=1;
				$ult="select * from compras where fecha_compra between '$fecha_ant' and '$fecha' limit 0, 5";
				$ult2=@mysql_query($ult,$conexion);
				while ($ult3=@mysql_fetch_object($ult2)){
					$com = $ult3->num_factura;
					$fes = $ult3->fecha_compra;
					$pro = $ult3->cod_pro;
			?>
              <tr class="celda" onClick="window.location='compras2.php?id_com=<? echo $com;?>&fec=<? echo $fes;?>&id_pro=<? echo $pro;?>'">
                <td width="40" class="Estilo7"><? echo $i;?> </td>
                <td width="318" class="Estilo7"><? echo $ult3->detalle; ?></td>
                <td width="16" class="Estilo7"><div align="center">$</div></td>
                <td width="53" class="Estilo7"><div align="right"><? echo $ult3->vr_costo;?></div></td>
              </tr>
			  <?
			 	$i++;
			 	}
			}else{ 
			  ?>
              <tr>
                <td colspan="4" class="Estilo7"><div align="center">No se registran compras desde <? echo $ult_com;?></div>                 </td>
              </tr>
             <?
			}
			?>
            </table></td>
            </tr>
        </table>
		</td>
      </tr>
    </table>    
	<? //echo "tabla3";?>	
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="205"><span class="Estilo8">Filtrar por Departamento </span></td>
        <td width="595">
		<select name="can" id="can" onChange="document.form1.can.selectedindex=0;document.form1.submit();">
          <option> Seleccione</option>
          <? 
		  $depto="select * from departamento order by nom_depto";
		  $depto2=@mysql_query($depto,$conexion);
		  while($campo = mysql_fetch_object($depto2)){
		  echo'<option value="'.$campo->cod_depto.'">'.$campo->nom_depto.'</option>';
		  } ?>
        </select>
		<input name="ver2" type="hidden" id="ver2"/>		</td>
      </tr>
      <tr>
        <td><span class="Estilo8">Buscar Articulo </span></td>
        <td>
		<input name="busco" type="text" id="busco">
		<input type="button" name="b" id="b" value="Buscar" onClick="buscar(this)" />
		<input name="ver" type="hidden" id="ver"/>
		</td>
      </tr>
    </table>
	<?
	//Tabla Mensaje
	if($act_crea_msj>0){
		@tabla_mensaje($valor_mensaje,$txt_mensaje);
	}
	//echo "tabla4";
	?>
	<table width="800" border="1">
      <tr>
        <td><div align="center"><span class="Estilo6">No</span></div></td>
        <td><div align="center"><span class="Estilo6">
		CODIGO</span></div></td>
        <td><div align="center"><span class="Estilo6">DETALLE</span></div></td>
        <td><div align="center"><span class="Estilo6">Vr/VENTA</span></div></td>
        <td><div align="center"><span class="Estilo6">Vr/COSTO</span></div></td>
        <td><div align="center"><span class="Estilo6">CANTIDAD</span></div></td>
      </tr>
	  <?
	  $alm="select * from almacen".$criterio." order by ".$orden." asc limit ".$limitInf.",".$tamPag;
	  $alm2=@mysql_query($alm,$conexion);
	  $cuan2=mysql_num_rows($alm2); 
	  if($val_dep>0){
	  	$alm="select * from almacen".$criterio." where cod_depto='$cod_depto' order by ".$orden." asc limit ".$limitInf.",".$tamPag;
		$alm2=@mysql_query($alm,$conexion);
	  }
	  
	  if($buscador>0)
	  {
		$alm="select * from almacen where des_item LIKE '%$buscar%' or cod_item LIKE '%$buscar%' limit ".$limitInf.",".$tamPag;
		$alm2=@mysql_query($alm,$conexion);
		$val_dep=0;
	  }
	 
	  while($dep3 = mysql_fetch_object($alm2)){
	  
	  $cod = $dep3->cod_item;
	  $det = $dep3->des_item;
	  $ven = $dep3->precio;
	  $ven = number_format($ven, 0, ",", ".");
	  $cos = $dep3->costo;
	  $cos = number_format($cos, 0, ",", ".");
	  $can = $dep3->cant_stock;
	 
	  ?>
      <tr class="celda" onClick="window.location='articulo2.php?id_pro=<? echo $cod; ?>'">
        <td><div align="center"><span class="Estilo7"><? echo $x;?></span></div></td>
        <td><div align="center"><span class="Estilo7"><? echo $cod;?></span></div></td>
        <td><div align="left"><span class="Estilo7"><? echo $det;?></span></div></td>
        <td>
          <table width="70" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="10"><div align="right"><span class="Estilo7">$</span></div></td>
              <td width="60"><div align="right"><span class="Estilo7"><? echo $ven;?></span></div></td>
            </tr>
          </table>
        </td>
        <td>
		<table width="70" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="10"><div align="right"><span class="Estilo7">$</span></div></td>
              <td width="60"><div align="right"><span class="Estilo7"><? echo $cos;?></span></div></td>
            </tr>
        </table>
		</td>
        <td><div align="center"><span class="Estilo7"><? echo $can;?></span></div></td>
      </tr>
	  <?
	  	$x++;
	 // 	}
	  //}
	  }
	  //echo "a ".$val_dep."<br>";
  	  //echo "b ".$buscador."<br>";
	  if($numeroRegistros==0){
	  	$depar="select * from departamento where cod_depto='$cod_depto'";
		$depar2=@mysql_query($depar,$conexion);
		$depar3 = mysql_fetch_object($depar2)
	  ?>
	  <tr>
       <td colspan="6" class="Estilo7">
	   <?
	   if($val_dep>0){
	   ?>
	   <div align="center">
	   	No se existen articulos para el departamento <? echo $depar3->nom_depto;?>
	   </div>                 
	   <?
	   }
	   if($buscador>0)
	   {
	   ?>
	   <div align="center">
	   	No se existen articulos con el nombre <? echo $buscar;?>
	   </div>                 
	   <?
	   }
	   ?>
	   </td>
      </tr>
	  <?
	  }
	  ?>
    </table>
	<?
	//echo "tabla6";
	?>
	<table border="0" cellspacing="0" cellpadding="0" align="center"> 
   	<tr><td align="center" valign="top">
	<?  
	//paginacion 
   	if($pagina>1) 
   	{ 
      	if($valores>0){
			echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&dig=".$valores."&buscor=".$buscar."'>"; 
      		echo "<font face='verdana' size='-2'>anterior</font></a>";
		}else{
		 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cano=".$cod_depto."'>"; 
    	 	echo "<font face='verdana' size='-2'>anterior</font>"; 
      	 	echo "</a> "; 
		}	
   	} 

   	for($i=$inicio;$i<=$final;$i++) 
   	{ 
      	 if($i==$pagina) 
      	 { 
         	 echo "<font face='verdana' size='-2'><b>".$i."</b> </font>"; 
      	 }else{ 
		 	if($valores>0){
				echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&dig=".$valores."&buscor=".$buscar."'>"; 
      			echo "<font face='verdana' size='-2'>".$i."</font></a> ";
			}else{
         	 	echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cano=".$cod_depto."'>"; 
         	 	echo "<font face='verdana' size='-2'>".$i."</font></a> "; 
			}	
      	 } 
   	} 
   	if($pagina<$numPags) 
   	{ 
		if($valores>0){
			echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&dig=".$valores."&buscor=".$buscar."&val=1'>"; 
      		echo "<font face='verdana' size='-2'>siguiente</font></a>";
		}else{
      		echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cano=".$cod_depto."'>"; 
      		echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
		}
   	} 
	?> 
	</td></tr> 
   	</table>
	<?
	//echo "tabla5";
	?>
	</td>
  </tr>
</table>  	
</form>
</body>
</html>
