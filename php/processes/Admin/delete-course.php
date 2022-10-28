<?php

    include '../../init.php';

    class DeleteCourseData{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));

            $courseID = filterInput($_POST -> courseID);

            $query = $connect -> multi_query("DELETE FROM `courses` WHERE `id` = '$courseID'; DELETE FROM `modules` WHERE `courseID` = '$courseID'");

            if($query){
                echo json_encode(
                    array(
                        'type' => 'success',
                        'message' => 'Course successfully deleted!'
                    )
                );
            }
            else{
                echo json_encode(
                    array(
                        'type' => 'error',
                        'message' => 'An error occured. Please try again!'
                    )
                );
            }
        }
    }

    $DeleteCourseData = new DeleteCourseData();
