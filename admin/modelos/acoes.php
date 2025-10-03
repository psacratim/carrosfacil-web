<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_modelos") {
        // Caso tenha exceptions ele volta pra pagina index.
        try {
            // CADASTRANDO CARGO NOVO
            $marca_modelo = mysqli_real_escape_string($conexao, $_POST['marca-modelo']);
            $nome_modelo = mysqli_real_escape_string($conexao, $_POST['nome-modelo']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

            $sql = "INSERT INTO modelo VALUES (0, '$nome', '$observacao', NOW(), 1);";
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Modelo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o modelo!';
        }

        header('Location: Index.php');
    }
?>

