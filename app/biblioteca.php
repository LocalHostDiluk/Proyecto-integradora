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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="estilos/biblio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Estilo para el título "Material Didáctico" */
        .titulo {
            font-family: 'Arial', sans-serif;
            font-size: 3em;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 5px rgba(255, 99, 71, 0.6), -2px -2px 5px rgba(173, 216, 230, 0.6);
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
                    <a class="seccion" href="index.php">
                        <ion-icon title="Calificaciones" name="clipboard-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="calif.php">
                        <ion-icon title="Reportes" name="document-text-outline"></ion-icon>
                        <span> Filtrado de Grupos</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" id="inbox" href="grupo.php">
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

       
    
            <div class="usuario">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">
                            Usuario: 
                            <?php
                            echo $_SESSION["correoUsuario"];
                            ?>
                        </span>
                        <span class="email">
                            <?php
                            echo $_SESSION["rol"];
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <main>
        <div class="titulo">Material Didáctico</div>
        <div class="gallery">
            <div class="image"><img src="image/civica.jpg" alt="Imagen Cívica" 
                 data-title="Formacion civica"
                 data-links='[
                {"name": "Guía Cívica 1", "url": "https://formacioncontinuaedomex.wordpress.com/wp-content/uploads/2012/12/guiadidfcye1.pdf"},
                {"name": "Recursos (civica y ética)", "url": "https://aprendiendocivicayetica.jimdofree.com/formaci%C3%B3n-c%C3%ADvica-y-%C3%A9tica/estrategias-y-recursos-did%C3%A1cticos-fce/"},
                {"name": "Ejercicios Prácticos", "url": "https://wordwall.net/es-mx/community/ejercicios-de-formaci%C3%B3n-civica-y-etica"},
                {"name": "Material visual", "url": "https://youtu.be/7yaj9eUqh88?si=w95mB2SvQxAzOK9t"},
                {"name": "Ejercicios visuales", "url": "https://www.youtube.com/watch?v=6AoYFwd7Elk"}
            ]'></div>
            <div class="image"><img src="image/biologia.jpg" alt="Imagen Biología"
            data-title="Biología"
             data-links='[
                {"name": "Guía Biología 1", "url": "#guia_biologia_1"},
                {"name": "Guía Biología 2", "url": "#guia_biologia_2"},
                {"name": "Actividad Biología", "url": "#actividad_biologia"},
                {"name": "Examen Biología", "url": "#examen_biologia"},
                {"name": "Resumen Biología", "url": "#resumen_biologia"}
            ]'></div>
            <div class="image"><img src="image/inglesz.jpg" alt="Imagen Inglés" 
            data-title="Inglés"
            data-links='[
                {"name": "Guía Inglés 1", "url": "https://www.inglesmundial.com/Guias-de-Ingles.html"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/artes.jpg" alt="Imagen Inglés"
            data-title="Artes"
             data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/historia.jpg" alt="Imagen Inglés"
            data-title="Historia"
             data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/ciencias.jpg" alt="Imagen Inglés" 
            data-title="Ciencias"
            data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/matematicas.jpg" alt="Imagen Inglés"
            data-title="Matemáticas"
             data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/espain.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/tec.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/depo.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/libro.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/geografia.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "#guia_ingles_1"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <div class="image"><img src="image/diccio.jpg" alt="Imagen Inglés" data-links='[
                {"name": "Guía Inglés 1", "url": "https://www.inglesmundial.com/Guias-de-Ingles.html"},
                {"name": "Guía Inglés 2", "url": "#guia_ingles_2"},
                {"name": "Actividad Inglés", "url": "#actividad_ingles"},
                {"name": "Examen Inglés", "url": "#examen_ingles"},
                {"name": "Resumen Inglés", "url": "#resumen_ingles"}
            ]'></div>
            <!-- Completa los enlaces para las imágenes restantes de la misma manera -->
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="modalEnlaces" tabindex="-1" aria-labelledby="modalEnlacesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEnlacesLabel">Enlaces Disponibles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalLinksContainer">
                    <!-- Aquí se agregarán los botones dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.gallery .image img').forEach(image => {
    image.addEventListener('click', () => {
        // Obtén los enlaces y el título específico de la imagen seleccionada
        const links = JSON.parse(image.dataset.links);
        const title = image.dataset.title;

        // Actualiza el título del modal
        const modalTitle = document.getElementById('modalEnlacesLabel');
        modalTitle.textContent = title;

        // Limpia y agrega los botones correspondientes al modal
        const modalBody = document.getElementById('modalLinksContainer');
        modalBody.innerHTML = '';
        links.forEach(link => {
            const button = document.createElement('a');
            button.href = link.url;
            button.textContent = link.name;
            button.className = 'btn btn-primary d-block mb-2';
            button.target = '_blank';
            modalBody.appendChild(button);
        });

        // Muestra el modal
        const modal = new bootstrap.Modal(document.getElementById('modalEnlaces'));
        modal.show();
    });
});
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>
</body>
</html>