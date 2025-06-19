$(document).ready(function () {
    $("#analizar-btn").on("click", function () {
        const analizarBtn = $("#analizar-btn");
        const resultado = $("#analisis-container");
        const recomendaciones = $("#recomendaciones-container");
        const logs = $("#logs-container").text().trim();

        let selectedAnalysis = [];
        let selectedAnalysisDescriptions = [];

        $("input[name='analysis_type[]']:checked").each(function () {
            const label = $(this)
                .closest(".form-check")
                .find("label")
                .text()
                .trim();
            selectedAnalysis.push($(this).val());
            selectedAnalysisDescriptions.push(label);
        });

        // Validaciones
        if (!logs) {
            Swal.fire({
                icon: "warning",
                title: "Sin logs cargados",
                text: "Por favor, selecciona un router primero.",
                confirmButtonColor: "#000000",
            });
            return;
        }

        if (selectedAnalysis.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Tipo de análisis no seleccionado",
                text: "Selecciona al menos una opción del tipo de análisis.",
                confirmButtonColor: "#000000",
            });
            return;
        }

        analizarBtn.prop("disabled", true);
        resultado.html("");
        recomendaciones.html("");

        Swal.fire({
            title: "Analizando...",
            html: "Por favor espera unos segundos",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: ANALYZE_LOG,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": CSRF_TOKEN,
            },
            data: {
                logs: logs,
                analysis_types: selectedAnalysis, // Enviamos array de IDs al backend
            },
            success: function (response) {
                Swal.close();

                if (response.error) {
                    resultado.html(
                        `<div class="alert alert-danger">${response.error}</div>`
                    );
                    return;
                }

                if (Array.isArray(response.resultados)) {
                    let html = "";
                    let recomendacionesHTML = "";

                    response.resultados.forEach((res) => {
                        let colorClass = "alert-secondary";
                        switch (res.severidad) {
                            case "alta":
                                colorClass = "alert-danger";
                                break;
                            case "media":
                                colorClass = "alert-warning";
                                break;
                            case "baja":
                                colorClass = "alert-info";
                                break;
                        }

                        // Mostrar análisis
                        html += `
            <div class="alert ${colorClass}">
                <strong>Análisis: ${
                    res.nombre
                } — Severidad: ${res.severidad.toUpperCase()}</strong><br>
                <p><em>${res.descripcion}</em></p>
                <p>${res.mensaje}</p>
            </div>
        `;

                        // Mostrar recomendaciones separadas
                        if (
                            Array.isArray(res.recomendaciones) &&
                            res.recomendaciones.length > 0
                        ) {
                            recomendacionesHTML += `
                <div class="mb-3">
                    <div class="alert alert-success">
                        <strong>Recomendaciones para: ${res.nombre}</strong>
                        <ul>
                            ${res.recomendaciones
                                .map((rec) => `<li>${rec}</li>`)
                                .join("")}
                        </ul>
                    </div>
                </div>
            `;
                        } else {
                            recomendacionesHTML += `
                <div class="mb-3">
                    <div class="alert alert-secondary">
                        <strong>Recomendaciones para: ${res.nombre}</strong>
                        <p>No se encontraron recomendaciones.</p>
                    </div>
                </div>
            `;
                        }
                    });

                    $("#analisis-container").html(html);
                    $("#recomendaciones-container").html(recomendacionesHTML);
                } else {
                    $("#analisis-container").html(
                        `<div class="alert alert-info">No se devolvieron resultados.</div>`
                    );
                    $("#recomendaciones-container").html("");
                }
            },

            error: function (xhr, status, error) {
                Swal.close();
                resultado.html(
                    `<div class="alert alert-danger">Error: ${
                        xhr.responseText || error
                    }</div>`
                );
                console.error(xhr);
            },

            complete: function () {
                analizarBtn.prop("disabled", false);
            },
        });
    });
});
