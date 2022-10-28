<?php

    include '../../init.php';

    class LectureData{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $userID = isset($_POST -> id) ? $_POST -> id : null;
                $courseID = $_POST -> courseID;
                $courseData = get_course_data($courseID);

                $courseData['userID'] = $userID;
                // @$courseData['module_progress'] = json_decode($row['module_progress']);
                $courseData['features'] = json_decode($courseData['features']);
                $courseData['modules'] = get_modules_by_courseID($courseID);
                $courseData['registered'] = is_course_registered($courseID, $userID);

                
                echo json_encode(
                    array(
                        'type' => 'success',
                        'data' => $courseData
                    )
                );
            }
        }
    }

    $LectureData = new LectureData();

?>