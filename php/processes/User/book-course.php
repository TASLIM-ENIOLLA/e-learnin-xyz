<?php

    include '../../init.php';

    class BookCourse{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $userID   = $_POST -> userID;
                $mdaID    = $_POST -> mdaID;
                $courseID = $_POST -> courseID;
                $modulesLength = $_POST -> modulesLength;
                $moduleProgress = json_encode(
                    array(
                        "data" => [],
                        "total" => $modulesLength
                        )
                    );
                $is_course_registered = is_course_registered($courseID, $userID);

                $query = $connect -> query(
                    "INSERT INTO `lectures` SET `userID` = '$userID', `mdaID` = '$mdaID', `courseID` = '$courseID', `module_progress` = '$moduleProgress'"
                );

                if($is_course_registered || $query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'message' => 'Course booked successfully!'
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

    $BookCourse = new BookCourse();

?>