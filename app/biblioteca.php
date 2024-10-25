<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                <span></span>
            </div>
            <button class="boton">
                <ion-icon name="add-outline"></ion-icon>
                <span>Create reporte</span>
            </button>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a href="index.php">
                        <ion-icon title="Reportes" name="document-text-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a href="calif.php">
                        <ion-icon title="Calificaciones" name="clipboard-outline"></ion-icon>
                        <span>Calificaciones</span>
                    </a>
                </li>
                <li>
                    <a href="grupo.php">
                        <ion-icon title="Grupos" name="grid-outline"></ion-icon>
                        <span>Grupo</span>
                    </a>
                </li>
                <li>
                    <a id="inbox" href="#">
                        <ion-icon title="Biblioteca Virtual" name="book-outline"></ion-icon>
                        <span>Bilbioteca Virtual</span>
                    </a>
                </li>
                <li>
                    <a href="../controlador_cerrar.php">
                        <ion-icon title="Cerrar sesión" name="log-out-outline"></ion-icon>
                        <span>Cerrar Sesion</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Modo Oscuro</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">
                            
                        </div>
                    </div>
                </div>
            </div>
    
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
                            Rol: 
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
        <div class="gallery">
            <div class="image">
                <a href="LINK_AQUI_1" target="_blank">
                    <img src="image/imagen1.jfif" alt="Imagen 1">
                </a>
            </div>
            <div class="image">
                <a href="LINK_AQUI_2">
                    <img src="image/imagen1.jfif" alt="Imagen 2">
                </a>
            </div>
            <div class="image">
                <a target="_blank" href="https://iapptitudes.com/?gad_source=1&gclid=Cj0KCQjw4Oe4BhCcARIsADQ0cskBbPxE0pf9ux2oWLjvSxqghYuICSN-0c4IIU3LRg8Cl_TTGWD9e4saAkBLEALw_wcB">
                    <img src="https://www.elespectador.com/resizer/v2/ORPMXKF6Z5DOZCCWF22IP5NVWI.png?auth=ab9dc8b235e768091e588c7c39993d375eb3ed9765ca664fe9075d8230ca0704&width=920&height=613&smart=true&quality=60" alt="Imagen 3">
                    <h3>holi</h3>
                </a>
            </div>
            <div class="image">
                <a  href="LINK_AQUI_4" target="_blank">
                    <img src="image/imagen1.jfif" alt="Imagen 4">
                </a>
            </div>
            <div class="image">
                <a href="LINK_AQUI_5">
                    <img src="image/imagen1.jfif" alt="Imagen 5">
                </a>
            </div>
            <div class="image">
                <a href="LINK_AQUI_6">
                    <img src="image/imagen1.jfif" alt="Imagen 6">
                </a>
            </div>
            <div class="image">
                <a href="LINK_AQUI_7">
                    <img src="image/imagen1.jfif" alt="Imagen 7">
                </a>
            </div>
            <div class="image">
                <a href="LINK_AQUI_8">
                    <img src="image/imagen1.jfif" alt="Imagen 8">
                </a>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>