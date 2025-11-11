<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cargo") {
        try {
            $nome_cargo = mysqli_real_escape_string($conexao, $_POST['nome-cargo']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

            $sql = "INSERT INTO cargo VALUES (0, '$nome_cargo', '$observacao', NOW(), 1);";
            
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Sucesso: Cargo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível cadastrar esse cargo.";
        }
        
        header('Location: Index.php');
    }

    // EDITANDO
    if (isset($_POST['atualizar']) && $_POST['atualizar'] == "atualizar_cargo") {
        try {
            $id = mysqli_real_escape_string($conexao, $_POST['edit_id']);
            $nome_cargo = mysqli_real_escape_string($conexao, $_POST['edit_nome']);
            $observacao = mysqli_real_escape_string($conexao, $_POST['edit_observacao']);
            $status = $_POST['edit_status'];

            $sql = "UPDATE cargo SET nome = '$nome_cargo', observacao = '$observacao', status = $status WHERE id = $id;";
            echo $sql;
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Sucesso: Cargo editado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Erro: Não foi possível editar esse cargo.";
        }
        
        header('Location: Index.php');
    }

    // EXCLUINDO CARGO
    if (isset($_POST['excluir_cargo'])) {
        $id = $_POST['excluir_cargo'];

        try {
            $sql = "DELETE FROM cargo WHERE id = $id;";
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = "Sucesso: O cargo foi excluido com sucesso.";
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $sql = "SELECT COUNT(id) AS total FROM funcionario WHERE id_cargo = $id";
                $query = mysqli_query($conexao, $sql);
                $total = mysqli_fetch_assoc($query)['total'];

                $_SESSION['message_type'] = 'info';
                $_SESSION['message_text'] = "Falhou: Não foi possível excluir esse cargo. Existem $total funcionários que dependem dele.";
            } else {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Erro: Não foi possível excluir esse cargo.";
            }
        }

        header('Location: Index.php');
    }
?>

