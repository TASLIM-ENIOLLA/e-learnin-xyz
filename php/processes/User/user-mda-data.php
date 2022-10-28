<?php

    include '../../init.php';

    class UserMDAData{
        public function __construct(){
            global $connect;

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $_POST = json_decode(file_get_contents('php://input'));

                $userID = $_POST -> id;

                $query = $connect -> query(
                    "SELECT `mdas`.* FROM `users` LEFT JOIN `mdas` ON `users`.`mda` = `mdas`.`id` WHERE `users`.`id` = '$userID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();

                    $row['courses'] = get_courses_by_mdaID($row['id']);
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
        }
    }

    $UserMDAData = new UserMDAData();

?>