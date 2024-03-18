<?php
require_once 'config.php';
require_once 'Model/User.php';
require_once 'Controller/UserController.php';

$action = isset ($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'create_user':
        // Crear una instancia del controlador de usuario
        $userController = new UserController(new User($pdo));
        $userController->create();
        break;

    case 'store_user':
        // Crear una instancia del controlador de usuario
        $userController = new UserController(new User($pdo));
        $userController->store();
        // Redireccionar a la página del dashboard después de almacenar el usuario
        header('Location: index.php?action=dashboard');
        exit();


    case 'delete_user':
        // Verificar si se proporcionó un ID de usuario a eliminar
        if (isset ($_POST['user_id'])) {
            // Imprimir el ID del usuario para depuración
            var_dump($_POST['user_id']);

            // Crear una instancia del controlador de usuario
            $userController = new UserController(new User($pdo));
            $userController->delete($_POST['user_id']);
            // Redireccionar a la página del dashboard después de eliminar el usuario
            echo "Redirigiendo a dashboard...";
            header('Location: index.php?action=dashboard');
            exit();
        }



    case 'login':
        // Creamos una instancia del controlador de usuario
        $userController = new UserController(new User($pdo));

        // Inicializamos la variable de error
        $error = '';

        // Verificamos si se envió el formulario de inicio de sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['username']) && isset ($_POST['password'])) {
            // Obtener los datos del formulario
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Llamar al método login del controlador UserController
            $roleId = $userController->login($username, $password);

            // Si el inicio de sesión falló, establecer el mensaje de error
            if (!$roleId) {
                $error = 'Usuario o contraseña incorrectos';
            }
        }

        // Mostrar la vista de inicio de sesión con el formulario y el mensaje de error si existe
        require 'View/login.php';
        break;

    case 'dashboard':
        // Creamos una instancia del controlador de usuario
        $userController = new UserController(new User($pdo));

        // Obtenemos la lista de usuarios
        $users = $userController->getUsers();

        // Mostramos la vista del dashboard
        require 'View/dashboard.php';
        break;

    case 'logout':
        // Llamamos al método logout del controlador de usuario para cerrar sesión
        $userController = new UserController(new User($pdo));
        $userController->logout();

        // Redirigimos al usuario a la página de inicio de sesión después del logout
        header('Location: index.php?action=login');
        exit();

    default:
        // Redirigimos a la página de inicio de sesión si la acción es desconocida
        header('Location: index.php?action=login');
        exit();
}

