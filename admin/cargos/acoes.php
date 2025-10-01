<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cargo") {
        $nome_cargo = mysqli_real_escape_string($conexao, $_POST['nome-cargo']);
        $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

        $sql = "INSERT INTO cargo VALUES (0, '$nome_cargo', '$observacao', NOW(), 1);";
        
        if (mysqli_query($conexao, $sql)) {
            // header('Location: Index.php');

            $_SESSION['mensagem'] = 'Cargo cadastrado com sucesso!';
            header('Location: Inserir.php');
        } else {
            // die('Erro: '. $sql . '<hr>' . mysqli_error($conexao));
            echo 'Deu ruim!';
            
            $_SESSION['mensagem'] = 'Erro ao cadastrar o cargo!';
            header('Location: Inserir.php');
        }
    }
?>

