$(document).ready(function () {
    $("#formSugerencia").on("submit", function (e) {
        e.preventDefault();

        $("#alertaSugerencia").html("");

        let formData = $(this).serialize();

        $("#btnEnviar").attr("disabled", true).text("Enviando...");

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: formData,
            success: function (response) {
                $("#sugerenciaModal").modal("hide");

                showToast('success', '¡Tu sugerencia fue enviada con éxito!');


                $("#mensaje").val("");
                $("#btnEnviar").attr("disabled", false).text("Enviar");
            },
            error: function (xhr) {
                let errores = "<ul>";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errores += "<li>" + value[0] + "</li>";
                    });
                } else {
                    errores += "<li>Ocurrió un error inesperado.</li>";
                }
                errores += "</ul>";

                showToast('error', 'Ocurrió un error al enviar la sugerencia');


                $("#sugerenciaModal").modal("hide");
                $("#btnEnviar").attr("disabled", false).text("Enviar");
            },
        });
    });
});
