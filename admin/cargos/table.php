<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

// Query base buscando os cargos
$query = "SELECT id, nome 'name', observacao 'observation', data_cadastro 'createdAt', status FROM cargo";

$name = $_POST['name'] ?? "";
$status = $_POST['status'] ?? "";
$conditions = [];

// Filtro por nome do cargo
if ($name !== "") {
    $name = mysqli_real_escape_string($connection, $name);
    $conditions[] = "nome LIKE '%$name%'";
}

// Filtro por status
if ($status !== "") {
    $conditions[] = "status = " . (int)$status;
}

// Montagem dinâmica da clausula WHERE
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY id ASC";
$result = mysqli_query($connection, $query);

// Renderização via componente Table
echo Table::render([
  "#" => "id",
  "Nome" => "name",
  "Observação" => "observation",
  "Data" => "createdAt",
  "Status" => "status"
], $result, [
  "entity" => "cargos",
  "modalTarget" => "#cargosModal" // Certifique-se que o ID do modal no Index de cargos seja este
]);
?>