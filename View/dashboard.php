<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6fd23a10af.js" crossorigin="anonymous"></script>
    <style>
        .btn-crud {
            margin-right: 5px;
        }

        .btn-crud i {
            margin-right: 5px;
        }

        .list-group-item {
            margin-bottom: 10px;
        }

        .btn-icon {
            padding: 10px;
            margin: 5px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .btn-icon i {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .btn-icon {
                padding: 8px;
                margin: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-lg-8">
            <h2 class="mb-4">Dashboard</h2>
            <div class="mb-3">
                <span class="fw-bold">Administrador</span>
            </div>

            <h3 class="mb-3">Lista de Usuarios</h3>
            <form id="add-card-form" action="index.php?action=submit" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Número de Tarjeta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><label>
                                        <input type="checkbox" name="selected_users" value="<?php echo $user['id']; ?>"
                                            class="user-checkbox">
                                        <?php echo isset ($user['id']) ? $user['id'] : ''; ?>
                                    </label></td>
                                <td>
                                    <?php echo isset ($user['username']) ? $user['username'] : ''; ?>
                                </td>
                                <td>
                                    <?php echo isset ($user['numero_tarjeta']) ? $user['numero_tarjeta'] : ''; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-success btn-crud add-card-btn"
                                            disabled><i class="fas fa-credit-card"></i> + </button>
                                        <button type="button" class="btn btn-outline-primary btn-crud assign-balance-btn"
                                            disabled><i class="fas fa-dollar-sign"></i></button>
                                        <button type="button" class="btn btn-outline-warning btn-crud edit-user-btn"
                                            disabled><i class="fas fa-edit"></i></button>
                                        <form action="index.php?action=delete_user" method="post">
                                            <input type="hidden" name="user_id" id="selected-user-id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-crud delete-user-btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                
            </form>

            <form action="index.php?action=create_user" method="post">
                <button type="submit" class="btn-icon"><i class="fas fa-user-plus"></i> Crear Usuario</button>
            </form>

            <a href="index.php?action=logout" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <!-- Font Awesome -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.user-checkbox');

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const isChecked = checkbox.checked;
                    const parentListItem = checkbox.closest('tr');
                    const buttons = parentListItem.querySelectorAll('.btn-crud');

                    checkboxes.forEach(function (otherCheckbox) {
                        if (otherCheckbox !== checkbox) {
                            otherCheckbox.disabled = isChecked;
                        }
                    });

                    buttons.forEach(function (button) {
                        button.disabled = !isChecked;
                    });
                });
            });

            const addCardBtns = document.querySelectorAll('.add-card-btn');

            addCardBtns.forEach(function (addCardBtn) {
                addCardBtn.addEventListener('click', function () {
                    document.getElementById('add-card-form').submit();
                });
            });
        });
    </script>


</body>

</html>