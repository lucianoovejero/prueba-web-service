var x = $(document);

x.ready(iniciar);

var dir = 'modelo/metodos_web_service.php';

function iniciar(){
    $('#ingresar').on('click',ingresar);
    $('#crearCuenta').on('click',crearCuenta);
}

function crearCuenta(){

    location.href = "vista/crearCuenta.html";
}

function ingresar(){
    
    let valores = $('#formulario').serialize();
    valores+= "&codigo=3";

    $.ajax({

        type     : 'POST',
        url      : dir,
        data     : valores,
        dataType : 'JSON',
        success  : function(json){

            if(json.error === undefined){
                location.href = "vista/sesion.html";
            }else
                alert(json.error);
            
        },
        error: function(){
            alert("Error en el servidor");
        }
    })
}



