/**
 * Función para mostrar rápidamente los registros al buscar
 * Entradas: Datos de búsqueda (input-search)
 * Salidas: 
 * - Información: Registros encontrados que coincidan con la búsqueda
 * - Alerta: Mensaje de error al no encontrar registros
 */
document.addEventListener('DOMContentLoaded', function() {
    // Se obtiene el valor del input
    var inputSearch = document.getElementById("input-search");
    // Se realiza lo conversión y evaluación 
    inputSearch.addEventListener("keyup", function() {
        var value = inputSearch.value.toLowerCase();
        var rows = document.querySelectorAll("#table-content tbody tr");
        var found = false;
        // Se recorre y se muestran los registros encontrados
        rows.forEach(function(row) {
            if (row.textContent.toLowerCase().indexOf(value) > -1) {
                row.style.display = "";
                found = true;
            } else {
                row.style.display = "none";
            }
        });

        // Se activa o desactiva el mensaje de 'message_empty' basado en los resultados encontrados
        var messageEmpty = document.getElementById("message-empty");
        if (!found) {
            messageEmpty.style.display = "block";
        } else {
            messageEmpty.style.display = "none";
        }
    });
});
