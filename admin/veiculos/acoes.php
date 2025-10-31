<?php
// INICIA A CONEXÃO COM O BANCO
require_once('../../conexao/conecta.php');

// STARTING SESSION
if (!isset($_SESSION)) {
    session_start();
}

// CADASTRAR VEÍCULO
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] === "cadastrar_veiculo") {
    // Get values from form send by user.
    $id_modelo        = mysqli_escape_string($conexao, $_POST['modelo']);
    $categoria        = mysqli_escape_string($conexao, $_POST['categoria']);
    $estado_do_veiculo = mysqli_escape_string($conexao, $_POST['estado']);
    $tempo_de_uso     = (int) $_POST['tempo_usado'];
    $quilometragem    = (int) $_POST['quilometragem'];
    $final_placa      = mysqli_escape_string($conexao, $_POST['final_placa']);
    $cor              = mysqli_escape_string($conexao, $_POST['cor']);
    $descricao        = mysqli_escape_string($conexao, $_POST['descricao']);
    $ano              = (int) $_POST['ano'];
    $tipo_cambio      = mysqli_escape_string($conexao, $_POST['tipo_cambio']);
    $tipo_combustivel = mysqli_escape_string($conexao, $_POST['tipo_combustivel']);
    $status           = 1; // Ativo por padrão
    $estoque          = $_POST['estoque']; // Estoque inicial

    $custo_raw       = mysqli_escape_string($conexao, $_POST['custo']);
    $lucro_esperado  = (float) $_POST['lucro_esperado'];
    $desconto        = (float) $_POST['desconto'];

    $custo = floatval(str_replace(',', '.', str_replace('.', '', $custo_raw)));

    $lucro = ($custo * ($lucro_esperado / 100));
    $preco_final = $custo + $lucro;

    // Calculate the discount in server-side to avoid errors.
    if ($desconto > 0) {
        $preco_final -= ($preco_final * ($desconto / 100));
    }
        
    // Save feature icon in server.
    $photoName = basename($_FILES['foto-veiculo-input']['name']); // Get photo path send by client.
    $photoTmp = $_FILES['foto-veiculo-input']['tmp_name']; // Get photo path in the temp file.
    $photo = '../../images/' . $photoName;
    move_uploaded_file($photoTmp, $photo);
    
    // Create sql query string.
    $sql = "INSERT INTO veiculo VALUES (
        0,
        '$id_modelo',
        '$categoria',
        '$estado_do_veiculo',
        '$tempo_de_uso',
        '$custo_raw',
        '$desconto',
        '$lucro_esperado',
        '$quilometragem',
        '$final_placa',
        '$cor',
        '$descricao',
        '$ano',
        '$tipo_cambio',
        '$tipo_combustivel',
        '$photoName',
        '$estoque',
        NOW(),
        b'$status'
    );";
        
    try {
        // Send to mysql.
        if (mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = 'Veículo cadastrado com sucesso!';
        } else {
            throw new mysqli_sql_exception('Erro ao inserir no banco');
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = 'Erro ao cadastrar o veículo!';
    }

    header('Location: index.php');
}

if (isset($_POST['editar']) && $_POST['editar'] === "editar_veiculo") {
    // Get values from form send by user.
    $id               = mysqli_escape_string($conexao, $_POST['id']);
    $id_modelo        = mysqli_escape_string($conexao, $_POST['modelo']);
    $categoria        = mysqli_escape_string($conexao, $_POST['categoria']);
    $estado_do_veiculo = mysqli_escape_string($conexao, $_POST['estado']);
    $tempo_de_uso     = (int) $_POST['tempo_usado'];
    $quilometragem    = (int) $_POST['quilometragem'];
    $final_placa      = mysqli_escape_string($conexao, $_POST['final_placa']);
    $cor              = mysqli_escape_string($conexao, $_POST['cor']);
    $descricao        = mysqli_escape_string($conexao, $_POST['descricao']);
    $ano              = (int) $_POST['ano'];
    $tipo_cambio      = mysqli_escape_string($conexao, $_POST['tipo_cambio']);
    $tipo_combustivel = mysqli_escape_string($conexao, $_POST['tipo_combustivel']);
    $status           = 1; // Ativo por padrão
    $estoque          = $_POST['estoque']; // Estoque inicial

    $custo_raw       = mysqli_escape_string($conexao, $_POST['custo']);
    $lucro_esperado  = (float) $_POST['lucro_esperado'];
    $desconto        = (float) $_POST['desconto'];

    $custo = floatval(str_replace(',', '.', str_replace('.', '', $custo_raw)));

    $lucro = ($custo * ($lucro_esperado / 100));
    $preco_final = $custo + $lucro;

    // Calculate the discount in server-side to avoid errors.
    if ($desconto > 0) {
        $preco_final -= ($preco_final * ($desconto / 100));
    }
    
    // Save feature icon in server.
    $photoName = basename($_FILES['foto-veiculo-input']['name']); // Get photo path send by client.
    $photoTmp = $_FILES['foto-veiculo-input']['tmp_name']; // Get photo path in the temp file.
    $photo = '../../images/' . $photoName;
    move_uploaded_file($photoTmp, $photo);

    $photo_query = $photoName != null ? "foto = '$photoName'," : '';

    // Create sql query string.
    $sql = "UPDATE veiculo SET 
        id_modelo = '$id_modelo',
        categoria = '$categoria',
        estado_do_veiculo = '$estado_do_veiculo',
        tempo_de_uso = '$tempo_de_uso',
        preco = '". str_replace(['.', ','], ['', '.'], $custo_raw) ."',
        desconto = '$desconto',
        lucro = '$lucro_esperado',
        kms_rodado = '$quilometragem',
        final_placa = '$final_placa',
        cor = '$cor',
        descricao = '$descricao',
        ano = '$ano',
        tipo_cambio = '$tipo_cambio',
        tipo_combustivel = '$tipo_combustivel',
        $photo_query
        estoque = '$estoque',
        status = $status
    WHERE id = $id;";
        
    try {
        // Send to mysql.
        if (mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = 'Veículo editado com sucesso!';
        } else {
            throw new mysqli_sql_exception('Erro ao atualizar no banco');
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar o veículo!';
    }

    header('Location: index.php');
}
?>
