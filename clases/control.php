<? //clase para el control del sitio
class control{
	
	// variables publicas-----------------------------------------------------------------
	var $conexion;
	var $dato;
	var $conectado;
	var $cadena;
	
	var $num_productos; 
    var $array_id_prod; 
    var $array_nombre_prod; 
    var $array_precio_prod;
	
	// funcion conectar-------------------------------------------------------------------
	public function conectar(){
		$conexion  = @mysql_connect(localhost,root,'');
		$conectado = @mysql_select_db(cuenta,$conexion) or die('No se realizó la conexion');
		return $conexion;
	}
	
	//Vinculo 
	/*public	function redir($url){
		$cadena	=	"<script language=javascript>location.href='$url';</script>";
		return $cadena;
	}*/
	
	// funcion buscar dato devuelve el numero de registros--------------------------------
	public function busca_dato($cadena,$conexion){
		$ejecuta =  @mysql_query($cadena,$conexion);
		$num_rows = @mysql_num_rows($ejecuta);
		return $num_rows;
	}
	
	//Busco el codigo de ciudad segun el nombre de la ciudad
	public function bus_cod_ciudad($nom_ciudad,$conexion){
	
		$cadena		= "select * from ciudad where nom_ciudad = '$nom_ciudad' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$cod_ciud	= $db_ciu->cod_ciudad;
		return $cod_ciud;
	}
	
	//Busco el nombre de ciudad segun el codigo de la ciudad
	public function bus_nom_ciudad($cod_ciudad,$conexion){
	
		$cadena		= "select * from ciudad where cod_ciudad = '$cod_ciudad' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$nom_ciud	= $db_ciu->nom_ciudad;
		return $nom_ciud;
	}
	
	//Busco el codigo de provincia segun el nombre de la ciudad
	public function bus_cod_provincia($nom_ciudad,$conexion){
	
		$cadena		= "select * from ciudad where nom_ciudad = '$nom_ciudad' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$cod_prov	= $db_ciu->cod_provincia;
		return $cod_prov;
	}

	//Busco el nombre de provincia segun el codigo de la provincia
	public function bus_nom_provincia($cod_provincia,$conexion){
	
		$cadena		= "select * from provincia where cod_provincia = '$cod_provincia' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$nom_prov	= $db_ciu->nom_provincia;
		return $nom_prov;
	}
	
	//Busco el codigo de pais segun el codigo de provincia
	public function bus_cod_pais($cod_prov,$conexion){
	
		$cadena		= "select * from provincia where cod_provincia = '$cod_prov' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$cod_pais	= $db_ciu->cod_pais;
		return $cod_pais;
	}
	
	//Busco el nombre de pais segun el codigo de pais
	public function bus_nom_pais($cod_pais,$conexion){
	
		$cadena		= "select * from pais where cod_pais = '$cod_pais' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$nom_pais	= $db_ciu->nom_pais;
		return $nom_pais;
	}
	
	//Busco el codigo de departamento(almacen) segun el nombre de departamento
	public function bus_cod_departamento($nom_depto,$conexion){
	
		$cadena		= "select * from departamento where nom_depto ='$nom_depto' ";
		$ejecuta 	=  @mysql_query($cadena,$conexion);
		$db_ciu 	= @mysql_fetch_object($ejecuta);
		$cod_depto	= $db_ciu->cod_depto;
		return $cod_depto;
	}
	
	
	//Funcion Consultar registros en stock del articulo
	public function verificar_existencia_art($codigo, $conexion){
	
		$sql2="select * from almacen where cod_item = '$codigo'";
		$consulta2=@mysql_query($sql2,$conexion);
		$campos=@mysql_fetch_object($consulta2);
		$cant1=$campos->cant_stock;
		
		$tem="select sum(cantidad) As TOTAL from temporal where id_art= '$codigo' ";
		$tem2=@mysql_query($tem,$conexion);
		$tem3=@mysql_fetch_object($tem2);
		$cant2=$tem3->total;
		
		$cantidad_stock=$cant1-$cant2;
		return $cantidad_stock;
	}
	
	//Funcion Insertar Tabla Temporal
	public function insertar_tb_temporal($cod_item, $cant, $detalle, $vr_uni, $no_fac, $fecha_fac, $conexion, $ins_default, $cliente, $vendedor){
		$v_total = $vr_uni * $cant;
		
		$con  = "select * from temporal where num_factura = '$no_fac' and fecha_factura ='$fecha_fac'";
		$con2 = @mysql_query($con,$conexion); 
		$con3 = @mysql_fetch_object($con2);	
		$cod_emp = $con3->cod_empleado;
		$cod_cli = $con3->cod_cli;
		if($ins_default>0){
			$cod_emp = $vendedor;
			$cod_cli = $cliente;
		}
		
		$sql="	
			INSERT INTO temporal (id_tem ,id_art ,cantidad, detalle ,vr_venta ,vr_total, num_factura, fecha_factura, cod_empleado, cod_cli)
			VALUES (NULL , '$cod_item', '$cant', '$detalle', $vr_uni, '$v_total', $no_fac, '$fecha_fac', '$cod_emp', '$cod_cli');
		";
		$sql2=@mysql_query($sql,$conexion);
		if(!$sql2){
			$sql2;
		}else{
			$mostrar_fac_ped = 1;
		}
		return $mostrar_fac_ped;
		
	}
	
	//Funcion Insertar Tabla Compra_Temporal
	public function insertar_tb_compra_temporal($cod_item, $cant, $detalle, $vr_uni, $no_fac, $fecha_fac, $fecha_ven, $cod_pro, $conexion){
		$v_total = $vr_uni * $cant;
		
		if(empty($fecha_ven)){
			$con  = "select * from compra_temporal where num_factura = '$no_fac' and fecha_compra ='$fecha_fac'";
			$con2 = @mysql_query($con,$conexion); 
			$con3 = @mysql_fetch_object($con2);	
			$fecha_ven = $con3->fecha_ven;
		}
				 
		$sql="	
			INSERT INTO compra_temporal (id_tem_c, id_art, cantidad, detalle, vr_costo, vr_total, num_factura, fecha_compra, fecha_ven, cod_pro)
			VALUES (NULL , '$cod_item', '$cant', '$detalle', $vr_uni, '$v_total', $no_fac, '$fecha_fac', '$fecha_ven', '$cod_pro');
		";
		
		$sql2=@mysql_query($sql,$conexion);
		if(!$sql2){
			$sql2;
		}else{
			$mostrar_fac_ped = 1;
		}
		return $mostrar_fac_ped;
	}
	
	//Funcion Buscar Numero Siguiente de Factura Venta
	public function num_factura_siguiente($conexion){
	
		$sqln_1		= "select * from facturacion";
		$ejecuta_1 	= @mysql_query($sqln_1,$conexion);
		$nro_fact	= @mysql_num_rows($ejecuta_1);
		
		if($nro_fact != 0)
		{
			$sqln_2		= "select * from temporal";
			$ejecuta_2 	= @mysql_query($sqln_2,$conexion);
			$nro_temp	= @mysql_num_rows($ejecuta_2);

			if($nro_temp != 0)
			{
				$sql5	= "select max(num_factura) as num_fac from temporal";
				$num	= @mysql_query($sql5,$conexion);
				$num2 	= @mysql_fetch_object($num);
				$mayor 	= $num2->num_fac;
				$no_fac = $mayor + 1;
			}else{
				$sql5	=	"select max(no_fac) as num_fac from facturacion";
				$num	=	@mysql_query($sql5,$conexion);
				$num2	=	@mysql_fetch_object($num);
				$mayor 	= 	$num2->num_fac;
				$no_fac = 	$mayor + 1;
			}
		}else{
			$sqln_3		= "select * from temporal";
			$ejecuta_3 	= @mysql_query($sqln_3,$conexion);
			$nro_temp2	= @mysql_num_rows($ejecuta_3);

			if($nro_temp2 != 0)
			{
				$sql5	=	"select max(num_factura) as num_fac from temporal";
				$num	=	@mysql_query($sql5,$conexion);
				$num2	=	@mysql_fetch_object($num);
				$mayor 	= 	$num2->num_fac;
				$no_fac = 	$mayor + 1;	
			}else{
				$no_fac = 1;
			}
		}
		return $no_fac;
	}
	
	// funcion buscar campo---------------------------------------------------------------
	public function busca_campo($cadena,$conexion){
		$ejecuta =  @mysql_query($cadena,$conexion);
		$campos= @mysql_fetch_object($ejecuta);
		return $campos;
	}	
	
	// funcion crea combos----------------------------------------------------------------
	public function combo($etiqueta,$valor,$nom_campo,$cadena,$conexion){
		$ejecuta = @mysql_query($cadena,$conexion);
		$campos=mysql_fetch_object($ejecuta);
		echo("<select name=".$nom_campo." class='style3'>");
		//echo("<option value=''>Seleccione</option>");
		do{
			echo("<option value=".$campos->$valor.">".$campos->$etiqueta."</option>");
		}while($campos=mysql_fetch_object($ejecuta));
		echo("</select>");
	}	
	
	// funcion insertar registros---------------------------------------------------------
	public function insertar($cadena,$conexion){
	 $eje_inser=@mysql_query($cadena,$conexion); 
	  if(!$eje_inser)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Datos  NO Insertados ....')
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Datos Insertados Correctamente.....')
		</SCRIPT>";}
	}
	// Borrar registros de estudiantes en administrador ------------------------------------------------------------------
	public function borrar1($cadena,$conexion){
		$ejecutar=@mysql_query($cadena,$conexion);
		if(!$ejecutar)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Articulo No fue  Eliminado de la Factura....')
		 location.href='facturacion.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Articulo se Elimino Exitosamente de la Factura.....')
		 location.href='facturacion.php';
		</SCRIPT>";}
	}
	// Borrar registros de psicologos en administrador ------------------------------------------------------------------
	public function borrar2($cadena,$conexion){  
		$ejecutar1=@mysql_query($cadena,$conexion);
		if(!$ejecutar1)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Psicologo No fue  Eliminado ....')
		 location.href='admin_lis_psico.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Psicologo Eliminado Correctamente.....')
		 location.href='admin_lis_psico.php';
		</SCRIPT>";}
	}
	
	
	// Borrar registros de administrador en administrador ------------------------------------------------------------------
	public function borrar3($cadena,$conexion){  
		$ejecutar2=@mysql_query($cadena,$conexion);
		if(!$ejecutar2)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Administrador No fue  Eliminado ....')
		 location.href='admin_lis_admin.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Administrador Eliminado Correctamente.....')
		 location.href='admin_lis_admin.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de estudiante en psicologo ------------------------------------------------------------------
	public function borrar4($cadena,$conexion){  
		$ejecutar3=@mysql_query($cadena,$conexion);
		if(!$ejecutar3)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Estudiante No fue  Eliminado ....')
		 location.href='psico_lis_est.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Estudiante Eliminado Correctamente.....')
		 location.href='psico_lis_est.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de psicologo en psicologo ------------------------------------------------------------------
	public function borrar5($cadena,$conexion){  
		$ejecutar4=@mysql_query($cadena,$conexion);
		if(!$ejecutar4)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El Psicologo No fue  Eliminado ....')
		 location.href='psico_lis_psi.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Psicologo Eliminado Correctamente.....')
		 location.href='psico_lis_psi.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de ciudad------------------------------------------------------------------
	public function borrar6($cadena,$conexion){  
		$ejecutar5=@mysql_query($cadena,$conexion);
		if(!$ejecutar5)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La Ciudad No fue  Eliminada ....')
		 location.href='admin_list_ciudad.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Ciudad Eliminada Correctamente.....')
		 location.href='admin_list_ciudad.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de Universidad------------------------------------------------------------------
	public function borrar7($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La Universidad No fue  Eliminada ....')
		 location.href='admin_list_universidad.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Universidad Eliminada Correctamente.....')
		 location.href='admin_list_universidad.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de ciudad------------------------------------------------------------------
	public function borrar8($cadena,$conexion){  
		$ejecutar5=@mysql_query($cadena,$conexion);
		if(!$ejecutar5)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La Ciudad No fue  Eliminada ....')
		 location.href='psico_list_ciudad.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Ciudad Eliminada Correctamente.....')
		 location.href='psico_list_ciudad.php';
		</SCRIPT>";}
	}
	
	// Borrar registros de Universidad------------------------------------------------------------------
	public function borrar9($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La Universidad No fue  Eliminada ....')
		 location.href='psico_list_universidad.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Universidad Eliminada Correctamente.....')
		 location.href='psico_list_universidad.php';
		</SCRIPT>";}
	}
	
	
	// Borrar registros de Universidad------------------------------------------------------------------
	public function borrar10($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Los resultados no fueron eliminados ....')
		 location.href='res_por_alumn.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Resultados eliminados exitosamente.....')
		  location.href='res_por_alum.php';
		</SCRIPT>";}
	}
	
//--------------------borrar cursos
	public function borrar11($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El curso no fue eliminado ....')
		 location.href='psi_nue_col.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El curso fue eliminado exitosamente ....')
		  location.href='psi_nue_col.php';
		</SCRIPT>";}
	}
	
	//------------------------borrar colegios
	
	public function borrar12($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El colegio no fue eliminado ....')
		 location.href='psi_nue_col.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El colegio fue eliminado exitosamente ....')
		  location.href='psi_nue_col.php?cole=888';
		</SCRIPT>";}
	}
	
	//--------------------borrar cursos
	public function borrar13($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El curso no fue eliminado ....')
		 location.href='admin_nue_col.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El curso fue eliminado exitosamente ....')
		  location.href='admin_nue_col.php';
		</SCRIPT>";}
	}
	
	//------------------------borrar colegios
	
	public function borrar14($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El colegio no fue eliminado ....')
		 location.href='admin_nue_col.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('El colegio fue eliminado exitosamente ....')
		  location.href='admin_nue_col.php?cole=888';
		</SCRIPT>";}
	}
	
	public function borrar15($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La carrera no fue eliminada ....')
		 location.href='admin_list_carrera.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La carrera fue eliminada exitosamente ....')
		  location.href='admin_list_carrera.php';
		</SCRIPT>";}
	}
	
	public function borrar16($cadena,$conexion){  
		$ejecutar6=@mysql_query($cadena,$conexion);
		if(!$ejecutar6)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La carrera no fue eliminada ....')
		 location.href='admin_list_carrera.php';
		 
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('La carrera fue eliminada exitosamente ....')
		  location.href='admin_list_carrera.php';
		</SCRIPT>";}
	}
	
	// modificar registros ---------------------------------------------------------------
	
	public function modificar($cadena,$conexion){
		$ejecutar=@mysql_query($cadena,$conexion);
		if(!$ejecutar)
	    {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Datos NO fueron modificados ....')
		</SCRIPT>";}
		else
		 {echo"
		 <SCRIPT language=JavaScript type=text/JavaScript>
		 alert('Datos modificados Correctamente.....')
		</SCRIPT>";}
	}
	
		// funcion insertar registros---------------------------------------------------------
	public function inser_popup($cadena,$conexion){
	 $eje_inser=@mysql_query($cadena,$conexion); 
	}
	//----------------------------------------------
	public function seg_usu()
	{
		if(!session_is_registered("cod_usu"))
		{
			echo("<script language=javascript>
			alert('Primero debes logearte holaaaa!!');
			location.href='../index.php';
			</script>");
	 		exit(0);	 
		}

	}
	public function seg_admin()
	{
		if(!session_is_registered("admin"))
		{
			echo("<script language=javascript>
			alert('Usted no posee privilegios de administrador..!!');
			location.href='login.php';
			</script>");
	 		//echo "Usted no posee privilegios de administrador... ";
	 		//echo "<a href='cam.php'>Comezar el logeo</a>";
	 		exit(0);	 
		}

	}
	public function seg_psi()
	{
		if(!session_is_registered("psi"))
		{
		
			echo("<script language=javascript>
			alert('Usted no es psicologo..!!');
			location.href='login.php';
			</script>");
	 		//echo "No es psicologo... ";
	 		//echo "<a href='cam.php'>Comezar el logeo</a>";
	 		exit(0);	 
		}

	}
	


}//---fin clase
?>