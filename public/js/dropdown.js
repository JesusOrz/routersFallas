
    $(document).ready(function () {
        $.ajax({
            url: ROUTERS_LIST_URL,
            method: 'GET',
            success: function (routers) {
                let select = $('#router_id');
                select.empty();
                select.append('<option selected disabled>Select router</option>');
                routers.forEach(router => {
                    select.append(`<option value="${router.id}">${router.host}</option>`);
                });
            },
            error: function () {
                Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        title: "Error al cargar los routers.",
                        showConfirmButton: false,
                        timer: 1500,
                    });
            }
        });
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
    });
