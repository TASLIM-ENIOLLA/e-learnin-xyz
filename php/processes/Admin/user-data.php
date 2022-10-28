<?php

    include '../../init.php';

    class UserData{
        public function __construct(){
            global $connect;

            if(isset($_GET['userID'])){
                $userID = $_GET['userID'];

                $query = $connect -> query(
                    "SELECT `mdas`.`name` AS 'mda_name', `users`.`id`, `users`.`f_name`, `users`.`l_name`, `users`.`email`, `users`.`empID`, `users`.`photo` FROM `users` LEFT JOIN `mdas` ON `users`.`mda` = `mdas`.`id` WHERE `users`.`id` = '$userID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();

                    if(!file_exists('../../../images/users/' . $row['id'] . '/' . $row['photo'])){
                        $row['photo'] = null;
                    }

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

    $UserData = new UserData();
