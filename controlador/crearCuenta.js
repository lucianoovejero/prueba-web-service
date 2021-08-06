var x = $(document);

x.ready(iniciar);

function iniciar(){

    $('#crearCuenta').on('click',crearCuenta);
}

function crearCuenta(){

    let datos = $('#formulario').serialize();
    datos+= "&codigo=2";

    $.ajax({

        type : 'POST',
        url  : '../modelo/metodos_web_service.php',
        data : datos,
        success : function(){
            location.href = "../index.html";
        }
    })
}