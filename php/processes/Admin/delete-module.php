<?php

    include '../../init.php';

    class DeleteModuleData{
        public function __construct(){
            global $connect;

            $_POST = json_decode(file_get_contents("php://input"));

            $moduleID = filterInput($_POST -> moduleID);

            $query = $connect -> query("DELETE FROM `modules` WHERE `id` = '$moduleID'");

            if($query){
                echo json_encode(
                    array(
                        'type' => 'success',
                        'message' => 'Module successfully deleted!'
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

    $DeleteModuleData = new DeleteModuleData();
