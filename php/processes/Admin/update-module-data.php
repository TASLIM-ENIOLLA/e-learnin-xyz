<?php

    include '../../init.php';

    class UpdateModule{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));
            
            $moduleID = filterInput($_POST -> id);
            $name = filterInput($_POST -> name);
            $courseID = filterInput($_POST -> courseID);
            $mdaID = filterInput($_POST -> mdaID);
            $features = $_POST -> features;
            $description = filterInput($_POST -> description);
            $status = filterInput($_POST -> status);

            if(strlen($name) > 100){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'Course name is too long. Max. of 100 characters!'
                    )
                );
            }
            elseif(strlen($name) < 10){
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'Course name is too short. Min. of 10 characters!'
                    )
                );
            }
            else{
                $sql_query = "UPDATE `modules` SET `name` = '$name', `mdaID` = '$mdaID', `courseID` = '$courseID'" . (
                    (strlen($description) < 1)
                    ? ''
                    : ", `description` = '$description'"
                ) . (
                    ($status === 'active')
                    ? ''
                    : ", `status` = '$status'"
                ) . (
                    (count($features) < 1)
                    ? ''
                    : ", `features` = '" . json_encode($features) . "'"
                ) . " WHERE `id` = '$moduleID'";
                
                $query = $connect -> query($sql_query);

                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => array(
                                'name' => $name,
                                'id' => $moduleID,
                                'mdaID' => $mdaID,
                                'mda' => get_mda_data($mdaID)['name'],
                                'status' => $status,
                                'courseID' => $courseID,
                                'course' => get_course_data($courseID)['name'],
                                'features' => $features,
                                'description' => $description
                            )
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => "An error occured, couldn't update module."
                        )
                    );
                }
            }
        }
    }

    $UpdateModule = new UpdateModule();
