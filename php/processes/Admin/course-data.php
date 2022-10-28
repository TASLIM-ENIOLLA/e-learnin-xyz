<?php

    include '../../init.php';

    class CourseData{
        public function __construct(){
            global $connect;

            if(isset($_GET['courseID'])){
                $courseID = $_GET['courseID'];
                $courseModules = get_modules_by_courseID($courseID);

                $query = $connect -> query(
                    "SELECT `courses`.*, `mdas`.`name` AS 'mda', `mdas`.`id` AS 'mda_id' FROM `courses` INNER JOIN `mdas` ON `courses`.`mdaID` = `mdas`.`id` WHERE `courses`.`id` = '$courseID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();
                    $row['features'] = json_decode($row['features']);
                    $row['modules'] = $courseModules;

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

    $CourseData = new CourseData();
