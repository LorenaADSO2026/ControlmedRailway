// Validación en el cliente antes de enviar el formulario al servidor (Laravel)
const usuario = document.getElementById("usuario");
const clave = document.getElementById("clave");
const formulario = document.getElementById("loginForm");

formulario.addEventListener("submit", function (event) {

    if (usuario.value.trim() === "" || clave.value.trim() === "") {
        event.preventDefault();
        alert("Por favor complete todos los campos");
    }
    // Si los campos están completos, el formulario se envía normalmente
    // por POST a /login, donde Laravel valida usuario y contraseña
    // contra la base de datos y crea la sesión.
});

// Mostrar/ocultar contraseña con el ícono del ojo
const ojo = document.querySelector(".input-group .fa-eye");
if (ojo) {
    ojo.addEventListener("click", function () {
        clave.type = clave.type === "password" ? "text" : "password";
        ojo.classList.toggle("fa-eye-slash");
    });
}
