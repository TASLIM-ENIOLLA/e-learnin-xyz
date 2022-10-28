<?php

    include '../../init.php';

    class GetCourses{
        public function __construct(){
            global $connect;

            $userID =  isset($_GET['userData']) ? json_decode($_GET['userData']) -> id : '';
            $userMDAID = get_user_data($userID)['mda'];
            
            $sql_query = "SELECT `courses`.*, `mdas`.`name` AS 'mda_name', `mdas`.`id` AS 'mdaID' FROM `courses` LEFT JOIN `mdas` ON `courses`.`mdaID` = `mdas`.`id`" . (
                ($userMDAID)
                ? " WHERE `courses`.`mdaID` = '$userMDAID'"
                : ""
            );

            $query = $connect -> query($sql_query);

            if($query && $query -> num_rows > 0){
                $arr = [];

                while($row = $query -> fetch_assoc()){
                    if($userID !== ''){
                        $row['is_registered'] = is_course_registered($row['id'], $userID);
                    }
                    $row['modules'] = get_modules_by_courseID($row['id']);
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
                        'data' => [$userID]
                    )
                );
            }
        }
    }

    $GetCourses = new GetCourses();

?>