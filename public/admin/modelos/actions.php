<?php 
    require_once('../../conexao/conecta.php');

    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"]; 

        try {
            $query = "DELETE FROM modelo WHERE id = $id;";
            if (mysqli_query($connection, $query)) {
                $_SESSION['messageType'] = 'success';
                $_SESSION['messageText'] = "Sucesso: O modelo foi removido.";
            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $query = "SELECT COUNT(id) AS total FROM veiculo WHERE id_modelo = $id";
                $result = mysqli_query($connection, $query);
                $totalCount = mysqli_fetch_assoc($result)['total'];

                $_SESSION['messageType'] = 'info';
                $_SESSION['messageText'] = "Falhou: Existem $totalCount veículos vinculados a este modelo.";
            } else {
                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Erro: Não foi possível excluir o modelo.";
            }
        }
        header('Location: Index.php');
        exit;
    }

    // Cadastrar e Editar
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $isEditing = ($id > 0);

    $brandId = (int)$_POST['id_marca'];
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $observation = mysqli_real_escape_string($connection, $_POST['observation']);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    if ($isEditing) {
        $query = "UPDATE modelo SET id_marca = $brandId, nome = '$name', observacao = '$observation', status = $status WHERE id = $id";
        $successMessage = "Modelo atualizado com sucesso!";
    } else {
        $query = "INSERT INTO modelo VALUES (0, $brandId, '$name', '$observation', NOW(), 1);";
        $successMessage = "Modelo cadastrado com sucesso!";
    }

    if (mysqli_query($connection, $query)) {
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = 'Sucesso: '. $successMessage;
    } else {
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = "Erro: Não foi possível salvar os dados, tente novamente.";
    }

    header('Location: Index.php');
    exit;
?>