/*
 * Versión específica .ready para Multiple Choice
 * @author Javier Castro Fernandez, Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
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
//			console.log("file: "+file);
//			console.log("response: "+response);
			
			$('#fotoAsociada').attr('src', response);
			var inicio=response.search("=")+1;
			var final=response.search("&amp;ubicacion");
			
			var nombreUnico=response.slice(inicio, final);
			$(id).val(nombreUnico);
		}
    });
});


function EliminarRespuestaMC(respuesta,numpreg){
  

    padre=respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);
   
    var k=padre.childNodes.length;
     
    j=0;
   
    for(i=0;i<k;i=i+2){
        j=j+1;
  
        //primer td
        padre.childNodes[i].setAttribute("id",'tablarespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id",'trrespuesta'+j+'_'+numpreg);
        //HIDDEN
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id",'res'+j+'_'+numpreg);
        //RADIO
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("id",'id_crespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("name",'crespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("onclick",'BotonRadio(crespuesta'+j+'_'+numpreg+')');
        //TEXTAREA
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[2].setAttribute("id",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[2].setAttribute("name",'respuesta'+j+'_'+numpreg);
        
        //segundo td
        //IMG
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick",'EliminarRespuesta(tablarespuesta'+j+'_'+numpreg+','+numpreg+")");
        //IMG
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id",'correcta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick",'InvertirRespuesta(correcta'+j+'_'+numpreg+','+numpreg+")");
        //HIDDEN
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("id",'valorcorrecta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("name",'valorcorrecta'+j+'_'+numpreg);
            
        
    }
    //Tengo una respuesta menos
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)-1;
    
    
    
   
}