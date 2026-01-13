<?php

class FormModal
{
    public static function create(array $settings, array $fields)
    {
        $modalId = htmlspecialchars($settings["modalId"]);
        $actionUrl = htmlspecialchars($settings["actionUrl"]);

        ob_start();
?>

        <div class="form-modal modal fade" id="<?= $modalId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="<?= $modalId ?>Label"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <?php
                                foreach ($fields as $field) {
                                    $label = $field['label'];
                                    $labelPrefix = $field['optional'] ? '' : '<span class="text-danger">*</span> ';

                                    if ($field['type'] == 'text') {
                                        $length = "";
                                        if (isset($field["length"])) {
                                            $length = 'maxlength="'. $field["length"] .'"';
                                        }
                                ?>
                                        <div class="col-12 mb-3">
                                            <label for="<?= htmlspecialchars($field['id']) ?>" class="form-label"><?= $labelPrefix . $label ?></label>
                                            <input <?= $length ?> type="text" name="<?= htmlspecialchars($field['id']) ?>" id="<?= htmlspecialchars($field['id']) ?>" class="form-control" maxlength="60" <?= $field['optional'] ? '' : 'required' ?>>
                                        </div>
                                    <?php } else if ($field['type'] == 'image') { ?>
                                        <div class="col-12 mb-3 text-center">
                                            <label for="<?= htmlspecialchars($field['id']) ?>" class="form-label d-block"><?= $label ?></label>
                                            <div class="img-preview-container mb-2">
                                                <img class="img-preview img-thumbnail" src="../../assets/img/placeholder-funcionario.png" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                            </div>
                                            <input class="form-control img-input" type="file" name="<?= htmlspecialchars($field['id']) ?>" id="<?= htmlspecialchars($field['id']) ?>" accept="image/png, image/jpeg">
                                        </div>
                                    <?php } else if ($field['type'] == 'select') { ?>
                                        <div class="form-group mb-3">
                                            <label for="<?= htmlspecialchars($field['id']) ?>"><?= $labelPrefix . $label ?></label>
                                            <select name="<?= htmlspecialchars($field['id']) ?>" id="<?= htmlspecialchars($field['id']) ?>" class="form-control">
                                                <?php
                                                foreach ($field['options'] as $option) {
                                                ?>

                                                    <option value="<?= htmlspecialchars($option['value']) ?>"><?= htmlspecialchars($option['label']) ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="d-grid gap-2">
                                <input name="id" id="id" type="text" hidden>
                                <input type="hidden" name="csfc" value="<?= htmlspecialchars(random_int(10000000, 99999999999)) ?>">
                                <?= $settings["submitButton"] ?>
                                <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
