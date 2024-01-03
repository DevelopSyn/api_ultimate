<?php
$server     = "127.0.0.1";
$user       = "plotdmco_devel_usr";
$pswd       = "Da.7E_;ToX#=";
$database   = "plotdmco_devel_db";
$port       = "3306";

$objConnDev = (object)[];


//string conexion

$conexion = new mysqli($server,$user,$pswd,$database,$port);
$conexion->set_charset("utf8");
if($conexion -> connect_errno){
    die($conexion -> connect_error);
}

$connection = new mysqli($server,$user,$pswd,$database,$port);
$connection->set_charset("utf8");
if($connection -> connect_errno){
    die($connection -> connect_error);
}

//CUD Guardar, modificar, eliminar

function NonQuery($sqlstr, &$conexion = null){
    if(!$conexion)global $conexion;
    $result = $conexion->query($sqlstr);
    return $conexion -> affected_rows;
}

//R Select
function ConsultaSimple($sqlstr, &$conexion = null){
    if(!$conexion)global $conexion;
    $result = $conexion->query($sqlstr);
    $resultArray = array();
    foreach ($result as $registros){
        $resultArray[] = $registros;
    }
    return $resultArray;
}

//Consultas DRV
function SimpleQuery($sqlstr, $database){

}

function ConsultaUnica($sqlstr, &$conexion = null){
    if(!$conexion)global $conexion;
    $result = $conexion->query($sqlstr);
    $resultArray = array();
    foreach ($result as $registros){
        $resultArray[] = $registros;
    }
    return $resultArray[0];
}

//utf-8
function ConvertirUTF8($array){
    array_walk_recursive($array,function(&$item,$key){
        if(!mb_detect_encoding($item,'utf-8',true)){
            $item = utf8_encode($item);
        }
    });
    return $array;
}

