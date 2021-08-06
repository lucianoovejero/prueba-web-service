var x = $(document);

x.ready(iniciar);

var url = '../modelo/metodos_web_service.php';

function iniciar(){

    traerDatos();
    $('#modificar').on('click',modificarDatos);
    $('#salir').on('click',cerrarSesion);
    $('#contratos').on('click',contratos);
    
}

function cerrarSesion(){

    location.href = '../index.html';

}

function contratos(){

    location.href = "contratos.html";
}

function traerDatos(){

    $.ajax({

        type : 'POST',
        url  : url,
        data : {'codigo':1},
        dataType : 'JSON',
        success : function(datos){
            
            $('[name = nombre]').val(datos[0].nombre);
            $('[name = telefono]').val(datos[0].telefono);
            $('[name = mail]').val(datos[0].mail);
        }
    })
}

function modificarDatos(){

    let valores = $('[name = formulario]').serialize();
    valores+= "&codigo=4";

    $.ajax({

        type : 'POST',
        url  : url, 
        data : valores,
        success : function(){
            alert("Cambios realizados"); 
        }
    })
}