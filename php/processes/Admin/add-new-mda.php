<?php

    include '../../init.php';

    class AddNewMDA{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));

            $mdaID = filterInput(generate_MDA_id());
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
            elseif(strlen($access_code) > 7){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'Access code is too long. Max. of 7 characters!'
                    )
                );
            }
            elseif(!preg_match('/\d+/', $access_code)){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'Access code contain unwanted characters. Only numbers are allowed.'
                    )
                );
            }
            else{
                $sql_query = "INSERT INTO `mdas` SET `id` = '$mdaID', `name` = '$name', `type` = '$type', `access_code` = '$access_code'" . (
                    (strlen($description) < 1)
                    ? ''
                    : ", `description` = '$description'"
                ) . (
                    ($status === 'active')
                    ? ''
                    : ", `status` = '$status'"
                );
                
                $query = $connect -> query($sql_query);

                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => array(
                                'id' => $mdaID,
                                'name' => $name,
                                'type' => $type,
                                'access_code' => $access_code,
                                'description' => $description,
                                'status' => $status
                            )
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => "An error occured, couldn't create new MDA."
                        )
                    );
                }
            }
        }
    }

    $AddNewMDA = new AddNewMDA();
