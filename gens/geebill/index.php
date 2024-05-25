<?php
$saveFolderPath = 'i';
if(isset($_GET['prompt']) && isset($_GET['answer'])){
    $text = strtolower($_GET['prompt']);
    $text2 = strtolower($_GET['answer']);
    $user = (isset($_GET['name2']) && $_GET['name2'] != "") ? strtolower($_GET['name2']) : "bill";
    if(substr($text, -1) != '?'){
        //The intention of this is the unpredictability of my ChatGPT bot adding a question mark at the end of the prompt
        $text .= '?';
    }
    $text = "gee ".$user."! how come your mom lets you " . $text;
    $filename = $saveFolderPath . '/' . uniqid() . '.png';
    $image = new Imagick(__DIR__ . '/template.png');

    $textImage = new Imagick();
    $textImage->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel('none'));
    $textDraw = new ImagickDraw();
    $textDraw->setFont('fonts/Poquito.otf');

    $font_size = 18;
    $textDraw->setFontSize($font_size);
    $textDraw->setFillColor('#3F3A36');
    $textDraw->setTextKerning(0.7);
    $textDraw->setTextAlignment(Imagick::ALIGN_CENTER);

    $y =  26;
    $z = 220;
    $line_height = 21;
    $str = wordwrap($text, 22,"\n");
    $str_array = explode("\n",$str);
    foreach($str_array as $line){
        $textImage->annotateImage($textDraw, $z, $y, 0, $line);
        $y += $line_height;
    }

    $textImage->blurImage(0, 0.33);
    $image->compositeImage($textImage, Imagick::COMPOSITE_OVER, 0, 0);



    $textImage->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel('none'));
    $textDraw = new ImagickDraw();
    $textDraw->setFont('fonts/Poquito.otf');

    $textLength = strlen($text2);
    $baseLength = 16;
    $baseFontSize = 31;

    if ($textLength <= $baseLength) {
        $fontSize = $baseFontSize;
    } else {
        $fontSize = $baseFontSize * ($baseLength / $textLength);
    }

    if($fontSize < 12){
        $fontSize = 12;
    }
    
    $textDraw->setFontSize($fontSize);    
    $textDraw->setFillColor('#F32A2A');
    $textDraw->setTextKerning(0.7);
    $textDraw->setTextAlignment(Imagick::ALIGN_CENTER);

    $y =  315;
    $z = 180;
    $line_height = 21;
    if ($textLength <= 16) {
        $wordWrapLength = 15;
    } else {
        $wordWrapLength = round(15 * ($textLength / 16));
    }

    if($wordWrapLength > 40) $wordWrapLength = 40;

    $str = wordwrap($text2, $wordWrapLength,"\n");
    $str_array = explode("\n",$str);
    $y -= 15 * count($str_array);
    foreach($str_array as $line){
        $textImage->annotateImage($textDraw, $z, $y, 0, $line);
        $y += $line_height;
    }

    $textImage->blurImage(0, 0.33);
    $image->compositeImage($textImage, Imagick::COMPOSITE_OVER, 0, 0);

    if(isset($_GET['avatar1']) && $_GET['avatar1'] != ""){
        try {
            $image2 = new Imagick($_GET['avatar1']);
            $image2->resizeImage(100, 100, Imagick::FILTER_LANCZOS, 1);
            $image2->roundCorners(200, 200);
            $image->compositeImage($image2, Imagick::COMPOSITE_OVER, 40, 60);
        } catch (ImagickException $e) {
            //echo json_encode(array('success' => false, 'reason' => 'Failed to open avatar1 image'));
            //header('Content-Type: application/json');
            //exit();
        }
    }
    
    if(isset($_GET['avatar2']) && $_GET['avatar2'] != ""){
        try{
            $image2 = new Imagick($_GET['avatar2']);
            $image2->resizeImage(100, 100, Imagick::FILTER_LANCZOS, 1);
            $image2->roundCorners(200, 200);
            $image->compositeImage($image2, Imagick::COMPOSITE_OVER, 190, 90);
        }catch(ImagickException $e){
            //echo json_encode(array('success' => false, 'reason' => 'Failed to open avatar2 image'));
            //header('Content-Type: application/json');
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