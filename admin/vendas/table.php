<?php
require_once("../usuario_comum.php");

require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

// Definindo a query principal com apelidos (aliases) em inglês para o código
$saleListSql = "SELECT 
            v.id, 
            c.nome AS customer_name, 
            f.nome AS employee_name, 
            v.valor_total AS total_amount, 
            v.data_cadastro AS createdAt, 
            v.status 
        FROM venda v 
        INNER JOIN cliente c ON v.id_cliente = c.id 
        INNER JOIN funcionario f ON v.id_funcionario = f.id";

$filterConditions = [];

// Verificando filtros enviados via POST (AJAX)
if (!empty($_POST['id'])) {
    $filterConditions[] = "v.id = " . (int)$_POST['id'];
}

if (!empty($_POST['customer'])) {
    $searchCustomer = mysqli_real_escape_string($connection, $_POST['customer']);
    $filterConditions[] = "c.nome LIKE '%$searchCustomer%'";
}

if (!empty($_POST['employee'])) {
    $searchEmployee = mysqli_real_escape_string($connection, $_POST['employee']);
    $filterConditions[] = "f.nome LIKE '%$searchEmployee%'";
}

if (!empty($_POST['date'])) {
    $searchDate = mysqli_real_escape_string($connection, $_POST['date']);
    $filterConditions[] = "DATE(v.data_cadastro) = '$searchDate'";
}

if (isset($_POST['status']) && $_POST['status'] !== "") {
    $filterConditions[] = "v.status = " . (int)$_POST['status'];
}

// Montando o WHERE dinamicamente se houver filtros
if (!empty($filterConditions)) {
    // Cara, ele sabe que o implode junta os itens do array com " AND "?
    $saleListSql .= " WHERE " . implode(" AND ", $filterConditions);
}

$saleListSql .= " ORDER BY v.id DESC";

$saleResult = mysqli_query($connection, $saleListSql);

// Renderizando a tabela: Labels em PT-BR para o usuário, mas chaves em EN para o banco
echo Table::render([
  "#" => "id",
  "Cliente" => "customer_name",
  "Vendedor" => "employee_name",
  "Total (R$)" => "total_amount",
  "Data" => "createdAt",
  "Status" => "status"
], $saleResult, [
  "editUrl" => "manage.php?id=",
  "entity" => "sales",
  "modalTarget" => null
]);