/*
 * Versión específica .ready para Multiple Choice
 * @author Javier Castro Fernandez, Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */
$(document).ready(function() {

    var text = '#botonFoto';
    var button = $(text), interval;

    new AjaxUpload(button, {
        action: 'procesa_imagenes_ejercicios.php',
        name: 'image',
        autoSubmit: true,
        onSubmit: function(file, ext) {
            // cambiar el texto del boton cuando se selecicione la imagen
            button.text('Subiendo');
            // desabilitar el boton
            this.disable();

//            console.log(file);
//            console.log(ext);
            interval = window.setInterval(function() {
                var text = button.text();
                if (text.length < 11) {
                    button.text(text + '.');
                } else {
                    button.text('Subiendo');
                }
            }, 200);
        },
        onComplete: function(file, response) {
            button.text('Cambiar Foto');
            // Habilitar boton otra vez	
            this.enable();
            window.clearInterval(interval);
            console.log($('#fotoAsociada').attr('src'));
            //La variable d es para resolver un problema de mozilla, que ocurre por que la url de la imagen
            //no cambia cuando se suben varias fotos seguidas, al no cambiar la url creo que mozilla piensa que
            //la imagen no ha cambiado y no recarga la vista de la foto, al pasarle d como argumento, aunque este
            //no se utiliza para nada la url cambia cada vez que se cambia la imagen y esta se refresca.S
            d=new Date();
            $('#fotoAsociada').attr('src', response.replace(/&amp;/g, '&')+'&d='+d.getTime());
//            $("#fotoAsociada").removeAttr("src");

            console.log($('#fotoAsociada').attr('src'));
        }
    });
});


function EliminarRespuestaMC(respuesta, numpreg) {


    padre = respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);

    var k = padre.childNodes.length;

    j = 0;

    for (i = 0; i < k; i = i + 2) {
        j = j + 1;

        //primer td
        padre.childNodes[i].setAttribute("id", 'tablarespuesta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id", 'trrespuesta' + j + '_' + numpreg);
        //HIDDEN
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id", 'res' + j + '_' + numpreg);
        //RADIO
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("id", 'id_crespuesta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("name", 'crespuesta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("onclick", 'BotonRadio(crespuesta' + j + '_' + numpreg + ')');
        //TEXTAREA
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[2].setAttribute("id", 'respuesta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[2].setAttribute("name", 'respuesta' + j + '_' + numpreg);

        //segundo td
        //IMG
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick", 'EliminarRespuesta(tablarespuesta' + j + '_' + numpreg + ',' + numpreg + ")");
        //IMG
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id", 'correcta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick", 'InvertirRespuesta(correcta' + j + '_' + numpreg + ',' + numpreg + ")");
        //HIDDEN
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("id", 'valorcorrecta' + j + '_' + numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("name", 'valorcorrecta' + j + '_' + numpreg);


    }
    //Tengo una respuesta menos
    numerorespuestas = document.getElementById('num_res_preg' + numpreg);

    numerorespuestas.value = parseInt(numerorespuestas.value) - 1;




}