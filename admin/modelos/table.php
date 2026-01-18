<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

// Query base com Join para trazer o nome da marca
$query = "SELECT m.id, ma.nome 'nameBrand', m.nome 'name', m.observacao 'observation', m.status, m.id_marca 
        FROM modelo m 
        INNER JOIN marca ma ON m.id_marca = ma.id";

$id = (int) $_POST['id'] ?? 0;
$nameBrand = $_POST['nameBrand'] ?? "";
$nameModel = $_POST['nameModel'] ?? "";
$status = $_POST['status'] ?? "";
$conditions = [];

if ($id > 0) {
    $id = mysqli_real_escape_string($connection, $id);
    $conditions[] = "m.id = '$id'";
}

if ($nameBrand !== "") {
    $nameBrand = mysqli_real_escape_string($connection, $nameBrand);
    $conditions[] = "ma.nome LIKE '%$nameBrand%'";
}

if ($nameModel !== "") {
    $nameModel = mysqli_real_escape_string($connection, $nameModel);
    $conditions[] = "m.nome LIKE '%$nameModel%'";
}

if ($status !== "") {
    $conditions[] = "m.status = " . (int)$status;
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY ma.nome ASC, m.nome ASC";
$result = mysqli_query($connection, $query);

// Renderização utilizando o novo componente de Tabela
echo Table::render([
  "#" => "id",
  "Marca" => "nameBrand",
  "Modelo" => "name",
  "Observação" => "observation",
  "Status" => "status"
], $result, [
  "entity" => "modelos",
  "modalTarget" => "#modelosModal"
]);