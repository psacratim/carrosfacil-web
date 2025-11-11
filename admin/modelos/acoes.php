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
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Sucesso: Modelo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível cadastrar esse modelo.";
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

            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Sucesso: Modelo editado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível editar esse modelo.";
        }

        header('Location: Index.php');
    }

    if (isset($_POST['excluir_modelo'])) {
        $id = $_POST['excluir_modelo'];

        try {
            $sql = "DELETE FROM modelo WHERE id = $id;";
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = "Sucesso: O modelo foi excluido com sucesso.";
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $sql = "SELECT COUNT(id) AS total FROM veiculo WHERE id_modelo = $id";
                $query = mysqli_query($conexao, $sql);
                $total = mysqli_fetch_assoc($query)['total'];

                $_SESSION['message_type'] = 'info';
                $_SESSION['message_text'] = "Falhou: Não foi possível excluir esse modelo. Existem $total veículos que dependem dele.";
            } else {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Erro: Não foi possível excluir esse modelo.";
            }
        }

        header('Location: Index.php');
    }
?>

