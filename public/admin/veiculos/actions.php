<?php
require_once('../../conexao/conecta.php');

if (!isset($_SESSION)) {
    session_start();
}

// Excluir
if (isset($_POST["delete"])) {
    $id = (int)$_POST["delete"];

    $salesCheck = mysqli_query($connection, "SELECT id FROM item_venda WHERE id_veiculo = $id");
    $salesCount = mysqli_num_rows($salesCheck);

    if (mysqli_num_rows($salesCheck) > 0) {
        $_SESSION['messageType'] = 'info';
        $_SESSION['messageText'] = "Impossível excluir: O veículo possui $salesCount vendas vinculadas.";
    } else {
        mysqli_query($connection, "DELETE FROM foto_veiculo WHERE id_veiculo = $id");
        mysqli_query($connection, "DELETE FROM caracteristica_carro WHERE id_veiculo = $id");

        $deleteVehicleQuery = "DELETE FROM veiculo WHERE id = $id";

        if (mysqli_query($connection, $deleteVehicleQuery)) {
            $_SESSION['messageType'] = 'success';
            $_SESSION['messageText'] = "Veículo removido com sucesso.";
        } else {
            $_SESSION['messageType'] = 'error';
            $_SESSION['messageText'] = "Erro ao processar a exclusão do veículo.";
        }
    }

    header('Location: Index.php');
    exit;
}

// Cadastrar e Editar
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$isEditing = ($id > 0);

// Mapeamento de variáveis do formulário manage.php
$id_model = (int)$_POST['model'];
$category = mysqli_real_escape_string($connection, $_POST["category"]);
$condition = mysqli_real_escape_string($connection, $_POST["condition"]);
$usageTime = (int)$_POST["usageTime"];
$year = (int)$_POST["year"];
$mileage = (int)$_POST["mileage"];
$transmissionType = mysqli_real_escape_string($connection, $_POST["transmissionType"]);
$fuelType = mysqli_real_escape_string($connection, $_POST["fuelType"]);
$description = mysqli_real_escape_string($connection, $_POST["description"]);
$profit = (int)$_POST["expected_profit"];
$discount = (int)$_POST["discount"];
$hasDiscount = ($discount > 0) ? 1 : 0;
$costPrice = str_replace(['.', ','], ['', '.'], $_POST["costPrice"]);
$sellPrice = str_replace(['.', ','], ['', '.'], $_POST["sellPrice"]);
$discountPrice = str_replace(['.', ','], ['', '.'], $_POST["discountPrice"]);
$stock = (int)$_POST["stock"];
$color = mysqli_real_escape_string($connection, $_POST["color"]);

$mainPhoto = "default.png";
if (!empty($_FILES['photo_1']['name'])) {
    $mainPhoto = time() . "_1_" . basename($_FILES['photo_1']['name']);
    move_uploaded_file($_FILES['photo_1']['tmp_name'], "../../images/" . $mainPhoto);
}

if ($isEditing) {
    $query = "UPDATE veiculo SET 
            id_modelo = $id_model, 
            categoria = '$category', 
            estado_do_veiculo = '$condition', 
            tempo_de_uso = $usageTime, 
            preco_custo = '$costPrice', 
            preco_venda = '$sellPrice', 
            preco_desconto = '$discountPrice', 
            desconto = $discount, 
            tem_desconto = $hasDiscount, 
            lucro = $profit, 
            quilometragem = $mileage, 
            cor = '$color', 
            descricao = '$description', 
            ano = $year, 
            tipo_cambio = '$transmissionType', 
            tipo_combustivel = '$fuelType', 
            estoque = $stock" .
        (!empty($_FILES['photo_1']['name']) ? ", foto='$mainPhoto'" : "") . " 
            WHERE id = $id";

    $successMessage = "Veículo atualizado!";
} else {
    $query = "INSERT INTO veiculo (
            id_modelo, categoria, estado_do_veiculo, tempo_de_uso, 
            preco_custo, preco_venda, preco_desconto, desconto, 
            tem_desconto, lucro, quilometragem, cor, descricao, 
            ano, tipo_cambio, tipo_combustivel, foto, estoque, 
            data_cadastro, status
        ) VALUES (
            $id_model, '$category', '$condition', $usageTime, 
            '$costPrice', '$sellPrice', '$discountPrice', $discount, 
            $hasDiscount, $profit, $mileage, '$color', '$description', 
            $year, '$transmissionType', '$fuelType', '$mainPhoto', $stock, 
            NOW(), 1
        )";

    $successMessage = "Veículo cadastrado!";
}

try {
    if (mysqli_query($connection, $query)) {
        $vehicleId = $isEditing ? $id : mysqli_insert_id($connection);

        // Fotos adicionais
        for ($i = 1; $i <= 6; $i++) {
            $field = "photo_$i";
            if (!empty($_FILES[$field]['name'])) {
                $finalName = time() . "_$i" . "_" . basename($_FILES[$field]['name']);
                if (move_uploaded_file($_FILES[$field]['tmp_name'], "../../images/" . $finalName)) {
                    // Verifica se já existe uma foto para essa ordem ao editar para evitar duplicatas simples
                    mysqli_query($connection, "INSERT INTO foto_veiculo (id_veiculo, caminho, ordem, data_cadastro, status) 
                                                  VALUES ($vehicleId, '$finalName', $i, NOW(), 1)");
                }
            }
        }

        // Características do Veículo
        mysqli_query($connection, "DELETE FROM caracteristica_carro WHERE id_veiculo = $vehicleId");
        if (isset($_POST['features']) && is_array($_POST['features'])) {
            foreach ($_POST['features'] as $fId) {
                $fId = (int)$fId;
                mysqli_query($connection, "INSERT INTO caracteristica_carro (id_veiculo, id_caracteristica) VALUES ($vehicleId, $fId)");
            }
        }

        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = $successMessage;
    } else {
        throw new mysqli_sql_exception();
    }
} catch (mysqli_sql_exception $e) {
    $_SESSION['messageType'] = 'error';
    $_SESSION['messageText'] = "Erro ao salvar veículo.";
}

header('Location: Index.php');
exit;
