<?php
    include_once(__DIR__ . '/functions.php'); 
    include_once(__DIR__ . '/../Class/User.php');

    global $conn;
    $conn = connect_db();
    $user = new User($conn);

    // Inicializar el array de objetos de usuarios
    if(isset($_GET['view']) && $_GET['view'] == 'users'){
        $users = $user->getUsers();
    }

    // Eliminar el usuario
    if(isset($_POST['user_id']) && $_POST['method'] == 'delete_user'){
        $user_id = $_POST['user_id'];
        $result = $user->deleteUser($user_id);
        if ($result === true) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Método para dar de alta un usuario
    if(isset($_POST['name'],$_POST['email'], $_POST['pass']) && $_POST['method'] == 'add_user'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $register = $user->register($email, $pass, $name);        
        if ($register !== true) { 
            echo json_encode(['status' => 'error' , 'msg' => $register]);
        } else {
            echo json_encode(['status' => 'success']);
        }
    }

    // Método para recuperar la info de un uusario
    if (isset($_GET['method']) && $_GET['method'] == 'getUserData') {
        // Verificamos si el ID de usuario está presente
        if (isset($_GET['id'])) {
            $id_user = $_GET['id'];
            $user_by_id = $user->getById($id_user);

            // Verificamos si se encontró un usuario
            if ($user_by_id) {
                echo json_encode($user_by_id);
            } else {
                // Si no se encuentra el usuario, devolvemos un error en formato JSON
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
        }
    }

    // Método para editar un usuario
    if(isset($_POST['name'],$_POST['email'], $_POST['pass'], $_POST['id_user']) && $_POST['method'] == 'update_user'){
        $id_user = $_POST['id_user'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pass'] ?? null;
        $result = $user->update($id_user, $name, $email, $password);

        // Resultado
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Hubo un error al actualizar el usuario']);
        }
        

    }

?>