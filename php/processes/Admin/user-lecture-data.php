<?php

    include '../../init.php';

    class UserLectureData{
        public function __construct(){
            global $connect;

            if(isset($_GET['userID'])){
                $userID = $_GET['userID'];

                $query = $connect -> query(
                    "SELECT `courses`.`name`, `lectures`.`module_progress` FROM `lectures` INNER JOIN `courses` ON `lectures`.`courseID` = `courses`.`id` WHERE `lectures`.`userID` = '$userID'"
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
                            'type' => '1error',
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

    $UserLectureData = new UserLectureData();
