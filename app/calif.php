<?php
include "../conexion.php"; // Asegúrate de tener bien configurada tu conexión

session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Tutor") {
    header("Location: ../admin/inicio.php");
    exit();
}

// Inicializa las variables de filtro
$filtro_grado = "";
$filtro_tutor = "";
$filtro_ciclo = "";

// Verifica si se enviaron filtros desde el formulario
if (isset($_POST['grado_grupo'])) {
    $filtro_grado = htmlspecialchars($_POST['grado_grupo']);
}
if (isset($_POST['idTutor'])) {
    $filtro_tutor = htmlspecialchars($_POST['idTutor']);
}
if (isset($_POST['ciclo_escolar'])) {
    $filtro_ciclo = htmlspecialchars($_POST['ciclo_escolar']);
}

// Construye la consulta SQL dinámica
$sql = "SELECT grupo.grado_grupo, grupo.ciclo_escolar, tutor.nombreTutor AS nombre_tutor 
        FROM grupo 
        LEFT JOIN tutor ON grupo.idTutor = tutor.idTutor 
        WHERE 1=1";

if (!empty($filtro_grado)) {
    $sql .= " AND grupo.grado_grupo = ?";
}
if (!empty($filtro_tutor)) {
    $sql .= " AND grupo.idTutor = ?";
}
if (!empty($filtro_ciclo)) {
    $sql .= " AND grupo.ciclo_escolar = ?";
}

// Preparar la consulta
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Define parámetros dinámicos
$params = [];
$param_types = "";

if (!empty($filtro_grado)) {
    $param_types .= "s";
    $params[] = $filtro_grado;
}
if (!empty($filtro_tutor)) {
    $param_types .= "i";
    $params[] = $filtro_tutor;
}
if (!empty($filtro_ciclo)) {
    $param_types .= "s";
    $params[] = $filtro_ciclo;
}

// Vincula los parámetros dinámicamente
if (!empty($params)) {
    $ref_params = [];
    foreach ($params as $key => $value) {
        $ref_params[$key] = &$params[$key];
    }
    array_unshift($ref_params, $param_types); // Agrega los tipos al inicio
    call_user_func_array([$stmt, 'bind_param'], $ref_params);
}

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();

// Obtener valores únicos para los selects dinámicos
$grados_grupos = $conn->query("SELECT DISTINCT grado_grupo FROM grupo")->fetch_all(MYSQLI_ASSOC);
$ciclos_escolares = $conn->query("SELECT DISTINCT ciclo_escolar FROM grupo")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro de Grupos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/biblio.css">
    <style>
        main {
            margin-left: 270px;
            padding: 20px;
        }
        .btn-primary {
            background-color: #4eb7f5;
            border: none;
        }
        .table thead {
            background-color: #4eb7f5;
            color: white;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    
<div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="menu-outline"></ion-icon>
                <span>Esc. Sec 4</span>
            </div>
        </div>
        
        <nav class="navegacion">
            <ul>
                <li>
                    <a class="seccion" href="inicio.php">
                        <ion-icon title="Inicio" name="clipboard-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a class="seccion"  href="index.php">
                        <ion-icon title="Calificaciones" name="clipboard-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" id="inbox" href="calif.php">
                        <ion-icon title="Reportes" name="document-text-outline"></ion-icon>
                        <span>Filtrado de Grupos</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="grupo.php">
                        <ion-icon title="Grupos" name="grid-outline"></ion-icon>
                        <span>Alumnos</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="biblioteca.php">
                        <ion-icon title="Biblioteca Virtual" name="book-outline"></ion-icon>
                        <span>Bilbioteca Virtual</span>
                    </a>
                </li>
                <li>
                    <div class="boton-modal" >
                        <label for="btn-modal">
                            <ion-icon title="Cerrar sesión" name="log-out-outline"></ion-icon>
                            <span>Cerrar Sesion</span>
                        </label>
                    </div>
                    <input type="checkbox" id="btn-modal">
                    <div class="container-modal">
                        <div class="content-modal">
                            <h2>¡ALERTA!</h2>
                            <p>¿Estás seguro de cerrar sesión?</p>
                            <div class="btn">
                                <a class="btn btn-success" href="../controlador_cerrar.php">Cerrar sesión</a>
                                <label class="btn btn-danger" for="btn-modal">Cancelar</label>
                            </div>
                        </div>
                        <label for="btn-modal" class="cerrar-modal"></label>
                    </div>
                    
                </li>
            </ul>
        </nav>
        
        <div>
            <div class="linea"></div>

            <div class="usuario-contenido">
    <div class="imagen-perfil" onclick="document.getElementById('modal-perfil').style.display='flex'">
        <img src="ruta/de/imagen/perfil/<?php echo $_SESSION['imagenPerfil'] ?? 'default.png'; ?>" alt="Imagen de Perfil">
    </div>
    <div class="usuario">
        <div class="info-usuario">
            <div class="nombre-email">
                <span class="nombre">
                    Usuario: <?php echo $_SESSION["correoUsuario"]; ?>
                </span>
                <span class="email">
                    <?php echo $_SESSION["rol"]; ?>
                </span>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>

    <!-- Modal para actualizar perfil -->
    <div id="modal-perfil" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modal-perfil').style.display='none'">&times;</span>
            <h2>Actualizar Perfil</h2>
            <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" id="correo" name="correo" value="<?php echo $_SESSION['correoUsuario']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Contraseña</label>
                    <input type="password" id="confirm-password" name="confirm-password">
                </div>
                <div class="form-group">
                    <label for="imagen">Cambiar Imagen de Perfil</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <main>
        <h1 class="mb-4">Filtro de Grupos</h1>
        <form method="POST" action="" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="grado_grupo" class="form-label">Filtrar por Grado/Grupo:</label>
                <select name="grado_grupo" id="grado_grupo" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($grados_grupos as $grado): ?>
                        <option value="<?= htmlspecialchars($grado['grado_grupo']) ?>" <?= $filtro_grado === $grado['grado_grupo'] ? "selected" : "" ?>>
                            <?= htmlspecialchars($grado['grado_grupo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="ciclo_escolar" class="form-label">Filtrar por Ciclo Escolar:</label>
                <select name="ciclo_escolar" id="ciclo_escolar" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($ciclos_escolares as $ciclo): ?>
                        <option value="<?= htmlspecialchars($ciclo['ciclo_escolar']) ?>" <?= $filtro_ciclo === $ciclo['ciclo_escolar'] ? "selected" : "" ?>>
                            <?= htmlspecialchars($ciclo['ciclo_escolar']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-6">
                <a href="calif.php" class="btn btn-secondary w-100">Limpiar</a>
            </div>
        </form>

        <h2>Resultados</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Grado/Grupo</th>
                    <th>Ciclo Escolar</th>
                    <th>Nombre del Tutor</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['grado_grupo']) ?></td>
                            <td><?= htmlspecialchars($fila['ciclo_escolar']) ?></td>
                            <td><?= htmlspecialchars($fila['nombre_tutor']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <script>

</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>
</body>
</html>