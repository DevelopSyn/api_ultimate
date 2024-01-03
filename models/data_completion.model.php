<?php

require_once "connection.php";

class DataCompletionModel {

    /*=============================================
    =            DATA COMPLETION DH               =
    =============================================*/

    static public function mdlGetDHData(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.getdatacompletiondh
        ");

        

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetDHColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getdatacompletiondh
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

    /*=============================================
    =      POLLINATION HARVEST COMPLETION         =
    =============================================*/

    static public function mdlGetPollinationHarvestData(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.getdatacompletiondh
        ");

        

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetPollinationHarvestColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getdatacompletiondh
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

    /*=============================================
    =            TRANSPLANT COMPLETION            =
    =============================================*/

    static public function mdlGetTransplantData(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.getdatacompletiontransplant
        ");

        

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetTransplantColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getdatacompletiontransplant
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }


    /*=============================================
    =           DH HARVEST PLANNING               =
    =============================================*/

    static public function mdlGetDHHarvestPlanningData(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.getdhharvestplanning
        ");

        

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetDHHarvestPlanningColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getdhharvestplanning
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }


    /*=============================================
    =            DATA COMPLETION TI               =
    =============================================*/

    static public function mdlGetTIData(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.getdatacompletionti
        ");

        

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetTIColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getdatacompletionti
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

    static public function mdlGetDHHarvestPlanningMaterialDetail($barcode){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT
                plotdmco_db.material.id,
                plotdmco_db.material.matid,
                plotdmco_db.material.origin_sag_cda,
                plotdmco_db.material.admin_code,
                plotdmco_db.material.does_exist,
                plotdmco_db.generation.code AS generation, #generation_id,
                plotdmco_db.material_line.name AS material_line, #material_line_id,
                plotdmco_db.material.gene_package_id,
                plotdmco_db.pollination.polid AS polid, #pollination_id,
                plotdmco_db.trial.trialid AS trialid, #trial_id,
                plotdmco_db.material.abbreviation_code
            
            FROM
                plotdmco_db.plot
            LEFT JOIN plotdmco_db.pollination
                ON plotdmco_db.plot.id = plotdmco_db.pollination.plot_id
            LEFT JOIN plotdmco_db.material
                ON plotdmco_db.pollination.id = plotdmco_db.material.pollination_id
            #JOINS PARA NOMBRES O CODE
            LEFT JOIN plotdmco_db.generation
                ON plotdmco_db.material.generation_id = plotdmco_db.generation.id
            LEFT JOIN plotdmco_db.material_line
                ON plotdmco_db.material.material_line_id = plotdmco_db.material_line.id
            LEFT JOIN plotdmco_db.trial
                ON plotdmco_db.material.trial_id = plotdmco_db.trial.id
            WHERE
                plotdmco_db.plot.barcode = '$barcode'
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

}