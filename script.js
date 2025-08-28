// Esperar a que cargue el DOM
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-cotizacion");

  if (form) {
    form.addEventListener("submit", function (event) {
      let productos = document.querySelectorAll('input[name="productos[]"]:checked');
      let valido = true;

      if (productos.length === 0) {
        alert("⚠️ Debes seleccionar al menos un producto para cotizar.");
        valido = false;
      } else {
        productos.forEach((prod) => {
          let cantidadInput = document.querySelector(
            `input[name="cantidades[${prod.value}]"]`
          );
          if (cantidadInput && cantidadInput.value <= 0) {
            alert(`⚠️ Debes ingresar una cantidad válida para ${prod.value}.`);
            valido = false;
          }
        });
      }

      if (!valido) {
        event.preventDefault(); // Evita que se envíe el formulario
      }
    });
  }
});
