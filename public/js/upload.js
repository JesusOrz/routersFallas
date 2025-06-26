$(document).ready(function () {
    $("#submitBtn").on("click", function () {
        const submitBtn = $("#submitBtn");
        const resultado = $("#resultado");
        const recomendacionesContainer = $("#recomendaciones");
        const form = $("#logUploadForm")[0];
        const formData = new FormData(form);

        const fileInput = $('#logUploadForm input[type="file"]')[0];
        if (!fileInput.files || fileInput.files.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No has seleccionado ningún archivo",
                text: "Por favor selecciona un archivo para continuar.",
            });
            return;
        }

      
        let selectedTypes = [];
        let selectedDescriptions = [];

        $('input[name="analysis_type[]"]:checked').each(function () {
            selectedTypes.push($(this).val());
            selectedDescriptions.push($(this).data("description"));
        });

        if (selectedTypes.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Selecciona al menos un tipo de análisis",
            });
            return;
        }

       
        formData.append("analysis_types", JSON.stringify(selectedTypes));
        formData.append("analysis_descriptions", JSON.stringify(selectedDescriptions));

       
        submitBtn.prop("disabled", true);
        resultado.html("");
        recomendacionesContainer.html("");

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
                    resultado.html(
                        `<div class="alert alert-danger">${response.error}</div>`
                    );
                    return;
                }

                if (!Array.isArray(response.analisis)) {
                    resultado.html(
                        `<div class="alert alert-warning">Formato de respuesta no válido.</div>`
                    );
                    return;
                }

                let resultadoHTML = "";
                let recomendacionesHTML = "";

                response.analisis.forEach(item => {
                    let colorClass = "alert-secondary";
                    switch (item.resultado.severidad) {
                        case "alta": colorClass = "alert-danger"; break;
                        case "media": colorClass = "alert-warning"; break;
                        case "baja": colorClass = "alert-info"; break;
                    }

                    resultadoHTML += `
                        <div class="alert ${colorClass}">
                            <strong>Análisis: ${item.description}</strong><br>
                            <p>${item.resultado.mensaje}</p>
                        </div>
                    `;

                    if (Array.isArray(item.resultado.recomendaciones) && item.resultado.recomendaciones.length > 0) {
                        recomendacionesHTML += `<div class="mb-2"><strong>${item.description}</strong><ul>`;
                        item.resultado.recomendaciones.forEach(rec => {
                            recomendacionesHTML += `<li>${rec}</li>`;
                        });
                        recomendacionesHTML += `</ul></div>`;
                    }
                });

                resultado.html(resultadoHTML);
                recomendacionesContainer.html(
                    recomendacionesHTML ? `<div class="alert alert-success">${recomendacionesHTML}</div>` : "No se encontraron recomendaciones."
                );
            },

            error: function (xhr, status, error) {
                Swal.close();
                resultado.html(
                    `<div class="alert alert-danger">Error: ${xhr.responseText || error}</div>`
                );
                console.error(xhr);
            },

            complete: function () {
                submitBtn.prop("disabled", false);
            }
        });
    });
});
