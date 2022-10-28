<?php

    include '../../init.php';

    class AddNewCourse{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));
            
            $courseID = filterInput(generate_course_id());
            $name = filterInput($_POST -> name);
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
                $sql_query = "INSERT INTO `courses` SET `id` = '$courseID', `name` = '$name', `mdaID` = '$mdaID'" . (
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
                                'id' => $courseID,
                                'mdaID' => $mdaID,
                                'status' => $status,
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

    $AddNewCourse = new AddNewCourse();
