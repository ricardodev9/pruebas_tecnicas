$(document).ready(function() {
    // Obtener el modal
    var modal = $('#modalAltaUsuario');
    
    // Abrir el modal cuando se haga clic en el botón
    $('#openModalBtn').on('click', function() {
         modal.show();  // Muestra el modal
    });

    $('#closeModalBtn').on('click',function(){
        modal.hide();
    })
    
    //envío de formulario para dar de alta
    $('#formAltaUsuario').submit(function(event) {
        event.preventDefault(); 
        var name = $('#usuarioNombre').val();
        var email = $('#usuarioEmail').val();
        var pass = $('#usuarioPassword').val();

         // Realizar la solicitud AJAX
         $.ajax({
            url: './inc/user.php',  
            type: 'POST',
            data: {
                method : 'add_user',
                name : name,
                email : email,
                pass : pass
            },
            success: function(response) {
                // Procesar la respuesta del servidor
                var data = JSON.parse(response);
                if (data.status  === 'success') {
                    alert('Usuario agregado correctamente');
                    location.reload();  // Recargar la página para ver los cambios
                }else{
                    alert(data.msg);
                }
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error en la solicitud AJAX. Inténtalo de nuevo.');
            }
        });
    })

    // Modal para ver y editar 
    var modalVer = $('#modalVerUsuario');
    $('.openModalVerBtn').on('click', function() {
        modalVer.show();  // Muestra el modal
        var userId = $(this).data('id_user');
         // Hacer una llamada AJAX para obtener los datos del usuario
         $.ajax({
            url: './inc/user.php',  
            type: 'GET',
            data: { 
                id: userId,
                method : 'getUserData'
            },
            success: function(response) {                
                var userData = JSON.parse(response);
                if (userData) {
                    $('#usuarioNombreVer').val(userData.name);
                    $('#usuarioEmailVer').val(userData.email);
                    $('#usuarioId').val(userData.id);
                } else {
                    alert('No se encontraron datos del usuario.');
                }
            },
            error: function(xhr, status, error) {
                alert('Error al cargar los datos del usuario. Inténtalo de nuevo.');
            }
        });
    });

    $('#closeModalVerBtn').on('click', function(){
        modalVer.hide();  
    })

    // Controlar el formulario de editar usuario
    $('#formVerEditarUsuario').submit(function(event) {
        event.preventDefault(); 
        var name = $('#usuarioNombreVer').val();
        var email = $('#usuarioEmailVer').val();
        var pass = $('#usuarioPasswordVer').val();
        var id_user = $('#usuarioId').val();
         // Realizar la solicitud AJAX
         $.ajax({
            url: './inc/user.php',  
            type: 'POST',
            data: {
                method : 'update_user',
                id_user : id_user,
                name : name,
                email : email,
                pass : pass
            },
            success: function(response) {
                // Procesar la respuesta del servidor
                var data = JSON.parse(response);
                if (data.status  == 'success') {
                    alert(data.message);
                    location.reload();  // Recargar la página para ver los cambios
                }else{
                    alert(data.message);
                }
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error en la solicitud AJAX. Inténtalo de nuevo.');
            }
        });
    })


    // Configuración de KonvaJS
    const stage = new Konva.Stage({
        container: 'container_dinA4',
        width: 210 * 3.7795275591, 
        height: 297 * 3.7795275591 
    });

    const layer = new Konva.Layer();
    stage.add(layer);
    const borderColor = 'black'; 
    const borderWidth = 3; 

    const border = new Konva.Rect({
        x: 0,
        y: 20,
        width: 210 * 3.7795275591,  
        height: 297 * 3.7795275591, 
        stroke: borderColor, 
        strokeWidth: borderWidth, 
        listening: false,
    });
    layer.add(border);
    layer.batchDraw();

    // Agregar un texto al escenario al hacer clic en el botón
    $('#addTextBtn').on('click', function() {
        const text = new Konva.Text({
            text: 'Hola, estoy aquí!',
            x: 50,
            y: 50,
            fontSize: 24,
            fontFamily: 'Roboto',
            fill: 'black',
            draggable: true,
        });

        // Al hacer clic en el texto, alternar entre negrita y normal
        text.on('click', function() {
            const currentFontStyle = this.fontStyle();
            this.setAttrs({
                fontStyle: currentFontStyle === 'bold' ? 'normal' : 'bold' // Alternar negrita
            });
            layer.batchDraw();
        });

        layer.add(text);
        layer.batchDraw();
    });

    // Función para descargar el PDF
    $('#downloadPdfBtn').on('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const canvas = stage.toCanvas();
    
        // Convertir el canvas a una imagen base64
        const imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 10, 10, 190, 277); 

        // Descargar el archivo PDF
        doc.save('origami_solutions_konvajs.pdf');
    });

    // Función para descargar el JSON con la configuración
    $('#downloadJsonBtn').on('click', function() {
        const elements = [];

        // Usamos find() para obtener los nodos de texto
        layer.find('Text').forEach((textNode) => {
            elements.push({
                text: textNode.text(),
                x: textNode.x(),
                y: textNode.y(),
                fontSize: textNode.fontSize(),
                fontFamily: textNode.fontFamily(),
                fontStyle: textNode.fontStyle()
            });
        });

        // Crear el archivo JSON
        const json = JSON.stringify(elements, null, 2);
        const blob = new Blob([json], {
            type: 'application/json'
        });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'documento.json';
        link.click();
    });
});