<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

if (!isset($_SESSION)) {
    session_start();
}

// Query base que vai ser usada abaixo
$query = "SELECT id, nome 'name', observacao 'observation', icone 'icon', data_cadastro 'createdAt', status FROM caracteristica";

$name = $_POST["name"] ?? "";
$status = $_POST["status"] ?? "";
$conditions = [];

// Filtro por nome
if ($name !== "") {
    $name = mysqli_real_escape_string($connection, $name);
    $conditions[] = "nome LIKE '%$name%'";
}

// Filtro por status (Ativo/Inativo)
if ($status !== "") {
    $conditions[] = "status = " . (int)$status;
}

// Se houver filtros, aplica o WHERE no SQL
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY id ASC";
$result = mysqli_query($connection, $query);

// Renderiza a tabela usando o componente padrão do sistema
echo Table::render([
  "#" => "id",
  "Ícone" => "icon",
  "Nome" => "name",
  "Observação" => "observation",
  "Status" => "status"
], $result, [
  "entity" => "vitems",
  "modalTarget" => "#acessoriosModal"
]);
?>