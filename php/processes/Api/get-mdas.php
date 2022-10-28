<?php

    include '../../init.php';

    class GetMDAs{
        public function __construct(){
            global $connect;

            $query = $connect -> query(
                "SELECT `id`, `name` FROM `mdas`"
            );

            if($query){
                if($query -> num_rows > 0){
                    $arr = [];

                    while($rows = $query -> fetch_assoc()){
                        array_push($arr, $rows);
                    }
                    echo json_encode(
                        array(
                            "type" => "success",
                            "data" => $arr
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            "type" => "success",
                            "data" => []
                        )
                    );    
                }
            }
            else{
                echo json_encode(
                    array(
                        "type" => "error",
                        "data" => "Couldn't retrieve MDAs from database!"
                    )
                );
            }
        }
    }

    $GetMDAs = new GetMDAs();

?>