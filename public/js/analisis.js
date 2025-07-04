$(document).ready(function () {
    $("#analizar-btn").on("click", function () {
        const analizarBtn = $("#analizar-btn");
        const resultado = $("#analisis-container");
        const recomendaciones = $("#recomendaciones-container");
        const logs = $("#logs-container").text().trim();
        const provider = $("#provider_id").val();
        const model = $("#model_id").val();

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

        if (!logs) {
            Swal.fire({
                icon: "warning",
                title: "Sin logs cargados",
                text: "Por favor, selecciona un router primero.",
                confirmButtonColor: "#000000",
            });
            return;
        }

        if (!provider || !model) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                text: "Debes seleccionar un proveedor y modelo de IA.",
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
                analysis_types: selectedAnalysis,
                ia_provider: provider,
                ia_model: model,
            },
            success: function (response) {
                Swal.close();

                if (Array.isArray(response.resultados)) {
                    let html = "";
                    let recomendacionesHTML = "";

                    response.resultados.forEach((res) => {
                        const datos = res.resultado || {};
                        let colorClass = "alert-secondary";

                        switch ((datos.severidad || "").toLowerCase()) {
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

                        html += `
                    <div class="alert ${colorClass}">
                        <strong>Análisis: ${res.nombre} — Severidad: ${
                            datos.severidad?.toUpperCase() || "N/A"
                        }</strong><br>
                        <p><em>${res.descripcion}</em></p>
                        <p>${datos.mensaje || "Sin mensaje"}</p>
                    </div>
                `;

                        if (
                            Array.isArray(datos.recomendaciones) &&
                            datos.recomendaciones.length > 0
                        ) {
                            recomendacionesHTML += `
                        <div class="mb-3">
                            <div class="alert alert-success">
                                <strong>Recomendaciones para: ${
                                    res.nombre
                                }</strong>
                                <ul>
                                    ${datos.recomendaciones
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

                    const resultsSection =
                        document.getElementById("analisis-container");
                    if (resultsSection) {
                        resultsSection.scrollIntoView({ behavior: "smooth" });
                    }
                } else {
                    $("#analisis-container").html(
                        `<div class="alert alert-info">No se devolvieron resultados.</div>`
                    );
                    $("#recomendaciones-container").html("");
                }
            },
            error: function (xhr, status, error) {
                Swal.close();

                const response = xhr.responseJSON;

                // Alerta SOLO si es error por clave o modelo no válido
                if (
                    response?.error?.includes("clave válida") ||
                    response?.error?.includes("no está registrado")
                ) {
                    Swal.fire({
                        icon: "error",
                        title: "Error de validación",
                        text: response.error,
                        confirmButtonColor: "#000000",
                    });
                } else {
                    // Otros errores normales en el contenedor
                    $("#analisis-container").html(
                        `<div class="alert alert-danger">Error: ${
                            response?.error || xhr.responseText || error
                        }</div>`
                    );
                }

                console.error(xhr);
            },
            complete: function () {
                analizarBtn.prop("disabled", false);
            },
        });
    });
});
