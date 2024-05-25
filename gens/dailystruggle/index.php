<?php
$saveFolderPath = 'i';
if(isset($_GET['option1']) && isset($_GET['option2'])){
    $option1 = strtoupper($_GET['option1']);
    $option2 = strtoupper($_GET['option2']);
    $image = new Imagick(__DIR__ . '/template.png');
    $textImage = new Imagick();
    $textImage->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel('none'));
    $textDraw = new ImagickDraw();
    $textDraw->setFont('fonts/Coopbl.ttf');
    $textDraw->setFontSize(13);
    $textDraw->setFillColor('black');
    $textDraw->setTextAlignment(Imagick::ALIGN_CENTER);

    $y = 88;
    $z = 115;
    $line_height = 20;
    $str = wordwrap($option1, 16,"\n");
    $str_array = explode("\n",$str);
    $index = 0;
    foreach($str_array as $line){
        $textImage->annotateImage($textDraw, $z + $index, $y, -15, $line);
        $y += $line_height;
        $index += 10;
    }
    $image->compositeImage($textImage, Imagick::COMPOSITE_OVER, 0, 0);


        $textImage = new Imagick();
        $textImage->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel('none'));
        $textDraw = new ImagickDraw();
        $textDraw->setFont('Coopbl.ttf');
        $textDraw->setFontSize(11);
        $textDraw->setFillColor('black');
        $textDraw->setTextAlignment(Imagick::ALIGN_CENTER);
    
        $y = 60;
        $z = 260;
        $line_height = 18;
        $str = wordwrap($option2, 16,"\n");
        $str_array = explode("\n",$str);
        $index = 0;
        foreach($str_array as $line){
            $textImage->annotateImage($textDraw, $z + $index, $y, -14, $line);
            $y += $line_height;
            $index += 10;
        }
        $image->compositeImage($textImage, Imagick::COMPOSITE_OVER, 0, 0);

        
    if(isset($_GET['avatar']) && $_GET['avatar'] != ""){
        try{
            $image2 = new Imagick($_GET['avatar']);
            $image2->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 1);
            $image2->roundCorners(200, 200);
            $image->compositeImage($image2, Imagick::COMPOSITE_OVER, 160, 380);

            $overlay = new Imagick(__DIR__ . '/overlay.png');
            $image->compositeImage($overlay, Imagick::COMPOSITE_OVER, 0, 0);
        }catch(Exception $e){
            //echo json_encode(array('success' => false, 'reason' => 'Failed to load avatar image'));
            //exit();
        }
    }

    if(isset($_GET['raw']) && intval($_GET['raw']) == 1){
        header('Content-Type: image/png');
        echo $image;
        exit();
    }else{
        $image->setImageFormat('png');
        $filename = $saveFolderPath . '/' . uniqid() . '.png';
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
    echo json_encode(array('success' => false, 'reason' => 'No option1 or option2 specified'));
}
?>