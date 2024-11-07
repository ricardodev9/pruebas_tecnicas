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
}
?>