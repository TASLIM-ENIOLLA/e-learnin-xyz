<?php

    include '../../init.php';

    class UpdateMDAData{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));

            $mdaID = filterInput($_POST -> id);
            $name = filterInput($_POST -> name);
            $type = filterInput($_POST -> type);
            $access_code = filterInput($_POST -> access_code);
            $description = filterInput($_POST -> description);
            $status = filterInput($_POST -> status);

            if(strlen($name) > 100){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'MDA name is too long. Max. of 100 characters!'
                    )
                );
            }
            elseif(strlen($name) < 10){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'MDA name is too short. Min. of 10 characters!'
                    )
                );
            }
            elseif($type !== 'ministry' && $type !== 'department' && $type !== 'agency'){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'MDA type is invalid!'
                    )
                );
            }
            elseif(!preg_match('/\d+/', $access_code)){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'MDA access code contains unwanted characters. Only numbers are allowed!'
                    )
                );
            }
            elseif($status !== 'active' && $status !== 'inactive'){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'MDA status is invalid!'
                    )
                );
            }
            else{
                $query = $connect -> query(
                    "UPDATE `mdas` SET `name` = '$name', `type` = '$type', `access_code` = '$access_code', `description` = '$description', `status` = '$status' WHERE `id` = '$mdaID'"
                );
    
                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $_POST
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'data' => []
                        )
                    );
                }
            }
        }
    }

    $UpdateMDAData = new UpdateMDAData();
