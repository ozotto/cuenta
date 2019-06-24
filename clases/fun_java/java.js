// JavaScript Document
	function sf(ID){
		document.form1.nombre.focus();
	}

//Funcion Poner focus	
	function sf_focus(ID){
		document.form1.inputString.focus();
		//document.form1.clave.focus();
	}	
	
// Funcion Campo vacio
	function vacio(q) {  
        for ( i = 0; i < q.length; i++ ) {  
                if ( q.charAt(i) != " " ) {  
                        return true  
                }  
        }  
        return false  
	}  	

//Funcion autocompletar Para Ciudad
	function lookup_ciudad(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("../clases/auto/combo_ciudad.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	
	} // lookup
	
	function fill_ciudad(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}

//Funcion autocompletar Para Departamento
	function lookup_departamento(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("../clases/auto/combo_departamento.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	
	} // lookup
	
	function fill_departamento(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}	

//Funcion autocompletar para Factura
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			//$.post("../clases/auto/comboauto2.php", {queryString: ""+inputString+""}, function(data){
			$.post("../clases/auto/comboauto.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	
	} // lookup	

	function fill(thisValue) {
		//Verificar el valor que se recibe
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
		
	}	
	
//Informacion Pagina
	function getPageTitle(){
        var t = document.getElementsByTagName('title')[0];
			if ( !!t.childNodes.length ) {
                return t.firstChild.data;
            } else if ( t.innerHTML ) {
                return t.innerHTML;
            }
    }
    function getNameURLWeb(){
        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
        return sPage;
    }
    var var_titulo_pagina =  escape(getPageTitle());
    var var_nombre_pagina =  getNameURLWeb();
 
//-Mensajes
	if(	var_nombre_pagina=="proveedor.php" ||
		var_nombre_pagina=="proveedor2.php"	){
		var men1	= "Debe completar el nombre del proveedor";
		var	men4 	= "Debe completar la direccion del proveedor";
		var	men5 	= "Inserte un Valor valido para la direccion del proveedor";
		var	men6 	= "Debe completar un telefono del proveedor";
		var	men7 	= "Inserte un Valor valido como telefono del proveedor";
		var	men8 	= "Debe completar un numero de fax del proveedor";
		var	men10	= "Debe completar un numero de celular del proveedor";
		var	men12 	= "Debe completar el nombre de contacto del proveedor";
		var	men13 	= "Inserte un Valor valido como nombre de vendedor";
		var	men14 	= "Es necesario que seleccione la ciudad del Proveedor";
	}
	if(	var_nombre_pagina=="cliente.php" ||
		var_nombre_pagina=="cliente2.php"){
		var men1	= "Debe completar el nombre del cliente";
		var	men4 	= "Debe completar la direccion del cliente";
		var	men5 	= "Inserte un Valor valido para la direccion del cliente";
		var	men6 	= "Debe completar un telefono del cliente";
		var	men7 	= "Inserte un Valor valido como telefono del cliente";
		var	men8 	= "Debe completar un numero de fax del cliente";
		var	men10	= "Debe completar un numero de celular del cliente";
		var	men12 	= "Debe completar el nombre de contacto del cliente";
		var	men13 	= "Inserte un Valor valido como nombre de contacto del cliente";
		var	men14 	= "Es necesario que seleccione la ciudad del cliente";
	}
	if(	var_nombre_pagina=="departamento.php"){
		var men1	= "Debe completar el nombre del Departamento";
	}
	
	var men2 	= "Debe completar el numero de registro tributario NIT";
	var	men3 	= "Inserte un Valor valido para el numero de registro tributario";
	var	men9 	= "Inserte un Valor valido como numero de fax";
	var	men11	= "Inserte un Valor valido como numero de celular";
	if(	var_nombre_pagina=="articulo.php"){
		var men1	= "Complete un valor valido para el codigo de barras";
		var men2	= "Complete un valor valido para la descripcion del articulo";
		var men3	= "Asigne un departamento para el articulo a crear";
		var men4	= "Complete la cantidad de articulos";
		var men5	= "Asigne un costo para el articuo";
		var men6	= "Asigne un precio de venta para el articuo";
	}
	
	
//-Menu de Gestion  	
	function nuevo_gestion()
	{
		if(var_nombre_pagina=="proveedor.php"	||
			var_nombre_pagina=="proveedor2.php")
		{
			document.form1.action="proveedor.php?val=2";
			document.form1.submit();
		}
		if(	var_nombre_pagina=="cliente.php"	||
			var_nombre_pagina=="cliente2.php")
		{
			document.form1.action="cliente.php?val=2";
			document.form1.submit();
		}
	}
	function listar_gestion()
	{
		if(	var_nombre_pagina=="proveedor.php" ||
			var_nombre_pagina=="proveedor2.php"){
			document.form1.action="proveedor.php?val=1";
			document.form1.submit();
		}
		if(	var_nombre_pagina=="cliente.php" ||
			var_nombre_pagina=="cliente2.php"){
			document.form1.action="cliente.php?val=1";
			document.form1.submit();
		}
		if(	var_nombre_pagina=="ventas2.php" ){
			document.form1.no_cont_fac.value="OK";
			document.form1.action="ventas.php?val=1";
			document.form1.submit();
		}
		if(	var_nombre_pagina=="compras2.php" ){
			document.form1.no_cont_fac.value="OK";
			document.form1.action="compras.php?val=1";
			document.form1.submit();
		}		
	}
	function cerrar_factura()
	{
		//alert(var_nombre_pagina);
		if(	var_nombre_pagina=="ventas2.php" ){
			document.form1.cerrar_fac.value="OK";
			document.form1.submit(); 
		}
		if(	var_nombre_pagina=="compras2.php" ){
			document.form1.cerrar_fac_compras.value="OK";
			document.form1.submit();
		}
	}
	function eliminar_factura()
	{
		document.form1.eliminar_fac.value="OK";
		document.form1.submit();
	}
	function eliminar_fact()
	{
		document.form1.eliminar_toda_factura.value="OK";
		document.form1.submit();
	}
	
	function eliminar_articulo()
	{
		document.form1.eliminar_articulo_fac.value="OK";
		document.form1.submit();
	}
	
	function eliminar_departamento()
	{
		document.form1.eliminar_depar.value="OK";
		document.form1.submit();
	}
	
	function continuar_factura()
	{
		document.form1.continua_fac.value="OK";
		document.form1.submit(); 
	}
	//Funcion Nueva Factura
	function nueva_factura()
	{
		document.form1.nueva_fac.value="OK";
		//document.form1.action="factura_user.php";
		document.form1.submit();
	}
	
	
//-------------------------------------------------------------------------------------------	
//Menu Principal
	function menu_inicio()
	{
		document.form1.menu_admin.value="OK";
		document.form1.action="administrar.php";
		document.form1.submit();
	}
	function menu_inventario()
	{
		document.form1.menu_inven.value="OK";
		document.form1.action="inventario.php";
		document.form1.submit();
	}
	function menu_productos(act_ver_nue_art)
	{
		var guarda_url = act_ver_nue_art; 
		document.form1.men_productos.value="OK";
		if (guarda_url > 0){
			document.form1.guarda_url.value="SI";
		}else{
			document.form1.guarda_url.value="NO";
		}	
		document.form1.action="articulo.php";
		document.form1.submit();
	}
	function menu_ventas()
	{
		document.form1.men_ventas.value="OK";
		document.form1.action="ventas.php?val=1";
		document.form1.submit();
	}
	function menu_compras()
	{
		document.form1.men_compras.value="OK";
		document.form1.action="compras.php?val=1";
		document.form1.submit();
	}
	function menu_cliente()
	{
		document.form1.men_cliente.value="OK";
		document.form1.action="cliente.php?val=1";
		document.form1.submit();
	}
	function menu_proveedor()
	{
		document.form1.men_proveedor.value="OK";
		document.form1.action="proveedor.php?val=1";
		document.form1.submit();
	}
	function menu_departa()
	{
		document.form1.men_departa.value="OK";
		document.form1.action="departamento.php";
		document.form1.submit();
	}
	function menu_factura()
	{
		document.form1.men_factura.value="OK";
		document.form1.action="facturacion.php";
		document.form1.submit();
	}
	function menu_ce_sesion()
	{
		document.form1.men_ce_sesion.value="OK";
		document.form1.action="../clases/datos.php?cerrar_sesion=1";
		document.form1.submit();
	}
//Boton Nueva Compra
	function nueva_compra()
	{
		var var_titulo_pagina2 =  escape(getPageTitle());
		var var_nombre_pagina2 =  getNameURLWeb();
		if(var_nombre_pagina2=="compras.php"){
			document.form1.n_com.value="OK";
			document.form1.action="compras1.php";
			document.form1.submit();
		}
		if(var_nombre_pagina2=="departamento.php"){
			document.form1.n_com.value="OK";
			document.form1.action="departamento.php";
			document.form1.submit();
		}
		
	}
	
//Boton Crear Factura con informacion
	function crea_fac_info() {  
		
		for(i=0; i <document.form1.ver.length; i++){
			if(document.form1.ver[i].checked){
				valorSeleccionado = document.form1.ver[i].value;
			}
		}
		//alert (valorSeleccionado);
		
		if(document.form1.can.value == "Seleccione" ) {  
			alert("Es necesario seleccionar el Proveedor");
			document.form1.can.focus();
            return false  
        }
		if( vacio(document.form1.orden.value) == false ) {  
			alert("Digite el numero de la Factura de compra");
			document.form1.orden.focus();
            return false  
        }	
		if( vacio(document.form1.fecha_compra.value) == false ) {  
			alert("Debe seleccionar la fecha de compra de la Factura");
			document.form1.fecha_compra.focus();
            return false  
        }
		if(valorSeleccionado == 2){
			if( vacio(document.form1.fecha_vence.value) == false ) { 
				alert("Debe seleccionar la fecha de vencimiento de la Factura");
				document.form1.fecha_vence.focus();
				return false  
			} 	
			if(document.form1.fecha_vence.value <= document.form1.fecha_compra.value) {
				alert("La fecha de Vencimiento debe ser MAYOR a la fecha de Compra");
				document.form1.fecha_vence.focus();
				return false
			}
		}
		
		var pagina	=	"compras1.php"
		var vProve 	= document.form1.can.value;
		var vFecha 	= document.form1.fecha_compra.value;
		var vFe_ve 	= document.form1.fecha_vence.value;
		var vFactu 	= document.form1.orden.value;
		var var1	=	"?id_pro=";
		var var2	=	"&fec="; 
		var var3	=	"&id_pen=";
		var var4	=	"&fec_ven=";
		
		if(valorSeleccionado == 1){
			var enviar	=	pagina	+	var1	+	vProve	+	var2	+	vFecha	+ 	var3	+	vFactu;
		}
		if(valorSeleccionado == 2){
			var enviar	=	pagina	+	var1	+	vProve	+	var2	+	vFecha	+ var4	+	vFe_ve	+	var3	+	vFactu;
		}
		
		
		document.form1.oc.value="OK";
		document.form1.action=enviar;
		document.form1.submit();  
	}

	
//Boton Modificar	
	function mod_gestion()
	{
		document.form1.btn_mod.value="OK";
		document.form1.action="departamento.php";
		document.form1.submit();
	}
	
	function modificar_departamento()
	{
		document.form1.modificar_depar.value="OK";
		document.form1.action="departamento.php";
		document.form1.submit();
	}
	
	function modificar_articulo()
	{
		document.form1.mod_articulo.value="OK";
		document.form1.action="articulo.php";
		document.form1.submit();
	}
	
//-------------------------------------------------------------------------------------------
	
//-Boton buscar_proveedor	
	function buscar_proveedor() 
	{ 
		if(document.form1.busco.value=="" )
		{
			if(var_nombre_pagina=="cliente.php"){
				alert("Debe completar el nombre del cliente");
			}
			if(var_nombre_pagina=="proveedor.php"){
				alert("Debe completar el nombre del proveedor");
			}
			if(var_nombre_pagina=="departamento.php"){
				alert("Debe completar el nombre del departamento");
			}
			document.form1.busco.focus();
		}else{
			document.form1.buscador.value="OK";
			document.form1.submit();  
		}	
	}	

//Funcion Validar creacion de Articulo
	function val_articulo(cod_val_acc){
		var cant = form1.cantidad.value;
		var cost = form1.costo.value;
		var prec = form1.precio.value;
	
		if( vacio(document.form1.barras.value) == false ) {  
      		alert(men1);
			document.form1.barras.focus();
            return false  
        }
		if( vacio(document.form1.descripcion.value) == false ) {  
      		alert(men2);
			document.form1.descripcion.focus();
            return false  
        }
		if( vacio(document.form1.inputString.value) == false ) {  
      		alert(men3);
			document.form1.inputString.focus();
            return false  
        }
		//Quitar estos comentarios cuando este listo el articulo!!
		/*
		if( (cant == "NaN") || (cant == 0) || ( vacio(document.form1.cantidad.value) == false ) ){
			alert(men4);
			document.form1.cantidad.focus();
            return false  
		}
		*/
		if( (cost == "NaN") || (cost == 0) || ( vacio(document.form1.costo.value) == false ) ){
			alert(men5);
			document.form1.costo.focus();
            return false  
		}
		if( (prec == "NaN") || (prec == 0) || ( vacio(document.form1.precio.value) == false ) ){
			alert(men6);
			document.form1.precio.focus();
            return false  
		}		
		if(cod_val_acc == 1){
			document.form1.crea_articulo.value="OK";
		}
		if(cod_val_acc == 2){
			document.form1.modifica_prod.value="OK";
		}
		if(cod_val_acc == 3){
			document.form1.crea_articulo.value="OK";
			document.form1.mostrar_menu.value="OK";
		}
		if(cod_val_acc == 4){
			document.form1.crea_articulo.value="OK";
			document.form1.crea_vol_fac.value="OK";
		}
		document.form1.action="articulo.php";
		document.form1.submit();     		
	}
	
//Funcion volver a la factura desde creacion articulo
	function vol_factura(){
		document.form1.volver_fact.value="OK";
		document.form1.submit(); 
	}
	
//- Boton Crear Proveedor validar formulario
	function val_cre_prov(cod_ges_mod) {  
//		alert(cod_ges_mod);		
        if( vacio(document.form1.nombre.value) == false ) {  
      			alert(men1);
				document.form1.nombre.focus();
                return false  
        }
		if( vacio(document.form1.nit.value) == false ) {  
                alert(men2);
				document.form1.nit.focus();
                return false  
        }
		if( document.form1.nit.value == 0 ||
			document.form1.nit.value == 'N/A' ) {  
                alert(men3);
				document.form1.nit.focus();
                return false  
        }
		if( vacio(document.form1.direccion.value) == false ) {  
                alert(men4);
				document.form1.direccion.focus();
                return false  
        }
		if( document.form1.direccion.value == 0 || 
			document.form1.direccion.value == 'N/A' ) {  
                alert(men5);
				document.form1.direccion.focus();
                return false  
        }
		if( vacio(document.form1.tel1.value) == false ) {  
                alert(men6);
				document.form1.tel1.focus();
                return false  
        }
		if( document.form1.tel1.value == 0 || 
			document.form1.tel1.value == 'N/A'	) {  
                alert(men7);
				document.form1.tel1.focus();
                return false  
        }
		if( document.form1.tel2.value == 0 ||
			document.form1.tel2.value == 'N/A'	) {  
                alert(men7);
				document.form1.tel2.focus();
                return false  
        }
		if( vacio(document.form1.fax.value) == false ) {  
                alert(men8);
				document.form1.fax.focus();
                return false  
        }
		if( document.form1.fax.value == 0 ||
			document.form1.fax.value == 'N/A' ) {  
                alert(men9);
				document.form1.fax.focus();
                return false  
        }
		if( vacio(document.form1.celular.value) == false ) {  
                alert(men10);
				document.form1.celular.focus();
                return false  
        }
		if( document.form1.celular.value == 0 ||
			document.form1.celular.value == 'N/A' ) {  
                alert(men11);
				document.form1.celular.focus();
                return false  
        }
		if( vacio(document.form1.vendedor.value) == false ) {  
                alert(men12);
				document.form1.vendedor.focus();
                return false  
        }
		if( document.form1.vendedor.value == 0 ||
			document.form1.vendedor.value == 'N/A'	) {  
                alert(men13);
				document.form1.vendedor.focus();
                return false  
        }
		if( vacio(document.form1.inputString.value) == false ) {  
                alert(men14);
				document.form1.inputString.focus();
                return false  
        }

		if(	var_nombre_pagina=="proveedor.php" ||
			var_nombre_pagina=="cliente.php"){
			document.form1.crea_pro.value="OK";
			var enviar = var_nombre_pagina;
		}
		if(	var_nombre_pagina=="proveedor2.php" ||
			var_nombre_pagina=="cliente2.php"){
			
			document.form1.mod_ges.value="OK";
	
			var cam_enviar = "?cod_tab_mod=";
			var enviar = var_nombre_pagina + cam_enviar + cod_ges_mod;
		} 		
		document.form1.action=enviar;
		document.form1.submit();     
	} 

	//- Funcion Valida Formulario
	function val_formulario() {
		if( vacio(document.form1.nombre.value) == false ) {  
      			alert(men1);
				document.form1.nombre.focus();
                return false  
        }
		document.form1.crea_depto.value="OK";
		//document.form1.action="departamento.php";
		document.form1.submit();
	}

//----------------------------------------------------------------------------
	//Funcion Solo permite valor Numerico
	function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
	//Funcion Llamar a solo numero
	function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
	
	//Funcion calcular precio
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
	//Funcion calcular porcentaje
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