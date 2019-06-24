	  <tr>
	   <td colspan='4'>
		 <div align='left'><span class='Estilo6'>UBICACION </span></div>	
	   </td>
	  </tr>
	    <tr>
       	 <td width='104'><span class='Estilo6'>PAIS</span></td>
       	 <td width='111' colspan='3'>
		 ";
		$pos1=0;
		$pos2=1;
		$formulario .= "
		<select name='pais' id='pais'>
		";
		for($cont=1; $cont<=$cant_pais; $cont++){
		 $formulario .= "<option value=". $lista_pais[$pos1][$pos2][0] .">". $lista_pais[$pos1][$pos2][1] ."</option>";
		 $pos1++;
		 $pos2++;
		}
		$formulario .= "</select>";

		$formulario.="		
		</td>
	  </tr>
	  <tr>	
       	<td width='95'><span class='Estilo6'>DEPARTAMENTO</span></td>
       	<td width='160' colspan='3'>
		 ";
		$pos1=0;
		$pos2=1;
		$formulario .= "
		<select name='pais' id='pais'>
		";
		for($cont=1; $cont<=$cant_dpto; $cont++){
		 $formulario .= "<option value=". $lista_dpto[$pos1][$pos2][0] .">". $lista_dpto[$pos1][$pos2][1] ."</option>";
		 $pos1++;
		 $pos2++;
		}
		$formulario .= "</select>";

		$formulario.="		
		</td>
	  <tr>	
		<td width='117'><span class='Estilo6'>CIUDAD</span></td>
        <td width='137' colspan='3'>
		
		 ". 
		// select_option($etiqueta,$valor,$nom_campo,$cadena,$conexion);
		  "				 
		</td>
      </tr>	  
	  <tr>
       <td colspan='6'>
		<div align='center'>
		 <input type='button' value='Crear Proveedor' onClick='valida2(this)' />
		</div>
	   </td>
      </tr>