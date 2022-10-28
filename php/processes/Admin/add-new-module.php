<?php

    include '../../init.php';

    class AddNewModule{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));
            
            $moduleID = filterInput(generate_module_id());
            $name = filterInput($_POST -> name);
            $courseID = filterInput($_POST -> courseID);
            $course_name = filterInput($_POST -> course_name);
            $mdaID = filterInput($_POST -> mdaID);
            $mda_name = filterInput($_POST -> mda_name);
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
                $sql_query = "INSERT INTO `modules` SET `id` = '$moduleID', `name` = '$name', `mdaID` = '$mdaID', `courseID` = '$courseID'" . (
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
                );
                
                $query = $connect -> query($sql_query);

                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => array(
                                'name' => $name,
                                'id' => $moduleID,
                                'mdaID' => $mdaID,
                                'mda_name' => $mda_name,
                                'status' => $status,
                                'courseID' => $courseID,
                                'course_name' => $course_name,
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
                            'message' => "An error occured, couldn't create new course."
                        )
                    );
                }
            }
        }
    }

    $AddNewModule = new AddNewModule();
