// Función para validar el formulario primero se parasa java script para relizarlo correcramente
function validarFormulario() {
    var nombre = document.getElementById('nombre').value.trim();
    var apellidos = document.getElementById('apellidos').value.trim();
    var correo = document.getElementById('correo').value.trim();
    var telefono = document.getElementById('no_telefono').value.trim();
    var estado_c = document.getElementById('estado_c').value.trim();
    var municipio_c = document.getElementById('municipio_c').value.trim();
    var colonia_c = document.getElementById('colonia_c').value.trim();
    var calle_c = document.getElementById('calle_c').value.trim();
    var no_calle_c = document.getElementById('no_calle_c').value.trim();
    var estado_e = document.getElementById('estado_e').value.trim();
    var municipio_e = document.getElementById('municipio_e').value.trim();
    var colonia_e = document.getElementById('colonia_e').value.trim();
    var calle_e = document.getElementById('calle_e').value.trim();
    var no_calle_e = document.getElementById('no_calle_e').value.trim();
    var fecha_evento = document.getElementById('fecha_evento').value.trim();
    var hora_evento = document.getElementById('hora_evento').value.trim();
    var hora_entrega = document.getElementById('hora_entrega').value.trim();
    var fecha_devolucion = document.getElementById('fecha_devolucion').value.trim();
    var hora_devolucion = document.getElementById('hora_devolucion').value.trim();
    var total = document.getElementById('total').value.trim();

    // Validación básica para campos obligatorios
    if (nombre === '' || apellidos === '' || correo === '' || telefono === '' ||
        estado_c === '' || municipio_c === '' || colonia_c === '' || calle_c === '' || no_calle_c === '' ||
        estado_e === '' || municipio_e === '' || colonia_e === '' || calle_e === '' || no_calle_e === '' ||
        fecha_evento === '' || hora_evento === '' || hora_entrega === '' ||
        fecha_devolucion === '' || hora_devolucion === '' || total === '') {
        alert('Por favor completa todos los campos.');
        return false;
    }

    // Validación para fechas y horas
    var regexFecha = /^\d{4}-\d{2}-\d{2}$/; // Formato YYYY-MM-DD
    var regexHora = /^\d{2}:\d{2}$/; // Formato HH:MM

    if (!regexFecha.test(fecha_evento)) {
        alert('Fecha del evento no válida. Usa el formato YYYY-MM-DD.');
        return false;
    }

    if (!regexHora.test(hora_evento)) {
        alert('Hora del evento no válida. Usa el formato HH:MM.');
        return false;
    }

    if (!regexHora.test(hora_entrega)) {
        alert('Hora de entrega no válida. Usa el formato HH:MM.');
        return false;
    }

    if (!regexFecha.test(fecha_devolucion)) {
        alert('Fecha de devolución no válida. Usa el formato YYYY-MM-DD.');
        return false;
    }

    if (!regexHora.test(hora_devolucion)) {
        alert('Hora de devolución no válida. Usa el formato HH:MM.');
        return false;
    }

    return true; //Envía el formulario si todas las validaciones pasan
}

//Función para copiar el domicilio de correspondencia al domicilio del evento
function copiarDomicilio() {
    const calle_c = document.getElementById('calle_c');
    const no_calle_c = document.getElementById('no_calle_c');
    const estado_c = document.getElementById('estado_c');
    const municipio_c = document.getElementById('municipio_c');
    const colonia_c = document.getElementById('colonia_c');

    document.getElementById('estado_e').value = estado_c.value;
    document.getElementById('municipio_e').value = municipio_c.value;
    document.getElementById('colonia_e').value = colonia_c.value;
    document.getElementById('calle_e').value = calle_c.value;
    document.getElementById('no_calle_e').value = no_calle_c.value;
}
