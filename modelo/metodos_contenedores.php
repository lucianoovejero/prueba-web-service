<?php

include 'conexion.php';

function peticion($sql,$datos){

    $pdo = new Conexion();

    $stmt = $pdo->prepare($sql);

    $valores = json_decode($datos,true);

    foreach($valores as $k=>$v)
        $stmt->bindValue($k,$v);

    $stmt->execute();
}

function peticionRetornaId($sql,$datos){

    $pdo = new Conexion();

    $stmt = $pdo->prepare($sql);

    $valores = json_decode($datos,true);

    foreach($valores as $k=>$v)
        $stmt->bindValue($k,$v);

    $stmt->execute();

    return $pdo->lastInsertId();
}

function consulta($sql){

    $pdo = new Conexion();

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return json_encode($stmt->fetchAll());
}

function consultaConParametros($sql,$datos){

    $pdo = new Conexion();
 
    $valores = json_decode($datos,true);

    $stmt = $pdo->prepare($sql);
    
    foreach($valores as $k => $v)
        $stmt->bindValue($k,$v);
    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return json_encode($stmt->fetchAll());
}