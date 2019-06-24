<?php
	session_start();
	include ("../clases/control.php");
	include ("../clases/datos.php");
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
?>
<html>
<head>
<title>Administrar</title>
<link href="../Estilo/estilo.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<p>Bienvenido <? echo $name_empleado;?></p>
<table width="200" border="1">
  <tr>
    <td><a href="sis_db.php">Administrar DB</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
