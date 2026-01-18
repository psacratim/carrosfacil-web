$(function () {
    const titles = { // titles[componente][isEditing], tipo: titles["vitems"][isEditing].
        ["vitems"]: {
            ["false"]: "CRIAR ACESSÓRIO",
            ["true"]: "EDITAR ACESSÓRIO"
        },
        ["cargos"]: {
            ["false"]: "CRIAR ACESSÓRIO",
            ["true"]: "EDITAR ACESSÓRIO"
        },
        ["marcas"]: {
            ["false"]: "CRIAR MARCA",
            ["true"]: "EDITAR MARCA"
        },
        ["modelos"]: {
            ["false"]: "CRIAR MODELO",
            ["true"]: "EDITAR MODELO"
        }
    }

    const loaders = {
        ["vitems"]: function (modal, trigger, isEdit) {
            // Get data from clicked button. If exists.
            let id = $(trigger).attr("data-id") || "";
            let name = $(trigger).attr("data-name") || "";
            let observation = $(trigger).attr("data-observation") || "";
            let icon = $(trigger).attr("data-icone") || null;
            let status = $(trigger).attr("data-status") || 1;

            // Get components
            const inputTitle = $(modal.find('.modal-title')[0]);
            const inputIcon = modal.find('#icon');
            const iconPreview = $(inputIcon.parent().find('.img-preview')[0]);
            const inputName = modal.find("#name");
            const inputObservation = modal.find("#observation");

            // Load data in modal elements
            inputName.val(name)
            inputObservation.val(observation)

            if (isEdit) {
                if (icon) {
                    iconPreview.attr('src', "../../../images/" + icon)
                }

                modal.find("#id").attr('value', id);
            }

            // Change modal elements
            const inputStatus = modal.find("#status");
            inputStatus.prop('disabled', !isEdit);
            inputStatus.val(status);

            inputTitle.text(titles["vitems"][isEdit]);
        },
        ["cargos"]: function (modal, trigger, isEdit) {
            // Get data from clicked button. If exists.
            let id = $(trigger).attr("data-id") || "";
            let name = $(trigger).attr("data-name") || "";
            let observation = $(trigger).attr("data-observation") || "";
            let status = $(trigger).attr("data-status") || 1;

            // Get components
            const inputTitle = $(modal.find('.modal-title')[0]);
            const inputName = modal.find("#name");
            const inputObservation = modal.find("#observation");

            // Load data in modal elements
            inputName.val(name)
            inputObservation.val(observation)

            if (isEdit) {
                modal.find("#id").attr('value', id);
            }

            // Change modal elements
            const inputStatus = modal.find("#status");
            inputStatus.prop('disabled', !isEdit);
            inputStatus.val(status);

            inputTitle.text(titles["cargos"][isEdit]);
        },
        ["marcas"]: function (modal, trigger, isEdit) {
            console.log('boa pa nois')
            let id = $(trigger).attr("data-id") || "";
            let name = $(trigger).attr("data-name") || "";
            let observation = $(trigger).attr("data-observation") || "";
            let status = $(trigger).attr("data-status") || 1;

            const inputTitle = $(modal.find('.modal-title')[0]);
            const inputName = modal.find("#name");
            const inputObservation = modal.find("#observation");

            inputName.val(name);
            inputObservation.val(observation);

            if (isEdit) {
                modal.find("#id").attr('value', id);
            }

            const inputStatus = modal.find("#status");
            inputStatus.prop('disabled', !isEdit);
            inputStatus.val(status);

            inputTitle.text(titles["marcas"][isEdit]);
        },
        ["modelos"]: function (modal, trigger, isEdit) {
            let id = $(trigger).attr("data-id") || "";
            let name = $(trigger).attr("data-name") || "";
            let observation = $(trigger).attr("data-observation") || "";
            let idMarca = $(trigger).attr("data-id_marca") || "";
            let status = $(trigger).attr("data-status") || 1;

            const inputTitle = $(modal.find('.modal-title')[0]);
            const inputName = modal.find("#name");
            const inputObservation = modal.find("#observation");
            const inputMarca = modal.find("#id_marca");

            inputName.val(name);
            inputObservation.val(observation);
            inputMarca.val(idMarca);

            if (isEdit) {
                modal.find("#id").attr('value', id);
            }

            const inputStatus = modal.find("#status");
            inputStatus.prop('disabled', !isEdit);
            inputStatus.val(status);

            inputTitle.text(titles["modelos"][isEdit]);
        }
    }

    $(".img-input").on('change', function () {
        const file = this.files[0];
        if (!file) {
            return;
        }

        const imagePreview = $(this).parent().find('.img-preview')[0];
        if (!imagePreview) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            imagePreview.setAttribute('src', event.target.result);
        }

        reader.readAsDataURL(file);
    });

    $(".form-modal").on('show.bs.modal', function (event) {
        const clickedBtn = event.relatedTarget;
        if (!clickedBtn) {
            return;
        }

        const isEdit = clickedBtn.classList.contains("open-edit-modal");
        const entity = $(clickedBtn).attr('data-entity')

        loaders[entity]($(this), clickedBtn, isEdit)
    });
});