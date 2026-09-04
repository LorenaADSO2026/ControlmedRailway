const formulario = document.getElementById("registroForm");

formulario.addEventListener("submit", function (event) {

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const cedula = document.getElementById("cedula").value.trim();
    const rol = document.getElementById("rol_id").value;
    const fecha = document.getElementById("fecha").value;
    const usuario = document.getElementById("usuario").value.trim();
    const clave = document.getElementById("clave").value;

    if (nombre === "" || apellido === "" || cedula === "" || rol === "" || fecha === "" || usuario === "" || clave === "") {
        event.preventDefault();
        alert("Por favor complete todos los campos");
        return;
    }

    if (!/^[0-9]+$/.test(cedula)) {
        event.preventDefault();
        alert("La cédula solo debe contener números");
        return;
    }

    if (clave.length < 6) {
        event.preventDefault();
        alert("La contraseña debe tener al menos 6 caracteres");
        return;
    }

    // Si todo es válido, el formulario se envía a /registro (Laravel)
    // que vuelve a validar y guarda el usuario en la base de datos.
});
