<?php
/**
 * Class para el usuario
 * Tiene un método para registrarse y logearse
 */
class User {
    private $conn;

    //conexión a la base de datos
    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    // Método para registrar un usuario
    public function register($email, $password, $name) {
        // Validar que no exista un usuario con el mismo correo
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);
        $name = $this->conn->real_escape_string($name);
        
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Verificar si el email ya está registrado
        $sqlCheckEmail = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sqlCheckEmail);

        if ($result->num_rows > 0) {
            return "El correo electrónico ya está registrado.";
        }

        // Si el email no existe, insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$hashedPassword', '$name')";
        
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return "Error al registrar el usuario: " . $this->conn->error;
        }
    }

    // Método para iniciar sesión
    public function login($email, $password) {
        // Evitar inyecciones SQL
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);

        // Buscar el usuario por correo electrónico
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        // No existe el usuario
        if ($result->num_rows == 0) {
            return "Credenciales incorrectas.";
        }

        // Si el usuario existe, verificar la contraseña
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // La contraseña es correcta
            return true; 
        } else {
            // La contraseña no es correcta
            return "Credenciales incorrectas.";
        }
    }

    //Método para hacer un get de todos los usuario
    public function getUsers(){
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        // Verifica que se obtuvieron resultados
        if ($result->num_rows > 0) {
            $users = [];
            while ($user = $result->fetch_object()) {
                $users[] = $user;
            }
            return $users;
        } else {
            return [];
        }
    }

    // Método para eliminar el usuario 
    public function deleteUser($id_user){
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_user);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        // Cerramos el statement
        $stmt->close();
    }

    // Método para recoger un uusario a través de su id
    public function getById($id_user){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error al preparar la consulta: ' . $this->conn->error);
        }
        $stmt->bind_param("i", $id_user);
        $stmt->execute();

        // Resultado
        $result = $stmt->get_result();
        
        // Comprobamos si se encontró el usuario
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
        
        // Cerramos el statement
        $stmt->close();
    }

    // Método para editar un usuario
    public function update($id, $name, $email, $password = null) {
        // Si la contraseña es proporcionada, se actualiza. Si no, no se actualiza.
        if ($password) {
            $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
        
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
        } else {
            $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
        
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
        
            $stmt->bind_param("ssi", $name, $email, $id);
        }

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;  
        }
    }
    
    
}
?>