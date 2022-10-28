<?php

    include '../../init.php';

    class MDAData{
        public function __construct(){
            global $connect;

            if(isset($_GET['mdaID'])){
                $mdaID = $_GET['mdaID'];
                $mdaCourses = get_courses_by_mdaID($mdaID);

                $query = $connect -> query(
                    "SELECT * FROM `mdas` WHERE `mdas`.`id` = '$mdaID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();
                    $row['courses'] = $mdaCourses;

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

    $MDAData = new MDAData();
