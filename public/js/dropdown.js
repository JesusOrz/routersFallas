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
            let select = $("#analysis_type");
            select.empty();
            select.append(
                "<option selected disabled>Selecciona una opción</option>"
            );
            data.data.forEach((analysis) => {
                select.append(
                    `<option value="${analysis.id}" data-description="${analysis.description}">${analysis.analysis}</option>`
                );
            });
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
