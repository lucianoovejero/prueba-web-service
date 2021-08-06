var x = $(document);

x.ready(iniciar);

var url = "../modelo/metodos_web_service.php";

function iniciar(){

    getTiposDeSeguro();
    misContratos();
    $('#tiposeguro').on('change',function(){
        getSeguros(0);
    });
    $('#contratar').on('click',contratarSeguro);
    $('#modificarContrato').on('click',modificarContrato);
    $('#eliminarContrato').on('click',darDeBajaContrato);
    $('#salir').on('click',cerrarSesion);
    $('#sesion').on('click',sesion);
    $('#traerDatos').on('click',traerInfoDeTabla);
    $('[name = contrato]').on('change',traerInfoDeTabla);
}

function cerrarSesion(){

    location.href = "../";
}

function sesion(){
    location.href = "sesion.html";
}

function traerInfoDeTabla(){

    let radio = $('input:radio[name = contrato]:checked');
    
    if(radio.attr('idseguro') != undefined){

        let idseguro     = radio.attr('idseguro');
        let idtiposeguro = radio.attr('idtiposeguro');
        let monto        = radio.attr('monto');

        $('#tiposeguro').val(idtiposeguro);
        getSeguros(idseguro);
        $('#monto').val(monto);
    }
}

function getTiposDeSeguro(){

    $.ajax({

        type : 'POST',
        url  : url,
        data : {'codigo':5},
        dataType : 'JSON',
        success : function(json){

            let largo = json.length;

            let options = "<option value = '0'>Elegí una opcion</option>";

            for(let i = 0; i < largo; i++){

                let id     = json[i].id;
                let nombre = json[i].nombre;

                options += "<option value = '"+id+"'>"+nombre+"</option>";

            }

            $('#tiposeguro').html(options);
        }
    })
}

function getSeguros(indice){
    
    // el parametro indice me sirve para indicar que opcion va a estar seleccionada por defecto
    // cuando se cargue el combobox
    
    let idtiposeguro = $('#tiposeguro').val();

    $.ajax({

        type : 'POST',
        url  : url,
        data : {'codigo':6,'idtiposeguro':idtiposeguro},
        dataType : 'JSON',
        success : function(json){

            let largo = json.length;

            let options = "<option value = '0'>Elegí un seguro</option>";

            for(let i = 0; i<largo; i++){

                let id     = json[i].id;
                let nombre = json[i].nombre;

                options += "<option value = '"+id+"'>"+nombre+"</option>";

            }

            $('#idseguro').html(options);
            $('#idseguro').val(indice);
        }
    })
}

function contratarSeguro(){

    let data = $('#formcontrato').serialize();
    data += "&codigo=7";

    $.ajax({

        type : 'POST',
        url  : url,
        data : data,
        success : function(){
            misContratos();
        }
    })
}

function modificarContrato(){

    let data = $('#formcontrato').serialize();
    data += "&idcontrato="+$('[name = contrato]:checked').val();
    data += "&codigo=9";

    $.ajax({

        type : 'POST',
        url  : url,
        data : data,
        success : function(){
            misContratos();
        }
    })
}

function darDeBajaContrato(){

    let data = "idcontrato="+$('[name = contrato]').val();
    data += "&codigo=10";
    
    $.ajax({

        type : 'POST',
        url  : url,
        data : data,
        success : function(){
            misContratos();
        }
    })

}

function misContratos(){

    $.ajax({

        type : 'POST',
        url  : url,
        data : {'codigo':8},
        dataType : 'JSON',
        success : function(json){

            let largo = json.length;

            let table = "<tr>"+
                          "<th>Cliente</th>"+
                          "<th>Seguro de</th>"+
                          "<th>Tipo de seguro</th>"+
                          "<th>Estado</th>"+
                          "<th>Monto</th>"+
                          "<th></th>"+
                     "</tr>";

            for(let i = 0; i<largo; i++){

                let id           = json[i].id;
                let idseguro     = json[i].idseguro;
                let idtiposeguro = json[i].idtiposeguro
                let cliente      = json[i].cliente;
                let seguro       = json[i].seguro;
                let tiposeguro   = json[i].tiposeguro;
                let monto        = json[i].monto;
                let estado       = json[i].estado;

                if(estado === 'V')
                    estado = "vigente";
                

                table += "<tr><td>"+cliente+"</td>"+
                             "<td>"+seguro +"</td>"+
                             "<td>"+tiposeguro+"</td>"+
                             "<td>"+estado+"</td>"+
                             "<td>$"+monto+"</td>"+
                             "<td><input type = 'radio' name = 'contrato' value = '"+id+"'"+
                             " idtiposeguro = '"+idtiposeguro+"' idseguro = '"+idseguro+"'"+
                             " monto = '"+monto+"'></td></tr>";
                             
            }
            
            $('#misContratos').html(table);
        }
    })
}