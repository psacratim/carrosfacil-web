<?php
require_once("../../conexao/conecta.php");

$sql = "
SELECT funcionario.id, funcionario.nome AS nome_funcionario, cargo.nome AS nome_cargo, funcionario.cpf, funcionario.salario, funcionario.sexo, funcionario.data_nascimento, funcionario.tipo_acesso, funcionario.telefone_recado, funcionario.email, funcionario.foto, funcionario.data_cadastro, funcionario.status
FROM funcionario
INNER JOIN cargo ON cargo.id = funcionario.id_cargo
";
$cpf = $_POST['cpf'] ?? "";
$nome = $_POST['nome'];
$sexo = $_POST['sexo'];
$data_nascimento = $_POST['data_nascimento'] ?? "";
$status = $_POST['status'];
$conditions = [];

if ($cpf !== "") {
    $conditions[] = "cpf LIKE '%$cpf%'";
}

if ($nome !== "") {
    $conditions[] = "funcionario.nome LIKE '%$nome%'";
}

if ($sexo !== "") {
    $conditions[] = "sexo = '$sexo'";
}

if ($data_nascimento !== "") {
    $conditions[] = "data_nascimento = '$data_nascimento'";
}
if ($status !== "") {
    $conditions[] = "funcionario.status = $status";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions); // O implode é igual o String.join do java. Pega uma lista e converte pra string com um separator, sendo o 'AND' nesse caso.
}

$query = mysqli_query($conexao, $sql);
if (mysqli_num_rows($query) > 0) {
?>
    <div class="card-body p-0">
        <table class="table m-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Preço Venda</th>
                    <th scope="col">Preço Desconto</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query as $veiculo) {
                ?>
                    <tr>
                        <td><?php echo $veiculo['id'] ?></td>
                        <td><?php echo $veiculo['modelo'] ?></td>
                        <td><?php echo $veiculo['categoria'] ?></td>
                        <td><?php echo $veiculo['estado_do_veiculo'] ?></td>
                        <td><?php echo number_format($veiculo['preco_venda'], 2, ',', '.') ?></td>
                        <td><?php echo number_format($veiculo['preco_desconto'], 2, ',', '.') ?></td>
                        <td><?php echo $veiculo['estoque'] ?></td>
                        <td><?php echo $veiculo['data_cadastro'] ?></td>
                        <td>
                            <?php
                            if ($veiculo['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $veiculo['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_veiculo" value="<?php echo $veiculo['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo '<div class="alert alert-danger m-3" role="alert">Nenhum registro encontrado!</div>';
}
?>