// Función para capturar datos del formulario y establecer los campos ocultos
function capturarDatos() {
  // Obtener los valores seleccionados por el usuario
  var silla = document.getElementById("silla").value;
  var cantidadSilla = parseInt(document.getElementById("cantidadSilla").value, 10);

  var mesa = document.getElementById("mesa").value;
  var cantidadMesa = parseInt(document.getElementById("cantidadMesa").value, 10);

  var mantel = document.getElementById("mantel").value;
  var colorMantel = document.getElementById("colorMantel").value;
  var cantidadMantel = parseInt(document.getElementById("cantidadMantel").value, 10);

  var carpa = document.getElementById("carpa").value;
  var colorCarpa = document.getElementById("colorCarpa").value;
  var cantidadCarpa = parseInt(document.getElementById("cantidadCarpa").value, 10);

  var inflable = document.getElementById("inflable").value;
  var cantidadInflable = parseInt(document.getElementById("cantidadInflable").value, 10);

  // Validaciones
  if (cantidadSilla <= 0 || isNaN(cantidadSilla)) {
    alert("Por favor ingrese una cantidad válida para las sillas.");
    return false;
  }

  if (cantidadMesa <= 0 || isNaN(cantidadMesa)) {
    alert("Por favor ingrese una cantidad válida para las mesas.");
    return false;
  }

  if (cantidadMantel <= 0 || isNaN(cantidadMantel)) {
    alert("Por favor ingrese una cantidad válida para los manteles.");
    return false;
  }

  if (cantidadCarpa <= 0 || isNaN(cantidadCarpa)) {
    alert("Por favor ingrese una cantidad válida para las carpas.");
    return false;
  }

  if (cantidadInflable <= 0 || isNaN(cantidadInflable)) {
    alert("Por favor ingrese una cantidad válida para los inflables.");
    return false;
  }

  // Establecer valores en campos ocultos si todas las validaciones son exitosas
  document.getElementById("silla_php").value = silla;
  document.getElementById("cantidadSilla_php").value = cantidadSilla;
  document.getElementById("mesa_php").value = mesa;
  document.getElementById("cantidadMesa_php").value = cantidadMesa;
  document.getElementById("mantel_php").value = mantel;
  document.getElementById("colorMantel_php").value = colorMantel;
  document.getElementById("cantidadMantel_php").value = cantidadMantel;
  document.getElementById("carpa_php").value = carpa;
  document.getElementById("colorCarpa_php").value = colorCarpa;
  document.getElementById("cantidadCarpa_php").value = cantidadCarpa;
  document.getElementById("inflable_php").value = inflable;
  document.getElementById("cantidadInflable_php").value = cantidadInflable;

  return true; // Retorna true si se establecieron correctamente los campos ocultos
}

// Función para retroceder o ir atrás en el formulario
function irAtras() {
  window.history.back();
}
