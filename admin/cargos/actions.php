<?php 
    require_once('../../conexao/conecta.php');

    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"]; 

        try {
            $query = "DELETE FROM cargo WHERE id = $id;";
            if (mysqli_query($connection, $query)) {
                $_SESSION['messageType'] = 'success';
                $_SESSION['messageText'] = "Sucesso: O cargo foi excluído.";
            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $query = "SELECT COUNT(id) AS total FROM funcionario WHERE id_cargo = $id";
                $result = mysqli_query($connection, $query);
                $totalCount = mysqli_fetch_assoc($result)['total'];

                $_SESSION['messageType'] = 'info';
                $_SESSION['messageText'] = "Falhou: Existem $totalCount funcionários vinculados a este cargo.";
            } else {
                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Erro ao excluir.";
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
        $query = "UPDATE cargo SET nome = '$name', observacao = '$observation', status = $status WHERE id = $id";
        $successMessage = "Cargo editado com sucesso!";
    } else {
        $query = "INSERT INTO cargo VALUES (0, '$name', '$observation', NOW(), 1);";
        $successMessage = "Cargo cadastrado com sucesso!";
    }

    if (mysqli_query($connection, $query)) {
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = $successMessage;
    } else {
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = "Erro ao processar cargo.";
    }

    header('Location: Index.php');
    exit;
?>