<?php
session_start();
include "../conexion.php";
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Administrador") {
    header("Location: ../app/index.php");
    exit();
}

$sql = "SELECT u.idUsuario, t.nombreTutor, t.apellidoTutor, t.telefonoTutor, t.direccionTutor, u.correoUsuario, u.rol, u.estatus_usuario FROM tutor t INNER JOIN usuario u ON t.idTutor = u.idTutor AND u.rol = 'Tutor'";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row['nombreTutor'], ' ', $row['apellidoTutor']; ?></td>
            <td><?php echo $row['rol']; ?></td>
            <td><?php echo $row['estatus_usuario']; ?></td>
            <td><?php echo $row['correoUsuario']; ?></td>
            <td>
                <button class="btn btn-dark abrir-modal-editar" data-id="<?php echo $row['idUsuario']; ?>" data-nombre="<?php echo $row['nombreTutor']; ?>" data-apellido="<?php echo $row['apellidoTutor']; ?>" data-correo="<?php echo $row['correoUsuario']; ?>" data-rol="<?php echo $row['rol']; ?>" data-estatus="<?php echo $row['estatus_usuario']; ?>">
                    Editar Usuario
                </button>
                <a class="btn btn-danger" style="text-decoration: none; cursor:pointer;" onclick="alerta_eliminar(<?php echo $row['idUsuario']; ?>)">
                    Eliminar
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No hay alumnos inactivos</td></tr>";
}
?>

<!-- Modal -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarUsuario" method="post" action="editar_usuario.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idUsuario" name="idUsuario">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Tutor">Tutor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus</label>
                        <select class="form-select" id="estatus" name="estatus" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.abrir-modal-editar').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const apellido = button.getAttribute('data-apellido');
        const correo = button.getAttribute('data-correo');
        const rol = button.getAttribute('data-rol');
        const estatus = button.getAttribute('data-estatus');

        document.getElementById('idUsuario').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('apellido').value = apellido;
        document.getElementById('correo').value = correo;
        document.getElementById('rol').value = rol;
        document.getElementById('estatus').value = estatus;

        const modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
        modal.show();
    });
});
</script>
