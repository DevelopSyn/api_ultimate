<?php

class QueueController{

/*=====================================================
                    UPDATE QUEUE CELL
=====================================================*/
    static public function ctrUpdateQueueCell($data){
        $resumen = array();

        foreach($data as $key => $value){
            $column = $value["col"];
            
            $newData = array(
                "newValue" => $value["newValue"],
                "id" => $value["id"]
            );

            $oldData = array(
                "oldValue" => $value["oldValue"],
                "id" => $value["id"]
            );

            //$oldValue = QueueModel::mdlGetCellValue($column, $updatedCell);

            $response = QueueModel::mdlUpdateQueueCell($column, $newData);

            $saveHistory = QueueModel::mdlSaveHistory($column, $oldData);

            array_push($resumen, array("status" => $response["status"], "history" => $saveHistory)
            );

        }

        //$column = null;
        //$data = null;
        //$response = QueueModel::mdlUpdateQueueCell($column, $data);

        return $resumen;
    }

/*=====================================================
                    UPDATE TRIAL STATUS
=====================================================*/
static public function ctrUpdateTrialStatus($data){
    $resumen = array();

    foreach($data as $key => $value){

        $updatedCell = array(
            "newValue" => $value["newValue"],
            "id" => $value["id"]
        );

        $trialAnexadosHeaders = array("locqt", "plntd", "notet", "shelt", "genm2", "oldcc", "prdes", "brxnc");

        if(in_array($value["col"], $trialAnexadosHeaders) ){
            //actualizar trial anexados
        }else{
            //actualizar status2
            $response = QueueModel::mdlUpdateTrialStatus($updatedCell);
        }



        //$oldValue = QueueModel::mdlGetCellValue($column, $updatedCell);



        

        //$saveHistory = QueueModel::mdlSaveHistory($column, $oldCell);

        array_push( $resumen, array("status" => $response["status"], "info" => $response["info"], "datos" => $response["datos"]) );

    }

    //$column = null;
    //$data = null;
    //$response = QueueModel::mdlUpdateQueueCell($column, $data);

    return $resumen;
}


    /*=====================================================
                    GET QUEUE AG GRID READY
    =====================================================*/
    static public function ctrGetQueueAG(){

        $resp1 = QueueModel::mdlGetQueue(); //mdlGetQueue Data
        $resp2 = QueueModel::mdlGetQueueColumns();

        $fields = array();

        foreach($resp2 as $key => $value){
            //array_push($fields, $value['Field']);
            array_push($fields, $value['Comment']);
        }

        $agrow = array();

        foreach($resp2 as $key => $value){

            array_push($agrow, array(
                "headerTooltip" => "wena",
                "field" => $value,
                "sortable" => true,
                "filter" => true,
                "editable" => false

            ));

        }


        // {headerTooltip: 'Col A', field: 'id', sortable: true, filter: true, editable: false}
        //{headerTooltip: 'Col A', field: element.Field, sortable: true, filter: true, editable: element.Field == "id" ? false : true}

            //$table = "instructions_order";
            // $response = ScanModel::mdlCountBarcd($table);

        return $agrow;
    }//.List BARCD




/*=====================================================
                    UPDATE NOTE TRIAL
=====================================================*/
static public function ctrUpdateNoteTrial($data){
    $resumen = array();
    $arrayResult = array();

    $encontrados = 0;
    $buscados = 0;
    foreach($data as $key => $value){
        $buscados += 1;
        $column = $value["col"];
        
        $data = array(
            "noteId" => $value["id"],
            "entityid" => $value["entityid"],
            "entitytype" => $value["entity_type"]
        );

        $foundTrial = QueueModel::mdlGetTrialOfEntity($data);

        $column = "trial_id";

        if($foundTrial['data']){
            //guardar trial
            $encontrados += 1;
            $dataUpdate = array(
                "noteId" => $data['noteId'],
                "trial_id" => $foundTrial['data']['trial_id']
            );
            $response = QueueModel::mdlSetTrialOfNote($column, $dataUpdate);

            array_push($arrayResult, array( "status" => $response['status'], "noteId" => $response['data'][0]['noteId'], "trial_id" => $response['data'][0]['trial_id'], "trialid" => $foundTrial['data']['trialid']));
            
        }else{
            //trial not found
        }

    }

    $resumen['data'] = $arrayResult;
    $resumen["result"] = array("encontrados" => $encontrados, "buscados" => $buscados);

    return $resumen;
}

/*=====================================================
                    DELETE NOTE
=====================================================*/
static public function ctrDeleteNote($data){
    $resumen = array();

    $eliminados = 0;
    foreach($data as $key => $value){
        $eliminados += 1;
        
        $data = array(
            "noteId" => $value["id"],
            "entityid" => $value["entityid"],
            "entitytype" => $value["entity_type"]
        );

        //delete note
        //$foundTrial = QueueModel::mdlGetTrialOfEntity($data);

    }
    
    $resumen["result"] = array("eliminados" => $eliminados);

    return $resumen;
}

}