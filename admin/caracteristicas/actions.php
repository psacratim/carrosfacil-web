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
                $_SESSION['mensagem'] = 'Cargo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o cargo!';
        }
        
        header('Location: Index.php');
    }

    // EDITANDO CARGO
    if (isset($_POST['atualizar']) && $_POST['atualizar'] == "atualizar_caracteristicas") {
        // Get input data send by user.
        $name = mysqli_real_escape_string($conexao, $_POST['nome']);
        $description = mysqli_real_escape_string($conexao, $_POST['description']);
        $status = $_POST['status'];
        
        // Save feature icon in server.
        $iconName = basename($_FILES['icone-acessorio']['name']); // Get icon path send by client.
        $iconTmp = $_FILES['icone-acessorio']['tmp_name']; // Get photo path in the temp file.
        $icon = '../../images/' . $iconName;
        move_uploaded_file($iconTmp, $icon);

        // Create sql query string.
        $sql = "UPDATE caracteristica SET nome = '$name', descricao = '$description', icone = '$iconName', NOW(), 1) WHERE id=$id";
        
        try {
            // Send to mysql the query.
            if (mysqli_query($conexao, $sql)) {
                $_SESSION['mensagem'] = 'Cargo cadastrado com sucesso!';
            } else {
                throw new mysqli_sql_exception('Erro');
            }
        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = 'Erro ao cadastrar o cargo!';
        }
        
        header('Location: Index.php');
    }
?>

