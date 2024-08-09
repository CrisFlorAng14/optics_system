document.addEventListener('DOMContentLoaded', function () {
    // Función para confirmación de eliminación
    document.querySelectorAll('.btnDelete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');

            const title = button.getAttribute('data-title');
            const text = button.getAttribute('data-text');
            const confirmButtonText = button.getAttribute('data-confirm-button-text');
            const cancelButtonText = button.getAttribute('data-cancel-button-text');

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: cancelButtonText,
                confirmButtonColor: '#FF0F0F',
                iconColor: '#FF3E1C',
            }).then((result) => {
                if(result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
