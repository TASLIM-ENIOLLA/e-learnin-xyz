<?php

    include '../../init.php';

    class ModuleData{
        public function __construct(){
            global $connect;

            if(isset($_GET['moduleID'])){
                $moduleID = $_GET['moduleID'];
                // $courseModules = get_modules_by_courseID($moduleID);

                $query = $connect -> query(
                    "SELECT `modules`.*, `mdas`.`name` AS 'mda', `courses`.`name` AS 'course' FROM `modules` LEFT JOIN `mdas` ON `modules`.`mdaID` = `mdas`.`id` LEFT JOIN `courses` ON `modules`.`courseID` = `courses`.`id` WHERE `modules`.`id` = '$moduleID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();
                    $row['features'] = json_decode($row['features']);
                    // $row['modules'] = $courseModules;

                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $row
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

    $ModuleData = new ModuleData();
