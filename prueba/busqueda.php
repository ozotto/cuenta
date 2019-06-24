<?php
	include ("../clases/control.php");
	include ("../clases/datos.php");
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	// Paginador desarrollado por Jossmorenn,
	
	// Inclusión de Buscador y menú desplegable Java Script, conexiones MySQL para listar y otras modificaciones varias por: Web Proyecto 
	
	// Aqui se incluye la conexion a la base de datos

?>
<?php

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Rs = 6;// este numero es el numero de resultados que quieren que se vean por pagina pueden poner algo asi: $maxRows_Rs = 6; para ver paginas con 6 resultados

$pageNum_Rs = 0;

if (isset($_GET['pageNum_Rs'])) {

$pageNum_Rs = $_GET['pageNum_Rs'];

}

$startRow_Rs = $pageNum_Rs * $maxRows_Rs;


//mysql_select_db($database_pellegrini, $conn);

$query_Rs = "SELECT * FROM almacen ORDER BY des_item DESC"; // SELECT Anterior

if ($_GET['id']) // Si existe la variable "id" en la barra url...

{

$id = $_GET['id'];

$query_Rs = "SELECT * FROM almacen WHERE cod_item = '$id' ORDER BY des_item DESC";

}

//*BUSCADOR DE REGISTROS!*/

if ($_GET['buscar'])

{

$buscar = $_GET['buscar'];


$query_Rs ="SELECT * FROM almacen WHERE des_item LIKE \"%$buscar%\" OR cod_item LIKE \"%$buscar%\" OR precio LIKE \"$buscar%\" ORDER BY des_item DESC" ;

}

$query_limit_Rs = sprintf("%s LIMIT %d, %d", $query_Rs, $startRow_Rs, $maxRows_Rs);

$Rs = mysql_query($query_limit_Rs, $conexion) or die(mysql_error());

$row_Rs = mysql_fetch_assoc($Rs);


if (isset($_GET['totalRows_Rs'])) {

$totalRows_Rs = $_GET['totalRows_Rs'];

} else {

$all_Rs = mysql_query($query_Rs);

$totalRows_Rs = mysql_num_rows($all_Rs);

}

$totalPages_Rs = ceil($totalRows_Rs/$maxRows_Rs)-1;


$queryString_Rs = "";

if (!empty($_SERVER['QUERY_STRING'])) {

$params = explode("&", $_SERVER['QUERY_STRING']);

$newParams = array();

foreach ($params as $param) {

if (stristr($param, "pageNum_Rs") == false &&

stristr($param, "totalRows_Rs") == false) {

array_push($newParams, $param);

}

}

if (count($newParams) != 0) {

$queryString_Rs = "&" . htmlentities(implode("&", $newParams));

}

}

$queryString_Rs = sprintf("&totalRows_Rs=%d%s", $totalRows_Rs, $queryString_Rs);

?>

<html>

<head>

<title>Web Proyecto - Paginador, con buscador MySQL y menú desplegable</title>

<link href="css/hoja-de-estilo.css" rel="stylesheet" type="text/css">

</head>

<body>

<table width="770" height="35" border="0" align="center" cellpadding="0" cellspacing="0">

<tr bgcolor="#FCFCFC">

<td width="10" class="Estilo10"><p> </p> </td>

<td width="442" class="Estilo10"><img src="../images/icn_arrow.gif" width="6" height="6"> <span class="Estilo1"><strong>Paginador PHP con buscador Inclu&iacute;do</strong></span></td>

<td width="318" class="txtNoticia"><div align="right" class="text-bordo">http://webproyecto.blogspot.com

</div></td>

</tr>

</table>

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

<td width="336"> </td>

<td width="434" align="right"><?php include "includes/buscador.php"; ?>

<div align="right"></div></td>

</tr>

</table>

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

<td width="161" valign="top"><?php include "includes/menu-izq.php"; ?></td>

<td width="609" valign="top"><table width="580" border="0" align="right" cellpadding="0" cellspacing="0">

<tr>

<td><table width="590" height="25" border="0" cellpadding="0" cellspacing="0">

<tr bgcolor="#F9F9F9">

<td width="10" class="tit-verde"> </td>

<td width="91" class="tit-verde">Cmpo1</td>

<td width="226" class="tit-verde">Campo2</td>

<td width="199" class="tit-verde">Campo3</td>

<td width="64" class="enlaces"><div align="center" class="tit-verde">Campo4</div></td>

</tr>

</table>

<table width="575" border="0" align="center" cellpadding="0" cellspacing="0">

<?php do { ?>

<tr>

<td width="94" height="20" class="texto-chico"><div align="left" class="texto-comun"> <?php echo $row_Rs['cod_item']; ?></div></td>

<td width="226" class="texto-chico"><div align="left" class="texto-comun"> <?php echo $row_Rs['des_item']; ?></div></td>

<td width="150" class="texto-chico"><div align="left" class="texto-comun"> <?php echo $row_Rs['precio']; ?></div></td>

<td width="105" class="fecha-texto"><div align="center" class="texto-comun">

<div align="right" class="texto-comun"><strong><?php echo $row_Rs['cant_stock']; ?></strong></div>

</div></td>

</tr>

<?php } while ($row_Rs = mysql_fetch_assoc($Rs));

if ($colorfila==0){


$color= "#DEDEBE";


$colorfila=1;


}else{


$color="#F0F0F0";


$colorfila=0;


}

?>

</table></td>

</tr>

<tr>

<td><table width="590" border="0" cellspacing="0" cellpadding="0">

<tr>

<td height="16"><img src="images/wna_linea_horiz.gif" width="580" height="1"></td>

</tr>

<tr>

<td height="10"><table width="590" height="34" border="0" cellpadding="0" cellspacing="0">

<tr bgcolor="#FBFBFB">

<td width="65" class="texto-chico"><div align="center">

<?php if ($pageNum_Rs > 0) { // Show if not first page ?>

<a href="<?php printf("%s?pageNum_Rs=%d%s", $currentPage, 0, $queryString_Rs); ?>" class="txt-paginador"><strong>Primero</strong></a>

<?php } // Show if not first page ?>

</div></td>

<td width="80" class="texto-chico"><div align="center">

<?php if ($pageNum_Rs > 0) { // Show if not first page ?>

<a href="<?php printf("%s?pageNum_Rs=%d%s", $currentPage, max(0, $pageNum_Rs - 1), $queryString_Rs); ?>" class="txt-paginador"><strong> &lt; Anterior</strong></a>

<?php } // Show if not first page ?>

</div></td>

<td width="312"><div align="center" class="titCategoria"><strong>

<?php

$last=$totalPages_Rs+1;

$current=$pageNum_Rs+1;

for ($i = 1; $i <= $last; $i++) {

if($current==$i){

echo $i." .";

}else{?>

<a href="<?php printf("%s?pageNum_Rs=%d%s", $currentPage, min($totalPages_Rs, $i-1), $queryString_Rs); ?>"><? echo $i;?></a>

<?

}

}

?>

</strong></div></td>

<td width="77"><div align="right" class="txt-paginador">

<?php if ($pageNum_Rs < $totalPages_Rs) { // Show if not last page ?>

<div align="center"><a href="<?php printf("%s?pageNum_Rs=%d%s", $currentPage, min($totalPages_Rs, $pageNum_Rs + 1), $queryString_Rs); ?>" class="txt-paginador"><strong>Siguiente &gt; </strong></a> </div>

<?php } // Show if not last page ?>

</div></td>

<td width="56"><div align="right">

<?php if ($pageNum_Rs < $totalPages_Rs) { // Show if not last page ?>

<div align="center" class="txt-paginador"><span class="titCategoria"><a href="<?php printf("%s?pageNum_Rs=%d%s", $currentPage, $totalPages_Rs, $queryString_Rs); ?>" class="txt-paginador"><strong>Ultimo</strong></a></span> </div>

<?php } // Show if not last page ?>

</div></td>

</tr>

</table>

<div align="left"></div>

<table width="590" border="0" align="left" cellpadding="0" cellspacing="0">

<tr>

<td height="26"><div align="right" class="text-marroncito"><strong>Est&aacute; en la Página:

<?

if($totalPages_Rs==0){

echo "0/0";

}else{

echo $pageNum_Rs+1;

echo "/";

echo $totalPages_Rs+1;

}

?>

</strong></div></td>

</tr>

</table></td>

</tr>

</table></td>

</tr>

</table></td>

</tr>

</table>

</body>

</html>

<?php

mysql_free_result($Rs);

?>