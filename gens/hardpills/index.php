<?php
$saveFolderPath = 'i';
if(isset($_GET['text'])){
    $text = $_GET['text'];
    $filename = $saveFolderPath . '/' . uniqid() . '.png';
    $image = new Imagick(__DIR__ . '/template.png');
        $draw = new ImagickDraw();
    $draw->setFillColor('black');
    $draw->setFont('fonts/Arialbd.ttf');
    $draw->setFontSize( 50 );
    $draw->setStrokeColor('#fff');
    $draw->setStrokeWidth(1.4);
    $draw->setTextAlignment(Imagick::ALIGN_CENTER);

    $y = 680;
    $z = 360;
    $line_height = 52;
    $str = wordwrap($text, 27,"\n");
    $str_array = explode("\n",$str);
    foreach($str_array as $line){
        $image->annotateImage($draw, $z, $y, 0, $line );
        $y += $line_height;
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