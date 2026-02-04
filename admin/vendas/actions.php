<?php
require_once("../../conexao/conecta.php");
if (!isset($_SESSION)) {
    session_start();
}

// Excluir
if (isset($_POST["delete"])) {
    $id = (int)$_POST["delete"];
    try {
        $items = mysqli_fetch_all(mysqli_query($connection, "SELECT id_veiculo, quantidade FROM item_venda WHERE id_venda=$id"), MYSQLI_ASSOC);
        foreach ($items as $item) {
            $vId = $item['id_veiculo'];
            $qty = $item['quantidade'];
            mysqli_query($connection, "UPDATE veiculo SET estoque=estoque+$qty WHERE id=$vId");
        }
        mysqli_query($connection, "DELETE FROM item_venda WHERE id_venda=$id");
        mysqli_query($connection, "DELETE FROM pagamento_venda WHERE id_venda=$id");
        mysqli_query($connection, "DELETE FROM venda WHERE id=$id");
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = "Sucesso: Venda excluída e o estoque foi restaurado.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = "Erro: Não foi possível excluir a venda.";
    }
    header("Location: Index.php");
    exit;
}

// Salvar
if (isset($_POST['actionSave'])) {
    $saleId = (int)$_POST['saleId'];
    $isEditing = ($saleId > 0);
    if ($isEditing) return; // Fix: Não permita edição de vendas.

    $customerId = (int)$_POST['customerId'];
    $employeeId = (int)$_POST['employeeId'];
    $discountPercent = (int)($_POST['saleDiscount'] ?? 0); // Percentual (ex: 10)

    try {
        if ($isEditing) {
            $oldItems = mysqli_fetch_all(mysqli_query($connection, "SELECT id_veiculo, quantidade FROM item_venda WHERE id_venda=$saleId"), MYSQLI_ASSOC);
            foreach ($oldItems as $old) {
                $vId = $old['id_veiculo'];
                $qty = $old['quantidade'];
                mysqli_query($connection, "UPDATE veiculo SET estoque=estoque+$qty WHERE id=$vId");
            }
            mysqli_query($connection, "DELETE FROM item_venda WHERE id_venda=$saleId");
            mysqli_query($connection, "DELETE FROM pagamento_venda WHERE id_venda=$saleId");
        }

        $aggregatedItems = [];
        foreach ($_POST['itemsId'] as $key => $vId) {
            $qty = (int)$_POST['itemAmount'][$key];
            if (!isset($aggregatedItems[$vId])) {
                $aggregatedItems[$vId] = 0;
            }
            $aggregatedItems[$vId] += $qty;
        }

        $subtotal = 0;
        foreach ($aggregatedItems as $vId => $totalQty) {
            $vehicleData = mysqli_fetch_assoc(mysqli_query($connection, "SELECT estoque, preco_venda FROM veiculo WHERE id=$vId"));

            if ($vehicleData['estoque'] < $totalQty) {

                $_SESSION['messageType'] = 'error';
                $_SESSION['messageText'] = "Falha: O veículo do código $vId tem apenas {$vehicleData['estoque']} em estoque! Você tentou vender $totalQty.";
                header("Location: manage.php");
                exit;
            }

            $subtotal += ($vehicleData['preco_venda'] * $totalQty);
        }

        $discountValue = $subtotal * ($discountPercent / 100); // Valor em R$
        $totalFinal = $subtotal - $discountValue;              // Valor líquido: valorTotal - desconto

        if ($isEditing) {
            mysqli_query($connection, "UPDATE venda SET 
                    id_funcionario=$employeeId, 
                    id_cliente=$customerId, 
                    valor_total='$totalFinal', 
                    valor_desconto='$discountValue', 
                    desconto=$discountPercent 
                    WHERE id=$saleId");
            $currentId = $saleId;
        } else {
            mysqli_query($connection, "INSERT INTO venda 
                    (id_funcionario, id_cliente, valor_total, valor_desconto, desconto, data_cadastro, status) 
                    VALUES ($employeeId, $customerId, '$totalFinal', '$discountValue', $discountPercent, NOW(), 1)");
            $currentId = mysqli_insert_id($connection);
        }

        foreach ($_POST['itemsId'] as $key => $vId) {
            $qty = (int)$_POST['itemAmount'][$key];
            $price = mysqli_fetch_assoc(mysqli_query($connection, "SELECT preco_venda FROM veiculo WHERE id=$vId"))['preco_venda'];
            mysqli_query($connection, "INSERT INTO item_venda (id_veiculo, id_venda, quantidade, valor_unitario, valor_total) VALUES ($vId, $currentId, $qty, '$price', '" . ($price * $qty) . "')");
            mysqli_query($connection, "UPDATE veiculo SET estoque=estoque-$qty WHERE id=$vId");
        }

        foreach ($_POST['payMethod'] as $key => $m) {
            $val = (float)$_POST['payAmount'][$key];
            $inst = (int)$_POST['payInstallments'][$key];
            $mClean = mysqli_real_escape_string($connection, $m);
            mysqli_query($connection, "INSERT INTO pagamento_venda (id_venda, metodo, valor_final, parcelas, status) VALUES ($currentId, '$mClean', $val, $inst, 1)");
        }

        $_SESSION['messageType'] = 'success';
        $_SESSION['messageText'] = "Sucesso: Venda realizada com sucesso.";
    } catch (Exception $e) {
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageText'] = 'Erro: ' . $e->getMessage();
    }
    header("Location: Index.php");
    exit;
}
