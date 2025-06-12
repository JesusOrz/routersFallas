$('#router_id').on('change', function () {
        let routerId = $(this).val();

        if (routerId) {
            $('#logs-container').text('Cargando logs...');
            $.ajax({
                url: GET_LOG,
                method: 'POST',
                data: {
                    router_id: routerId,
                    _token: CSRF_TOKEN
                },
                success: function (response) {
                    $('#logs-container').text(response.logs);
                },
                error: function (xhr) {
                    $('#logs-container').text('Error al obtener logs.');
                    console.error(xhr.responseText);
                }
            });
        }
    });