
    $('#analizar-btn').on('click', function () {
        const logs = $('#logs-container').text();
        $('#analisis-container').text('Analizando...');

        $.ajax({
            url: ANALYZE_LOG,
            method: 'POST',
            data: {
                logs: logs,
                _token: CSRF_TOKEN
            },
            success: function (response) {
                $('#analisis-container').html('<pre>' + response.respuesta + '</pre>');
            },
            error: function (response) {
                $('#analisis-container').text('Ocurrió un error al analizar los logs.');
                console.log(response);
            }
        });
    });

