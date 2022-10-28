<?php

    include '../../init.php';

    class UpdateModuleProgress{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $userID   = $_POST -> userID;
                $courseID   = $_POST -> courseID;
                $mdaID   = $_POST -> mdaID;
                $moduleID   = $_POST -> moduleID;
                $moduleProgress   = $_POST -> moduleProgress;

                $moduleProgressData = $moduleProgress -> data;
                array_push($moduleProgressData, $moduleID);
                
                $moduleProgress = array(
                    'data' => $moduleProgressData,
                    'total' => $moduleProgress -> total
                );

                $moduleProgressEncoded = json_encode($moduleProgress);

                $query = $connect -> query(
                    "UPDATE `lectures` SET `module_progress` = '$moduleProgressEncoded' WHERE `userID` = '$userID' AND `courseID` = '$courseID'"
                );

                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'course_completed' => (
                                (count($moduleProgress['data']) === $moduleProgress['total'])
                                ? 'yes'
                                : 'no'
                            )
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'An error occured, please try again!'
                        )
                    );
                }
            }
        }
    }

    $UpdateModuleProgress = new UpdateModuleProgress();

?>

