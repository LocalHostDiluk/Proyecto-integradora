const container = document.querySelector(".container");
const btnSignIn = document.getElementById("btn-sign-in");
const btnSignUp = document.getElementById("btn-sign-up");

btnSignIn.addEventListener("click",()=>{
   container.classList.remove("toggle");
});
btnSignUp.addEventListener("click",()=>{
   container.classList.add("toggle");
});
document.getElementById("btn-sign-up").addEventListener("click", function () {
    // Obtener los valores de los campos
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Expresión regular para validar que el correo contiene al menos un @
    const emailPattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

    // Validar el correo
    if (!emailPattern.test(email)) {
        alert("Por favor, ingresa un correo electrónico válido.");
        return; // Detener la ejecución si el correo no es válido
    }

    // Validar la longitud de la contraseña
    if (password.length !== 8) {
        alert("La contraseña debe tener exactamente 8 caracteres.");
        return; // Detener la ejecución si la contraseña no cumple con los requisitos
    }

    // Si las validaciones son correctas, redirigir al usuario
    setTimeout(function () {
        window.location.href = "../registro/registro.html";
    }, 500);
});
