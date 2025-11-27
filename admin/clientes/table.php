<?php
require_once("../../conexao/conecta.php");

$sql = "SELECT id, cpf, nome_completo, data_nascimento, telefone1, sexo, status FROM cliente";
$cpf = $_POST['cpf'] ?? "";
$nome = $_POST['nome'];
$telefone = $_POST['telefone'] ?? "";
$sexo = $_POST['sexo'];
$data_nascimento = $_POST['data_nascimento'] ?? "";
$status = $_POST['status'];
$conditions = [];

if ($cpf !== "") {
    $conditions[] = "cpf LIKE '%$cpf%'";
}

if ($nome !== "") {
    $conditions[] = "nome_completo LIKE '%$nome%'";
}

if ($telefone !== "") {
    $conditions[] = "telefone1 LIKE '%$telefone%' OR telefone2 LIKE '%$telefone%'";
}
if ($sexo !== "") {
    $conditions[] = "sexo = '$sexo'";
}

if ($data_nascimento !== "") {
    $conditions[] = "data_nascimento = '$data_nascimento'";
}
if ($status !== "") {
    $conditions[] = "status = $status";
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
                    <th scope="col">CPF</th>
                    <th scope="col">Nome Completo</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $cliente) { ?>
                    <tr>
                        <td><?php echo $cliente['id'] ?></td>
                        <td><?php echo $cliente['cpf'] ?></td>
                        <td><?php echo $cliente['nome_completo'] ?></td>
                        <td><?php echo $cliente['telefone1'] ?></td>
                        <td><?php echo $cliente['sexo'] ?></td>
                        <td><?php echo $cliente['data_nascimento'] ?></td>
                        <td>
                            <?php
                            if ($cliente['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $cliente['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_cliente" value="<?php echo $cliente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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