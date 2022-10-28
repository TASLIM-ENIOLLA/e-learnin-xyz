<?php

    include '../../init.php';

    class GetUserRegisteredCourses{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $userID = $_POST -> id;

                $query = $connect -> query(
                    "SELECT
                        `lectures`.`module_progress`,
                        `mdas`.`name` AS 'mda_name',
                        `courses`.`id` AS 'id',
                        `courses`.`name` AS 'name',
                        `courses`.`description` AS 'description'
                    FROM `lectures`
                    LEFT JOIN `mdas`
                    ON `lectures`.`mdaID` = `mdas`.`id`
                    LEFT JOIN `courses`
                    ON `lectures`.`courseID` = `courses`.`id`
                    WHERE `lectures`.`userID` = '$userID'"
                );

                if($query && $query -> num_rows > 0){
                    $arr = [];
                    
                    while($row = $query -> fetch_assoc()){
                        array_push($arr, $row);
                    }

                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $arr
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => "Couldn't retrieve data." . json_encode(mysqli_error($connect))
                        )
                    );
                }
            }
        }
    }

    $GetUserRegisteredCourses = new GetUserRegisteredCourses();

?>