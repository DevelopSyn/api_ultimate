<?php
// header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); //CORS
header("Access-Control-Allow-Headers: Content-Type");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
require_once 'model.php';

if(isset($_GET['url'])){
    $var = $_GET['url'];

    //READ - GET
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $id = intval(preg_replace('/[^0-9]+/','',$var),10);
        $val = explode("/", $var);
        switch ($val[0]){
            case "measurement":
                $resp = Measurement($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(200);
                }else{
                    http_response_code(404);
                }
                break;
            case "barcd":
                $resp = FindBarCD($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "matid":
                $resp = FindMatID($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "listall":
                $resp = ListAll($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "listdates":
                $resp = ListDates();
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "listfamilies":
                $resp = ListFamilies($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "vertipo":
                $resp = verTipo($val[1]);
                if(!empty($resp)){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "sunflower_materials.json":
                $resp = sunflower_materials($val[1]);
                if(!empty($resp)){
//                    header('Content-disposition: attachment; filename=sunflower_materials.json');
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(404);
                }
                break;
            case "enrichment":
                require_once "models/general.model.php";
                $option = $val[1];
                $parameter = $val[2];

                switch($option){
                    case 'code':
                        $resp = GeneralModel::getEnrichmentData($parameter);

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(200);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(500);
                        }

                        break;

                    default:
                        break;
                }
                break;
            //QUEUE
            case "queue":

                require_once "models/queue.model.php";
                $option = $val[1];
                $parameter = $val[2];

                switch($option){
                    case 'getqueue':
                        $resp = QueueModel::mdlGetQueue(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;

                    case 'getqueuecolumns':
                        $resp = QueueModel::mdlGetQueueColumns(); //mdlGetQueueColumns
    
                            if(!empty($resp)){
                                ob_start('ob_gzhandler');
                                    header('Access-Control-Allow-Origin: *'); //CORS
                                    header('Content-Type: application/json; charset=utf-8');
                                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                    http_response_code(201);
                                ob_end_flush();
                            }else{
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(404);
                            }
                        break;

                    case 'getqueueag':
                        require_once "controllers/queue.controller.php";

                        $resp = QueueController::ctrGetQueueAG();

                        header('Access-Control-Allow-Origin: *'); //CORS
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                        http_response_code(200);

                        break;

                    case 'getdatacompletiondh':
                        require_once "models/queue.model.php";

                        $resp = QueueModel::mdlGetDHCompletion();

                        ob_start('ob_gzhandler');
                            header('Access-Control-Allow-Origin: *'); //CORS
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                            http_response_code(200);
                        ob_end_flush();

                        break;

                    case 'getdatacompletiondhcolums':
                        $resp = QueueModel::mdlGetDHCompletionColumns(); //mdlGetQueueColumns
    
                            if(!empty($resp)){
                                ob_start('ob_gzhandler');
                                    header('Access-Control-Allow-Origin: *'); //CORS
                                    header('Content-Type: application/json; charset=utf-8');
                                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                    http_response_code(200);
                                ob_end_flush();
                            }else{
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(404);
                            }
                        break;

                    case 'gettrialstatuscolumns':
                        $resp = QueueModel::mdlGetTrialStatusColumns(); //mdlGetTrialStatusColumns
    
                            if(!empty($resp)){
                                ob_start('ob_gzhandler');
                                    header('Access-Control-Allow-Origin: *'); //CORS
                                    header('Content-Type: application/json; charset=utf-8');
                                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                    http_response_code(201);
                                ob_end_flush();
                            }else{
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(404);
                            }
                        break;

                    case 'gettrialstatus':
                        $resp = QueueModel::mdlGetTrialStatus(); //mdlGetTrialStatus
    
                            if(!empty($resp)){
                                ob_start('ob_gzhandler');
                                    header('Access-Control-Allow-Origin: *'); //CORS
                                    header('Content-Type: application/json; charset=utf-8');
                                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                    http_response_code(201);
                                ob_end_flush();
                            }else{
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(404);
                            }
                        break;

                    case 'getnotes':

                        require_once "models/queue.model.php";

                        $limitAndProgram = explode("-", $parameter);
                        $limit = $limitAndProgram[0];
                        $program = $limitAndProgram[1];

                        $resp = QueueModel::mdlGetNotes($limit, $program);

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                                http_response_code(200);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
    
                    case 'getnotescolumns':
                        $resp = QueueModel::mdlGetNotesColumns(); //mdlGetQueueColumns
    
                            if(!empty($resp)){
                                ob_start('ob_gzhandler');
                                    header('Access-Control-Allow-Origin: *'); //CORS
                                    header('Content-Type: application/json; charset=utf-8');
                                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                    http_response_code(200);
                                ob_end_flush();
                            }else{
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(404);
                            }
                        break;

                    default;

                }
                break;

            //DATA COMPLETION
            case "datacompletion":

                require_once "models/data_completion.model.php";
                $option = $val[1];
                $parameter = $val[2];

                switch($option){
                    //POLLINATION HARVEST DATA
                    case 'getpollinationharvestdata':
                        $resp = DataCompletionModel::mdlGetPollinationHarvestData(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //POLLINATION HARVEST COLUMNS
                    case 'getpollinationharvestcolumns':
                        $resp = DataCompletionModel::mdlGetPollinationHarvestColumns(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;

                    //TRANSPLANT DATA
                    case 'gettransplantdata':
                        $resp = DataCompletionModel::mdlGetTransplantData(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(200);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //TRANSPLANT COLUMNS
                    case 'gettransplantcolumns':
                        $resp = DataCompletionModel::mdlGetTransplantColumns(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;

                    //TRANSPLANT DATA
                    case 'getplantingdata':
                        $resp = DataCompletionModel::mdlGetTransplantData(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //TRANSPLANT COLUMNS
                    case 'getplantingcolumns':
                        $resp = DataCompletionModel::mdlGetTransplantColumns(); //mdlGetQueue Data

                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;

                    //DH DATA
                    case 'getdhdata':

                        $resp = DataCompletionModel::mdlGetDHData(); //DATA
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                                http_response_code(200);
                            ob_end_flush();

                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //DH COLUMNS
                    case 'getdhcolums':
                        $resp = DataCompletionModel::mdlGetDHColumns(); //COLUMNS
    
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }
                        break;

                    //DH HARVEST PLANNING DATA
                    case 'getdhharvestplanningdata':

                        $resp = DataCompletionModel::mdlGetDHHarvestPlanningData(); //DATA
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                                http_response_code(200);
                            ob_end_flush();

                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //DH HARVEST PLANNING COLUMNS 
                    case 'getdhharvestplanningcolumns':
                        $resp = DataCompletionModel::mdlGetDHHarvestPlanningColumns(); //COLUMNS
    
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }
                        break;
                    //DH HARVEST PLANNING MATERIAL DETAILS 
                    case 'getdhharvestplanningmaterialdetail':
                        $barcode = $parameter;
                        $resp = DataCompletionModel::mdlGetDHHarvestPlanningMaterialDetail($barcode); //COLUMNS
    
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }
                        break;


                    //TI DATA
                    case 'gettidata':

                        $resp = DataCompletionModel::mdlGetTIData(); //DATA
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                                http_response_code(200);
                            ob_end_flush();

                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }

                        break;
                    //TI COLUMNS
                    case 'getticolumns':
                        $resp = DataCompletionModel::mdlGetTIColumns(); //COLUMNS
    
                        if(!empty($resp)){
                            ob_start('ob_gzhandler');
                                header('Access-Control-Allow-Origin: *'); //CORS
                                header('Content-Type: application/json; charset=utf-8');
                                echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                                http_response_code(201);
                            ob_end_flush();
                        }else{
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(404);
                        }
                        break;

                    default;
                    http_response_code(400);
                }
                break;


            default;
        }
        //POST
    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        $val = explode("/", $var);
        switch ($val[0]){
            case "queue":

                require_once "models/queue.model.php";
                require_once "controllers/queue.controller.php";
                $option = $val[1];

                $postBody = file_get_contents("php://input");
                $convert = json_decode($postBody,true);

                if(json_last_error() == 0){
                    switch ($option){
                        case "updatequeue":
                            $resp = QueueController::ctrUpdateQueueCell($convert);
                            header('Access-Control-Allow-Origin: *'); //CORS
                            // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
                            // header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(200);
                            break;

                        case "updatetrialstatus":
                            $resp =  QueueController::ctrUpdateTrialStatus($convert);
                            header('Access-Control-Allow-Origin: *'); //CORS
                            // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
                            // header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(200);
                            break;

                        case "updatenotetrial":
                            $resp = QueueController::ctrUpdateNoteTrial($convert);
                            header('Access-Control-Allow-Origin: *'); //CORS
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(200);
                            break;

                        case "deletenote":
                            $resp = QueueController::ctrDeleteNote($convert);
                            header('Access-Control-Allow-Origin: *'); //CORS
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(200);
                            break;

                        default;
                    }
                }else{
                    http_response_code(400);
                }

            break;

            case "scan":
                $option = $val[1];
                $postBody = file_get_contents("php://input");
                $convert = json_decode($postBody,true);

                if(json_last_error() == 0){
                    switch ($option){
                        case "savematch":
                            $resp = saveMatch($convert);
                            echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                            http_response_code(201);
                            break;
                            default;
                    }
                }else{
                    http_response_code(400);
                }
                break;

            case "savematch":
                if(json_last_error() == 0){
                    $postBody = file_get_contents("php://input");
                    $convert = json_decode($postBody,true);
                    $resp = saveMatch($convert);
                    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
                    http_response_code(201);
                }else{
                    http_response_code(400);
                }
            break;
            default;
        }
        // $postBody = file_get_contents("php://input");
        // $convert = json_decode($postBody,true);
        // if(json_last_error() == 0){
        //     switch ($var){
        //         case "savematch":
        //             $resp = saveMatch($convert);
        //             echo json_encode($resp, JSON_UNESCAPED_UNICODE);
        //             http_response_code(201);
        //             break;
        //         default;
        //     }
        // }else{
        //     http_response_code(400);
        // }


        //PUT - ACTUALIZAR
    }else if($_SERVER['REQUEST_METHOD']=='PUT'){
        $postBody = file_get_contents("php://input");
        $convert = json_decode($postBody,true);
        $run = intval(preg_replace('/[^0-9]+/','',$var),10);
        if(json_last_error() == 0){
            switch ($var){
                case "usuario/$run";
                    $convert[0]['run'] = $run;
                    //$resp = ModificarUsuario($convert);
                    if($resp){
                        http_response_code(200);
                    }else{
                        http_response_code(202);
                    }
                    break;
                default;
            }
        }else{
            http_response_code(400);
        }
        //DELETE
    }else if($_SERVER['REQUEST_METHOD']=='DELETE'){
        $run = intval(preg_replace('/[^0-9]+/','',$var),10);
        switch ($var){
            case "poi/$run";
                //$resp = EliminarUsuario($run);
                if($resp){
                    http_response_code(200);
                }else{
                    http_response_code(400);
                }
                break;
            default;
        }
    }else if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
        
        http_response_code(200); //OPTIONS para el fetch preflight

    }else{
        http_response_code(405);
    }
}else{
    ?>
    <link rel="stylesheet" href="public/style.css" type="text/css">
    <div class="container">
        <h1>API PROTO METADATA</h1>
        <div class="divbody">
            <p>Scan2Match</p>
            <code>
                GET /measurement
                <br>
                GET /measurement/$id
                <br>
                GET /barcd              Lists all barcd
                <br>
                GET /barcd/$barcd       Lists all barcd and new matid associated by the New MATID
                <br>
                GET /matid              Lists all matid
                <br>
                GET /matid/$matid       Lists all matid associated the the New MATID
                <br>
                GET /listall/$matid or $barcd Lists all rows associated by matid
                <br>
                GET /listdates List all dates that have data
                <br>
                GET /listfamilies/$date List all familys (matid) by date
            </code>
        </div>
    </div>
    <?php
}
//204 No Content  (Especially in cases like DELETE or POSTs that don't require feedback).
?>
