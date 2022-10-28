<?php

    include '../../init.php';

    class GetUserLectures{
        public function __construct(){
            global $connect;

            if(isset($_GET)){
                $userID = $_GET['userID'];

                $query = $connect -> query("
                    SELECT
                        *
                    FROM
                        `lectures`
                    WHERE
                        `userID` = '$userID'
                ");

                if($query && $query -> num_rows > 0){
                    $arr = [];

                    while($row = $query -> fetch_assoc()){
                        // if($userID !== ''){
                        //     $row['is_registered'] = is_course_registered($row['id'], $userID);
                        // }
                        $row['course_data'] = get_course_data($row['courseID']);
                        $row['module_progress'] = json_decode($row['module_progress']);
                        $row['modules'] = get_modules_by_courseID($row['courseID']);
                        array_push($arr, $row);
                    }

                    echo json_encode(
                        array(
                            'type' => 'success',
                            'data' => $arr
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'type' => 'error',
                            'data' => null
                        )
                    );
                }
            }
            else{
                echo json_encode(
                    array(
                        'type' => 'error',
                        'data' => 'FORBIDDEN'
                    )
                );
            }
        }
    }

    $GetUserLectures = new GetUserLectures();

?>