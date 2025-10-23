<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    if (isset($_FILES["imagem"])) {
        $image = basename($_FILES['imagem']['name']);
        $tmp = $_FILES['imagem']['tmp_name'];
        $final = '../images/' . $image;
        
        if (move_uploaded_file($tmp, $final)){
            echo json_encode($final);
        } else {
            echo json_encode("unknown_error");
        }
    } else {
        echo json_encode("error_no_file");
    }
?>