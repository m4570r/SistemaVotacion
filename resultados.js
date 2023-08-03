/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/
$(document).ready(function() {
    // Obtener el recuento de votantes
    $.ajax({
        url: 'estadistica.php',
        method: 'POST',
        data: {action: 'get_voter_count'},
        success: function(data) {
            $('#voterCount').text('Número total de votantes: ' + data);
        }
    });

    // Obtener los datos de cómo se enteraron los votantes
    $.ajax({
        url: 'estadistica.php',
        method: 'POST',
        data: { action: 'get_notification_data' },
        success: function (data) {
            var notifications = JSON.parse(data);  

            var notificationText = "Datos de cómo se enteraron los votantes:\n";
            for (var i = 0; i < notifications.length; i++) {
                notificationText += notifications[i].descripcion + ": " + notifications[i].count + "\n";
            }

            $('#notificationCount').text(notificationText);
        }
    });


    // Obtener los resultados de la votación y crear un gráfico
    $.ajax({
        url: 'estadistica.php',
        method: 'POST',
        data: { action: 'get_voting_results' },
        success: function (data) {
            var results = JSON.parse(data).data; 
            var labels = results.map(function (result) {
                return result.nombre;
            });

            var data = results.map(function (result) {
                return result.votos;
            });

            var ctx = document.getElementById('votingResultsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# de Votos',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
});
