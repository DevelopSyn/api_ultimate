<?php

require_once "connection.php";

class QueueModel {
    static public function mdlGetQueue(){

        $stmt = Connection::connect()->prepare("
        SELECT
            id,
            projectid,
            dmdyear,
            dhtype,
            regcode,
            sitecommn,
            sitelocnm,
            inexpno,
            inkpe,
            inbarcd,
            intrlid,
            inmatid,
            bgpcd,
            incontid,
            inabbcd,
            inplotid,
            incpu,
            DATE_FORMAT( inpltdt, '%m/%d/%Y' ) AS inpltdt,
            intloc,
            innewmat,
            instdct,
            DATE_FORMAT( inpoldt, '%m/%d/%Y' ) AS inpoldt,
            inpolct,
            inyear,
            incgenes,
            inhvect,
            DATE_FORMAT( inhvdt, '%m/%d/%Y' ) AS inhvdt,
            proearslab,
            bntrlid,
            bnextno,
            hapemct,
            traytrsct,
            DATE_FORMAT( traytrsdt, '%m/%d/%Y' ) AS traytrsdt,
            fldtrspct,
            DATE_FORMAT( trspdt, '%m/%d/%Y' ) AS trspdt,
            offtyplct,
            bnstdct,
            bnpolct,
            bnyear,
            bnbarcd,
            bnhvect,
            offtyearct,
            DATE_FORMAT( bnhvdt, '%m/%d/%Y' ) AS bnhvdt,
            bnhve50k,
            inplweek,
            bnhve5k,
            bnhve15k,
            inplacd,
            bnplacd,
            bndmgect,
            DATE_FORMAT( bnpoldt, '%m/%d/%Y' ) AS bnpoldt,
            ineconct,
            labconrt,
            bne_req,
            DATE_FORMAT( labpdt, '%m/%d/%Y' ) AS labpdt,
            hg,
            exresrt,
            bnsamct,
            DATE_FORMAT( bnsamdt, '%m/%d/%Y' ) AS bnsamdt,
            bnselrt,
            dhprotocol,
            incpureq,
            pinumber,
            mg,
            crop,
            DATE_FORMAT( shipdt, '%m/%d/%Y' ) AS shipdt,
            DATE_FORMAT( esthodt, '%m/%d/%Y' ) AS esthodt,
            DATE_FORMAT( acthodt, '%m/%d/%Y' ) AS acthodt,
            DATE_FORMAT( brhodt, '%m/%d/%Y' ) AS brhodt,
            DATE_FORMAT( samshpdt, '%m/%d/%Y' ) AS samshpdt,
            magcd,
            magcdst,
            incalle,
            inhilera,
            bncalle,
            bnhilera,
            potreq,
            trspreq,
            hapereq,
            bnpolreq,
            inpolreq,
            totemct,
            DATE_FORMAT( sprosdt, '%m/%d/%Y' ) AS sprosdt,
            rshpid,
            bnsterct,
            labemsz,
            labcnct,
            labcndct,
            bnhv_dis,
            bnhv_req,
            labear_req,
            `status`,
            DATE_FORMAT( est_samardt, '%m/%d/%Y' ) AS est_samardt
        FROM plotdmco_devel_db.queue limit 1000
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetQueueColumns(){

        $stmt = Connection::connect()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_devel_db.queue
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

    /*=============================================
    =            UPDATE QUEUE CELL                =
    =============================================*/

    static public function mdlUpdateQueueCell($column, $data){


        $stmt = Connection::connect()->prepare("UPDATE plotdmco_devel_db.queue SET $column = :newValue WHERE id = :id");

        $stmt->bindParam(":newValue", $data["newValue"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return array("status" => "ok", "oldValue");
        }else{
            return json_encode($data);
        }

        $stmt = null;

    }

    static public function mdlUpdateTrialStatus($data){


        $stmt = Connection::connect_super()->prepare("
            UPDATE plotdmco_db.trial_has_trial_status
                SET plotdmco_db.trial_has_trial_status.trial_status_id = :newValue 
            WHERE trial_id = :id");

        $stmt->bindParam(":newValue", $data["newValue"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return array("status" => "ok");
        }else{
            return array("status" => "error", "info" => $stmt -> errorInfo(), "datos" => $data);
        }

        $stmt = null;

    }

    /*=============================================
    =       GET CELL VALUE (FOR HISTORY)          =
    =============================================*/

    static public function mdlGetCellValue($column, $data){


        $stmt = Connection::connect()->prepare("SELECT plotdmco_devel_db.queue.$column WHERE plotdmco_devel_db.queue.id = :id");

        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array("status" => "error", "data" => $data, "error" => $stmt ->errorInfo());
        }

        $stmt = null;

    }

    /*=============================================
    =            SAVE HISTORY                     =
    =============================================*/

    static public function mdlSaveHistory($column, $oldData){

        $stmt = Connection::connect()->prepare("
            INSERT INTO 
                plotdmco_devel_db.queue_history(`column`, value_string, id_queue)
                VALUES('$column', :oldValue, :id)
        ");

        $stmt->bindParam(":oldValue", $oldData["oldValue"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $oldData["id"], PDO::PARAM_INT);

        if($stmt->execute()){
            return array("status" => "ok", "oldValue");
        }else{
            return array("status" => "error", "info" => $stmt -> errorInfo(), "olddata" => $oldData);
        }

        $stmt = null;

    }

    /*=============================================
    =            DATA COMPLETION  DH              =
    =============================================*/

    static public function mdlGetDHCompletion(){

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

    static public function mdlGetDHCompletionColumns(){

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
    =            TRIAL STATUS                  =
    =============================================*/

    static public function mdlGetTrialStatus(){

        $stmt = Connection::connect_super_ro()->prepare("
            SELECT * FROM plotdmco_db.gettrialstatus
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetTrialStatusColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.gettrialstatus
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }

    /*=============================================
    =            TRIAL STATUS                  =
    =============================================*/

    static public function mdlGetNotes($limit, $program){
        $query = "SELECT * FROM plotdmco_db.getnotes ";
        if($program){
            $query.= "WHERE program LIKE '%{$program}%' ";
        }
        if($limit){
            $query.= "LIMIT {$limit}";
        }
        $stmt = Connection::connect_super_ro()->prepare($query);

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGetNotesColumns(){

        $stmt = Connection::connect_super_ro()->prepare("

            SHOW FULL COLUMNS FROM plotdmco_db.getnotes
            
        ");

        if($stmt->execute()){
            return $stmt ->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
        $stmt = null;

    }


    /*=============================================
    =       FIND TRIAL OF ENTITY OF NOTE          =
    =============================================*/

    static public function mdlGetTrialOfEntity($data){
        if($data["entitytype"] == "1"){ //1 es plot 2 es material

            $stmt = Connection::connect_super_ro()->prepare("
                SELECT
                    plotdmco_db.plot.trial_id,
                    plotdmco_db.trial.trialid
                FROM plotdmco_db.plot
                LEFT JOIN plotdmco_db.trial
                    ON plotdmco_db.plot.trial_id = plotdmco_db.trial.id
                WHERE plotdmco_db.plot.barcode = :entityid"
            );
            $stmt->bindParam(":entityid", $data["entityid"], PDO::PARAM_STR);
            if($stmt->execute()){
                return array("status" => "ok", "data" => $stmt ->fetch(PDO::FETCH_ASSOC));
            }else{
                return array("status" => "error", "data" => $data, "error" => $stmt ->errorInfo());
            }
            $stmt = null;

        }else if($data["entitytype"] == "2"){

            $stmt = Connection::connect_super_ro()->prepare("
                SELECT
                    plotdmco_db.material.trial_id,
                    plotdmco_db.trial.trialid
                FROM plotdmco_db.material
                LEFT JOIN plotdmco_db.trial
                    ON plotdmco_db.material.trial_id = plotdmco_db.trial.id
                WHERE plotdmco_db.material.matid = :entityid
            ");
            $stmt->bindParam(":entityid", $data["entityid"], PDO::PARAM_STR);
            if($stmt->execute()){
                return array("status" => "ok", "data" => $stmt ->fetch(PDO::FETCH_ASSOC));
            }else{
                return array("status" => "error", "data" => $data, "error" => $stmt ->errorInfo());
            }
            $stmt = null;

        }else{
            return array("status" => "error", "data" => "No query for entity");
        }


    }

    /*=============================================
    =       SET TRIAL ON NOTE FINDED          =
    =============================================*/

    static public function mdlSetTrialOfNote($column, $data){


        $stmt = Connection::connect_super()->prepare("
            UPDATE plotdmco_db.note SET $column = :trial_id WHERE id = :noteId
        ");

        $stmt->bindParam(":noteId", $data["noteId"], PDO::PARAM_STR);
        $stmt->bindParam(":trial_id", $data["trial_id"], PDO::PARAM_STR);

        if($stmt->execute()){
            return array("status" => "ok", "data" => array($data));
        }else{
            return array("status" => "error", "info" => $stmt -> errorInfo(), "datos" => $data);
        }

        $stmt = null;

    }

}




