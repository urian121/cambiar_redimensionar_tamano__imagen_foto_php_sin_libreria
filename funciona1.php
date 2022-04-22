<?php 
if (isset($_FILES['imagen1']) && $_FILES['imagen1']['tmp_name']!=''){
//Imagen original
$rtOriginal   = $_FILES['imagen1']['tmp_name'];
$tipofile     = $_FILES["imagen1"]["type"];

//Crear variable
if($tipofile=='image/jpeg' || $tipofile=='image/jpg'){
  $original = imagecreatefromjpeg($rtOriginal);
  }
  else if($tipofile=='image/png' || $tipofile=='image/PNG'){
  $original = imagecreatefrompng($rtOriginal);
  }
  else if($tipofile=='image/gif'){
  $original = imagecreatefromgif($rtOriginal);
  }
  else if($tipofile=='image/webp'){
    $original = imagecreatefromwebp($rtOriginal);
    
    /*imagewebp($original);
    imagedestroy($original); */
  }

//Ancho y alto máximo
$max_ancho = 800; 
$max_alto = 500;
 
//Medir la imagen
list($ancho,$alto)=getimagesize($rtOriginal);

//Ratio
$x_ratio = $max_ancho / $ancho;
$y_ratio = $max_alto / $alto;

//Proporciones
if(($ancho <= $max_ancho) && ($alto <= $max_alto) ){
    $ancho_final = $ancho;
    $alto_final = $alto;
}
else if(($x_ratio * $alto) < $max_alto){
    $alto_final = ceil($x_ratio * $alto);
    $ancho_final = $max_ancho;
}
else {
    $ancho_final = ceil($y_ratio * $ancho);
    $alto_final = $max_alto;
}

//Crear un lienzo
$lienzo = imagecreatetruecolor($ancho_final,$alto_final); 
$color = imagecolorallocatealpha($lienzo, 255, 255, 255, 1);
imagefill($lienzo, 0, 0, $color);

//Copiar original en lienzo
imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
//Destruir la original
imagedestroy($original);

$path= "upload";
//Crear la imagen y guardar en directorio upload/
$filename = $path."/".$_FILES['imagen1']['name'];
imagejpeg($lienzo,$filename);

}
?>
 <form action="" method="post" enctype="multipart/form-data">
 	<input type="file" name="imagen1">
 	<input type="submit" value="Subir">
 </form>