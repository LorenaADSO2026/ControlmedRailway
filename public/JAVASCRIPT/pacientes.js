const formPacientes = document.getElementById("formPacientes");

formPacientes.addEventListener("submit", function (event) {

    let nombre = document.getElementById("nombre").value.trim();
    let medicamento = document.getElementById("medicamento").value.trim();
    let fecha = document.getElementById("fecha").value;

    if (nombre === "" || medicamento === "" || fecha === "") {
        event.preventDefault();
        alert("Por favor complete todos los campos");
        return;
    }

    // Validación: el nombre solo debe contener letras y espacios
    if (!/^[A-Za-zÀ-ÿ\s\.]+$/.test(nombre)) {
        event.preventDefault();
        alert("El nombre del paciente solo debe contener letras");
        return;
    }

    // Si todo es correcto, se envía normalmente a Laravel (POST /pacientes)
});
