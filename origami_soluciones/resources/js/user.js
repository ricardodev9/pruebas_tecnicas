function deleteUser(userId) {
    // Confirmar con el usuario antes de eliminar
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        // Realizar la solicitud AJAX
        $.ajax({
            url: './inc/user.php',  
            type: 'POST',
            data: {
                method : 'delete_user',
                user_id: userId
            },
            success: function(response) {
                // Procesar la respuesta del servidor
                var data = JSON.parse(response);
                if (data.status  === 'success') {
                    alert('Usuario eliminado correctamente');
                    location.reload();  // Recargar la página para ver los cambios
                } else {
                    alert('Hubo un error al eliminar al usuario. Inténtalo de nuevo.');
                }
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error en la solicitud AJAX. Inténtalo de nuevo.');
            }
        });
    }
}
