<?php 
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'carrosfacil_ti50';

    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
    
    if (mysqli_connect_errno()) {
        die("Failed to connect in mysql: " . mysqli_connect_error());
    }
    
?>