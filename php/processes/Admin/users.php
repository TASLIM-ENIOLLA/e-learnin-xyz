<?php

    include '../../init.php';

    class UsersCount{
        public function __construct(){
            global $connect;

            $query = $connect -> query(
                'SELECT ' . (
                    (isset($_GET['count']) && $_GET['count'] === 'true')
                    ? 'COUNT(*) AS "total"'
                    : '*'
                ) . ' FROM `users`'
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
                        if(!file_exists('../../../images/users/' . $row['id'] . '/' . $row['photo'])){
                            $row['photo'] = null;
                        }
                        $row['fallback_photo'] = '../../../images/users/user_default.png';
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

    $UsersCount = new UsersCount();