<?php
$saveFolderPath = 'i';
if(isset($_GET['text'])){
    $text = strtoupper($_GET['text']);
    $text = "BITCHES DON'T KNOW BOUT MY " . $text;
    $filename = $saveFolderPath . '/' . uniqid() . '.png';
    $image = new Imagick(__DIR__ . '/template.jpg');

    $textImage = new Imagick();
    $textImage->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel('none'));
    $textDraw = new ImagickDraw();
    $textDraw->setFont('fonts/Coopbl.ttf');
    $textDraw->setFontSize(30);
    $textDraw->setFillColor('white');
    $textDraw->setTextAlignment(Imagick::ALIGN_CENTER);

    $y = 380;
    $z = 230;
    $line_height = 52;
    $str = wordwrap($text, 12,"\n");
    $str_array = explode("\n",$str);
    $index = 0;
    foreach($str_array as $line){
        $textImage->annotateImage($textDraw, $z - $index, $y, 10, $line);
        $y += $line_height;
        $index += 10;
    }

    $textImage->blurImage(0, 1);
    $image->compositeImage($textImage, Imagick::COMPOSITE_OVER, 0, 0);

    if(isset($_GET['avatar']) && $_GET['avatar'] != ""){
        try{
            $image2 = new Imagick($_GET['avatar']);
            $image2->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 1);
            $image2->roundCorners(200, 200);
            $image->compositeImage($image2, Imagick::COMPOSITE_OVER, 170, 90);
        }catch(Exception $e){
            //echo json_encode(array('success' => false, 'reason' => 'Failed to load avatar'));
            //exit();
        }
    }

    if(isset($_GET['raw']) && intval($_GET['raw']) == 1){
        header('Content-Type: image/png');
        echo $image;
        exit();
    }else{
        $image->setImageFormat('png');
        $image->writeImage($filename);
        if(file_exists($filename)){
            $filename = "https://ugleh.com/imagegen/i/" . basename($filename);
            echo json_encode(array('success' => true, 'image' => $filename));
            $files = glob($saveFolderPath . '/*');
            if(count($files) > 100){
                unlink($files[0]);
            }
        }else{
            echo json_encode(array('success' => false, 'reason' => 'Failed to save image'));
        }
    }
}else{
    echo json_encode(array('success' => false, 'reason' => 'No text specified'));
}
?>