<?php

    include '../../init.php';

    class GetCoursesByMDAID{
        public function __construct(){
            if(isset($_GET['mdaID'])){
                $mdaID = $_GET['mdaID'];
                $mdaCourses = get_courses_by_mdaID($mdaID);
                // $mdaCourses['modules'] = get_modules_by_courseID($mdaCourses[]);
                // foreach ($mdaCourses as $each) {
                //     $each['modules'] = get_modules_by_courseID($each['id']);
                // }
                for($x = 0; $x < count($mdaCourses); $x++){
                    $mdaCourses[$x]['modules'] = get_modules_by_courseID($mdaCourses[$x]['id']);
                }

                echo json_encode(
                    array(
                        'type' => 'success',
                        'data' => $mdaCourses
                    )
                );
            }
        }
    }

    $GetCoursesByMDAID = new GetCoursesByMDAID();

?>