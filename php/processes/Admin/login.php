<?php

    include "../../init.php";

    class Login{
        function __construct(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $connect;

                $_POST = json_decode(file_get_contents("php://input"));

                $adminID = filterInput($_POST -> adminID);
                $password = filterInput($_POST -> password);

                if(strlen($password) < 8){
                    echo json_encode(
                        array(
                            "type" => "error",
                            "data" => "Passwords too short! Min. of & characters."
                        )
                    );
                }
                else{
                    $password = md5($password);

                    $query = $connect -> query(
                        "SELECT `id`, `f_name`, `email`, COUNT(*) AS 'total' FROM `admin` WHERE `adminID` = '$adminID' AND `password` = '$password'"
                    );

                    if($query){
                        $row = $query -> fetch_assoc();

                        if($row['total'] > 0){
                            echo json_encode(
                                array(
                                    "type" => "success",
                                    "data" => array(
                                        "id" => $row['id'],
                                        "f_name" => $row['f_name'],
                                        "email" => $row['email'],
                                        "accountType" => "admin"
                                    )
                                )
                            );
                        }
                        else{
                            echo json_encode(
                                array(
                                    "type" => "error",
                                    "data" => "User account not found."
                                )
                            );
                        }
                    }
                    else{
                        echo json_encode(
                            array(
                                "type" => "error",
                                "data" => "Log in failed! Please try again."
                            )
                        );
                    }
                }
            }
        }
    }

    $Login = new Login();

?>
