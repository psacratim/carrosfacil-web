<?php
require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

$query = "SELECT id, cpf, nome 'name', telefone1 'phone1', sexo 'gender', data_nascimento 'birthDate', status FROM cliente";
$conditions = [];

if (!empty($_POST['name'])) $conditions[] = "nome LIKE '%".mysqli_real_escape_string($connection, $_POST['name'])."%'";
if (!empty($_POST['cpf'])) $conditions[] = "cpf LIKE '%".mysqli_real_escape_string($connection, $_POST['cpf'])."%'";
if (!empty($_POST['phone'])) $conditions[] = "telefone1 LIKE '%".mysqli_real_escape_string($connection, $_POST['phone'])."%'";
if (!empty($_POST["gender"])) $conditions[] = "sexo = '".$_POST["gender"]."'";
if (!empty($_POST['status']) && $_POST['status'] !== "") $conditions[] = "status = " . (int)$_POST['status'];

if (!empty($conditions)) $query .= " WHERE " . implode(" AND ", $conditions);
$query .= " ORDER BY id ASC";

$result = mysqli_query($connection, $query);

echo Table::render([
  "#" => "id",
  "CPF" => "cpf",
  "Nome Completo" => "name",
  "Telefone" => "phone1",
  "Sexo" => "gender",
  "Nascimento" => "birthDate",
  "Status" => "status"
], $result, [
  "editUrl" => "manage.php?id=",
  "entity" => "clientes",
]);