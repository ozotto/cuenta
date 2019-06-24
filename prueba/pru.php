<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	$con = new control;
	$con->conectar(); 
	$conexion = $con->conectar();
	

	$sql5="select cod_item as num_art FROM almacen order by cod_item";
	$num=@mysql_query($sql5,$conexion);

?>	
	
<html>
<head>
<meta>
<title>Documento sin título</title>
</head>

<body>
<?	
/*
$fruits = array("lemon", "orange", "banana", "apple");
sort($fruits);
foreach ($fruits as $key => $val) {
    echo "Frutas[" . $key . "] = " . $val . "\n";
}


$ar_mas_ven[] = array(1 => array(	0 => "DVD",
									1 => 200, 
									2 => 2, 
											)
								);			
$ar_mas_ven[] = array( 2 => array(	0 => "Teclado",
									1 => 50, 
									2 => 3, 
											)						
								);			
$ar_mas_ven[] = array(3 => array(	0 => "Pantalla",
									1 => 100, 
									2 => 1, 
											)
								);
$ar_mas_ven[] = array(4 => array(	0 => "computador",
									1 => 500, 
									2 => 20, 
											)
								);

foreach ($ar_mas_ven as $key => $val) {
    echo "Frutas[" . $key . "] = " . $val . "\n";
}
								print_r($ar_mas_ven);		
echo "<br><br>";	
$ar[] = array(
       1 => array(0 => "DVD",		1 => 200, 	2 => 2),
       2 => array(0 => "Teclado",	1 => 50,	2 => 3)
      );
array_multisort($ar[1][1], SORT_ASC, SORT_STRING,
                $ar[2][1], SORT_NUMERIC, SORT_DESC);
var_dump($ar);	
*/			
/*$rojo = $_POST['color_rojo'];
$azul = $_POST['color_azul'];
$verde = $_POST['color_verde'];
 
echo $rojo  . '<br>';
echo $azul  . '<br>';
echo $verde . '<br>';		
			
$colores = $_POST['colores'];
$texto_colores = @implode(', ', $colores);
echo ' Tus colores son favoritos son: ' . $texto_colores;
?>
<form name="prueba" action="pru.php" method="POST">
         Cuales son tus colores preferidos?
        <br>
		Rojo <input type="checkbox" name="colores[]" value="rojo" />
        <br>
        Azul <input type="checkbox" name="colores[]" value="azul" />
        <br>
        Verde <input type="checkbox" name="colores[]" value="verde" />
        <br>
        <input type="submit" value="Enviar" name="btn_colores" />
    </form>
	*/
	?>
	
<form name="form1" action="" method="post">
<table>
<tr>
 
<td>Contado<input type='radio' name='ver' value="1"  checked onclick="form1.depto2.disabled = true;" /></td>
<td>Credito<input type='radio' name='ver' value="1" onclick="form1.depto2.disabled = false;" /></td>
<td><input type='text' name='contado' size='30' value='$var_col2' ><td>
<td><input type='text' name='depto2' size='30' value='$var_col2' DISABLED><td>
</tr>
</table>


	
<table>
<? 

/*for($i=1;$i<4;$i++){
$nom_campo = "depto".$i;
echo $nom_campo."<br>";
$campo =  "<input type='checkbox' name='valores[$i]' value='1' onclick='document.form1.$nom_campo.disabled=!document.form1.$nom_campo.disabled' />";
$campo1 = "<input type='text' name='depto[]' id='$nom_campo' size='30' value='$var_col2' DISABLED>";*/
?>
<script type="text/javascript">
//*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
	function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
	
function calcula_precio(Control)
{
		var costo	 = parseFloat(document.getElementById("costo").value);
		var porciento = parseFloat(document.getElementById("porcentaje").value);
		var resultado;
		var precio;
		
		resultado	= ((costo * porciento)/100);
		precio		= resultado + costo
		document.getElementById("precio").value = precio;
}
function calcula_porciento(Control)
{
	var verifica = Solo_Numerico(Control.value);
	
	Control.value=Solo_Numerico(Control.value);
	if (verifica != "")
	{
		var costo	 = parseFloat(document.getElementById("costo").value);
		var precio	 = parseFloat(document.getElementById("precio").value);
		var resultado;
		var porciento;
		
		if (costo == 0){}else{
			resultado	= precio - costo; 
			porciento	= parseFloat(((resultado * 100)/costo)).toFixed(2);
			document.getElementById("porcentaje").value = porciento;
			//alert (costo);
		}
	}	 
}

function modificar_articulo()
{
	document.form1.action="articulo.php";
	document.form1.submit();
}
</script>
<tr>	
<td>
<table>
<tr>
	<td>Cantidad</td>
	<td><input name='cantidad' type='text' id='cantidad' size='10' value='0' onkeyUp="return ValNumero(this);"></td>	
	<td>Costo</td>
	<td><input name='costo' type='text' id='costo' size='10' value='0' onkeyUp="calcula_precio(this);"></td>
	<td>%</td>
	<td><input type="text" id="porcentaje" value='0' onkeyUp="calcula_precio(this);" /></td>
	<td>Precio de Venta</td>
	<td><input type="text" name="precio" id="precio" value='0' onkeyUp="calcula_porciento(this);"  /></td>
</tr>
</table>
<!--
<a href="articulo.php?cod_pro=<? echo $pro->cod_item; ?>">
				  <img src="../imagenes/logo_modificar.jpg" width="24" height="25" border="0"></a>
-->				  
				  <a onclick="modificar_articulo()">
				  <img src="../imagenes/logo_modificar.jpg" width="24" height="25" border="0"></a>
<!--
 <p>Costo <input type="text" id="costo"  /></p>
 <p>Porcentaje <input type="text" id="porcentaje" onkeyUp="calcula_precio(this);" /></p>
 <p>Precio <input type="text" id="precio" onkeyUp="calcula_porciento(this);"  /></p>
 <p><input type="button" value="calcula" onClick="javascript: calcula(this);" /></p>
 
 <p>Cedula: <input type=text name=Cedula onkeyUp="return ValNumero(this);"></p>
<p>Telefono: <input type=text name=Telefono onkeyUp="return ValNumero(this);"></p>
<p>Nro Hijos: <input type=text name=NroHijos onkeyUp="return ValNumero(this);"></p>
 -->
</td>	
</tr>
<?
//}
?>
</table>
</form>

</body>
</html>