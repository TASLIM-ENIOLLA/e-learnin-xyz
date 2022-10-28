<?php

    include '../../init.php';

    class DeleteMDAData{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));

            $mdaID = filterInput($_POST -> mdaID);

            $query = $connect -> multi_query("DELETE FROM `mdas` WHERE `id` = '$mdaID'; DELETE FROM `courses` WHERE `mdaID` = '$mdaID'; DELETE FROM `modules` WHERE `mdaID` = '$mdaID'");

            if($query){
                echo json_encode(
                    array(
                        'type' => 'success',
                        'message' => 'MDA successfully deleted!'
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

    $DeleteMDAData = new DeleteMDAData();
