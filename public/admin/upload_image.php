<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    
    if (isset($_FILES["image"])) {
        $image = basename($_FILES['image']['name']);
        $tempImagePath = $_FILES['image']['tmp_name'];
        $final = '../images/' . $image;
        
        if (move_uploaded_file($tempImagePath, $final)){
            echo json_encode($image);
        } else {
            echo json_encode("unknown_error");
        }
    } else {
        echo json_encode("error_no_file");
    }
?>