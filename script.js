var nombre = document.getElementById('nombre');
var apellidoP = document.getElementById('apellidoP');
var apellidoM = document.getElementById('apellidoM');
var correo = document.getElementById('correo');
var pass = document.getElementById('pass');


const boton = document.getElementById('registro');
boton.addEventListener('click', () => {
    val();
});

function val() {
    if (nombre.value === "" || apellidoP.value === "" || apellidoM.value === "" || correo.value === "" || pass.value === "") {
        return alert("Todos los campos son obligatorios");
    }
    
    // Expresión regular para validar el formato del correo electrónico
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(correo.value)) {
        return alert("El formato del correo electrónico es inválido");
    }
    
    // Aquí realizarías la consulta a la base de datos para verificar si el correo ya existe
    // Suponiendo que tienes una función 'existeCorreo' que devuelve true si el correo existe
    if (existeCorreo(correo.value)) {
        return alert("El correo electrónico ya está registrado");
    }

    // Si todas las validaciones pasan, puedes continuar con el registro
    alert("Datos válidos. ¡Registro exitoso!");

}

function existeCorreo(correo) {
    // Simulación de consulta a la base de datos
    const correosRegistrados = ['ejemplo@correo.com', 'otro@correo.com']; // Reemplaza con tus datos reales
    return correosRegistrados.includes(correo);
}