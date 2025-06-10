
    $(document).ready(function () {
        $('#submitBtn').on('click', function () {
            const submitBtn = $('#submitBtn');
            const resultado = $('#resultado');
            const form = $('#logUploadForm')[0];
            const formData = new FormData(form);

            submitBtn.prop('disabled', true);
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
                url: UPLOAD_LOG,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    Swal.close();

                    if (data.respuesta) {
                        resultado.html(`<div class="alert">${data.respuesta}</div>`);
                    } else if (data.error) {
                        resultado.html(`<div class="alert alert-danger">${data.error}</div>`);
                    } else {
                        resultado.html(`<div class="alert alert-warning">Respuesta inesperada.</div>`);
                    }
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    resultado.html(`<div class="alert alert-danger">Error: ${xhr.responseText || error}</div>`);
                },
                complete: function () {
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });