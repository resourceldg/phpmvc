<?php
require_once 'Model/User.php';

class UserController {
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function create() {
        // Lógica para mostrar el formulario de creación de usuario
        require 'View/create_user.php';
    }
    public function delete($userId) {
        // Llamar al método del modelo para eliminar el usuario
        
        return $this->userModel->deleteUser($userId);
        
        
    }

    public function store() {
        // Verificar si se enviaron los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
            // Obtener los datos del formulario
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Hash de la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Llamar al método del modelo para almacenar el usuario en la base de datos
            $result = $this->userModel->createUser($username, $hashedPassword);

            if ($result) {
                // Usuario creado exitosamente
                echo 'Usuario creado exitosamente.';
            } else {
                // Error al crear el usuario
                echo 'Hubo un error al crear el usuario.';
            }
        } else {
            // Redirigir si se intenta acceder directamente a la acción sin enviar el formulario
            header('Location: index.php?action=create_user');
            exit();
        }
    }
    public function login($username, $password) {
        // Verificar las credenciales del usuario
        $roleId = $this->userModel->getUserByUsernameAndRoleId($username);
    
        if ($roleId == 1) { // Suponiendo que 1 es el ID del rol que deseas validar
            // Inicio de sesión exitoso y usuario tiene el rol correcto, redireccionar al dashboard
            header('Location: index.php?action=dashboard');
            exit();
        } else {
            // Credenciales incorrectas o usuario no tiene el rol correcto, mostrar mensaje de error
            $error = 'Usuario o contraseña incorrectos';
            require 'View/login.php';
        }
    }

    public function getUsers() {
        return $this->userModel->getAllUsers();

    }

    

    public function logout() {
        // Borra todas las variables de sesión
        session_unset();
        
        // Destruye la sesión
        session_destroy();
    }
}

