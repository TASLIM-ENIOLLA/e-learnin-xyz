<?php
    function filterInput($var){
        global $connect;
        $var = trim($var);
        $var = htmlspecialchars($var);
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = mysqli_real_escape_string($connect, $var);
        $var = strtolower($var);
        return $var;
    }
    function forbiddenChars($string, $type = null){
        if($type == "name" || $type == null){
            return preg_match("/[^0-9a-zA-Z_\-\s]/", $string);
        }
        elseif($type == "text"){
            return preg_match("/[^0-9a-zA-Z_\/\r\s\-\+\,\!\.]/", $string);
        }
        elseif($type == "number"){
            return preg_match("/[^0-9\,\.]/", $string);
        }
        elseif($type == "password"){
            return preg_match("/[^0-9a-zA-Z_]/", $string);
        }
    }
    function clear_folder($path){
        foreach(scandir($path) as $file){
            if($file != "." && $file != ".."){
                unlink($path . $file);
            }
        }
    }
    function randomTextGen($no_of_chars){
        $rr = '';
        for($x = 0; strlen($rr) < $no_of_chars; $x++){
            $re = mt_rand(48, 90);
            if($re < 58 || $re > 64){
                $re = dechex($re);
                $re = pack("H*", $re);
                $rr .= $re;
            }
        }
        return $rr;
    }
    function generate_user_id(){
        global $connect;
        $id = 'USR-' . randomTextGen(16);

        $query = $connect -> query(
            "SELECT * FROM `users` WHERE `id` = '$id'"
        );

        if($query && $query -> num_rows > 0){
            generate_user_id();
        }
        else{
            return $id;
        }
    }
    function generate_MDA_id(){
        global $connect;
        $id = 'MDA-' . randomTextGen(16);

        $query = $connect -> query(
            "SELECT * FROM `mdas` WHERE `id` = '$id'"
        );

        if($query && $query -> num_rows > 0){
            generate_MDA_id();
        }
        else{
            return $id;
        }
    }
    function generate_course_id(){
        global $connect;
        $id = 'CRS-' . randomTextGen(16);

        $query = $connect -> query(
            "SELECT * FROM `courses` WHERE `id` = '$id'"
        );

        if($query && $query -> num_rows > 0){
            generate_course_id();
        }
        else{
            return $id;
        }
    }
    function generate_module_id(){
        global $connect;
        $id = 'MDL-' . randomTextGen(16);

        $query = $connect -> query(
            "SELECT * FROM `courses` WHERE `id` = '$id'"
        );

        if($query && $query -> num_rows > 0){
            generate_module_id();
        }
        else{
            return $id;
        }
    }
    function generate_message_id(){
        global $connect;
        $id = 'MSG-' . randomTextGen(16);

        $query = $connect -> query(
            "SELECT * FROM `contact_messages` WHERE `id` = '$id'"
        );

        if($query && $query -> num_rows > 0){
            generate_message_id();
        }
        else{
            return $id;
        }
    }
    function verify_access_code($accessCode, $mdaID){
        global $connect;

        $query = $connect -> query(
            "SELECT COUNT(*) AS 'total' FROM `mdas` WHERE `access_code` = '$accessCode' AND `id` = '$mdaID'"
        );

        if($query && $query -> num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function get_courses_by_mdaID($mdaID, $userID = null){
        global $connect;
        $arr = [];

        $query = $connect -> query(
            "SELECT `courses`.*, `mdas`.`name` AS mda_name FROM `courses` LEFT JOIN `mdas` ON `courses`.`mdaID` = `mdas`.`id` WHERE `mdaID` = '$mdaID'"
        );

        if($query && $query -> num_rows > 0){
            while($row = $query -> fetch_assoc()){
                $row['modules'] = get_modules_by_courseID($row['id']);
                if(isset($userID) && $userID){
                    $row['is_registered'] = is_course_registered($row['id'], $userID);
                }
                array_push($arr, $row);
            }
        }

        return $arr;
    }
    function get_modules_by_courseID($courseID){
        global $connect;
        $arr = [];

        $query = $connect -> query(
            "SELECT * FROM `modules` WHERE `courseID` = '$courseID'"
        );

        if($query && $query -> num_rows > 0){
            while($row = $query -> fetch_assoc()){
                array_push($arr, $row);
            }
            return $arr;
        }
        else{
            return [];
        }
    }
    function get_mda_data($mdaID){
        global $connect;

        $query = $connect -> query(
            "SELECT * FROM `mdas` WHERE `id` = '$mdaID'"
        );

        if($query && $query -> num_rows > 0){
            return $query -> fetch_assoc();
        }
        else{
            return false;
        }
    }
    // is_module_
    function get_course_data($courseID){
        global $connect;

        $query = $connect -> query(
            "SELECT `courses`.*, `mdas`.`name` AS 'mda_name', `mdas`.`id` AS 'mdaID' FROM `courses` INNER JOIN `mdas` ON `courses`.`mdaID` = `mdas`.`id` WHERE `courses`.`id` = '$courseID'"
        );

        if($query && $query -> num_rows > 0){
            $row = $query -> fetch_assoc();
            // $row['modules'] = get_modules_by_courseID($row['id']);
            return $row;
        }
        else{
            return false;
        }
    }
    function get_user_data($userID){
        global $connect;

        $query = $connect -> query(
            "SELECT * FROM `users` WHERE `id` = '$userID'"
        );

        if($query && $query -> num_rows > 0){
            return $query -> fetch_assoc();
        }
        else{
            return null;
        }
    }
    function is_course_registered($courseID, $userID){
        global $connect;

        $query = $connect -> query(
            "SELECT COUNT(*) AS 'total' FROM `lectures` WHERE `userID` = '$userID' AND `courseID` = '$courseID'"
        );

        if($query && $query -> fetch_assoc()['total'] > 0){
            return true;
        }
        else{
            return false;
        }
    }
?>
