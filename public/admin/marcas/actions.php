<?php 
    require_once('../../conexao/conecta.php');

    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"]; 

        try {
            $query = "DELETE FROM marca WHERE id = $id;";
            if (mysqli_query($connection, $query)) {
                $_SESSION['messageType'] = 'success';
                $_SESSION['messageText'] = "Sucesso: Marca removida com sucesso.";
            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $query = "SELECT COUNT(id) AS total FROM modelo WHERE id_marca = $id";
                $result = mysqli_query($connection, $query);
                $totalCount = mysqli_fetch_assoc($result)['total'];

                $_SESSION['messageType'] = 'info';
                $_SESSION['messageText'] = "Falhou: Existem $totalCount modelos vinculados nessa marca.";
            } else {
                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Erro: Não foi possível excluir a marca.";
            }
        }
        header('Location: Index.php');
        exit;
    }

    // Cadastrar e Editar
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $isEditing = ($id > 0);

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $observation = mysqli_real_escape_string($connection, $_POST['observation']);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    if ($isEditing) {
        $query = "UPDATE marca SET nome = '$name', observacao = '$observation', status = $status WHERE id = $id";
        $successMessage = "Marca atualizada com sucesso!";
    } else {
        $query = "INSERT INTO marca VALUES (0, '$name', '$observation', NOW(), 1);";
        $successMessage = "Marca cadastrada com sucesso!";
    }

    if (mysqli_query($connection, $query)) {
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = 'Sucesso: '. $successMessage;
    } else {
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = "Erro: Não foi possível salvar a marca, tente novamente.";
    }

    header('Location: Index.php');
    exit;
?>