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
    $.ajax({
        url: ANALYSIS_LIST_URL,
        method: "GET",
        success: function (data) {
            let container = $("#analysis_type_container");
            container.empty(); // Limpiar contenido previo

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
