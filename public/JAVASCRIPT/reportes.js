// El filtro por fechas ahora se hace con un formulario GET normal (ver reportes/index.blade.php)
// Aquí solo se arma la URL de exportación con las fechas seleccionadas.

function exportarPDF() {
    let inicio = document.getElementById("fechaInicio").value;
    let fin = document.getElementById("fechaFin").value;

    if (inicio === "" || fin === "") {
        alert("Seleccione un rango de fechas");
        return;
    }

    window.location.href = RUTA_EXPORTAR_PDF + "?fecha_inicio=" + inicio + "&fecha_fin=" + fin;
}

function exportarExcel() {
    let inicio = document.getElementById("fechaInicio").value;
    let fin = document.getElementById("fechaFin").value;

    if (inicio === "" || fin === "") {
        alert("Seleccione un rango de fechas");
        return;
    }

    window.location.href = RUTA_EXPORTAR_EXCEL + "?fecha_inicio=" + inicio + "&fecha_fin=" + fin;
}

// Confirmación al salir del sistema
const salir = document.querySelector(".salir");
if (salir) {
    const formSalir = salir.closest("form");
    if (formSalir) {
        formSalir.addEventListener("submit", function (event) {
            let confirmar = confirm("¿Desea cerrar sesión?");
            if (!confirmar) {
                event.preventDefault();
            }
        });
    }
}
