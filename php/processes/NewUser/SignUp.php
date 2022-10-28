<?php

    include "../../init.php";

    class SignUp{
        private function verify_access_code($mdaID, $accessCode){
            global $connect;

            $query = $connect -> query(
                "SELECT * FROM `mdas` WHERE `id` = '$mdaID' AND `access_code` = '$accessCode'"
            );

            return $query && $query -> num_rows > 0;
        }
        function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $empID = filterInput($_POST -> empID);
                $f_name = filterInput($_POST -> f_name);
                $l_name = filterInput($_POST -> l_name);
                $email = filterInput($_POST -> email);
                $mdaID = filterInput($_POST -> MDA);
                $accessCode = filterInput($_POST -> accessCode);
                $password = filterInput($_POST -> password);
                $c_password = filterInput($_POST -> c_password);

                if(strlen($f_name) > 50){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "First name is too long! Max. of 50 characters."
                        )
                    );
                }
                elseif(strlen($l_name) > 50){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Last name is too long! Max. of 50 characters."
                        )
                    );
                }
                elseif(strlen($f_name) < 1){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "First name cannot be empty!"
                        )
                    );
                }
                elseif(strlen($l_name) < 1){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Last name cannot be empty!"
                        )
                    );
                }
                elseif(!$this -> verify_access_code($mdaID, $accessCode)){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Access code incorrect for this MDA."
                        )
                    );
                }
                elseif(strlen($email) > 100){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Email is too long! Max. of 100 characters."
                        )
                    );
                }
                elseif(!preg_match("/\@/", $email)){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Email address seems invalid!"
                        )
                    );
                }
                elseif(!preg_match("/\d+/", $accessCode)){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Access code contains unwanted character, only digits are acceptable!"
                        )
                    );
                }
                elseif(strlen($accessCode) > 7){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Access code is too long!"
                        )
                    );
                }
                elseif(!preg_match("/^mda-/", $mdaID)){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Selected MDA is unacceptable!"
                        )
                    );
                }
                elseif(!verify_access_code($accessCode, $mdaID)){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Access code is incorrect!"
                        )
                    );
                }
                elseif($password !== $c_password){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Passwords do not match! Try again."
                        )
                    );
                }
                elseif(strlen($password) < 8){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Passwords too short! Min. of & characters."
                        )
                    );
                }
                else{
                    $password = md5($password);
                    $id = strtolower(generate_user_id());

                    $query = $connect -> query(
                        "INSERT INTO `users` SET `id` = '$id', `f_name` = '$f_name', `l_name` = '$l_name', `email` = '$email', `mda` = '$mdaID', `empID` = '$empID', `password` = '$password'"
                    );

                    if($query){
                        echo json_encode(
                            array(
                                "type" => "success",
                                "data" => array(
                                    "id" => $id,
                                    "f_name" => $f_name,
                                    "email" => $email,
                                    "accountType" => "civil servant"
                                )
                            )
                        );
                    }
                    else{
                        echo json_encode(
                            array(
                                "type" => "error",
                                "data" => "Sign up failed! Please try again."
                            )
                        );
                    }
                }
            }
        }
    }

    $SignUp = new SignUp();

?>
