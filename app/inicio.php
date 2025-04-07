<?php
    session_start();
    if (empty($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit();
    } else if ($_SESSION["rol"] != "Tutor") {
        header("Location: ../admin/inicio.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/inicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Panel de Administración</title>
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
                    <a class="seccion" id="inbox" href="inicio.php">
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
                    <a class="seccion" href="calif.php">
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

<div class="container">
        <!-- Título del panel -->
        <div class="title">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Usuario'); ?> 👋</h1>
            <p>Aquí puedes gestionar y visualizar toda la información del sistema de manera eficiente.</p>
        </div>

        <!-- Tarjetas -->
        <div class="cards">
            <!-- Primera fila -->
            <div class="card">
                <div class="card-icon">📋</div>
                <h3>Reportes</h3>
                <p>Consulta y descarga reportes académicos de forma rápida.</p>
                <button onclick="window.location.href='index.php'">Ir a Reportes</button>
            </div>
            <div class="card">
                <div class="card-icon">👥</div>
                <h3>Grupos</h3>
                <p>Administra y organiza los grupos escolares de manera sencilla.</p>
                <button onclick="window.location.href='calif.php'">Gestionar Grupos</button>
            </div>
            <div class="card">
                <div class="card-icon">🎓</div>
                <h3>Alumnos</h3>
                <p>Consulta, edita y organiza la información de los estudiantes.</p>
                <button onclick="window.location.href='grupo.php'">Ver Alumnos</button>
            </div>
        </div>

        <!-- Segunda fila (centrada) -->
        <div class="cards" style="margin-top: 15px;">
            <div class="card">
                <div class="card-icon">📚</div>
                <h3>Biblioteca Virtual</h3>
                <p>Accede a recursos digitales y materiales para los estudiantes.</p>
                <button onclick="window.location.href='biblioteca.php'">Explorar Biblioteca</button>
            </div>
            <div class="card">
                <div class="card-icon">🚪</div>
                <h3>Cerrar Sesión</h3>
                <p>Sal del sistema de manera segura.</p>
                <button onclick="window.location.href='../controlador_cerrar.php'">Cerrar Sesión</button>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <script>
        // Script para cerrar el modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('modal-perfil');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
