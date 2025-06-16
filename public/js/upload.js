$(document).ready(function () {
    $("#submitBtn").on("click", function () {
        const submitBtn = $("#submitBtn");
        const resultado = $("#resultado");
        const form = $("#logUploadForm")[0];
        const formData = new FormData(form);

        const analysisType = $("#analysis_type").val();
        const analysisTypeText = $("#analysis_type option:selected").text();
        const analysisDescription = $("#analysis_type option:selected").data(
            "description"
        );
        const fileInput = $('#logUploadForm input[type="file"]')[0];


        if (!fileInput.files || fileInput.files.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No has seleccionado ningún archivo",
                text: "Por favor selecciona un archivo para continuar.",
            });
            return;
        }
        if (!analysisType || !analysisDescription) {
            Swal.fire({
                icon: "warning",
                title: "Selecciona un tipo de análisis",
            });
            return;
        }

        formData.append("analysis_type", analysisType);
        formData.append("analysis_description", analysisDescription);

        submitBtn.prop("disabled", true);
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
            url: UPLOAD_LOG,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": CSRF_TOKEN,
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.close();

                if (response.error) {
                    $("#resultado").html(
                        `<div class="alert alert-danger">${response.error}</div>`
                    );
                    $("#recomendaciones").html(""); // Limpia recomendaciones
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
                $("#resultado").html(`
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
                    $("#recomendaciones").html(
                        `<div class="alert alert-success">${recomendacionesHTML}</div>`
                    );
                } else {
                    $("#recomendaciones").html(
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
                submitBtn.prop("disabled", false);
            },
        });
    });
});
