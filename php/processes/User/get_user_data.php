<?php

    include '../../init.php';

    class GetUserData{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $userID = $_POST -> id;

                $query = $connect -> query(
                    "SELECT
                        `users`.`id`,
                        `users`.`f_name`,
                        `users`.`l_name`,
                        `users`.`empID`,
                        `users`.`email`,
                        `users`.`photo`,
                        `users`.`mda`,
                        `mdas`.`name` AS 'mda_name'
                    FROM `users`
                    LEFT JOIN `mdas`
                    ON `users`.`mda` = `mdas`.`id`
                    WHERE `users`.`id` = '$userID'"
                );

                if($query && $query -> num_rows > 0){
                    $row = $query -> fetch_assoc();

                    if(!file_exists("../../../images/users/" . $userID . "/" . $row['photo'])){
                        $row['photo'] = '../user_default.png';
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
                            'message' => "Couldn't retrieve user data."
                        )
                    );
                }
            }
        }
    }

    $GetUserData = new GetUserData();

?>