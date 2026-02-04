<?php
require_once('../../conexao/conecta.php');

if (!isset($_SESSION)) {
    session_start();
}

// Excluir
if (isset($_POST["delete"])) {
    $id = (int)$_POST["delete"];

    try {
        $query = "DELETE FROM caracteristica WHERE id = $id;";
        if (mysqli_query($connection, $query)) {
            $_SESSION['messageType'] = 'success';
            $_SESSION['messageText'] = "Sucesso: A característica foi excluída.";
        } else {
            throw new mysqli_sql_exception();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            $query = "SELECT COUNT(id_veiculo) AS total FROM caracteristica_carro WHERE id_caracteristica = $id";
            $result = mysqli_query($connection, $query);
            $totalCount = mysqli_fetch_assoc($result)['total'];

            $_SESSION['messageType'] = 'info';
            $_SESSION['messageText'] = "Falhou: Existem $totalCount veículos que dependem dela.";
        } else {
            $_SESSION['messageType'] = 'error';
            $_SESSION['messageText'] = "Erro: Não foi possível excluir o item.";
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

$iconQuery = "";
if (!empty($_FILES['icon']['name'])) {
    $iconName = time() . "_" . basename($_FILES['icon']['name']);
    if (move_uploaded_file($_FILES['icon']['tmp_name'], '../../images/' . $iconName)) {
        $iconQuery = ", icone = '$iconName'";
    }
}

if ($isEditing) {
    $query = "UPDATE caracteristica SET nome = '$name', observacao = '$observation', status = $status $iconQuery WHERE id = $id";
    $successMessage = "Característica editada com sucesso!";
} else {
    $iconFinal = !empty($iconName) ? $iconName : 'default.png';
    $query = "INSERT INTO caracteristica VALUES (0, '$name', '$observation', '$iconFinal', NOW(), 1);";
    $successMessage = "Característica cadastrada!";
}

try {
    if (mysqli_query($connection, $query)) {
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = 'Sucesso: ' . $successMessage;
    } else {
        throw new mysqli_sql_exception();
    }
} catch (mysqli_sql_exception $e) {
    $_SESSION['messageType'] = 'error';
    $_SESSION['messageText'] = ($e->getCode() == 1062) ? "Erro: Já existe uma caracteristica com esse nome." : "Erro: Não foi possível salvar os dados, tente novamente.";
}

header('Location: Index.php');
exit;
