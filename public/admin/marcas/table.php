<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

$query = "SELECT id, nome 'name', observacao 'observation', data_cadastro 'createdAt', status FROM marca";

$id = (int) $_POST['id'] ?? 0;
$name = $_POST["name"] ?? "";
$status = $_POST['status'] ?? "";
$conditions = [];

if ($id > 0) {
    $id = mysqli_real_escape_string($connection, $id);
    $conditions[] = "id = '$id'";
}

if ($name !== "") {
    $name = mysqli_real_escape_string($connection, $name);
    $conditions[] = "nome LIKE '%$name%'";
}

if ($status !== "") {
    $conditions[] = "status = " . (int)$status;
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($connection, $query);

// Renderiza a tabela usando o componente padrão
echo Table::render([
  "#" => "id",
  "Nome" => "name",
  "Observação" => "observation",
  "Cadastro" => "createdAt",
  "Status" => "status"
], $result, [
  "entity" => "marcas",
  "modalTarget" => "#marcasModal"
]);