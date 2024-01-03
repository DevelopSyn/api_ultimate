<?php
require_once 'db.php';

function Measurement($id){
    if($id){
        $sql = "select * from measurement_unit where id = $id";
    }else{
        $sql = "select * from measurement_unit";
    }

    return ConvertirUTF8(ConsultaSimple($sql));
}

function ListAll($code){
    if($code){
        $sql = "SELECT * FROM instructions_order
        WHERE ((SELECT `newmatid` FROM `instructions_order` WHERE `newmatid` = '$code' LIMIT 1) IS NULL OR newmatid = '$code') 
        AND ((SELECT `barcd` FROM `instructions_order` WHERE `barcd` = '$code') IS NULL OR newmatid = (SELECT `newmatid` FROM `instructions_order` WHERE `barcd` = '$code'))
        AND NOT (SELECT `newmatid` FROM `instructions_order` WHERE `newmatid` = '$code' LIMIT 1) <=> (SELECT `barcd` FROM `instructions_order` WHERE `barcd` = '$code')";

        return ConvertirUTF8(ConsultaSimple($sql));
    }
}

function FindBarCD($barcd){
    if($barcd) {
        $sql = "SELECT * FROM plotdmco_devel_db.instructions_order WHERE `newmatid` = (SELECT `newmatid` FROM `instructions_order` WHERE `barcd` = '$barcd')";
    }else{
        $sql = "SELECT * FROM plotdmco_devel_db.instructions_order";
    }
    return ConvertirUTF8(ConsultaSimple($sql));
}

function FindMatID($matid){
    if($matid) {
        $sql = "SELECT * FROM plotdmco_devel_db.instructions_order WHERE newmatid = '$matid'";
    }else{
        $sql = "SELECT * FROM plotdmco_devel_db.instructions_order";
    }
    return ConvertirUTF8(ConsultaSimple($sql));
}


function saveMatch($array){
    $id = $array['id'];
    $barcd = $array['barcd'];
    $newmatid = $array['newmatid'];
    $status = $array['status'];

    $sql = "UPDATE instructions_order SET status = $status WHERE id = $id AND barcd = '$barcd' AND newmatid = '$newmatid'";

    $rs = NonQuery($sql);

    return $status;
//    if($rs != 0){
//        return true;
//    }else{
//        return false;
//    }
}

function ListDates(){
    
    $sql = "SELECT 
	CAST(creation_date AS DATE) as fechas
        FROM plotdmco_devel_db.instructions_order
        GROUP BY 
        CAST(creation_date AS DATE)";

    return ConvertirUTF8(ConsultaSimple($sql));
}

function ListFamilies($date){
    
    $sql = "SELECT
                newmatid, creation_date,
                IFNULL(SUM(CASE WHEN status IN (1,2)THEN 1 ELSE 0 END),0) cant_proceso1,
                IFNULL(SUM(CASE WHEN status IN (2,3,4)THEN 1 ELSE 0 END),0) cant_proceso2,
                COUNT(*) AS total_familia,
                CASE WHEN IFNULL(SUM(CASE WHEN status IN (2,3,4)THEN 1 ELSE 0 END),0) = COUNT(*) THEN 'Finalizado' ELSE 'Incompleto' END AS estadofamilia
            FROM 
                    plotdmco_devel_db.instructions_order
            WHERE 
                creation_date LIKE '{$date}%'
            GROUP BY newmatid";
    
    $familyData = ConvertirUTF8(ConsultaSimple($sql));
    
    foreach($familyData as $key => $value){
        
        $sql2 = "SELECT
                        *
                FROM 
                        plotdmco_devel_db.instructions_order
                WHERE instructions_order.newmatid = '{$value['newmatid']}'";
                
        $arrBarcd = ConvertirUTF8(ConsultaSimple($sql2));
        
        //$value["barcodes"]
                
        $familyData[$key]["barcodes"] = $arrBarcd;
        
    }
    
    
    return $familyData;
    
}

function verTipo($code){
        $sql = "SELECT
                CASE 
                    WHEN (SELECT `newmatid` FROM `instructions_order` WHERE `newmatid` = '{$code}' LIMIT 1) IS NOT NULL THEN 'matid'
                    WHEN (SELECT `barcd` FROM `instructions_order` WHERE `barcd` = '{$code}') IS NOT NULL THEN 'barcd' 
                    ELSE 'no match'
                END AS tipo_cod";

        return ConvertirUTF8(ConsultaUnica($sql));
    
}

function sunflower_materials($args){
        $sql = "SELECT * FROM sunflower_materials";

        return ConvertirUTF8(ConsultaSimple($sql));
    
}