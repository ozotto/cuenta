<?php
	session_start();	
	//Llamado de Clases
	include ("../clases/control.php");
	include ("../clases/consultar.php");
	include ("../clases/insertar.php");
	include ("../clases/datos.php");
	include ("../clases/diseno.php");
	
	//Creacion de Objeto
	$con = new control;
	$con->conectar(); 
	$con-> seg_usu();
	$conexion = $con->conectar();
	
	//Inicio HTML
	@inicio_html($pagina_actual);
	
	//Llamado clase de Estilos
	echo $clase_estilo;
	
	//Llamado Clase JAVA
	echo $clase_java;
	
	//Funcion Inicio del Diseño BODY
	@ini_dise_pagina();

//-----------------------------------------------------------------------------
//-----------CONTENIDO PAGINA--------------------------------------------------
?>
<?
	//Tabla Encabezado Empresa
	echo $encabezado_empresa;
	//Tabla Division para Menu Principal
?>
	<table width='800' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr valign='top'>
        <td width='20'>
		<?
		//Funcion Menu Principal	
		@menu_principal();
		?>
		</td>
        <td>
		Bienvenido: <? echo $name_empleado;?>
		<br><p> ESPACIO EN CONSTRUCCION </p></br>
		<table>
		<tr>
		<td><? //@articulos_mas_vendidos($conexion);?></td>
		<td>		col2		</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
<?	
//-----------------------------------------------------------------------------	
//-----------FIN PAGINA--------------------------------------------------	
	//Funcion FIN del Diseño BODY	
	@fin_dise_pagina();	
?>


	 

