window.addEventListener("load", function () {
    alert("Bienvenido al sistema CONTROLMED");
});

// Confirmación al cerrar sesión (ahora "Salir" es un botón dentro de un formulario)
const formSalir = document.querySelector(".salir")
    ? document.querySelector(".salir").closest("form")
    : null;

if (formSalir) {
    formSalir.addEventListener("submit", function (event) {
        let confirmar = confirm("¿Desea cerrar sesión?");
        if (!confirmar) {
            event.preventDefault();
        }
    });
}
