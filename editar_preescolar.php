<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login_admin.php');
    exit();
}

require_once 'config.php';

$id = $_GET['id'];
$conn = db_connect();
$sql = "SELECT * FROM Preescolar WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno de Preescolar</title>
    <!-- Import Google Icon Font -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Import MaterializeCSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Baloo 2', cursive;
            color: #555;
        }
        .navbar, .dropdown-content {
            background-color: #f8c291 !important;
        }
        .navbar a, .dropdown-content a {
            color: #555 !important;
        }
        .brand-logo img {
            max-width: 50px;
        }
        .content {
            margin-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .form-container:hover {
            transform: translateY(-5px);
        }
        .input-field input[type=text], .input-field input[type=number], .input-field input[type=file] {
            background-color: #ffe8d6;
        }
        .btn-primary {
            background-color: #C2185B !important;
            border: none;
        }
        .btn-primary:hover {
            background-color: #a71d44 !important;
        }
        .header {
            margin-bottom: 30px;
        }
        .header h2 {
            font-size: 2.5rem;
        }
        .pdf-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pdf-buttons .btn-small {
            padding: 0 10px;
            font-size: 14px;
        }
        .preview-image {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            position: relative;
        }
        .preview-image img {
            max-width: 100px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .hide {
            display: none;
        }
        @media (max-width: 768px) {
            .form-container {
                margin: 0 15px;
            }
            .header h2 {
                font-size: 2rem;
            }
        }
        @media (min-width: 992px) {
            .form-container {
                max-width: 800px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-wrapper navbar">
            <a href="admin_dashboard.php" class="brand-logo"><img src="img/logo.png" alt="Logo"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="dropdown1">Nuevo registro<i class="material-icons right">arrow_drop_down</i></a>
                </li>
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="dropdown2">Expediente<i class="material-icons right">arrow_drop_down</i></a>
                </li>
                <li>
                    <a href="logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <ul id="dropdown1" class="dropdown-content">
        <li><a href="registro_preescolar.php">Alumnos preescolar</a></li>
        <li><a href="registro_maternal.php">Alumnos maternal</a></li>
        <li><a href="registro_profesor.php">Profesores</a></li>
    </ul>
    <ul id="dropdown2" class="dropdown-content">
        <li><a href="expediente_preescolar.php">Alumnos preescolar</a></li>
        <li><a href="expediente_maternal.php">Alumnos maternal</a></li>
        <li><a href="expediente_profesores.php">Profesores</a></li>
    </ul>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="registro_preescolar.php">Alumnos preescolar</a></li>
        <li><a href="registro_maternal.php">Alumnos maternal</a></li>
        <li><a href="registro_profesor.php">Profesores</a></li>
        <li><a href="expediente_preescolar.php">Alumnos preescolar</a></li>
        <li><a href="expediente_maternal.php">Alumnos maternal</a></li>
        <li><a href="expediente_profesores.php">Profesores</a></li>
        <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>

    <div class="container content">
        <div class="row">
            <div class="col s12">
                <div class="form-container">
                    <div class="header">
                        <h2 class="text-center">EDITAR ALUMNO DE PREESCOLAR</h2>
                    </div>
                    <div class="preview-image">
                        <?php if($alumno['fotografia']): ?>
                            <img src="<?php echo $alumno['fotografia']; ?>" alt="Fotografía del alumno">
                        <?php endif; ?>
                    </div>
                    <form method="post" action="guardar_editar_preescolar.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">
                        <div class="input-field">
                            <input type="text" id="nombre" name="nombre" value="<?php echo $alumno['nombre']; ?>" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo $alumno['apellido_paterno']; ?>" required>
                            <label for="apellido_paterno">Apellido paterno</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo $alumno['apellido_materno']; ?>">
                            <label for="apellido_materno">Apellido materno</label>
                        </div>
                        <div class="input-field">
                            <input type="number" id="edad" name="edad" value="<?php echo $alumno['edad']; ?>" required>
                            <label for="edad">Edad</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="curp" name="curp" value="<?php echo $alumno['curp_documento']; ?>" required>
                            <label for="curp">CURP</label>
                            <div class="pdf-buttons">
                                <?php if($alumno['curp_documento']): ?>
                                    <button type="button" class="btn-small red lighten-1" onclick="removeCurpPdf()"><i class="material-icons">delete</i></button>
                                <?php endif; ?>
                                <input type="file" id="curp_pdf" name="curp_pdf" accept="application/pdf" class="hide">
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="certificado_medico">Añadir certificado médico</label>
                            <div class="pdf-buttons">
                                <?php if($alumno['certificado_medico']): ?>
                                    <button type="button" class="btn-small red lighten-1" onclick="removeCertificadoMedico()"><i class="material-icons">delete</i></button>
                                <?php endif; ?>
                                <input type="file" id="certificado_medico" name="certificado_medico" accept="application/pdf" class="hide">
                            </div>
                        </div>
                        <h4 class="text-center">Información del tutor</h4>
                        <div class="input-field">
                            <input type="text" id="nombre_tutor" name="nombre_tutor" value="<?php echo $alumno['tutor_nombre']; ?>" required>
                            <label for="nombre_tutor">Nombre del tutor</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="apellido_paterno_tutor" name="apellido_paterno_tutor" value="<?php echo $alumno['tutor_apellido_paterno']; ?>" required>
                            <label for="apellido_paterno_tutor">Apellido paterno del tutor</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="apellido_materno_tutor" name="apellido_materno_tutor" value="<?php echo $alumno['tutor_apellido_materno']; ?>">
                            <label for="apellido_materno_tutor">Apellido materno del tutor</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="curp_tutor" name="curp_tutor" value="<?php echo $alumno['tutor_curp']; ?>" required>
                            <label for="curp_tutor">CURP del tutor</label>
                            <div class="pdf-buttons">
                                <?php if($alumno['tutor_curp']): ?>
                                    <button type="button" class="btn-small red lighten-1" onclick="removeCurpTutorPdf()"><i class="material-icons">delete</i></button>
                                <?php endif; ?>
                                <input type="file" id="curp_tutor_pdf" name="curp_tutor_pdf" accept="application/pdf" class="hide">
                            </div>
                        </div>
                        <div class="input-field">
                            <input type="text" id="telefono_tutor" name="telefono_tutor" value="<?php echo $alumno['tutor_telefono']; ?>" required>
                            <label for="telefono_tutor">Número de teléfono del tutor</label>
                        </div>
                        <div class="input-field">
                            <input type="text" id="direccion" name="direccion" value="<?php echo $alumno['direccion']; ?>" required>
                            <label for="direccion">Dirección</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import jQuery and MaterializeJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elemsDropdown = document.querySelectorAll('.dropdown-trigger');
            M.Dropdown.init(elemsDropdown, {
                hover: true,
                coverTrigger: false
            });

            var elemsSidenav = document.querySelectorAll('.sidenav');
            M.Sidenav.init(elemsSidenav);

            M.updateTextFields();
        });

        function removeCurpPdf() {
            document.getElementById('curp_pdf').value = "";
            document.getElementById('curp_pdf').classList.remove('hide');
        }

        function removeCertificadoMedico() {
            document.getElementById('certificado_medico').value = "";
            document.getElementById('certificado_medico').classList.remove('hide');
        }

        function removeCurpTutorPdf() {
            document.getElementById('curp_tutor_pdf').value = "";
            document.getElementById('curp_tutor_pdf').classList.remove('hide');
        }
    </script>
</body>
</html>
