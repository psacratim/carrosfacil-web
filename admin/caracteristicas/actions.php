<?php 
    // INICIA A CONEXAO COM O BANCO
    require_once('../../conexao/conecta.php');

    // STARTING SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    // CADASTRANDO CARGO NOVO
    if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_caracteristicas") {
        // Get input data send by user.
        $name = mysqli_real_escape_string($conexao, $_POST['nome']);
        $description = mysqli_real_escape_string($conexao, $_POST['description']);
        
        // Save feature icon in server.
        $iconName = basename($_FILES['icone-acessorio']['name']); // Get icon path send by client.
        $iconTmp = $_FILES['icone-acessorio']['tmp_name']; // Get photo path in the temp file.
        $icon = '../../images/' . $iconName;
        move_uploaded_file($iconTmp, $icon);

        // Create sql query string.
        $sql = "INSERT INTO caracteristica VALUES (0, '$name', '$description', '$iconName', NOW(), 1);";
        
        try {
            // Send to mysql the query.
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Caracteristica cadastrada com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível cadastrar essa caracteristica.";
        }
        
        header('Location: Index.php');
    }

    // EDITANDO CARGO
    if (isset($_POST['atualizar']) && $_POST['atualizar'] == "atualizar_caracteristicas") {
        // Get input data send by user.
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($conexao, $_POST['nome']);
        $description = mysqli_real_escape_string($conexao, $_POST['descricao']);
        $status = $_POST['status'];
        
        // Save feature icon in server.
        $iconName = basename($_FILES['edit_icone']['name']); // Get icon path send by client.
        $iconTmp = $_FILES['edit_icone']['tmp_name']; // Get photo path in the temp file.
        $icon = '../../images/' . $iconName;
        move_uploaded_file($iconTmp, $icon);

        $iconQuery = $iconName != null ? ", icone = '$iconName'" : '';

        // Create sql query string.
        $sql = "UPDATE caracteristica SET nome = '$name', descricao = '$description', status = $status $iconQuery WHERE id = $id";
        
        try {
            // Send to mysql the query.
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = 'Caracteristica editada com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message_text'] = "Erro: Não foi possível editar essa caracteristica.";
        }
        
        header('Location: Index.php');
    }

    // EXCLUINDO CARACTERISTICAS
    if (isset($_POST['excluir_caracteristica'])) {
        $id = $_POST['excluir_caracteristica'];

        try {
            $sql = "DELETE FROM caracteristica WHERE id = $id;";
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message_text'] = "Sucesso: A caracteristica foi excluida com sucesso.";
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $sql = "SELECT COUNT(id_veiculo) AS total FROM caracteristica_carro WHERE id_caracteristica = $id";
                $query = mysqli_query($conexao, $sql);
                $total = mysqli_fetch_assoc($query)['total'];

                $_SESSION['message_type'] = 'info';
                $_SESSION['message_text'] = "Falhou: Não foi possível excluir essa caracteristica. Existem $total veículos que dependem dela.";
            } else {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message_text'] = "Erro: Não foi possível excluir essa caracteristica.";
            }
        }

        header('Location: Index.php');
    }
?>

