<?php

    include '../../init.php';

    class CoursesCount{
        public function __construct(){
            global $connect;

            $query = $connect -> query(
                'SELECT ' . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? 'COUNT(*) AS "total"'
                    : "`courses`.*, `mdas`.`name` AS 'mda_name'"
                ) . " FROM `courses`" . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? ''
                    : " INNER JOIN `mdas` ON `courses`.`mdaID` = `mdas`.`id`"
                ) . ' ORDER BY `courses`.`name` ASC'
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
                        $row['modules'] = get_modules_by_courseID($row['id']);
                        $row['features'] = json_decode($row['features']);
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

    $CoursesCount = new CoursesCount();