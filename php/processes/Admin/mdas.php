<?php

    include '../../init.php';

    class MDAs{
        public function __construct(){
            global $connect;

            $query = $connect -> query(
                'SELECT ' . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? 'COUNT(*) AS "total"'
                    : '*'
                ) . ' FROM `mdas` ORDER BY `name` ASC'
            );

            if($query && $query -> num_rows > 0){
                if(isset($_GET['count']) && $_GET['count'] === 'true'){
                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $query -> fetch_assoc()['total']
                        )
                    );
                }
                else{
                    $arr = [];

                    while($row = $query -> fetch_assoc()){
                        array_push($arr, $row);
                    }

                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $arr
                        )
                    );
                }
            }
            else{
                echo json_encode(
                    array(
                        'type' => 'error',
                        'data' => 0
                    )
                );
            }
        }
    }

    $MDAs = new MDAs();