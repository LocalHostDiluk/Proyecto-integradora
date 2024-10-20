const container = document.querySelector(".container");
const btnSignIn = document.getElementById("btn-sign-in");
const btnSignUp = document.getElementById("btn-sign-up");

btnSignIn.addEventListener("click",()=>{
    container.classList.remove("toggle");
});

btnSignUp.addEventListener("click",()=>{
    container.classList.add("toggle");
});

function signIn() {
    let email = document.getElementById("correolog").value;
    let password = document.getElementById("passlog").value;
    const emailPattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

    if (email === "" || password === "") {
        alert("Por favor, ingresa tu correo y contraseña.");
        return;
    } else if (!emailPattern.test(email)) {
        alert("Por favor, ingresa un correo electrónico válido.");
        return;
    } else if (password.length < 8) {
        alert("La contraseña debe tener mínimo 8 caracteres.");
        return;
    }
    else{
        alert("¡Bienvenido!");
        window.location.replace("/app/index.html");
    }
}

function registro(){
    let email = document.getElementById("correoreg").value;
    let password = document.getElementById("passreg").value;
    let nombre = document.getElementById("nombrereg").value;
    const emailPattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

    if (email === "" || password === "" || nombre === "") {
        alert("Por favor, ingresa los campos.");
        return;
    } else if (!emailPattern.test(email)) {
        alert("Por favor, ingresa un correo electrónico válido.");
        return;
    } else if (password.length < 8) {
        alert("La contraseña debe tener mínimo 8 caracteres.");
        return;
    }
}