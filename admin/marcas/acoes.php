<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_marca") {
        try {
            $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

            $sql = "INSERT INTO marca VALUES (0, '$nome', '$observacao', NOW(), 1);";
            
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Marca cadastrada com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar a marca!';
        }
    }

    if (isset($_POST['atualizar']) && $_POST['atualizar'] == "atualizar_marca") {
        try {
            $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
            $status = $_POST['status'];
            $id = $_POST['id'];

            $sql = "UPDATE marca SET nome = '$nome', observacao = '$observacao', status = $status WHERE id = $id;";

            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Marca atualizada com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao atualizar a marca!';
        }
    }
    header('Location: Index.php');
    
?>

