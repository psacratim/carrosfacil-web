search

<?php
require_once("../../conexao/conecta.php");

$type = $_GET['type'] ?? '';
$query = mysqli_real_escape_string($connection, $_GET['q'] ?? '');

if ($type == 'customer') {
    $sql = "SELECT id, nome, cpf FROM cliente WHERE nome LIKE '%$query%' OR cpf LIKE '%$query%' LIMIT 5";
    $res = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<div class='search-item' onclick=\"selecionarCliente('{$row['id']}', '{$row['nome']}')\">
                <strong>{$row['nome']}</strong> <br> <small>CPF: {$row['cpf']}</small>
              </div>";
    }
}

if ($type == 'vendedor') {
    $sql = "SELECT id, nome FROM funcionario WHERE nome LIKE '%$query%' AND status = 1 LIMIT 5";
    $res = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<div class='search-item' onclick=\"selecionarVendedor('{$row['id']}', '{$row['nome']}')\">
                <strong>{$row['nome']}</strong>
              </div>";
    }
}

if ($type == 'veiculo') {
    $sql = "SELECT v.id, m.nome as modelo, v.preco_venda, v.estoque, v.cor 
            FROM veiculo v 
            INNER JOIN modelo m ON v.id_modelo = m.id 
            WHERE m.nome LIKE '%$query%' AND v.status = 1 AND v.estoque > 0 LIMIT 5";
    $res = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $preco = number_format($row['preco_venda'], 2, ',', '.');
        echo "<div class='search-item' onclick=\"selecionarVeiculo('{$row['id']}', '{$row['modelo']}', '{$row['preco_venda']}', '{$row['estoque']}')\">
                <strong>{$row['modelo']}</strong> - {$row['cor']} <br>
                <small>Preço: R$ $preco | Estoque: {$row['estoque']}</small>
              </div>";
    }
}