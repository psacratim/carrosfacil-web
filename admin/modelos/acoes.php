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
            $marca_modelo = $_POST['marca-modelo'];
            $nome_modelo = mysqli_real_escape_string($conexao, $_POST['nome-modelo']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
            $sql = "INSERT INTO modelo VALUES (0, $marca_modelo, '$nome_modelo', '$observacao', NOW(), 1);";
            echo $sql;
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

    if (isset($_POST['editar']) && $_POST['editar'] == "editar_modelos") {
        // Caso tenha exceptions ele volta pra pagina index.
        try {
            // CADASTRANDO CARGO NOVO
            $marca_modelo = $_POST['marca-modelo'];
            $nome_modelo = mysqli_real_escape_string($conexao, $_POST['nome-modelo']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
            $status = $_POST['status'];
            $id = $_POST['id-modelo'];
            $sql = "UPDATE modelo SET id_marca = $marca_modelo, nome = '$nome_modelo', observacao = '$observacao', status = $status WHERE id = $id;";
            echo $sql;
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Modelo atualizado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao atualizar o modelo!';
        }

        header('Location: Index.php');
    }
?>

