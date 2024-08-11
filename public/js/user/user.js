$(document).ready(function () {
    // Detectar cambios en los elementos select y activar el botón submit
    $('#orderBySelect, #orderDirectionSelect').change(function () {
        $('#searchForm').submit();
    });
});
