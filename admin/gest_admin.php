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

$sql = "SELECT * FROM admin";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row['nombreAdmin'], ' ', $row['apellidoAdmin']; ?> </td>
            <td><?php echo 'Administrador'; ?> </td>
            <td><?php echo $row['estatus_admin']; ?></td>
            <td>
                <a style="text-decoration: none; cursor:pointer;" class="link-dark" 
                onclick="alerta_eliminar(<?php echo $row['idAdmin']; ?>)">
                    <i title="Activar" class="fa-solid fa-circle-check fs-5 me-3"></i>
                </a>
            </td>
            <td>
                <button class="btn btn-dark abrir-modal-editar" 
                        data-id="<?php echo $row['idAdmin']; ?>" 
                        data-nombre="<?php echo $row['nombreAdmin']; ?>" 
                        data-apellido="<?php echo $row['apellidoAdmin']; ?>" 
                        data-estatus="<?php echo $row['estatus_admin']; ?>">
                    Editar Usuario
                </button>
                <a class="btn btn-danger" style="text-decoration: none; cursor:pointer;" onclick="alerta_eliminarAdmin(<?php echo $row['idAdmin']; ?>)">
                    Eliminar
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No hay administradores inactivos</td></tr>";
}
?>

<!-- Modal -->
<div class="modal fade" id="modalEditarAdmin" tabindex="-1" aria-labelledby="modalEditarAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarAdmin" method="post" action="editar_admin.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarAdminLabel">Editar Administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idAdmin" name="idAdmin">
                    <div class="mb-3">
                        <label for="nombreAdmin" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreAdmin" name="nombreAdmin" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidoAdmin" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellidoAdmin" name="apellidoAdmin" required>
                    </div>
                    <div class="mb-3">
                        <label for="estatusAdmin" class="form-label">Estatus</label>
                        <select class="form-select" id="estatusAdmin" name="estatusAdmin" required>
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
        const estatus = button.getAttribute('data-estatus');

        document.getElementById('idAdmin').value = id;
        document.getElementById('nombreAdmin').value = nombre;
        document.getElementById('apellidoAdmin').value = apellido;
        document.getElementById('estatusAdmin').value = estatus;

        const modal = new bootstrap.Modal(document.getElementById('modalEditarAdmin'));
        modal.show();
    });
});
</script>
