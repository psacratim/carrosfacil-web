<?php
    require_once("../../conexao/conecta.php");
    if (!isset($_SESSION)) { session_start(); }

    // Excluir
    if (isset($_POST["delete"])) {
        $id = (int)$_POST["delete"];
        try {
            // Devolve estoque antes de apagar
            $queryItems = mysqli_query($connection, "SELECT id_veiculo, quantidade FROM item_venda WHERE id_venda = $id");
            $items = mysqli_fetch_all($queryItems, MYSQLI_ASSOC);

            foreach ($items as $item) {
                $vId = $item['id_veiculo'];
                $qty = $item['quantidade'];
                mysqli_query($connection, "UPDATE veiculo SET estoque = estoque + $qty WHERE id = $vId");
            }

            mysqli_query($connection, "DELETE FROM item_venda WHERE id_venda = $id");
            mysqli_query($connection, "DELETE FROM pagamento_venda WHERE id_venda = $id");
            mysqli_query($connection, "DELETE FROM venda WHERE id = $id");

            $_SESSION['messageType'] = 'success';
            $_SESSION['messageText'] = "Sucesso: Venda removida e o estoque foi restaurado.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['messageType'] = 'error';
            $_SESSION['messageText'] = "Erro: Falha ao excluir a venda.";
        }
        header("Location: Index.php");
        exit;
    }

    // Salvar
    if (isset($_POST['actionSave'])) {
        $saleId = (int)$_POST['saleId'];
        $customerId = (int)$_POST['customerId'];
        $employeeId = (int)$_POST['employeeId'];
        $discount = (int)($_POST['saleDiscount'] ?? 0);

        try {
            // Se for editar devolve estoque e limpa registros antigos para reprocessar
            if ($saleId > 0) {
                $queryOld = mysqli_query($connection, "SELECT id_veiculo, quantidade FROM item_venda WHERE id_venda = $saleId");
                $oldItems = mysqli_fetch_all($queryOld, MYSQLI_ASSOC);

                foreach ($oldItems as $old) {
                    $vId = $old['id_veiculo'];
                    $qty = $old['quantidade'];
                    mysqli_query($connection, "UPDATE veiculo SET estoque = estoque + $qty WHERE id = $vId");
                }
                mysqli_query($connection, "DELETE FROM item_venda WHERE id_venda = $saleId");
                mysqli_query($connection, "DELETE FROM pagamento_venda WHERE id_venda = $saleId");
            }

            // Validar estoque disponível
            foreach ($_POST['itemsId'] as $key => $vId) {
                $qty = (int)$_POST['itemAmount'][$key];
                $stockQuery = mysqli_query($connection, "SELECT estoque FROM veiculo WHERE id = $vId");
                $stock = mysqli_fetch_assoc($stockQuery)['estoque'];

                if ($stock < $qty) {
                    throw new Exception("Falhou: Sem estoque no veículo ID: $vId");
                }
            }

            // Calcular valor total
            $subtotal = 0;
            foreach ($_POST['itemsId'] as $key => $vId) {
                $qty = (int)$_POST['itemAmount'][$key];
                $priceQuery = mysqli_query($connection, "SELECT preco_venda FROM veiculo WHERE id = $vId");
                $price = mysqli_fetch_assoc($priceQuery)['preco_venda'];
                $subtotal += ($price * $qty);
            }
            $total = $subtotal - ($subtotal * ($discount / 100));

            // Gravar Venda Principal
            if ($saleId > 0) {
                mysqli_query($connection, "UPDATE venda SET id_funcionario=$employeeId, id_cliente=$customerId, valor_total='$total' WHERE id=$saleId");
                $currentId = $saleId;
            } else {
                mysqli_query($connection, "INSERT INTO venda (id_funcionario, id_cliente, valor_total, data_cadastro, status) VALUES ($employeeId, $customerId, '$total', NOW(), 1)");
                $currentId = mysqli_insert_id($connection);
            }

            // Gravar Itens e baixar estoque
            foreach ($_POST['itemsId'] as $key => $vId) {
                $qty = (int)$_POST['itemAmount'][$key];
                $priceQuery = mysqli_query($connection, "SELECT preco_venda FROM veiculo WHERE id = $vId");
                $price = mysqli_fetch_assoc($priceQuery)['preco_venda'];
                $itemTotal = $price * $qty;

                mysqli_query($connection, "INSERT INTO item_venda (id_veiculo, id_venda, quantidade, valor_unitario, valor_total) VALUES ($vId, $currentId, $qty, '$price', '$itemTotal')");
                mysqli_query($connection, "UPDATE veiculo SET estoque = estoque - $qty WHERE id = $vId");
            }

            // Gravar Pagamentos
            foreach ($_POST['payMethod'] as $key => $m) {
                $val = (float)$_POST['payAmount'][$key];
                $inst = (int)$_POST['payInstallments'][$key];
                $method = mysqli_real_escape_string($connection, $m);
                mysqli_query($connection, "INSERT INTO pagamento_venda (id_venda, metodo, valor_final, parcelas, status) VALUES ($currentId, '$method', $val, $inst, 1)");
            }

            $_SESSION['messageType'] = 'success';
            $_SESSION['messageText'] = "Sucesso: Venda realizada com sucesso.";

        } catch (Exception $e) {
            $_SESSION['messageType'] = 'error';
            $_SESSION['messageText'] = $e->getMessage();
        }

        header("Location: Index.php");
        exit;
    }
?>