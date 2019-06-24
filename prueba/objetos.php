<?
	include ("../clases/control.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	include ("../clases/consultar.php");
//	$con = new control;
//	$con->conectar(); 
	
?>
<html>
<head>
<meta>
<title><? echo $titulo_pagina;?></title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<script src="../clases/fun_java/java.js" type="text/javascript"></script>
<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <td>
  <input type=button value='Nuevo Proveedor' onClick='valida_proveedor();'/>
      <input name='op2' type='hidden' id='op2' />
     </td> 
    <td>
	<? echo $encabezado_empresa;?>
    <?
	
	$j=0;
	$cant_pro 		= @mysql_num_rows($dep2);
	
	$dep = 'select * from proveedor order by name_pro asc';
	$dep2 = @mysql_query($dep,$conexion); 
	$valores = array();
	while($campos[] = @mysql_fetch_assoc($dep2)){
		$valores = $campos;	
	}
	echo "<pre>";
	//print_r ($valores);
	echo "</pre>";
		
	$dep = 'select * from proveedor order by name_pro asc';
	$dep3 = @mysql_query($dep,$conexion); 
	$list_prov = array();
	$i=1;
/*	while($campos = @mysql_fetch_assoc($dep3)){
		$cod_pro	= $campos['cod_pro'];
		$name_pro	= $campos['name_pro'];
		$nro_telefo	= $campos['nro_telefo'];
		$vendedor	= $campos['vendedor'];*/
		
	while($campos = @mysql_fetch_assoc($dep3)){
		//Codigo Proveedor
		$codigo_proveedor = $campos['cod_pro'];
		
		//Columna 1 "Nombre Proveedor"
		$nombre_proveedor = $campos['name_pro'];
		$nombre_proveedor = strtolower($nombre_proveedor); 		
		$nombre_proveedor = ucwords($nombre_proveedor);	
		
		//Columna 2 "Nombre Ciudad del Proveedor"
		$cod_ciu_pro 	 = $campos['cod_ciudad'];  
		$ciu 			= "select * from ciudad where cod_ciudad = $cod_ciu_pro";
		$ciu2 			= @mysql_query($ciu,$conexion); 
		$cant_ciu 		= @mysql_num_rows($ciu2);
		$campos2 		= @mysql_fetch_assoc($ciu2);
		
		$nombre_ciudad = $campos2['nom_ciudad'];
		$nombre_ciudad = strtolower($nombre_ciudad); 		
		$nombre_ciudad = ucwords($nombre_ciudad);
		
		//Columna 3 "Telefono Proveedor"
		$telefono_proveedor = $campos['nro_telefo'];
		
		//Columna 4 "Contacto Proveedor"
		$contacto_proveedor = $campos->vendedor;
		$contacto_proveedor = strtolower($contacto_proveedor); 		
		$contacto_proveedor = ucwords($contacto_proveedor);	
		
		//Columna 5 "Numero de Compras Realizadas x Proveedor"
		$cant_comp 		= "select distinct num_factura from compras where cod_pro = $codigo_proveedor";
		$cant_comp2 	= @mysql_query($cant_comp,$conexion);
		$cant_comp_pro 	= @mysql_num_rows($cant_comp2); 
	
		if ($cant_ciu == 0){
			$nombre_ciudad = "N/A";
		}
		if (empty($telefono_proveedor)){
			$telefono_proveedor = "N/A";
		}
		if (empty($contacto_proveedor)){
			$contacto_proveedor = "N/A";
		}
		
		$list_prov[] = array($i => array(	0 => $codigo_proveedor,
											1 => "$nombre_proveedor", 
											2 => "$nombre_ciudad", 
											3 => $telefono_proveedor,
											4 => "$contacto_proveedor",
											5 => $cant_comp_pro
											));
		$i++;
		
	}
	$var 	= 0;
	$var1 	= 1;
	$var3 	= 3;
	echo "<pre>";
	print_r ($lista_pais);
//	print_r ($list_prov[$var][$var1][$var3]);
	echo "</pre>";
	

//	echo $list_prov;
//echo $list_prov[3][1];
	$i=1;
	$dep = 'select * from proveedor order by name_pro asc';
	$dep2 = @mysql_query($dep,$conexion); 
/*while(	$campos = @mysql_fetch_object($dep2)){
		$numero	= $campos->cod_pais;
		$cod_pro	= $campos->cod_pro;
		$name_pro	= $campos->name_pro;
		$nro_telefo	= $campos->nro_telefo;


$pedido = array();

$pedido[0]["familia"] = $cod_pro;
$pedido[1]["referencia"] = $name_pro;
$pedido[2]["cantidad"] = $nro_telefo;
$pedido[3]["poscion"] = $cod_pro;
$i++;
}
//Muestro los datos

	echo 	'Familia:'.$pedido[0]["familia"]. 
			'Referencia:'.$pedido[1]["referencia"]. 
			'Cantidad:'.$pedido[2]["cantidad"].
			'posicion:'.$pedido[3]["posicion"].'<br>'; 

$arr = array("somearray" => array(6 => 5, 13 => 9, "a" => 42));

//echo $arr["somearray"][6];    // 5
//		print_r($list_prov);
// Crea un array simple.
$array[0] = array(1, 2, 3, 4, 5);
$array[1] = array(6, 7, 8, 9, 10);
//print_r($array);

// Ahora eliminar cada ítem, pero dejar el array mismo intacto:
foreach ($array as $i => $value) {
    unset($array[$i]);
}
//print_r($array);

// Agregar un ítem (note que la nueva key es 5, en lugar de 0).
$array[] = 6;
//print_r($array);

// Re-indexar:
$array = array_values($array);
$array[] = 7;
//print_r($array);


/*	$ar_lis_pro = mysql_fetch_array($dep2, MYSQL_NUM);
   	while ($ar_lis_pro = mysql_fetch_array($dep2, MYSQL_NUM)){
	printf("ID: %s  Name: %s", $ar_lis_pro[0], $ar_lis_pro[1]);
	}
	for($x=1;$x<=$cant_pro;$x++){
	printf($ar_lis_pro[0],$ar_lis_pro[1])."<br>"; 
//	printf("ID: %s  Name: %s", $row[0], $row[1]);  
	}
/*    while($campos = @mysql_fetch_object($dep2)){ 
	$codigo_proveedor = $campos->cod_pro."<br>";
	$nombre_proveedor = $campos->name_pro;
	$ar_lis_pro = array("no" => $i, "cod_pro" => $codigo_proveedor, "nom_pro" => $nombre_proveedor);
	$i++;
	}
	for($x=1;$x<=$cant_pro;$x++){
		print_r($ar_lis_pro);
	//echo $ar_lis_pro["cod_pro"];
	}
*/	
	?>
    
    <table width="800" border="1">
      <tr>
        <td colspan="6" width="800"><div align="center"><span class="Estilo6">CREAR PROVEEDOR </span></div></td>
        </tr> 
      <tr>
        <td width="104"><span class="Estilo6">PAIS</span></td>
        <td width="111">
		<select name="pais" id="pais" onChange="document.form1.pais.selectedindex=0;document.form1.submit();document.form1.crea.value='1'">
        <option>Seleccione</option>
        <?
		  while($campos=mysql_fetch_object($db_pais)){
		?>
        <option value="<? echo $campos->cod_pais;?>"<? if($campos-> cod_pais==$_POST['pais']) echo ("selected"); ?>>
		<? echo $campos->nom_pais;?>		</option>
        <? } ?>
        </select>		</td>
        <td width="95"><span class="Estilo6">ESTADO</span></td>
		<? 
		  if (isset($_POST['pais'])){
		    $_SESSION['pais'] = $_POST['pais'];
		  	$pais = $_SESSION['pais'];
			$sql2="select * from provincia where cod_pais=$pais order by nom_provincia";
			$consulta2= mysql_query($sql2,$conexion);
		  } 
		?>
        <td width="160">
		<select name="dep" id="dep" onChange="document.form1.dep.selectedindex=0;document.form1.submit();document.form1.crea.value='1'">
        <option>Seleccione</option>
        <?
		 if (isset($_POST['pais'])){
		   while($campos2=mysql_fetch_object($consulta2)){
		?>
        <option value="<? echo $campos2->cod_provincia;?>" <? if($campos2->cod_provincia==$_POST['dep']) echo ("selected"); ?>>
		<? echo $campos2->nom_provincia;?>		</option>
        <? 
		   }
		  } 
		?>
        </select>		</td>
		<? 
		  if (isset($_POST['dep'])){
		 	$_SESSION['dep'] = $_POST['dep'];
		  	$depto = $_SESSION['dep'];
	
			$sql3="select * from ciudad where cod_provincia=$depto order by nom_ciudad";
			$consulta3= mysql_query($sql3,$conexion);
		  } 
		?>
        <td width="117"><span class="Estilo6">CIUDAD</span></td>
        <td width="137">
		<select name="ciu" id="ciu" 
		 onChange="document.form1.ciu.selectedindex=0;document.form1.submit();document.form1.crea.value='1';document.form1.cua.value='1'">
         <option>Seleccione</option>
         <?
		 if (isset($_POST['dep'])){
		   while($campos3=mysql_fetch_object($consulta3)){
		 ?>
         <option value="<? echo $campos3->cod_ciudad;?>" <? if($campos3->cod_ciudad==$_POST['ciu']) echo ("selected"); ?>>
		 <? echo $campos3->nom_ciudad;?>		 </option>
         <? 
		   }
		  } 
		 ?>
        </select>		</td>
      </tr>
      <tr>
        <td colspan="6">

		    <? 
	    if (isset($_POST['ciu'])){
		  $_SESSION['ciu'] = $_POST['ciu'];
		  $ciudad = $_SESSION['ciu'];

		  if($ciudad > 0){
		?>

		  <p align="center">
		  <table width="745" border="1" bordercolor="#000000">
          <tr>
            <td width="110"><span class="Estilo6">NOMBRE</span></td>
              <td width="210"><input name="nombre" type="text" id="nombre" size="30"></td>
              <td width="157"><span class="Estilo6">NIT</span></td>
              <td width="250"><input name="nit" type="text" id="nit" size="30"></td>
            </tr>
          <tr>
            <td><span class="Estilo6">DIRECCION</span></td>
              <td><input name="direccion" type="text" id="direccion" size="30"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          <tr>
            <td><span class="Estilo6">No. TELEFONO 1</span></td>
              <td><input name="tel1" type="text" id="tel1" size="30"></td>
              <td><span class="Estilo6">No. TELEFONO 2 </span></td>
              <td><input name="tel2" type="text" id="tel2" size="30"></td>
            </tr>
          <tr>
            <td><span class="Estilo6">No. FAX </span></td>
              <td><input name="fax" type="text" id="fax" size="30"></td>
              <td><span class="Estilo6">No. CELULAR </span></td>
              <td><input name="celular" type="text" id="celular" size="30"></td>
            </tr>
          <tr>
            <td><span class="Estilo6">VENDEDOR</span></td>
              <td colspan="2"><input name="vendedor" type="text" id="vendedor" size="30"></td>
              <td>&nbsp;</td>
            </tr>
        </table>
		<? } 
		}
		?>
    
    </td>
  </tr>
</table>    
</body>
</html>