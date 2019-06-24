<style>
body { font-family: "Tahoma", "Arial", "Helvetica", "sans-serif"; font-size:     10pt; color: #000000;
background-image: url(http://annouk-oscar.i-set.com/uploads/1209-photos-bg1920-20.jpg);
background-repeat:no-repeat;
background-position:center top;
background-attachment:scroll;
background-color:#333333;}a { color: #4cb2b2; text-decoration:none; }
a:visited { color: #4cb2b2;text-decoration:none ;}
a:hover { color: #4cb2b2;text-decoration:underline;}
html > body > div > table { box-shadow: 1px 1px 12px #000000;}
</style>

<style>
/* ThemeIsetMenu Style Sheet */

.ThemeIsetMenu,.ThemeIsetSubMenuTable
{
	cursor:		default;
	font-family:	arial, verdana, sans-serif;
	font-size:	10pt; 
	padding:	0;
	border:		0;
	white-space:	nowrap;
}

.ThemeIsetMenu
{
    font-family	: Times, sans-serif;
    font-size	: large;	
    font-weight	: bold;
    text-align	: left ;
    color	:white	;
    background	:#FF0099;
    margin-top	: 10;
    
    border	: 10px;
    border-top	: 10;
    border-top-width: thick;
    border-color: 	3;
    width:200px;
    height:22px;}

.ThemeIsetSubMenu
{
	position:	absolute;
	visibility:	hidden;
	overflow:	hidden;
	color: #FFFFCC;
        font-weight:    bold;
	border:		0;
	padding:	0;
}

.ThemeIsetSubMenuShadow
{
	z-index:	-1;
	position:	absolute;
	top:		9px;
	left:		9px;
	width:		100%;
	height:		300em;
	background-color:	black;  
	opacity:	0.45;
	border:		0;
	margin:		0;
}

.ThemeIsetSubMenuBorder
{
	border:		1px solid #000000;
	background-color:	#CCE799;
	padding:	2px;
	margin:		0px 3px 3px 0px;
}
 
.ThemeIsetSubMenuTable
{
	border:		0;
	background-color:	#003366;
}

.ThemeIsetSubMenuTable td
{
	white-space:	nowrap;
}

.ThemeIsetMainItem,.ThemeIsetMainItemHover,.ThemeIsetMainItemActive,
.ThemeIsetMenuItem,.ThemeIsetMenuItemHover,.ThemeIsetMenuItemActive
{
	padding:	1px 3px 1px 3px;
	white-space:	nowrap;
}

.ThemeIsetMainItemHover,.ThemeIsetMainItemActive,
.ThemeIsetMenuItemHover,.ThemeIsetMenuItemActive
{
	color:		#ffffcc;
	background-color:	#00CCCC;
}

td.ThemeIsetMenuSplit
{
	margin:		0px;
	border:		0px;
	overflow:	hidden;
	background-color:	inherit;
}

div.ThemeIsetMenuSplit
{
	height:		1px;
	margin:		1px 0px 1px 0px;
	overflow:	hidden;
	background-color:	inherit;
	border-top:	1px solid #CCE799;
}

.ThemeIsetMenuVSplit
{
	width:		1px;
	margin:		0px;
	overflow:	hidden;
	background-color:	inherit;
	border-right:	1px solid #CCE799;
}

/* image shadow animation */

/*
	seq1:	image for normal
	seq2:	image for hover and active

	To use, in the icon field, input the following:
	<img class="seq1" src="normal.gif" /><img class="seq2" src="hover.gif" />
*/

.ThemeIsetMenuItem img.seq1
{
	display:	inline;
}

.ThemeIsetMenuItemHover seq2,
.ThemeIsetMenuItemActive seq2
{
	display:	inline;
}

.ThemeIsetMenuItem .seq2,
.ThemeIsetMenuItemHover .seq1,
.ThemeIsetMenuItemActive .seq1
{
	display:	none;
}

.boton{
        font-family	: Times, sans-serif;
		font-size	: large;	
        font-weight	: bold;
		text-align	: left ;
		
		color		:white	;
        background	:#FF0099;
        
		margin-top	: 2;
		border		:	10px;
		border-top	:	10;
		border-top-width: thick;
		border-color: 	3;
		
		width:200px;
		height:22px;
		
       }
	.boton2{
		font-size:14px;
		font-family:Arial,sans-serif;
		font-weight:bold;
		text-align	: left ;
		color:#FFFFFF;
		

		
		background-color:#925071;
		border-top-style:double;

		border-top-width:4px;
		border-bottom-style:double;

		border-bottom-width:4px;
		border-left-style:solid;
		border-left-color:#131313;
		border-left-width:4px;
		border-right-style:solid;
		border-right-color:#131313;
		border-right-width:4px;
		
		width:200px;
		height:24px;
			
	}
	
	input.groovybutton
	{
	#CF6307
				border-bottom-color:#131313;
						border-top-color:#131313;
   font-size:12px;
   font-family:Arial,sans-serif;
   font-weight:bold;
   color:#FFFFFF;
   background-color:#EE7777;
   border-top-style:double;
   border-top-color:#EE7777;
   border-top-width:4px;
   border-bottom-style:double;
   border-bottom-color:#EE7777;
   border-bottom-width:4px;
   border-left-style:solid;
   border-left-color:#EE7777;
   border-left-width:4px;
   border-right-style:solid;
   border-right-color:#EE7777;
   border-right-width:4px;
	}
</style>

<?
//<form name="groovyform">
//font-family:Verdana,Helvetica;
//font-size:10px;
//onMouseOver="goLite(this.form.name,this.name)" onMouseOut="goDim(this.form.name,this.name)"
 $clase = "boton2";
?>
<!--
<div align="left">
  <form name="form1" action="http://www.yahoo.es" target="_blank" method="post">
    <table width='210' bgcolor='131313'>
	<tr><td><input type="submit" value="Accueil" class="boton2"></td></tr>
	<tr><td><input type="submit" value="Info" class="boton2"></td></tr>	
	<tr><td><input type="submit" value="menu2" class="boton2"></td></tr>	
	<tr><td><input type="submit" value="menu3" class="boton2"></td></tr>	
	</table>
  </form>
</div>
-->

<script language="javascript">

function goLite(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.backgroundColor = "#FF7777";
}

function goDim(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.backgroundColor = "#EE7777";
}

</script>




<form name="form" target="_blank" method="post">
<table width="960" align= "center">
<tr>
<td>

<table align="center">
<tr>
<td width="960"><img src=../imagenes/Banner.jpg width='960' height='200' /></td>
</tr>
</table>

</td>
</tr>

<tr>
<td>

<table align="center" width="960">
<tr>
<td width="210">
<table width='210' bgcolor='131313'>
<tr><td><input type="button" name="btn1" class="<? echo $clase;?>" value="Arizona" title=""></td></tr>
<tr><td><input type="button" name="btn1" class="<? echo $clase;?>" value="menu1" title=""></td></tr>
<tr><td><input type="button" name="btn1" class="<? echo $clase;?>" value="menu2" title=""></td></tr>
<tr><td><input type="button" name="btn1" class="<? echo $clase;?>" value="mennu3" title=""></td></tr>
</table>

</td>
<td width="750">info</td>
</tr>
</table>

</td>
</tr>

</table>


</form>
