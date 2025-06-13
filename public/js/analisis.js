$(document).ready(function () {
    $("#analizar-btn").on("click", function () {
        const analizarBtn = $("#analizar-btn");
        const resultado = $("#analisis-container");
        const logs = $("#logs-container").text().trim();
        const analysisType = $("#analysis_type").val();
        const analysisTypeText = $("#analysis_type option:selected").text();
        const analysisDescription = $("#analysis_type option:selected").data(
            "description"
        );

        if (!logs) {
            Swal.fire({
                icon: "warning",
                title: "Sin logs cargados",
                text: "Por favor, selecciona un router primero.",
                confirmButtonColor: "#000000",
            });
            return;
        }

        if (!analysisType) {
            Swal.fire({
                icon: "warning",
                title: "Tipo de análisis no seleccionado",
                text: "Selecciona una opción del tipo de análisis.",
                confirmButtonColor: "#000000",
            });
            return;
        }

        analizarBtn.prop("disabled", true);
        resultado.html("");

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
                analysis_type: analysisTypeText,
                analysis_description: analysisDescription,
            },
            success: function (response) {
                Swal.close();

                if (response.error) {
                    $("#analisis-container").html(
                        `<div class="alert alert-danger">${response.error}</div>`
                    );
                    $("#recomendaciones-container").html(""); // Limpia recomendaciones
                    return;
                }

                // Definir colores según severidad
                let colorClass = "alert-secondary";
                switch (response.severidad) {
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

                // Mostrar análisis en el contenedor de análisis con nombre y descripción
                $("#analisis-container").html(`
                    <div class="alert ${colorClass}">
                        <strong>Análisis realizado: ${analysisTypeText}<br>Severidad: ${response.severidad.toUpperCase()}</strong><br>
                        <p><em>${analysisDescription}</em></p>
                        <p>${response.mensaje}</p>
                    </div>
                `);

                // Mostrar recomendaciones en su contenedor aparte
                if (
                    Array.isArray(response.recomendaciones) &&
                    response.recomendaciones.length > 0
                ) {
                    let recomendacionesHTML = "<ul>";
                    response.recomendaciones.forEach((rec) => {
                        recomendacionesHTML += `<li>${rec}</li>`;
                    });
                    recomendacionesHTML += "</ul>";
                    $("#recomendaciones-container").html(
                        `<div class="alert alert-success">${recomendacionesHTML}</div>`
                    );
                } else {
                    $("#recomendaciones-container").html(
                        "<p>No se encontraron recomendaciones.</p>"
                    );
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
