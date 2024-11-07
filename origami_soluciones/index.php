<?php
session_start();  // Iniciar la sesión
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Origami Solutions</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="resources/js/index.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <ul class="menu-items">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?view=users">Usuarios</a></li>
                <li><a href="https://www.linkedin.com/in/ricardo-apaza-cueva-43b0572a1/" target="_blank">About me</a></li>
                <li><a href="mailto:ricardoapazacueva2000@gmail.com">Contact</a></li>
                <?php
                echo isset($_SESSION['user_email'])
                    ? '<li><a href="inc/login.php?action=logout">Logout</a></li>'
                    : '<li><a href="http://localhost/pruebas_tecnicas/origami_soluciones/login.php">Login</a></li>';
                ?>
            </ul>
            <h1 class="logo">Origami Solutions</h1>
        </div>
    </nav>
    <?php
    //vista para la tabla de usuarios
    if (isset($_GET['view']) && $_GET['view'] == 'users') {
        include_once 'inc/user.php';
    ?>
        <script src="resources/js/user.js"></script>
        <!-- Modal para Dar de Alta un Usuario -->
        <div id="modalAltaUsuario" class="modal" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dar de Alta Usuario</h5>
                        <button type="button" class="close" id="closeModalBtn" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formAltaUsuario" method="POST">
                            <div class="mb-3">
                                <label for="usuarioNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="usuarioNombre" name="usuarioNombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="usuarioEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="usuarioEmail" name="usuarioEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="usuarioPassword" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="usuarioPassword" name="usuarioPassword" required>
                            </div>
                            <button type="submit" class="btn btn-success">Dar de Alta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para Ver y Editar Usuario -->
        <div id="modalVerUsuario" class="modal" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver Usuario</h5>
                        <button type="button" class="close" id="closeModalVerBtn" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formVerEditarUsuario" method="POST">
                            <div class="mb-3">
                                <label for="usuarioNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="usuarioNombreVer" name="usuarioNombreVer" required>
                            </div>
                            <div class="mb-3">
                                <label for="usuarioEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="usuarioEmailVer" name="usuarioEmailVer" required>
                            </div>
                            <div class="mb-3">
                                <label for="usuarioPassword" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="usuarioPasswordVer" name="usuarioPasswordVer">
                            </div>
                            <input type="hidden" id="usuarioId" name="usuarioId">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5 ">
            <div class="table-responsive">
                <?php if (count($users) > 0) { ?>

                    <table id="user-table" class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Fecha de Registro</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $user) {
                            ?>
                                <tr>
                                    <td><?= $user->name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->reg_date ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2 openModalVerBtn" id='openModalVerBtn' data-id_user='<?= $user->id ?>'>Ver/editar</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteUser('<?= $user->id ?>')">Eliminar</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                <?php } ?>

            </div>

            <button class="btn btn-success btn-lg d-flex align-items-center justify-content-center rounded-pill shadow-lg px-4" id="openModalBtn">
                <i class="bi bi-person-plus-fill fs-4 me-2"></i> Dar de Alta
            </button>
        </div>
    <?php
    } else {
    ?>
        <div class="container mt-5 ">

        <div class="controls mt-4">
            <button id="addTextBtn" class="btn btn-primary btn-lg mx-2">
                <i class="bi bi-file-earmark-plus"></i> Añadir Texto
            </button>
            <button id="downloadPdfBtn" class="btn btn-success btn-lg mx-2">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
            </button>
            <button id="downloadJsonBtn" class="btn btn-info btn-lg mx-2">
                <i class="bi bi-file-earmark-json"></i> Descargar JSON
            </button>
        </div>


            <div id="container_dinA4"></div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/konva@8.3.5/konva.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <?php
    }
    ?>

</body>

</html>