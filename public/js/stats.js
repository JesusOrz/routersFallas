
    $(document).ready(function () {
        $.ajax({
            url: STATS_SYSTEM,
            method: 'GET',
            success: function (data) {
                $('#router-count').text(data.routers);
                $('#key-count').text(data.keys);
               
            },
            error: function () {
                console.error("Error al cargar los datos del dashboard");
            }
        });
    });
