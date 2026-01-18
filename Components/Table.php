<?php
class Table
{
    public static function render(array $columns, $query, array $config)
    {
        // $columns: ['Título da Coluna' => 'nome_no_banco']
        // $config: ['entity' => 'vendas', 'modalTarget' => '#vendasModal']

        if (mysqli_num_rows($query) > 0) {
            ob_start(); ?>
            <div class="card-body p-0">
                <table class="table table-hover m-0">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($columns) as $label): ?>
                                <th><?= $label ?></th>
                            <?php endforeach; ?>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($query as $row): ?>
                            <tr>
                                <?php foreach ($columns as $label => $field): ?>
                                    <td>
                                        <?php
                                        // Lógica especial para tipos específicos
                                        if ($field == 'icon') {
                                            echo '<img class="table-icon" src="../../images/' . $row['icon'] . '" style="width:30px">';
                                        } elseif ($field == 'status') {
                                            echo $row['status'] == 1
                                                ? '<span class="badge text-bg-success">Ativo</span>'
                                                : '<span class="badge text-bg-danger">Inativo</span>';
                                        } else {
                                            echo htmlspecialchars($row[$field]);
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="text-end">
                                    <?php
                                    if (isset($config['modalTarget'])) {
                                    ?>
                                        <button type="button" class="btn btn-outline-success btn-sm open-edit-modal"
                                            data-bs-toggle="modal" data-bs-target="<?= $config['modalTarget'] ?>"
                                            data-entity="<?= $config['entity'] ?>"
                                            <?php foreach ($row as $k => $v) {
                                                echo 'data-' . $k . '="' . htmlspecialchars($v) . '" ';
                                            } ?>>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?php echo $config['editUrl'].$row['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    <?php

                                    }
                                    ?>
                                    <form action="actions.php" method="post" class="d-inline">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" name="delete" value="<?= $row['id'] ?>" onclick="return confirm('Excluir?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<?php return ob_get_clean();
        }
        return '<div class="alert alert-info m-3">Nenhum registro encontrado.</div>';
    }
}
