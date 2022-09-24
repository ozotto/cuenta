<?php
	if(!isset($_SESSION)) 
  { 
        session_start(); 
  } 
	
	//Llamado de Clases
	require_once ("../clases/control.php");
	require_once ("../clases/consultar.php");
	require_once ("../clases/insertar.php");
	require_once ("../clases/datos.php");
	require_once ("../clases/diseno.php");
	
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

	//Ultimas Ventas realizadas
	$ult="select * from facturacion where fecha_fac between '$fecha_ant' and '$fecha' limit 0, 5";
	$ult2=@mysql_query($ult,$conexion);
	$u_art=mysql_num_rows($ult2); 
	$ult_pro = $u_art;

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
      	<br>
      	<br>
      	<? //tabla 3.2.1, Listado de Ventas?>
				<div align="center"><span class="Estilo6">ULTIMAS VENTAS REGISTRADAS </span></div>
				<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
				<? 
					if($ult_pro > 0	){
				?>
				<tr>
					<td width="27"><div align="center"><span class="Estilo6">No</span></div></td>
			    <td width="70"><div align="center"><span class="Estilo6">No. Factura</span></div></td>
			    <td width="112"><div align="center"><span class="Estilo6">Cliente</span></div></td>
			    <td width="61"><div align="center"><span class="Estilo6">Total Fac</span></div></td>
			    <td width="100"><div align="center"><span class="Estilo6">Fecha Fac</span></div></td>
			 	</tr>
				<?
					$i=1;
					$cant="select * from facturacion ORDER BY fecha_registro DESC limit 0, 5";
					$cant2=@mysql_query($cant,$conexion);
					while ($cant3=@mysql_fetch_object($cant2)){
				  	$id_cli = $cant3->cod_cli;
						$cli="select * from clientes where cod_cli = $id_cli";
						$cli2=@mysql_query($cli,$conexion);
						$cli3=@mysql_fetch_object($cli2); 	
							 
						$no_fac = $cant3->no_fac;
						$fe_fac = $cant3->fecha_fac;
						$tot_fac = $cant3->vr_fac;
						$tot_fac = number_format($tot_fac, 2, ",", ".");
						 
						$cli = $cli3->name_cli;
						$nom_cli = strtolower($cli); 		//Pasar todo a minusculas
						$nom_cli = ucwords($nom_cli);		//Pasar a mayuscula la primera letra de cada cadena	
						
				?>
			  <tr class="celda" onClick="window.location='ventas2.php?id_com=<? echo $no_fac;?>&fec=<? echo $fe_fac;?>'">
			    <td><div align="center"><span class="Estilo7"><? echo $i;?></span></div></td>
			    <td><div align="center"><span class="Estilo7"><? echo $no_fac;?></span></div></td>
			    <td><div align="left"><span class="Estilo7"><? echo $nom_cli;?></span></div></td>
			    <td><div align="right"><span class="Estilo7"><? echo $tot_fac;?></span></div></td>
			    <td><div align="center"><span class="Estilo7"><? echo $fe_fac;?></span></div></td>
			  </tr>
				<? 
						$i++;
					}
				}else{
				?>
			  <tr>
			  	<td colspan="5">
						<div align="center"><span class="Estilo7">No se registran ventas desde <? echo $ult_com;?></span></div>
					</td>
			  </tr>
				<? }?>
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


	 

