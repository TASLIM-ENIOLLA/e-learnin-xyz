<?php

    include '../../init.php';

    class GetSessionData{
        public function __construct(){
            if(isset($_SESSION['E_LEARNING'])){
                echo json_encode(
                    array(
                        'type' => 'success',
                        'data' => $_SESSION['E_LEARNING']
                    )
                );
            }
            else{
                echo json_encode(
                    array(
                        'type' => 'failed',
                        'data' => null
                    )
                );
            }
        }
    }

    $GetSessionData = new GetSessionData();

?>