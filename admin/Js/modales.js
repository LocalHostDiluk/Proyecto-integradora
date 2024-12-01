
document.addEventListener('DOMContentLoaded', function () {
    const perfilImagen = document.getElementById('perfil-imagen');
    const modal = document.getElementById('modal-ajustar-perfil');
    const cerrarModal = document.getElementById('cerrar-modal');

    perfilImagen.addEventListener('click', function () {
        modal.style.display = 'flex';
    });

    cerrarModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

function openAddModal() {
    Swal.fire({
        title: 'Agregar Tutor',
        html: `
            <form id="addForm">
                <label>Nombre:</label>
                <input type="text" id="addNombre" name="nombre" required oninput="checkAddForm()">
                <label>Apellido:</label>
                <input type="text" id="addApellido" name="apellido" required oninput="checkAddForm()">
                <label>Teléfono:</label>
                <input type="text" id="addTelefono" name="telefono" required oninput="checkAddForm()">
                <label>Dirección:</label>
                <input type="text" id="addDireccion" name="direccion" required oninput="checkAddForm()">
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        didOpen: () => {
            // Deshabilitar el botón "Guardar" al inicio
            const confirmButton = Swal.getConfirmButton();
            confirmButton.disabled = true;

            // Activar la función de validación
            checkAddForm();
        },
        preConfirm: () => {
            const form = document.getElementById('addForm');
            if (form.checkValidity()) {
                return form;
            } else {
                Swal.showValidationMessage('Por favor, completa todos los campos.');
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            form.innerHTML = `
                <input type="hidden" name="agregar_tutor" value="1">
                <input type="hidden" name="nombre" value="${document.getElementById('addNombre').value}">
                <input type="hidden" name="apellido" value="${document.getElementById('addApellido').value}">
                <input type="hidden" name="telefono" value="${document.getElementById('addTelefono').value}">
                <input type="hidden" name="direccion" value="${document.getElementById('addDireccion').value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openAddAdmin() {
    Swal.fire({
        title: 'Agregar Administrador',
        html: `
            <form id="addForm">
                <label>Nombre:</label>
                <input type="text" id="addNombre" name="nombre" required oninput="checkAddForm()">
                <label>Apellido:</label>
                <input type="text" id="addApellido" name="apellido" required oninput="checkAddForm()">
                <label>Teléfono:</label>
                <input type="text" id="addTelefono" name="telefono" required oninput="checkAddForm()">
                <label>Dirección:</label>
                <input type="text" id="addDireccion" name="direccion" required oninput="checkAddForm()">
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        didOpen: () => {
            // Deshabilitar el botón "Guardar" al inicio
            const confirmButton = Swal.getConfirmButton();
            confirmButton.disabled = true;

            // Activar la función de validación
            checkAddForm();
        },
        preConfirm: () => {
            const form = document.getElementById('addForm');
            if (form.checkValidity()) {
                return form;
            } else {
                Swal.showValidationMessage('Por favor, completa todos los campos.');
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            form.innerHTML = `
                <input type="hidden" name="agregar_admin" value="1">
                <input type="hidden" name="nombre" value="${document.getElementById('addNombre').value}">
                <input type="hidden" name="apellido" value="${document.getElementById('addApellido').value}">
                <input type="hidden" name="telefono" value="${document.getElementById('addTelefono').value}">
                <input type="hidden" name="direccion" value="${document.getElementById('addDireccion').value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function checkAddForm() {
    const nombre = document.getElementById('addNombre').value.trim();
    const apellido = document.getElementById('addApellido').value.trim();
    const telefono = document.getElementById('addTelefono').value.trim();
    const direccion = document.getElementById('addDireccion').value.trim();

    const confirmButton = Swal.getConfirmButton();
    confirmButton.disabled = !(nombre && apellido && telefono && direccion);
}


function openEditModal(idTutor, nombreTutor, apellidoTutor, telefonoTutor, direccionTutor) {
    Swal.fire({
        title: 'Editar Tutor',
        html: `
            <form id="editForm">
                <label>Nombre:</label>
                <input type="text" id="editNombre" name="nombre" value="${nombreTutor}" required>
                <label>Apellido:</label>
                <input type="text" id="editApellido" name="apellido" value="${apellidoTutor}" required>
                <label>Teléfono:</label>
                <input type="text" id="editTelefono" name="telefono" value="${telefonoTutor}" required>
                <label>Dirección:</label>
                <input type="text" id="editDireccion" name="direccion" value="${direccionTutor}" required>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const form = document.getElementById('editForm');
            if (form.checkValidity()) {
                return form;
            } else {
                Swal.showValidationMessage('Por favor, completa todos los campos.');
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            form.innerHTML = `
                <input type="hidden" name="editar_tutor" value="1">
                <input type="hidden" name="idTutor" value="${idTutor}">
                <input type="hidden" name="nombre" value="${document.getElementById('editNombre').value}">
                <input type="hidden" name="apellido" value="${document.getElementById('editApellido').value}">
                <input type="hidden" name="telefono" value="${document.getElementById('editTelefono').value}">
                <input type="hidden" name="direccion" value="${document.getElementById('editDireccion').value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}