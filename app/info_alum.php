<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<?php
    if (empty($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit();
    } else if ($_SESSION["rol"] != "Tutor") {
        header("Location: ../admin/inicio.php");
        exit();
    }
    include '../conexion.php';
    $idAlumno = $row['idAlumno'];
    $sql = "SELECT * FROM alumno WHERE idAlumno = '$idAlumno'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
<div class="modal fade" id="modalinfo<?php echo $row['idAlumno'] ?>" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informacion completa del alumno</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container d-flex justify-content-center">
                        <div style="margin-right: 15px;" class="row mb-3">
                            <div class="col mb-3">
                                <label style="font-weight: bold;" class="form-label">Nombre:</label><br>
                                <?php echo $row['nombreAlumno']?>
                            </div>
                            <div class="col mb-3">
                                <label style="font-weight: bold;" class="form-label">Apellido:</label><br>
                                <?php echo $row['apellidoAlumno']?>
                            </div>
                            <div class="col mb-3">
                                <label style="font-weight: bold;" class="form-label">Estatus:</label><br>
                                <?php echo $row['estatus_alumno']?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col mb-3">
                                <label style="font-weight: bold;" class="form-label">Descripción:</label><br>
                                <?php echo $row['descripcionAlumno']?>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</html>