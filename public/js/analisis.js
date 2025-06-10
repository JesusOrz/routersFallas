$(document).ready(function () {
    $('#analizar-btn').on('click', function () {
        const analizarBtn = $('#analizar-btn');
        const resultado = $('#analisis-container');
        const logs = $('#logs-container').text().trim();

        // Verificar si no hay logs
        if (!logs) {
            Swal.fire({
                icon: 'warning',
                title: 'Sin logs cargados',
                text: 'Por favor, selecciona un router primero.',
                confirmButtonColor: '#000000'
            });
            return;
        }

        analizarBtn.prop('disabled', true);
        resultado.html('');

        Swal.fire({
            title: 'Analizando...',
            html: 'Por favor espera unos segundos',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: ANALYZE_LOG,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            data: {
                logs: logs
            },
            success: function (response) {
                Swal.close();

                if (response.respuesta) {
                    resultado.html(`<div class="alert">${response.respuesta}</div>`);
                } else if (response.error) {
                    resultado.html(`<div class="alert alert-danger">${response.error}</div>`);
                } else {
                    resultado.html(`<div class="alert alert-warning">Respuesta inesperada.</div>`);
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                resultado.html(`<div class="alert alert-danger">Error: ${xhr.responseText || error}</div>`);
                console.error(xhr);
            },
            complete: function () {
                analizarBtn.prop('disabled', false);
            }
        });
    });
});
