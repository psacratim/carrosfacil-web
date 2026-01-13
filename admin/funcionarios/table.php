<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

$query = "SELECT f.id, f.nome 'name', c.nome 'role', f.cpf, f.salario, f.tipo_acesso 'accessType', f.data_cadastro 'createdAt', f.status
        FROM funcionario f
        INNER JOIN cargo c ON c.id = f.id_cargo";

$conditions = [];
if (!empty($_POST["name"])) $conditions[] = "f.nome LIKE '%".mysqli_real_escape_string($connection, $_POST["name"])."%'";
if (!empty($_POST['cpf'])) $conditions[] = "f.cpf = '".mysqli_real_escape_string($connection, $_POST['cpf'])."'";
if (!empty($_POST["gender"])) $conditions[] = "f.sexo = '".$_POST["gender"]."'";
if (!empty($_POST['birthDate'])) $conditions[] = "f.data_nascimento = '".$_POST['birthDate']."'";
if (!empty($_POST['status']) && $_POST['status'] !== "") $conditions[] = "f.status = " . (int)$_POST['status'];

if (!empty($conditions)) $query .= " WHERE " . implode(" AND ", $conditions);

$result = mysqli_query($connection, $query);

echo Table::render([
  "#" => "id",
  "Nome" => "name",
  "Cargo" => "role",
  "CPF" => "cpf",
  "Tipo Acesso" => "accessType",
  "Cadastro" => "createdAt",
  "Status" => "status"
], $result, [
  "editUrl" => "manage.php?id=",
  "entity" => "funcionarios"
]);