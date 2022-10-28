<?php

    include '../../init.php';

    class SendContactMessage{
        public function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $name = filterInput($_POST -> name);
                $email = filterInput($_POST -> email);
                $message = filterInput($_POST -> message);

                if(empty($name)){
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'Name cannot be empty!'
                        )
                    );
                }
                elseif(strlen($name) > 100){
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'Name is too long, max. of 100 characters!'
                        )
                    );
                }
                elseif(empty($email)){
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'Email cannot be empty!'
                        )
                    );
                }
                elseif(strlen($email) > 100){
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'Email is too long, max. of 100 characters!'
                        )
                    );
                }
                elseif(empty($message)){
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'message' => 'Message cannot be empty!'
                        )
                    );
                }
                else{
                    $messageID = strtolower(generate_message_id());

                    $query = $connect -> query(
                        "INSERT INTO `contact_messages` SET `id` = '$messageID', `name` = '$name', `email` = '$email', `message` = '$message'"
                    );

                    if($query){
                        echo json_encode(
                            array(
                                'type' => 'success',
                                'message' => 'Message sent successfully!'
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
    }

    $SendContactMessage = new SendContactMessage();

?>