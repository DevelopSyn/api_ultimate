<?php

require_once "connection.php";

class GeneralModel {

    static public function mdlUpdateTrialAnexadosField($field, $data){

    /*=============================================
    =      UPDATE TRIAL ANEXADOS FIELD            =
    =============================================*/


        $stmt = Connection::connect_super()->prepare("
            UPDATE plotdmco_devel_db.datos_anexados_trial
                SET plotdmco_devel_db.datos_anexados_trial.$field = :newValue 
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

    static public function getEnrichmentData($parameter){

        $sql = "SELECT
            note.id AS id,
            note.code,
            note.creation_date,
            capture_date,
            quantity,
            iteration,
            plotdmco_db.process.name AS process_name,
            CONCAT(plotdmco_db.user.name, ' ', plotdmco_db.user.lastname) AS username,
            trial.trialid,
            maturity
        FROM
            plotdmco_db.note
        LEFT JOIN plotdmco_db.process
            ON plotdmco_db.note.process_id = plotdmco_db.process.id
        LEFT JOIN plotdmco_db.user
            ON plotdmco_db.note.user_id = plotdmco_db.user.id
        # LEFT JOIN plotdmco_db.activity
        # LEFT JOIN plotdmco_db.movement_guide
        # LEFT JOIN plotdmco_db.magenta
        # LEFT JOIN plotdmco_db.origin
        LEFT JOIN plotdmco_db.trial
            ON plotdmco_db.note.trial_id = plotdmco_db.trial.id
        WHERE
            process_id = 9
            AND
            note.code LIKE :code";

        $stmt = Connection::connect_super_ro()->prepare($sql);

        $stmt->bindParam(":code", $parameter);

        if($stmt->execute()){
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt -> errorInfo();
        }

    }

}