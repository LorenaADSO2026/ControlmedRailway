window.addEventListener("load", function () {
    alert("Revisar las alertas del sistema CONTROLMED");
});

let filas = document.querySelectorAll("tbody tr");
let totalAlertas = filas.length;

console.log("Total de alertas:", totalAlertas);
