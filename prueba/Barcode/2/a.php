<?Php

require_once 'Image/Barcode.php';
//Image_Barcode::draw('1234', 'int25', 'png');
//Image_Barcode::draw('1', 'code128', 'png');
Image_Barcode::draw($_GET[NUM], $_GET[TYP], $_GET[IMG]);

?> 
<html>
<head>
</head>
<body>
<h1>Codigo de Barras EAN13</h1>
<img src="a.php?NUM=4011030968433&TYP=ean13&IMG=png"/>
</body>
</html>
