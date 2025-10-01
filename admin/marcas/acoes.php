<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_marca") {
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

        $sql = "INSERT INTO marca VALUES (0, '$nome', '$observacao', NOW(), 1);";
        
        if (mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = 'Marca cadastrada com sucesso!';
            header('Location: Index.php');
        } else {
            $_SESSION['mensagem'] = 'Erro ao cadastrar a marca!';
            header('Location: Index.php');
        }
    }
?>

