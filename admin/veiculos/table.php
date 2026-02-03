<?php
require_once("../usuario_comum.php");

require_once("../../conexao/conecta.php");
require_once("../../Components/Table.php");

$query = "SELECT v.id, m.nome 'modelName', v.categoria 'category', v.estado_do_veiculo, v.preco_venda 'sellPrice', v.estoque 'stock', v.status 
        FROM veiculo v 
        INNER JOIN modelo m ON v.id_modelo = m.id";

$conditions = [];
if (!empty($_POST['id'])) $conditions[] = "v.id = " . (int)$_POST['id'];
if (!empty($_POST['model'])) $conditions[] = "m.nome LIKE '%".mysqli_real_escape_string($connection, $_POST['model'])."%'";
if (!empty($_POST['category'])) $conditions[] = "v.categoria = '".$_POST['category']."'";
if (!empty($_POST['conditions'])) $conditions[] = "v.estado_do_veiculo = '".$_POST['conditions']."'";
if (isset($_POST['status']) && $_POST['status'] !== "") $conditions[] = "v.status = " . (int)$_POST['status'];

if (!empty($conditions)) $query .= " WHERE " . implode(" AND ", $conditions);
$query .= " ORDER BY v.id";

$result = mysqli_query($connection, $query);

// Renderizando com o componente Table
echo Table::render([
  "#" => "id",
  "Modelo" => "modelName",
  "Categoria" => "category",
  "Preço (R$)" => "sellPrice",
  "Estoque" => "stock",
  "Status" => "status"
], $result, [
  "editUrl" => "manage.php?id=", // Ajuste no componente para aceitar link de página em vez de modal se necessário
  "entity" => "veiculos",
  "modalTarget" => null // Indica que não abre modal, vai pra página
]);