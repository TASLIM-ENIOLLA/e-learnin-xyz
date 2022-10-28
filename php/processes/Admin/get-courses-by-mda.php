<?php

    include '../../init.php';

    class GetCoursesByMDA{
        public function __construct(){
            global $connect;

            if(isset($_GET['mdaID']) && !empty($_GET['mdaID'])){
                $mdaID = $_GET['mdaID'];
                $coursesList = get_courses_by_mdaID($mdaID);

                echo json_encode(
                    array(
                        'type' => 'success',
                        'data' => $coursesList
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

    $GetCoursesByMDA = new GetCoursesByMDA();
