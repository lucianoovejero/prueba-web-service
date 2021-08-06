<?php

include 'metodos_sql.php';
// un web service se consulta mediante una URL
session_start();
echo ejecutarMetodo();

function ejecutarMetodo(){

    $codigo =  $_POST['codigo'];

    if($codigo == 1)
        echo consultarDatosDeCliente();
    else if($codigo == 2)
        echo crearCuenta();
    else if($codigo == 3)
        echo verificarUsuario();
    else if($codigo == 4)
        echo modificarDatos();
    else if($codigo == 5)
        echo getTiposDeSeguro();
    else if($codigo == 6)
        echo getSeguros();
    else if($codigo == 7)
        echo registrarContratoDeSeguro();
    else if($codigo == 8)
        echo getContratos();
    else if($codigo == 9)
        echo modificarContratoDeCliente();
    else if($codigo == 10)
        echo darDeBajaContratoDeCliente();
}


function crearCuenta(){
    try{
        $nombre   = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $mail     = $_POST['mail'];
        $usuario  = $_POST['usuario'];
        $clave    = $_POST['clave'];
    }catch(Exception $ex){
        echo $ex->getMessage();
    }

    $clave = password_hash($clave,PASSWORD_BCRYPT,['cost'=>10]);
    
    insertContacto($nombre,$telefono,$mail,$usuario,$clave);
}

function verificarUsuario(){

    $usuario        = $_POST['usuario'];
    $claveIngresada = $_POST['clave'];
    
    $clave = json_decode(getClave($usuario),true);

    if(count($clave) == 1){

        $clave = $clave[0]['clave'];

        if(password_verify($claveIngresada,$clave)){

            $array = json_decode(getIdUsuario($usuario,$clave),true);
           
            if(count($array) == 1){
    
                $_SESSION['id_cliente'] = $array[0]['id_cliente'];
                return json_encode($array);
            }
        }
    }

    return json_encode(array("error"=>"Usuario y/o contraseña incorrecta"));
}


function modificarDatos(){

    $nombre   = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $mail     = $_POST['mail'];    

    updateCliente($nombre,$mail,$telefono,$_SESSION['id_cliente']);
    
}

function consultarDatosDeCliente(){

    return selectDatosClientePorId($_SESSION['id_cliente']);
}

function getTiposDeSeguro(){

    return getTipo_Seguro();
} 

function getSeguros(){

    $id_tipo_seguro = $_POST['idtiposeguro'];

    return get_Seguros($id_tipo_seguro); 
}

function registrarContratoDeSeguro(){

    $idseguro       = $_POST['idseguro'];
    $monto          = $_POST['monto'];

    registrarContrato_Seguro($idseguro,$_SESSION['id_cliente'],$monto);
}

function modificarContratoDeCliente(){

    $idcontrato = $_POST['idcontrato'];
    $monto      = $_POST['monto'];
    $idseguro   = $_POST['idseguro'];

    modificarContrato_Seguro($idcontrato,$idseguro,$_SESSION['id_cliente'],$monto);
}

function darDeBajaContratoDeCliente(){
    $idcontrato = $_POST['idcontrato'];

    eliminarContrato($idcontrato);
}

function getContratos(){

    return get_Contratos($_SESSION['id_cliente']);
}





