<?php

include "metodos_contenedores.php";

function insertContacto($nombre,$telefono,$mail,$usuario,$clave){

    $cliente = array(":nombre"=>$nombre,":telefono"=>$telefono,":mail"=>$mail);                         

    $sql = "INSERT INTO cliente (nombre,telefono,mail) VALUES (:nombre,:telefono,:mail)";

    $idcliente = peticionRetornaId($sql,json_encode($cliente));

    insertCuenta($idcliente,$usuario,$clave);
}

function insertCuenta($idcliente,$usuario,$clave){

    if($idcliente){

        $sql = "INSERT INTO usuario (nombre,clave,id_cliente) VALUES (:nombre,:clave,:idcliente)";

        $nuevoUsuario = array(":nombre"=>$usuario,":clave"=>$clave,":idcliente"=>$idcliente);

        peticion($sql,json_encode($nuevoUsuario));
    }
}

function updateCliente($nombre,$mail,$telefono,$idcliente){

    $sql = "UPDATE cliente SET 
                            nombre = :nombre, 
                            telefono = :telefono, 
                            mail = :mail 
                            WHERE id = :idcliente";
    
    $datos = array(":nombre"=>$nombre,
                   ":telefono"=>$telefono,
                   ":mail"=>$mail,
                   ":idcliente"=>$idcliente);
    
    peticion($sql,json_encode($datos));
}

function updateUsuario($idcliente,$clave){

    $sql = "UPDATE usuario SET clave = :clave WHERE id_cliente = :idcliente";
    $datos = array(":idcliente"=>$idcliente,":clave"=>$clave);

    peticion($sql,json_encode($datos));
}

function getIdUsuario($usuario,$clave){

    $sql = "SELECT id_cliente FROM usuario where nombre = :nombre AND clave = :clave";
    $datos = array(":nombre"=>$usuario,":clave"=>$clave);
    return consultaConParametros($sql,json_encode($datos));
}

function getClave($usuario){

    $sql   = "SELECT clave FROM usuario WHERE nombre = :nombre";
    $datos = array(":nombre"=>$usuario);
    return consultaConParametros($sql,json_encode($datos));
}

function getTipo_seguro(){

    $sql = "SELECT * FROM tipo_seguro";
    return consulta($sql);
}

function get_Seguros($id_tipo_seguro){

    $sql = "SELECT id,nombre FROM seguro WHERE id_tipo_seguro = :idtiposeguro";
    $datos = array(":idtiposeguro"=>$id_tipo_seguro);

    return consultaConParametros($sql,json_encode($datos));
}

function selectDatosClientePorId($idcliente){

    $sql = "SELECT t1.nombre,telefono,mail
            FROM cliente AS t1
            WHERE t1.id = :idcliente";
    
    $datos = array(":idcliente"=>$idcliente);

    return consultaConParametros($sql,json_encode($datos));
}

function registrarContrato_Seguro($id_seguro,$id_cliente,$monto){

    $sql = "INSERT INTO contrato (id_seguro,id_cliente,monto,estado)
                        VALUES   (:idseguro,:idcliente,:monto,'V')";
    
    $datos = array(":idseguro"     => $id_seguro,
                   ":idcliente"    => $id_cliente,
                   ":monto"        => $monto);
    
    peticion($sql,json_encode($datos));               
}

function modificarContrato_Seguro($id_contrato,$id_seguro,$id_cliente,$monto){

    $sql = "UPDATE contrato SET id_seguro  = :idseguro, 
                                id_cliente = :idcliente,
                                monto      = :monto 
                            WHERE id = :id";
    $datos = array(":idseguro"  =>$id_seguro,
                   ":idcliente" =>$id_cliente,
                   ":monto"     =>$monto,
                   ":id"        =>$id_contrato);
                   
    peticion($sql,json_encode($datos));                   
}

function eliminarContrato($id_contrato){

    $sql = "UPDATE contrato SET estado = 'B' WHERE id = :id";

    $datos = array(":id"=>$id_contrato);

    return peticion($sql,json_encode($datos));
}

function get_Contratos($id_cliente){

    $sql = "SELECT t1.id,
                   t3.id AS idseguro,
                   t4.id AS idtiposeguro,
                   t1.monto,
                   t1.estado,
                   t2.nombre AS cliente,
                   t3.nombre AS seguro,
                   t4.nombre AS tiposeguro
            FROM contrato AS t1 INNER JOIN cliente AS t2 ON t1.id_cliente = t2.id
                                INNER JOIN seguro  AS t3 ON t1.id_seguro  = t3.id
                                INNER JOIN tipo_seguro AS t4 ON t3.id_tipo_seguro = t4.id
                                WHERE t1.id_cliente = :idcliente AND t1.estado != 'B'";
    
    $datos = array(":idcliente"=>$id_cliente);

    return consultaConParametros($sql,json_encode($datos));

}