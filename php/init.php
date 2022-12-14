<?php

    class Init{
        public function __construct(){
            $this -> cors(true);
        }
        
        protected function cors($state = false){
            if($state){
                // Allow from any origin
                // var_dump($_SERVER);
                if (isset($_SERVER['HTTP_ORIGIN'])) {
                    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                    // you want to allow, and if so:
                    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                    header("Access-Control-Allow-Origin: *");
                    header('Access-Control-Allow-Credentials: true');
                    header('Access-Control-Max-Age: 86400');    // cache for 1 day
                }
                
                // Access-Control headers are received during OPTIONS requests
                if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                    
                    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                        // may also be using PUT, PATCH, HEAD etc
                        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
                    
                    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
                
                    exit(0);
                }
            }
        }
    }
    
    $Init = new Init();

    include "connect/connect.php";
    include "functions/functions.php";
    include "functions/MULTIPLE_FILES_UPLOAD.php";

    session_start();

?>
