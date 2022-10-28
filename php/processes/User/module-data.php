<?php

    include '../../init.php';

    class ModuleData{
        public function __construct(){
            global $connect;
            
            if(isset($_GET['moduleID']) && !empty($_GET['moduleID'])){
                $moduleID = $_GET['moduleID'];

                $query = $connect -> query(
                    "SELECT * FROM `modules` WHERE `modules`.`id` = '$moduleID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();
                    $row['features'] = json_decode($row['features']);

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
                            'data' => null
                        )
                    );
                }
            }
            else{
                echo json_encode(
                    array(
                        'type' => 'error',
                        'data' => null
                    )
                );
            }
        }
    }

    $ModuleData = new ModuleData();
