/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Versión específica .ready para Multiple Choice
 * @author Javier Castro Fernandez
 */
$(document).ready(function(){
    
    var text='#botonFoto';
    var button = $(text), interval;
    var id='#idFoto';
    var nombre = $(id).val();
	
    new AjaxUpload(button,{
        action: 'procesa_imagenes_ejercicios.php?nombre='+nombre,
        name: 'image',
        autoSubmit: true,
        onSubmit : function(file, ext){
            
	        // cambiar el texto del boton cuando se selecicione la imagen
            button.text('Subiendo');
            // desabilitar el boton
            this.disable();

            interval = window.setInterval(function(){
                var text = button.text();
                if (text.length < 11){
                    button.text(text + '.');
                } else {
                    button.text('Subiendo');
                }
            }, 200);
        },
        onComplete: function(file, response){
			button.text('Cambiar Foto');

			window.clearInterval(interval);

			// Habilitar boton otra vez
			this.enable();
			
			$('#fotoAsociada').attr('src', response);
		}
    });
});