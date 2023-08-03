/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/
// Este script comienza a ejecutarse una vez que se ha cargado todo el documento HTML
$(document).ready(function() {

    // Definición de la función para validar el formato de un RUT
    function validarRUT(rut) {
        // Se eliminan los puntos y el guion del RUT
        var valor = rut.replace('.', '');
        valor = valor.replace('-', '');

        // Se separa el RUT en cuerpo y dígito verificador
        cuerpo = valor.slice(0, -1);
        dv = valor.slice(-1).toUpperCase();

        rut = cuerpo + '-' + dv;

        // Se verifica que el cuerpo del RUT tenga al menos 7 dígitos
        if (cuerpo.length < 7) { return false; }

        // Inicialización de variables para el cálculo del dígito verificador
        suma = 0;
        multiplo = 2;

        // Se recorre el RUT de atrás hacia adelante para calcular la suma necesaria para el dígito verificador
        for (i = 1; i <= cuerpo.length; i++) {
            // Se multiplica cada dígito por un múltiplo y se suma al total
            index = multiplo * valor.charAt(cuerpo.length - i);
            suma = suma + index;

            // El múltiplo aumenta de 2 a 7 y luego vuelve a 2
            if (multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
        }

        // Se calcula el dígito verificador esperado
        dvEsperado = 11 - (suma % 11);

        // Se convierte el dígito verificador a su representación numérica, donde K es 10 y 0 es 11
        dv = (dv == 'K') ? 10 : dv;
        dv = (dv == 0) ? 11 : dv;

        // Se compara el dígito verificador calculado con el ingresado. Si no coinciden, el RUT es inválido
        if (dvEsperado != dv) { return false; }

        // Si todas las validaciones pasan, el RUT es válido
        return true;
    }

    // Se activa cuando el campo de texto del RUT pierde el foco
    $('#rut').blur(function() {
        // Se obtiene el valor ingresado en el campo RUT
        var rut = $(this).val();

        // Se validan las distintas condiciones del RUT
        if (rut === '') {  // El RUT no puede estar vacío
            alert("Por favor, no dejes el campo RUT en blanco.");
            return false;
        } else if (!validarRUT(rut)) {  // El RUT debe tener un formato válido
            alert("Por favor, introduce un RUT válido");
            return false;
        } else {  // El RUT no puede haber votado antes
            // Se hace una solicitud AJAX al servidor para verificar si el RUT ya ha votado
            $.ajax({
                url: 'php/validaciones.php',
                method: 'POST',
                data: {action: 'check_rut', rut: rut},
                success: function(data) {
                    // Se procesa la respuesta del servidor
                    var response = JSON.parse(data);
                    // Si el RUT ya ha votado, se muestra un mensaje de error y se limpia el campo RUT
                    if (response.exists) {
                        alert('Este RUT ya ha votado.');
                        $('#rut').val('');
                        return false;
                    }
                }
            });
        }
    });

    // Se activa cuando se envía el formulario de votación
    $('#votingForm').submit(function(e) {
        // Se evita el comportamiento predeterminado de envío del formulario
        e.preventDefault();

        // Se definen los campos que deben ser validados
        var campos = ['nombre_apellido', 'alias', 'rut', 'email', 'region', 'provincia', 'comuna', 'candidato', 'notificado_por'];

        // Se verifica que ninguno de los campos esté vacío
        for (var i = 0; i < campos.length; i++) {
            var campo = campos[i];
            var valor = $('#' + campo).val();
            if (valor === '' || valor === null) {
                alert('Por favor, no dejes el campo ' + campo + ' vacío.');
                return false;
            }
        }

        // Se validan condiciones específicas de cada campo
        // Validación del campo nombre y apellido
        if ($("#nombre_apellido").val() === '') {
            alert("Por favor, introduce tu nombre y apellido");
            return false;
        }

        // Validación del campo alias
        var alias = $("#alias").val();
        // El alias debe tener más de 5 caracteres y contener al menos una letra y un número
        if (alias.length <= 5 || !(/[a-zA-Z]/.test(alias) && /[0-9]/.test(alias))) {
            alert("El alias debe tener más de 5 caracteres y contener al menos una letra y un número");
            return false;
        }

        // Validación del campo email
        var email = $("#email").val();
        // Se utiliza una expresión regular para validar el formato del email
        var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
        if (!emailRegex.test(email)) {
            alert("Por favor, introduce un email válido");
            return false;
        }

        // Validación de las casillas de verificación
        var checkboxes = $('input[type="checkbox"]:checked');
        // Deben estar seleccionadas al menos dos opciones
        if (checkboxes.length < 2) {
            alert("Debes seleccionar al menos dos opciones en 'Cómo se enteró de nosotros'");
            return false;
        }

        // Si todas las validaciones pasan, se procede a enviar el formulario

        // Se recolectan los datos del formulario
        var formData = $(this).serialize();
        // Se añaden campos adicionales a los datos del formulario
        formData += '&action=submit_vote';
        formData += '&id_rg=' + $('#region').val();
        formData += '&id_pr=' + $('#provincia').val();
        formData += '&id_co=' + $('#comuna').val();

        // Se hace una solicitud AJAX al servidor para enviar el voto
        $.ajax({
            url: 'php/validaciones.php',
            method: 'POST',
            data: formData,
            success: function(data) {
                // Se procesa la respuesta del servidor
                if (JSON.parse(data).success) {
                    alert('Tu voto ha sido registrado.');
                    // Se limpian todos los campos después de un envío exitoso
                    var campos = ['nombre_apellido', 'alias', 'rut', 'email', 'region', 'provincia', 'comuna', 'candidato', 'notificado_por'];
                    for (var i = 0; i < campos.length; i++) {
                        $('#' + campos[i]).val('');
                    }
                    // Se desmarcan todas las casillas de verificación
                    $('input[type="checkbox"]').prop('checked', false);
                } else {
                    // Si hubo algún error en el servidor, se muestra un mensaje de error
                    alert('Hubo un error. Por favor intenta nuevamente.');
                }
            }
        });
    });

    // Se cargan las provincias correspondientes cuando se selecciona una región
    $('#region').change(function() {
        var regionId = $(this).val();
        $.ajax({
            url: 'php/validaciones.php',
            method: 'POST',
            data: {
                action: 'get_provincias',
                id: regionId
            },
            dataType: 'json',
            success: function(data) {
                var provinciaSelect = $('#provincia');
                provinciaSelect.empty();
                $.each(data, function(i, provincia) {
                    provinciaSelect.append($('<option>', {
                        value: provincia.id_pr,
                        text : provincia.str_descripcion
                    }));
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    });

    // Se cargan las regiones al cargar la página
    $.ajax({
        url: 'php/validaciones.php',
        type: 'POST',
        data: {action: 'get_regiones'},
        success: function(data) {
            var regionSelect = $('#region');
            $.each(JSON.parse(data), function(i, region) {
                regionSelect.append($('<option>', {
                    value: region.id_rg,
                    text : region.str_descripcion
                }));
            });
        }
    });

    // Se cargan las comunas correspondientes cuando se selecciona una provincia
    $('#provincia').change(function() {
        var provinciaId = $(this).val();
        $.ajax({
            url: 'php/validaciones.php',
            method: 'POST',
            data: {
                action: 'get_comunas',
                id: provinciaId
            },
            success: function(data) {
                var comunaSelect = $('#comuna');
                comunaSelect.empty();
                $.each(JSON.parse(data), function(i, comuna) {
                    comunaSelect.append($('<option>', {
                        value: comuna.id_co,
                        text : comuna.str_descripcion
                    }));
                });
            }
        });
    });

    // Se cargan los candidatos al cargar la página
    $.ajax({
        url: 'php/validaciones.php',
        type: 'POST',
        data: {action: 'get_candidatos'},
        success: function(data) {
            var candidatoSelect = $('#candidato');
            $.each(JSON.parse(data), function(i, candidato) {
                candidatoSelect.append($('<option>', {
                    value: candidato.id,
                    text : candidato.nombre
                }));
            });
        }
    });
});
