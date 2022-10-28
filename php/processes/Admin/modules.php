<?php

    include '../../init.php';

    class Modules{
        public function __construct(){
            global $connect;

            $query = $connect -> query(
                'SELECT ' . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? 'COUNT(*) AS "total"'
                    : "`modules`.*, `mdas`.`name` AS 'mda_name', `courses`.`name` AS 'course_name'"
                ) . ' FROM `modules`' . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? ''
                    : " INNER JOIN `mdas` ON `modules`.`mdaID` = `mdas`.`id` INNER JOIN `courses` ON `modules`.`courseID` = `courses`.`id`"
                )
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

    $Modules = new Modules();