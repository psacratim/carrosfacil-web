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
                    <th scope="col">Nome</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Salário</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Tipo Acesso</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query as $funcionario) {
                ?>
                    <tr>
                        <td><?php echo $funcionario['id'] ?></td>
                        <td><?php echo $funcionario['nome_funcionario'] ?></td>
                        <td><?php echo $funcionario['nome_cargo'] ?></td>
                        <td><?php echo $funcionario['cpf'] ?></td>
                        <td><?php echo $funcionario['salario'] ?></td>
                        <td><?php echo $funcionario['sexo'] ?></td>
                        <td><?php echo date('d/m/Y', strtotime($funcionario['data_nascimento'])) ?></td>
                        <td><?php
                            if ($funcionario['tipo_acesso'] == 0) {
                                echo '<span class="badge badge-pill badge-success">Comum</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-danger">Administrador</span>';
                            }
                            ?></td>
                        <td><?php echo date('d/m/Y', strtotime($funcionario['data_cadastro'])) ?></td>
                        <td>
                            <?php
                            if ($funcionario['status'] == 0) {
                                echo '<span class="badge badge-pill badge-danger">Inativo</span>';
                            } else {
                                echo '<span class="badge badge-pill badge-success">Ativo</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="editar.php?id=<?php echo $funcionario['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="acoes.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="excluir_funcionario" value="<?php echo $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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