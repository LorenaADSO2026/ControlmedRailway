const formInventario = document.getElementById("formInventario");

formInventario.addEventListener("submit", function (event) {

    let nombre = document.getElementById("nombre").value.trim();
    let codigo = document.getElementById("codigo").value.trim();
    let lote = document.getElementById("lote").value.trim();
    let fecha = document.getElementById("fecha").value;
    let cantidad = document.getElementById("cantidad").value;

    // Validación de campos obligatorios
    if (nombre === "" || codigo === "" || lote === "" || fecha === "" || cantidad === "") {
        event.preventDefault();
        alert("Por favor complete todos los campos");
        return;
    }

    // Validación: el código solo debe contener números
    if (!/^[0-9]+$/.test(codigo)) {
        event.preventDefault();
        alert("El código solo debe contener números");
        return;
    }

    // Validación: la cantidad no puede ser negativa
    if (parseInt(cantidad) < 0) {
        event.preventDefault();
        alert("La cantidad no puede ser negativa");
        return;
    }

    // Validación: el lote no debe tener caracteres especiales
    if (!/^[A-Za-z0-9\-]+$/.test(lote)) {
        event.preventDefault();
        alert("El lote solo admite letras, números y guiones");
        return;
    }

    // Si todo es correcto, el formulario se envía normalmente a Laravel (POST /inventario)
});
