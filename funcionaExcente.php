<?php
if(isset($_POST["submit"])) {
    if(is_array($_FILES)) {
        echo '<pre>';
            print_r($_FILES);
        echo '</pre>';


        $file = $_FILES['image']['tmp_name'];
        $sourceProperties = getimagesize($file);
        $fileNewName = time();
        $folderPath = "upload/";
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        echo $imageType = $sourceProperties[2];


        switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            case IMAGETYPE_WEBP:
                $imageResourceId = imagecreatefromwebp($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagewebp($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;
    

            default:
                echo "Invalid Image type.";
                exit;
                break;
        }

       // move_uploaded_file($file, $folderPath. $fileNewName. ".". $ext);
        echo "Image Resize Successfully.";
    }
}


function imageResize($imageResourceId,$width,$height) {
    $targetWidth =500;
    $targetHeight =300;

    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

    return $targetLayer;
}
?>

<div class="container">
  <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image" />
    <input type="submit" name="submit" value="Submit" />
  </form>
</div>
