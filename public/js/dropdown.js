$(document).ready(function () {
    $.ajax({
        url: ROUTERS_JSON_URL,
        method: "GET",
        success: function (data) {
            let select = $("#router_id");
            select.empty();
            select.append(
                "<option selected disabled>Selecciona un router</option>"
            );
            data.data.forEach((router) => {
                select.append(
                    `<option value="${router.id}">${router.host}</option>`
                );
            });
        },
        error: function () {
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Error al cargar los routers.",
                showConfirmButton: false,
                timer: 1500,
            });
        },
    });

    let $providerSelect = $("#provider_id");
    let $modelSelect = $("#model_id");

   $('#model_id').select2({
    templateResult: function (data) {
        if (!data.id) return data.text; 

        const type = $(data.element).data('type');
        const model = data.text.split(' (')[0];

        let typeLabel = '';
        let colorClass = '';

        if (type === 'libre') {
            colorClass = 'badge text-bg-success';
            typeLabel = 'Libre';
        } else if (type === 'pago') {
            colorClass = 'badge text-bg-warning';
            typeLabel = 'Pago';
        } else if (type === 'libre (limitado)') {
            colorClass = 'badge text-bg-primary';
            typeLabel = 'Libre-Limitado';
        }
        return $(`
            <span>
                ${model} <span class="${colorClass}"> ${typeLabel}</span>
            </span>
        `);
    }
});


    $.ajax({
        url: IA_JSON_URL,
        method: "GET",
        success: function (response) {
            const iaData = response.data;

            const proveedoresUnicos = [
                ...new Set(iaData.map((item) => item.ia)),
            ];

            $providerSelect
                .empty()
                .append(
                    "<option selected disabled>Selecciona un proveedor</option>"
                );
            proveedoresUnicos.forEach((proveedor) => {
                $providerSelect.append(
                    `<option value="${proveedor}">${proveedor}</option>`
                );
            });

            $providerSelect.on("change", function () {
                const proveedorSeleccionado = $(this).val();

                const modelos = iaData.filter(
                    (item) => item.ia === proveedorSeleccionado
                );

                $modelSelect
                    .empty()
                    .append(
                        "<option selected disabled>Selecciona un modelo</option>"
                    );

                modelos.forEach(modelo => {
    $modelSelect.append(
        `<option value="${modelo.model}" data-type="${modelo.type}">
            ${modelo.model} ${modelo.type}
        </option>`
    );
});

            });
        },
        error: function () {
            alert("Error al cargar proveedores y modelos.");
        },
    });

    $.ajax({
        url: ANALYSIS_LIST_URL,
        method: "GET",
        success: function (data) {
            let container = $("#analysis_type_container");
            container.empty();

            if (data.data.length === 0) {
                container.append(
                    "<div class='text-muted'>No hay tipos de análisis disponibles.</div>"
                );
            } else {
                data.data.forEach((analysis) => {
                    let checkbox = `
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="analysis_type[]" 
                            value="${analysis.id}" 
                            id="analysis-${analysis.id}" 
                            data-description="${analysis.description}">
                        <label class="form-check-label" for="analysis-${analysis.id}">
                            ${analysis.analysis}
                        </label>
                    </div>
                `;
                    container.append(checkbox);
                });
            }
        },
        error: function () {
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Error al cargar las opciones.",
                showConfirmButton: false,
                timer: 1500,
            });
            console.log(ANALYSIS_LIST_URL);
        },
    });
});
