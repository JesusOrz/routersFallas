$(document).ready(function () {
    const commonOptions = {
    responsive: true,
    pageLength: 10,
    searching: false,
    lengthChange: false,
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json",
    },
};

let table = $("#routers-table").DataTable({
    ajax: ROUTERS_JSON_URL,
    columns: [
        { data: "host" },
        { data: "user" },
        {
            data: "state",
            render: function (data, type, row) {
                if (data === "activo") {
                    return `<span class="text-success" title="Activo"><i class="bi bi-check-circle-fill"></i></span>`;
                } else if (data === "inactivo") {
                    return `<span class="text-danger" title="Inactivo"><i class="bi bi-x-circle-fill"></i></span>`;
                } else {
                    return `<span class="text-secondary" title="Desconocido"><i class="bi bi-question-circle-fill"></i></span>`;
                }
            },
        },
        { data: "port" },
        {
            data: null,
            render: function (data, type, row) {
                return `
                    <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
                        <i class="bi bi-pencil-square"></i> Editar
                    </button>
                `;
            },
        },
    ],
    ...commonOptions,
});

let tableAnalysis = $("#analysis-table").DataTable({
    ajax: ANALYSIS_LIST_URL,
    columns: [
        { data: "id" },
        { data: "analysis" },
        { data: "description" },
    ],
    ...commonOptions,
});

let tableKeys = $("#keys-table").DataTable({
    ajax: KEYS_JSON_URL,
    columns: [
        { data: "key" },
        { data: "ia_name" },
        { data: "ia_model" },
        {
            data: "type",
            render: function (data, type, row) {
                if (data === "libre") {
                    return `<span class="badge text-bg-success">Libre</span>`;
                } else if (data === "pago" || data === "libre (limitado)") {
                    return `<span class="badge text-bg-warning">Pago</span>`;
                } else {
                    return `<span class="badge text-bg-danger">No asignado</span>`;
                }
            },
            className: "text-center",
        },
    ],
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 },
    ],
    ...commonOptions,
});


    $("#createIA").click(function () {
        const ia = $("#iaName").val();
        const model = $("#modelIA").val();

        $.ajax({
            url: IA_STORE_URL,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                ia: ia,
                model: model,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Registro agregado correctamente",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    cargarDropdownIAs();
                    $("#iaName, #modelIA").val("");
                    $("#modalNewIa").modal("hide");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let msg = "";
                for (let field in errors) {
                    msg += errors[field][0] + "\n";
                }
                alert(msg);
            },
        });
    });

    $("#btnCreateKey").click(function () {
        const key = $("#key").val();
        const proveedor = $("#provider_id").val();
        const modelo = $("#model_id").val();

        $.ajax({
            url: KEYS_STORE_URL,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                key: key,
                ia: proveedor,
                model: modelo,
                user_id: USER_ID,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Registro agregado correctamente",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    tableKeys.ajax.reload();
                    $("#key, #provider_id, #model_id").val("");
                    $("#modalKeys").modal("hide");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let msg = "Error desconocido";
                for (let field in errors) {
                    msg = errors[field][0];
                }
                alert(msg);
                $("#key, #provider_id, #model_id").val("");
            },
        });
    });

    $("#btnCreate").click(function () {
        const host = $("#host").val();
        const user = $("#user").val();
        const pass = $("#pass").val();
        const port = $("#port").val();

        $.ajax({
            url: ROUTERS_STORE_URL,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                host: host,
                user: user,
                password: pass,
                port: port,
                userSystem_id: USER_ID,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Router has been saved",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    table.ajax.reload();
                    $("#host, #user, #pass").val("");
                    $("#port").val("8728");
                    $("#modalConnect").modal("hide");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let msg = "";
                for (let field in errors) {
                    msg += errors[field][0] + "\n";
                }
                alert(msg);
            },
        });
    });

    $("#routers-table").on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        const rowData = table.row($(this).closest("tr")).data();

        $("#edit-id").val(rowData.id);
        $("#edit-host").val(rowData.host);
        $("#edit-user").val(rowData.user);
        $("#edit-pass").val(""); // no se muestra la contraseña real
        $("#edit-port").val(rowData.port);

        $("#modalEditRouter").modal("show");
    });

    $("#btnUpdate").click(function () {
        const id = $("#edit-id").val();
        const host = $("#edit-host").val();
        const user = $("#edit-user").val();
        const pass = $("#edit-pass").val(); // opcional
        const port = $("#edit-port").val();

        $.ajax({
            url: `${ROUTERS_UPDATE_URL}/${id}`,
            method: "PUT",
            data: {
                _token: CSRF_TOKEN,
                host: host,
                user: user,
                password: pass,
                port: port,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Router actualizado correctamente",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $("#modalEditRouter").modal("hide");
                    table.ajax.reload();
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let msg = "";
                for (let field in errors) {
                    msg += errors[field][0] + "\n";
                }
                alert(msg);
            },
        });
    });

    $("#btnCreateAnalysis").click(function () {
        const analysis = $("#analysis").val().trim();
        const description = $("#description").val().trim();
        $.ajax({
            url: ANALYSIS_STORE_URL,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                analysis: analysis,
                description: description,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Se agregó correctamente el registro",
                        showConfirmButton: false,
                        timer: 1500,
                    });

                    //agregar nueva opción al dropdown
                    $("#analysis_type")
                        .append(
                            $("<option>", {
                                value: response.analysis.id,
                                text: response.analysis.analysis,
                            })
                        )
                        .val(response.analysis.id);
                    tableAnalysis.ajax.reload();
                    $("#analysis, #description").val("");
                    $("#modalAnalysis").modal("hide");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let msg = "";
                for (let field in errors) {
                    msg += errors[field][0] + "\n";
                }
                alert(msg);
            },
        });
    });
});
