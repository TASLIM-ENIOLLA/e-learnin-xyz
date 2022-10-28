<?php

    include '../../init.php';

    class UpdateUserData{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $id = $_POST -> id;
                $f_name = $_POST -> f_name;
                $l_name = $_POST -> l_name;
                $email = $_POST -> email;

                $query = $connect -> query(
                    "UPDATE `users` SET `f_name` = '$f_name', `l_name` = '$l_name', `email` = '$email' WHERE `id` = '$id'"
                );

                if($query){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'message' => 'Update successful!'
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'An error occured, please try again!'
                        )
                    );
                }
            }
        }
    }

    $UpdateUserData = new UpdateUserData();

?>