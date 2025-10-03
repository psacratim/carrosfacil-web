<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    if (isset($_GET['marca-modelo'])) {
        // try {
            // CADASTRANDO CARGO NOVO
            $id = $_GET['marca-modelo'];
            $sql = "SELECT * FROM marca WHERE id=$id";
            $query = mysqli_query($conexao, $sql);
            if ($query) {
                $row = mysqli_fetch_assoc($query);
                echo $row['nome'];
            } else {
                echo 'null';
            }
    }
?>

