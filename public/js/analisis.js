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
                                <strong>${
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
                                <strong>${res.nombre}</strong>
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

                    $("#descargar-pdf").show();
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

    $("#descargar-pdf").on("click", function () {
        // Vuelve a leer los análisis seleccionados para construir el nombre
        let selectedAnalysisDescriptions = [];
        $("input[name='analysis_type[]']:checked").each(function () {
            const label = $(this)
                .closest(".form-check")
                .find("label")
                .text()
                .trim();
            selectedAnalysisDescriptions.push(label);
        });

        let nombreArchivo = "informe_analisis_";
        if (selectedAnalysisDescriptions.length > 0) {
            nombreArchivo += selectedAnalysisDescriptions
                .join("_")
                .replace(/\s+/g, "_");
        } else {
            nombreArchivo += "red";
        }
        nombreArchivo += ".pdf";

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF("p", "mm", "a4");

        // Logo en base64
        const logoBase64 =
            "data:image/jpeg;base64,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FOTynzLCPi8NxkMezf6BFqXzJLfmGXVCyREQhERKNHtbYpNq5ePouVWN068Fuq7a7P3N2EDr6pkZ+HXnY1uPapCXI1TqeDKSP2geII7gRNpGkTO7GKxEzMeUT5sdjW4OCuLePjKrbwT2Mpvcq48CCD5yWREjIkX2Nh7u1dp26H4yrCGvYdBeDofISURAREQIRzg8lTtPI2ZWw/4ep7brz2dGBXonvY6D3bx7JNlGg0HUOycxASLLhWbOuvtx6DbiZb+kXVVAdLVklVV7VQ6dIjBQSo9YEEgNvaCUxA0ScrsIjU2lT+A9V1b/AKDIG18phbRvs2mjYtNVleJcDXflWo1JaltQ9dNTgOWYcN9gFAbUFjwkqiB1YuOlSJXWoVK1CKg4BUUaADwAE7YiBD+UXJnTOxtr49ZsvxwyW0AqpuqNbICpYhekXe4akAjhqNBNmnK3F4iw21MOBW2m6rQ+9l0PvBIm9iBoLeVdJ9XHS7JsPUlVT7pPja4WtPzmE+9jbMtNrZmYV9IZTUlSEtXj0kglFYgF3YgFn0Gu6oAAHHdzmAmi5RbIex6MvHCemYhYpv8ABLKnXSylmAJUMNCGAO6QDoRqDvYgaCrlXQPVyEuxrBpvJbW4APhaoNb+9WM4u5UI+q4dVuTafZCo9dOvVq97qEUdp03m06lPVJBEDT8nNjejC13Ktk5T9PfYo0DWaBQqg8QiqAo17iTxJm4iICIiAiIlCIiQIiICIiAiIgIiICIiAmDtw3jHuOLu+kBGareG8psA1VSO4nh5zOiBXOPyj2xamTaMVqxjAXrS9Dh8itmRxWnH7oKxapAGu9uaga6RVyg2wa3vbHZVptSk0ejubrUeywG1F3uIVGx24ajUWg9XCxtJxpAhezNubQOFbflVNXlOGrppWixyLq8XVy6rr6rXLZoeojc0J3hrr9l7f2u9lS21EI7IjH0S5N0W7OFwbViQAt/xZ18ddJYmk50gVNftfaWSuLZdTfW1NuFdvjDydUZqL0yd6sDedBYF9XxB6iDNrg8oNri3GXIx2As9CawLj2OqraLVyQXXUKVYVHQ8V3jrwBIsPSNIEE2xyi2j0mV6JU+7VUXx63xbyMh1Fq262cBWyuq6KdN8dWu8CNfn8pNsBGail33Vy2Rjh3a2im6voNV4GtnU2DQ9e5qBxEsvSNIELHKDNGHml6rPTK7MurG3cW/dtFSNZQ27ofVYDTXXQkga6zCxOUG1OlAvRxQWtUumFkFlX0Ku6pwASTpYXTd04kadcsHSNIEZ5BbTzMil2zkau9WA6NqXoATdGhUtqH14k6H1dd08RqZPEQEREBERKEREgREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREoREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQERED/2Q==";

        const fecha = new Date().toLocaleString();
        const routerNombre =
            $("#router_id option:selected").text().trim() ||
            "Router desconocido";
        const proveedor = $("#provider_id option:selected").text().trim();
        const modelo = $("#model_id option:selected").text().trim();

        let y = 15;

        // Agregar logo
        doc.addImage(logoBase64, "PNG", 165, 10, 30, 30);

        y += 35;

        // Título
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        const analisisSeleccionados = $("input[name='analysis_type[]']:checked")
            .map(function () {
                return $(this)
                    .closest(".form-check")
                    .find("label")
                    .text()
                    .trim();
            })
            .get()
            .join(" y ");

        const tituloPDF = `Análisis de ${analisisSeleccionados || "Red"}`;
        doc.text(tituloPDF, 105, y, { align: "center" });

        y += 10;

        // Datos generales
        doc.setFont("helvetica", "normal");
        doc.setFontSize(11);
        doc.text(`Fecha: ${fecha}`, 15, y);
        y += 6;
        doc.text(`Host: ${routerNombre}`, 15, y);
        y += 6;
        doc.text(`Proveedor IA: ${proveedor}`, 15, y);
        y += 6;
        doc.text(`Modelo IA: ${modelo}`, 15, y);
        y += 10;

        // Análisis
        doc.setFont("helvetica", "bold");
        doc.text("Análisis:", 15, y);
        y += 6;
        doc.setFont("helvetica", "normal");

        $("#analisis-container .alert").each(function () {
            const $alert = $(this);
            const titulo = $alert.find("strong").text().trim();
            const descripcion = $alert.find("em").text().trim(); 
            const contenido = $alert
                .find("p")
                .map(function () {
                    return $(this).text().trim();
                })
                .get()
                .join("\n");

            const contenidoFormateado = doc.splitTextToSize(contenido, 180);

            // Salto de página si se necesita
            if (y + 12 + contenidoFormateado.length * 6 > 280) {
                doc.addPage();
                y = 15;
            }

            // 📝 Título del análisis
            doc.setFont("helvetica", "bold");
            doc.setFontSize(12);
            doc.text(titulo, 15, y);
            y += 6;

            doc.setFont("helvetica", "italic");
            doc.setFontSize(12);
            doc.text(descripcion, 15, y);
            y += 6;

            // 📄 Contenido del análisis
            doc.setFont("helvetica", "normal");
            doc.setFontSize(11);
            doc.text(contenidoFormateado, 15, y);
            y += contenidoFormateado.length * 6 + 4;
        });

        // Recomendaciones
        doc.setFont("helvetica", "bold");
        doc.text("Recomendaciones:", 15, y);
        y += 6;
        doc.setFont("helvetica", "normal");

        const recomendaciones = $("#recomendaciones-container .alert")
            .map(function () {
                const titulo = $(this).find("strong").text().trim();
                const items = $(this)
                    .find("li")
                    .map(function () {
                        return "- " + $(this).text().trim();
                    })
                    .get();
                return { titulo, items };
            })
            .get();

        recomendaciones.forEach((rec) => {
            if (y + 6 > 280) {
                doc.addPage();
                y = 15;
            }

            doc.setFont("helvetica", "bold");
            doc.text(rec.titulo + ":", 15, y);
            y += 6;
            doc.setFont("helvetica", "normal");

            rec.items.forEach((line) => {
                const wrapped = doc.splitTextToSize(line, 180);
                if (y + wrapped.length * 6 > 280) {
                    doc.addPage();
                    y = 15;
                }
                doc.text(wrapped, 15, y);
                y += wrapped.length * 6;
            });

            y += 4;
        });

        // Descargar PDF con nombre dinámico
        doc.save(nombreArchivo);
    });
});
