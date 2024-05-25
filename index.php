<?php
if(isset($_GET['type'])){
    $type = $_GET['type'];
    
    //prevent any directory traversal
    if(strpos($type, '/') !== false){
        echo json_encode(array('success' => false, 'reason' => 'Invalid type'));
        exit();
    }

    $file = 'gens/' . $type . '/index.php';
    if(file_exists($file)){
        include($file);
    }else{
        echo json_encode(array('success' => false, 'reason' => 'Invalid type'));
    }
}else{
    echo json_encode(array('success' => false, 'reason' => 'No type specified'));
}

header('Content-Type: application/json');
?>